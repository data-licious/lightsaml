<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class SubjectConfirmationData extends AbstractSamlModel
{
    /** @var int|null */
    protected $notBefore;

    /** @var int|null */
    protected $notOnOrAfter;

    /** @var string|null */
    protected $address;

    /** @var string|null */
    protected $inResponseTo;

    /** @var string|null */
    protected $recipient;



    /**
     * @param null|string $address
     * @return $this|SubjectConfirmationData
     */
    public function setAddress($address)
    {
        $this->address = (string)$address;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param null|string $inResponseTo
     * @return $this|SubjectConfirmationData
     */
    public function setInResponseTo($inResponseTo)
    {
        $this->inResponseTo = (string)$inResponseTo;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInResponseTo()
    {
        return $this->inResponseTo;
    }

    /**
     * @param int|string|\DateTime $notBefore
     * @return $this|SubjectConfirmationData
     */
    public function setNotBefore($notBefore)
    {
        $this->notBefore = Helper::getTimestampFromValue($notBefore);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNotBeforeTimestamp()
    {
        return $this->notBefore;
    }

    /**
     * @return string|null
     */
    public function getNotBeforeString()
    {
        if ($this->notBefore) {
            return Helper::time2string($this->notBefore);
        }
        return null;
    }

    /**
     * @return \DateTime|null
     */
    public function getNotBeforeDateTime()
    {
        if ($this->notBefore) {
            return new \DateTime('@'.$this->notBefore);
        }
        return null;
    }

    /**
     * @param int|string|\DateTime $notOnOrAfter
     * @return $this|SubjectConfirmationData
     */
    public function setNotOnOrAfter($notOnOrAfter)
    {
        $this->notOnOrAfter = Helper::getTimestampFromValue($notOnOrAfter);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNotOnOrAfterTimestamp()
    {
        return $this->notOnOrAfter;
    }

    /**
     * @return string|null
     */
    public function getNotOnOrAfterString()
    {
        if ($this->notOnOrAfter) {
            return Helper::time2string($this->notOnOrAfter);
        }
        return null;
    }

    /**
     * @return \DateTime|null
     */
    public function getNotOnOrAfterDateTime()
    {
        if ($this->notOnOrAfter) {
            return new \DateTime('@'.$this->notOnOrAfter);
        }
        return null;
    }

    /**
     * @param null|string $recipient
     * @return $this|SubjectConfirmationData
     */
    public function setRecipient($recipient)
    {
        $this->recipient = (string)$recipient;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('SubjectConfirmationData', null, $parent, $context);

        $this->attributesToXml(
            array('InResponseTo', 'NotBefore', 'NotOnOrAfter', 'Address', 'Recipient'),
            $result
        );
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'SubjectConfirmationData', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array(
            'InResponseTo', 'NotBefore', 'NotOnOrAfter', 'Address', 'Recipient'
        ));
    }

}