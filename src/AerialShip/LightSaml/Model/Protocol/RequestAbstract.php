<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\Model\Assertion\Issuer;
use AerialShip\LightSaml\Model\XmlDSig\Signature;
use AerialShip\LightSaml\SamlConstants;

abstract class RequestAbstract extends AbstractSamlModel
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $version = SamlConstants::VERSION_20;

    /** @var int */
    protected $issueInstant;

    /** @var string|null */
    protected $destination;

    /** @var string|null */
    protected $consent;

    /** @var Issuer|null */
    protected $issuer;

    /** @var Signature|null */
    protected $signature;



    /**
     * @param null|string $consent
     * @return $this|RequestAbstract
     */
    public function setConsent($consent)
    {
        $this->consent = (string)$consent;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getConsent()
    {
        return $this->consent;
    }

    /**
     * @param null|string $destination
     * @return $this|RequestAbstract
     */
    public function setDestination($destination)
    {
        $this->destination = (string)$destination;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $id
     * @return $this|RequestAbstract
     */
    public function setID($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @param int|string|\DateTime $issueInstant
     * @return $this|RequestAbstract
     */
    public function setIssueInstant($issueInstant)
    {
        $this->issueInstant = Helper::getTimestampFromValue($issueInstant);
        return $this;
    }

    /**
     * @return int
     */
    public function getIssueInstantTimestamp()
    {
        return $this->issueInstant;
    }

    /**
     * @return string
     */
    public function getIssueInstantString()
    {
        if ($this->issueInstant) {
            return Helper::time2string($this->issueInstant);
        }
        return null;
    }

    /**
     * @return \DateTime
     */
    public function getIssueInstantDateTime()
    {
        if ($this->issueInstant) {
            return new \DateTime('@'.$this->issueInstant);
        }
        return null;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\Issuer|null $issuer
     * @return $this|RequestAbstract
     */
    public function setIssuer(Issuer $issuer = null)
    {
        $this->issuer = $issuer;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\NameID|null
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param \AerialShip\LightSaml\Model\XmlDSig\Signature|null $signature
     * @return $this|RequestAbstract
     */
    public function setSignature(Signature $signature = null)
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\XmlDSig\Signature|null
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $version
     * @return $this|RequestAbstract
     */
    public function setVersion($version)
    {
        $this->version = (string)$version;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->attributesToXml(array('ID', 'Version', 'IssueInstant', 'Destination', 'Consent'), $parent);

        $this->singleElementsToXml(array('Issuer', 'Signature'), $parent, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->attributesFromXml($node, array('ID', 'Version', 'IssueInstant', 'Destination', 'Consent'));

        $this->singleElementsFromXml($node, $context, array(
            'Issuer' => array('saml', 'Aerialship\LightSaml\Model\Assertion\Issuer'),
            'Signature' => array('ds', 'Aerialship\LightSaml\Model\XmlDSig\SignatureXmlValidator'),
        ));
    }

}