<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Error\LightSamlModelException;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;

abstract class AbstractNameID extends AbstractSamlModel
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var string|null
     */
    protected $format;

    /**
     * @var string|null
     */
    protected $nameQualifier;

    /**
     * @var string|null
     */
    protected $spNameQualifier;

    /**
     * @var string|null
     */
    protected $spProvidedId;



    /**
     * @param string $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }



    /**
     * @param null|string $format
     * @return $this|NameID
     */
    public function setFormat($format)
    {
        $this->format = (string)$format;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param null|string $nameQualifier
     * @return $this|NameID
     */
    public function setNameQualifier($nameQualifier)
    {
        $this->nameQualifier = (string)$nameQualifier;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getNameQualifier()
    {
        return $this->nameQualifier;
    }

    /**
     * @param null|string $spNameQualifier
     * @return $this|NameID
     */
    public function setSPNameQualifier($spNameQualifier)
    {
        $this->spNameQualifier = (string)$spNameQualifier;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSPNameQualifier()
    {
        return $this->spNameQualifier;
    }

    /**
     * @param null|string $spProvidedId
     * @return $this|NameID
     */
    public function setSPProvidedID($spProvidedId)
    {
        $this->spProvidedId = (string)$spProvidedId;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSPProvidedID()
    {
        return $this->spProvidedId;
    }

    /**
     * @param string $value
     * @return $this|NameID
     */
    public function setValue($value)
    {
        $this->value = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


    protected function prepareForXml()
    {
        if (false == $this->getValue()) {
            throw new LightSamlModelException('NameID value not set');
        }
    }

    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return \DOMElement
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        /** @var \DOMElement $parent */
        $this->attributesToXml(array('Format', 'NameQualifier', 'SPNameQualifier', 'SPProvidedID'), $parent);
        $parent->nodeValue = $this->getValue();
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->attributesFromXml($node, array('NameQualifier', 'Format', 'SPNameQualifier', 'SPProvidedID'));
        $this->setValue((string)$node);
    }


}