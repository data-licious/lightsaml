<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class Attribute extends AbstractSamlModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $nameFormat;

    /**
     * @var string
     */
    protected $friendlyName;

    /**
     * @var string[]
     */
    protected $attributeValue;


    /**
     * @param string $attributeValue
     * @return $this|Attribute
     */
    public function addAttributeValue($attributeValue)
    {
        if (false == is_array($this->attributeValue)) {
            $this->attributeValue = array();
        }
        $this->attributeValue[] = $attributeValue;

        return $this;
    }

    /**
     * @param string[]|string $attributeValue
     * @return $this|Attribute
     */
    public function setAttributeValue($attributeValue)
    {
        if (false == is_array($attributeValue)) {
            $attributeValue = array($attributeValue);
        }
        $this->attributeValue = $attributeValue;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    /**
     * @return string|null
     */
    public function getFirstAttributeValue()
    {
        $arr = $this->attributeValue;
        return array_shift($arr);
    }

    /**
     * @param string $friendlyName
     * @return $this|Attribute
     */
    public function setFriendlyName($friendlyName)
    {
        $this->friendlyName = $friendlyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFriendlyName()
    {
        return $this->friendlyName;
    }

    /**
     * @param string $name
     * @return $this|Attribute
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $nameFormat
     * @return $this|Attribute
     */
    public function setNameFormat($nameFormat)
    {
        $this->nameFormat = $nameFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameFormat()
    {
        return $this->nameFormat;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('Attribute', null, $parent, $context);

        $this->attributesToXml(array('Name', 'NameFormat', 'FriendlyName'), $result);

        $this->manyElementsToXml($this->attributeValue, $result, $context, 'AttributeValue');
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Attribute', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array('Name', 'NameFormat', 'FriendlyName'));

        $this->attributeValue = array();
        $this->manyElementsFromXml($node, $context, 'AttributeValue', 'saml', null, 'addAttributeValue');
    }

}