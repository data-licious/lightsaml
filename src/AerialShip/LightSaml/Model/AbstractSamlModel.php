<?php

namespace AerialShip\LightSaml\Model;

use AerialShip\LightSaml\Error\LightSamlXmlException;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;

abstract class AbstractSamlModel implements SamlElementInterface
{
    /**
     * @param string $name
     * @param null|string $namespace
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return \DOMElement
     */
    protected function createElement($name, $namespace, \DOMNode $parent, SerializationContext $context)
    {
        if ($namespace) {
            $result = $context->getDocument()->createElementNS($namespace, $name);
        } else {
            $result = $context->getDocument()->createElement($name);
        }
        $parent->appendChild($result);

        return $result;
    }


    /**
     * @param string $name
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @throws \LogicException
     */
    private function oneElementToXml($name, \DOMNode $parent, SerializationContext $context)
    {
        $value = $this->getPropertyValue($name);
        if (null == $value) {
            return;
        }
        if ($value instanceof SamlElementInterface) {
            $value->serialize($parent, $context);
        } else if (is_string($value)) {
            $node = $context->getDocument()->createElement($name, $value);
            $parent->appendChild($node);
        } else {
            throw new \LogicException(sprintf("Element '%s' must implement SamlElementInterface or be a string", $name));
        }
    }

    /**
     * @param array|string[] $names
     * @param \DOMNode $parent
     * @param SerializationContext $context
     */
    protected function singleElementsToXml(array $names, \DOMNode $parent, SerializationContext $context)
    {
        foreach ($names as $name) {
            $this->oneElementToXml($name, $parent, $context);
        }
    }


    /**
     * @param array|null $value
     * @param \DOMNode $node
     * @param SerializationContext $context
     * @param null|string $nodeName
     * @throws \LogicException
     */
    protected function manyElementsToXml($value, \DOMNode $node, SerializationContext $context, $nodeName = null)
    {
        if (false == $value) {
            return;
        }

        if (false == is_array($value)) {
            throw new \LogicException('value must be array or null');
        }

        foreach ($value as $object) {
            if ($object instanceof SamlElementInterface) {
                if ($nodeName) {
                    throw new \LogicException('nodeName should not be specified when serializing array of SamlElementInterface');
                }
                $object->serialize($node, $context);
            } else if ($nodeName) {
                $child = $context->getDocument()->createElement($nodeName, (string)$object);
                $node->appendChild($child);
            } else {
                throw new \LogicException('Can handle only array of AbstractSamlModel or strings with nodeName parameter specified');
            }
        }
    }


    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @param string $nodeName
     * @param string|null $namespacePrefix
     * @param string $class
     * @param string $methodName
     * @throws \LogicException
     */
    protected function manyElementsFromXml(\DOMElement $node, DeserializationContext $context, $nodeName, $namespacePrefix, $class, $methodName)
    {
        if ($namespacePrefix) {
            $query = sprintf("%s:%s", $namespacePrefix, $nodeName);
        } else {
            $query = sprintf("%s", $nodeName);
        }

        foreach ($context->getXpath()->query($query, $node) as $xml) {
            /** @var \DOMElement $xml */
            if ($class) {
                /** @var SamlElementInterface $object */
                $object = new $class();
                if (false == $object instanceof SamlElementInterface) {
                    throw new \LogicException(sprintf("Node '%s' class '%s' must implement SamlElementInterface", $nodeName, $class));
                }
                $object->deserialize($xml, $context);
                $this->{$methodName}($object);
            } else {
                $object = $xml->textContent;
                $this->{$methodName}($object);
            }
        }
    }

    /**
     * @param string $name
     * @param \DOMElement $element
     * @throws \LogicException
     * @return bool True if property value is not empty and attribute was set to the element
     */
    protected function singleAttributeToXml($name, \DOMElement $element)
    {
        $value = $this->getPropertyValue($name);
        if ($value) {
            $element->setAttribute($name, $value);

            return true;
        }

        return false;
    }

    /**
     * @param array|string[] $names
     * @param \DOMElement $element
     */
    protected function attributesToXml(array $names, \DOMElement $element)
    {
        foreach ($names as $name) {
            $this->singleAttributeToXml($name, $element);
        }
    }


    /**
     * @param \DOMElement $node
     * @param string $expectedName
     * @param string $expectedNamespaceUri
     * @throws \AerialShip\LightSaml\Error\LightSamlXmlException
     */
    protected function checkXmlNodeName(\DOMElement $node, $expectedName, $expectedNamespaceUri)
    {
        if ($node->localName != $expectedName || $node->namespaceURI != $expectedNamespaceUri) {
            throw new LightSamlXmlException(sprintf("Expected '%s' xml node and '%s' namespace but got node '%s' and namespace '%s'",
                $expectedName,
                $expectedNamespaceUri,
                $node->localName,
                $node->namespaceURI
            ));
        }
    }

    /**
     * @param \DOMElement $node
     * @param string $attributeName
     */
    protected function singleAttributeFromXml(\DOMElement $node, $attributeName)
    {
        $value = $node->getAttribute($attributeName);
        if ($value !== '') {
            $setter = 'set'.$attributeName;
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            }
        }
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @param string $elementName
     * @param string $class
     * @param string $namespacePrefix
     * @throws \LogicException
     */
    protected function oneElementFromXml(\DOMElement $node, DeserializationContext $context, $elementName, $class, $namespacePrefix)
    {
        if ($namespacePrefix) {
            $query = sprintf('./%s:%s', $namespacePrefix, $elementName);
        } else {
            $query = sprintf('./%s', $elementName);
        }
        $arr = $context->getXpath()->query($query, $node);
        $value = $arr->length > 0 ? $arr->item(0) : null;

        if ($value) {
            $setter = 'set'.$elementName;
            if (false == method_exists($this, $setter)) {
                throw new \LogicException(sprintf(
                    "Unable to find setter for element '%s' in class '%s'",
                    $elementName,
                    get_class($this)
                ));
            }

            if ($class) {
                /** @var AbstractSamlModel $object */
                $object = new $class();
                if (false == $object instanceof \AerialShip\LightSaml\Model\SamlElementInterface) {
                    throw new \LogicException(sprintf(
                        "Specified class '%s' for element '%s' must implement SamlElementInterface",
                        $class,
                        $elementName
                    ));
                }

                $object->deserialize($value, $context);

            } else {
                $object = $value->textContent;
            }

            $this->{$setter}($object);
        }
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @param array $options elementName=>class
     */
    protected function singleElementsFromXml(\DOMElement $node, DeserializationContext $context, array $options)
    {
        foreach ($options as $elementName=>$info) {
            $this->oneElementFromXml($node, $context, $elementName, $info[1], $info[0]);
        }
    }

    /**
     * @param \DOMElement $node
     * @param array $attributeNames
     */
    protected function attributesFromXml(\DOMElement $node, array $attributeNames)
    {
        foreach ($attributeNames as $attributeName) {
            $this->singleAttributeFromXml($node, $attributeName);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \LogicException
     */
    private function getPropertyValue($name)
    {
        $getter = 'get'.$name.'String';
        if (false == method_exists($this, $getter)) {
            $getter = 'get'.$name;
        }
        if (false == method_exists($this, $getter)) {
            throw new \LogicException(sprintf("Unable to find getter method for '%s' on '%s'",
                $name,
                get_class($this)
            ));
        }
        $value = $this->{$getter}();

        return $value;
    }
}