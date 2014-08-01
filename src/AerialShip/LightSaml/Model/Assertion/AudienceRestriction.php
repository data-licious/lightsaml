<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class AudienceRestriction extends AbstractSamlModel
{
    /**
     * @var string[]
     */
    protected $audience = array();


    /**
     * @param string|string[] $audience
     */
    public function __construct($audience)
    {
        if (false == is_array($audience)) {
            $audience = array($audience);
        }
        $this->audience = $audience;
    }


    /**
     * @param string $audience
     * @return $this|AudienceRestriction
     */
    public function addAudience($audience)
    {
        $this->audience[] = $audience;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAllAudience()
    {
        return $this->audience;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('AudienceRestriction', null, $parent, $context);

        $this->manyElementsToXml($this->getAllAudience(), $result, $context, 'Audience');
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'AudienceRestriction', SamlConstants::NS_ASSERTION);

        $this->audience = array();
        $this->manyElementsFromXml($node, $context, 'Audience', 'saml', null, 'addAudience');
    }

}