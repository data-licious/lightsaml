<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;

class AssertionConsumerService extends IndexedEndpoint
{
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->createElement('AssertionConsumerService', null, $parent, $context);
        parent::serialize($parent, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'AssertionConsumerService', SamlConstants::NS_METADATA);
        parent::deserialize($node, $context);
    }

}