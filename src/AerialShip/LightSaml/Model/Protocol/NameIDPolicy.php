<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class NameIDPolicy extends AbstractSamlModel
{
    /**
     * @var string|null
     */
    protected $format;

    /**
     * @var bool|null
     */
    protected $allowCreate;

    /**
     * @var string|null
     */
    protected $spNameQualifier;



    /**
     * @param string|bool|null $allowCreate
     * @return $this|NameIDPolicy
     */
    public function setAllowCreate($allowCreate)
    {
        if ($allowCreate === null) {
            $this->allowCreate = null;
        } else if (is_string($allowCreate) || is_int($allowCreate)) {
            $this->allowCreate = strcasecmp($allowCreate, 'true') == 0 || $allowCreate === true || $allowCreate == 1;
        } else {
            $this->allowCreate = (bool)$allowCreate;
        }
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowCreate()
    {
        return $this->allowCreate;
    }

    /**
     * @return string|null
     */
    public function getAllowCreateString()
    {
        if ($this->allowCreate === null) {
            return null;
        }
        return $this->allowCreate ? 'true' : 'false';
    }

    /**
     * @param string|null $format
     * @return $this|NameIDPolicy
     */
    public function setFormat($format)
    {
        $this->format = (string)$format;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string|null $spNameQualifier
     * @return $this|NameIDPolicy
     */
    public function setSPNameQualifier($spNameQualifier)
    {
        $this->spNameQualifier = $spNameQualifier;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSPNameQualifier()
    {
        return $this->spNameQualifier;
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('NameIDPolicy', null, $parent, $context);

        $this->attributesToXml(array('Format', 'SPNameQualifier', 'AllowCreate'), $result);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'NameIDPolicy', SamlConstants::NS_PROTOCOL);

        $this->attributesFromXml($node, array('Format', 'SPNameQualifier', 'AllowCreate'));
    }

}