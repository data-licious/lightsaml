<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class AuthnStatement extends AbstractSamlModel
{
    /**
     * @var int|null
     */
    protected $authnInstant;

    /**
     * @var int|null
     */
    protected $sessionNotOnOrAfter;

    /**
     * @var string|null
     */
    protected $sessionIndex;

    /**
     * @var AuthnContext
     */
    protected $authnContext;

    /**
     * @var SubjectLocality
     */
    protected $subjectLocality;



    /**
     * @param \AerialShip\LightSaml\Model\Assertion\AuthnContext $authnContext
     * @return $this|AuthnStatement
     */
    public function setAuthnContext(AuthnContext $authnContext)
    {
        $this->authnContext = $authnContext;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\AuthnContext
     */
    public function getAuthnContext()
    {
        return $this->authnContext;
    }

    /**
     * @param int|string|\DateTime $authnInstant
     * @return $this|AuthnStatement
     */
    public function setAuthnInstant($authnInstant)
    {
        $this->authnInstant = Helper::getTimestampFromValue($authnInstant);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAuthnInstantTimestamp()
    {
        return $this->authnInstant;
    }

    /**
     * @return string|null
     */
    public function getAuthnInstantString()
    {
        if ($this->authnInstant) {
            return Helper::time2string($this->authnInstant);
        }
        return null;
    }

    /**
     * @return \DateTime|null
     */
    public function getAuthnInstantDateTime()
    {
        if ($this->authnInstant) {
            return new \DateTime('@'.$this->authnInstant);
        }
        return null;
    }

    /**
     * @param null|string $sessionIndex
     * @return $this|AuthnStatement
     */
    public function setSessionIndex($sessionIndex)
    {
        $this->sessionIndex = $sessionIndex;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSessionIndex()
    {
        return $this->sessionIndex;
    }

    /**
     * @param int|string|\DateTime $sessionNotOnOrAfter
     * @return $this|AuthnStatement
     */
    public function setSessionNotOnOrAfter($sessionNotOnOrAfter)
    {
        $this->sessionNotOnOrAfter = Helper::getTimestampFromValue($sessionNotOnOrAfter);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSessionNotOnOrAfterTimestamp()
    {
        return $this->sessionNotOnOrAfter;
    }

    /**
     * @return string|null
     */
    public function getSessionNotOnOrAfterString()
    {
        if ($this->sessionNotOnOrAfter) {
            return Helper::time2string($this->sessionNotOnOrAfter);
        }
        return null;
    }

    /**
     * @return \DateTime|null
     */
    public function getSessionNotOnOrAfterDateTime()
    {
        if ($this->sessionNotOnOrAfter) {
            return new \DateTime('@'.$this->sessionNotOnOrAfter);
        }
        return null;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\SubjectLocality $subjectLocality
     * @return $this|AuthnStatement
     */
    public function setSubjectLocality($subjectLocality)
    {
        $this->subjectLocality = $subjectLocality;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\SubjectLocality
     */
    public function getSubjectLocality()
    {
        return $this->subjectLocality;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('AuthnStatement', null, $parent, $context);

        $this->attributesToXml(
            array('AuthnInstant', 'SessionNotOnOrAfter'),
            $result
        );

        $this->singleElementsToXml(
            array('SessionIndex', 'AuthnContext', 'SubjectLocality'),
            $result,
            $context
        );
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'AuthnStatement', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array('AuthnInstant', 'SessionNotOnOrAfter'));

        $this->singleElementsFromXml($node, $context, array(
            'SessionIndex' => array('saml', 'AerialShip\LightSaml\Model\Assertion\SessionIndex'),
            'AuthnContext' => array('saml', 'AerialShip\LightSaml\Model\Assertion\AuthnContext'),
            'SubjectLocality' => array('saml', 'AerialShip\LightSaml\Model\Assertion\SubjectLocality'),
        ));
    }

}