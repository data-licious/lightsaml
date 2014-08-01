<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;

class Issuer extends AbstractNameID
{
    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->prepareForXml();
        $result = $this->createElement('saml:Issuer', SamlConstants::NS_ASSERTION, $parent, $context);
        parent::serialize($result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Issuer', SamlConstants::NS_ASSERTION);

        parent::deserialize($node, $context);
    }

} 