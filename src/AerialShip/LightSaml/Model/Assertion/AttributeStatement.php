<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class AttributeStatement extends AbstractSamlModel
{
    /**
     * @var Attribute[]
     */
    protected $attributes = array();


    /**
     * @param Attribute $attribute
     * @return $this|AttributeStatement
     */
    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Attribute[]
     */
    public function getAllAttributes()
    {
        return $this->attributes;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('AttributeStatement', null, $parent, $context);

        $this->manyElementsToXml($this->getAllAttributes(), $result, $context, null);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'AttributeStatement', SamlConstants::NS_ASSERTION);

        $this->attributes = array();
        $this->manyElementsFromXml($node, $context, 'Attribute', 'saml',
            'AerialShip\LightSaml\Model\Assertion\Attribute', 'addAttribute');
    }


}