<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;

class LogoutResponse extends StatusResponse
{
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('samlp:LogoutResponse', SamlConstants::NS_PROTOCOL, $parent, $context);

        parent::serialize($result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'LogoutResponse', SamlConstants::NS_PROTOCOL);

        parent::deserialize($node, $context);
    }

}