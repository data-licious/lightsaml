<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\Assertion\Assertion;
use AerialShip\LightSaml\SamlConstants;

class Response extends StatusResponse
{
    /** @var Assertion[] */
    protected $assertions = array();


    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Assertion[]
     */
    public function getAllAssertions() {
        return $this->assertions;
    }

    public function addAssertion(Assertion $assertion) {
        $this->assertions[] = $assertion;
    }



    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('samlp:Response', SamlConstants::NS_PROTOCOL, $parent, $context);

        parent::serialize($result, $context);

        $this->manyElementsToXml($this->getAllAssertions(), $result, $context, null);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Response', SamlConstants::NS_PROTOCOL);

        parent::deserialize($node, $context);

        $this->assertions = array();
        $this->manyElementsFromXml($node, $context, 'Assertion', 'samlp',
            'AerialShip\LightSaml\Model\Assertion\Assertion', 'addAssertion');
    }

}
