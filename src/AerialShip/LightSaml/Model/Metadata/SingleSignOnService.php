<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;

class SingleSignOnService extends Endpoint
{
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('md:SingleSignOnService', SamlConstants::NS_METADATA, $parent, $context);

        parent::serialize($result, $context);
    }

    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'SingleSignOnService', SamlConstants::NS_METADATA);

        parent::deserialize($node, $context);
    }

}