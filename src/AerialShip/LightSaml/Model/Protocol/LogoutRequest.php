<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\Assertion\NameID;
use AerialShip\LightSaml\SamlConstants;
use JMS\Serializer\Annotation as JMS;

class LogoutRequest extends RequestAbstract
{
    /**
     * @var string|null
     */
    protected $reason;

    /**
     * @var int|null
     */
    protected $notOnOrAfter;

    /**
     * @var NameID
     */
    protected $nameID;

    /**
     * @var string|null
     */
    protected $sessionIndex;




    /**
     * @param \AerialShip\LightSaml\Model\Assertion\NameID $nameID
     * @return $this|LogoutRequest
     */
    public function setNameID(NameID $nameID)
    {
        $this->nameID = $nameID;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\NameID
     */
    public function getNameID()
    {
        return $this->nameID;
    }

    /**
     * @param int|null $notOnOrAfter
     * @return $this|LogoutRequest
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
     * @param null|string $reason
     * @return $this|LogoutRequest
     */
    public function setReason($reason)
    {
        $this->reason = (string)$reason;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param null|string $sessionIndex
     * @return $this|LogoutRequest
     */
    public function setSessionIndex($sessionIndex)
    {
        $this->sessionIndex = (string)$sessionIndex;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }


    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('LogoutRequest', SamlConstants::NS_PROTOCOL, $parent, $context);

        parent::serialize($result, $context);

        $this->attributesToXml(array('Reason', 'NotOnOrAfter'), $result);

        $this->singleElementsToXml(array('NameID', 'SessionIndex'), $result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'LogoutRequest', SamlConstants::NS_PROTOCOL);

        parent::deserialize($node, $context);

        $this->attributesFromXml($node, array('Reason', 'NotOnOrAfter'));

        $this->singleElementsFromXml($node, $context, array(
            'NameID' => array('saml', 'AerialShip\LightSaml\Model\Assertion\NameID'),
            'SessionIndex' => array('saml', null),
        ));
    }


}
