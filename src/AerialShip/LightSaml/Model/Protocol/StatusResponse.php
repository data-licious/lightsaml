<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\Model\Assertion\Issuer;
use AerialShip\LightSaml\Model\XmlDSig\Signature;

abstract class StatusResponse extends AbstractSamlModel
{
    /** @var  string */
    protected $id;

    /** @var string */
    protected $inResponseTo;

    /** @var  string */
    protected $version;

    /** @var  int */
    protected $issueInstant;

    /** @var  string|null */
    protected $destination;

    /** @var  string|null */
    protected $consent;

    /** @var  Issuer|null */
    protected $issuer;

    /** @var  Signature|null */
    protected $signature;

    /** @var Status */
    protected $status;



    /**
     * @param string $inResponseTo
     */
    public function setInResponseTo($inResponseTo) {
        $this->inResponseTo = $inResponseTo;
    }

    /**
     * @return string
     */
    public function getInResponseTo() {
        return $this->inResponseTo;
    }


    /**
     * @param \AerialShip\LightSaml\Model\Protocol\Status $status
     */
    public function setStatus(Status $status) {
        $this->status = $status;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Protocol\Status
     */
    public function getStatus() {
        return $this->status;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->attributesToXml(array('ID', 'InResponseTo', 'Version', 'IssueInstant', 'Destination', 'Consent'), $parent);

        $this->singleElementsToXml(array('Issuer', 'Signature', 'Status'), $parent, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->attributesFromXml($node, array('ID', 'InResponseTo', 'Version', 'IssueInstant', 'Destination', 'Consent'));

        $this->singleElementsFromXml($node, $context, array(
            'Issuer' => array('saml', 'AerialShip\LightSaml\Model\Assertion\Issuer'),
            'Signature' => array('ds', 'AerialShip\LightSaml\Model\XmlDSig\Signature'),
            'Status' => array('samlp', 'AerialShip\LightSaml\Model\Protocol\Status'),
        ));
    }

}