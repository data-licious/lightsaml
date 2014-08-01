<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\Assertion\Conditions;
use AerialShip\LightSaml\Model\Assertion\Subject;
use AerialShip\LightSaml\SamlConstants;

class AuthnRequest extends RequestAbstract
{
    //region Attributes

    /** @var bool|null */
    protected $forceAuthn;

    /** @var bool|null */
    protected $isPassive;

    /** @var int|null */
    protected $assertionConsumerServiceIndex;

    /** @var string|null */
    protected $assertionConsumerServiceURL;

    /** @var int|null */
    protected $attributeConsumingServiceIndex;

    /** @var string|null */
    protected $protocolBinding;

    /** @var string|null */
    protected $providerName;

    //endregion


    //region Elements

    /** @var Conditions|null */
    protected $conditions;

    /** @var NameIDPolicy|null */
    protected $nameIDPolicy;

    /** @var Subject|null */
    protected $subject;



    /**
     * @param \AerialShip\LightSaml\Model\Assertion\Subject|null $subject
     * @return $this|AuthnRequest
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Subject|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param null|string $providerName
     * @return $this|AuthnRequest
     */
    public function setProviderName($providerName)
    {
        $this->providerName = (string)$providerName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * @param null|string $protocolBinding
     * @return $this|AuthnRequest
     */
    public function setProtocolBinding($protocolBinding)
    {
        $this->protocolBinding = (string)$protocolBinding;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getProtocolBinding()
    {
        return $this->protocolBinding;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Protocol\NameIDPolicy|null $nameIDPolicy
     * @return $this|AuthnRequest
     */
    public function setNameIDPolicy(NameIDPolicy $nameIDPolicy)
    {
        $this->nameIDPolicy = $nameIDPolicy;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Protocol\NameIDPolicy|null
     */
    public function getNameIDPolicy()
    {
        return $this->nameIDPolicy;
    }

    /**
     * @param bool|null $isPassive
     * @return $this|AuthnRequest
     */
    public function setIsPassive($isPassive)
    {
        $this->isPassive = strcasecmp($isPassive, 'true') == 0 || $isPassive === true || $isPassive == 1;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsPassive()
    {
        return $this->isPassive;
    }

    /**
     * @return string|null
     */
    public function getIsPassiveString()
    {
        if ($this->isPassive === null) {
            return null;
        }
        return $this->isPassive ? 'true' : 'false';
    }

    /**
     * @param bool|null $forceAuthn
     * @return $this|AuthnRequest
     */
    public function setForceAuthn($forceAuthn)
    {
        $this->forceAuthn = strcasecmp($forceAuthn, 'true') == 0 || $forceAuthn === true || $forceAuthn == 1;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getForceAuthn()
    {
        return $this->forceAuthn;
    }

    /**
     * @return string|null
     */
    public function getForceAuthnString()
    {
        if ($this->forceAuthn === null) {
            return null;
        }
        return $this->forceAuthn ? 'true' : 'false';
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\Conditions|null $conditions
     * @return $this|AuthnRequest
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Conditions|null
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param null|int $attributeConsumingServiceIndex
     * @return $this|AuthnRequest
     */
    public function setAttributeConsumingServiceIndex($attributeConsumingServiceIndex)
    {
        $this->attributeConsumingServiceIndex = $attributeConsumingServiceIndex !== null
            ? intval(((string)$attributeConsumingServiceIndex))
            : null;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getAttributeConsumingServiceIndex()
    {
        return $this->attributeConsumingServiceIndex;
    }

    /**
     * @param null|string $assertionConsumerServiceURL
     * @return $this|AuthnRequest
     */
    public function setAssertionConsumerServiceURL($assertionConsumerServiceURL)
    {
        $this->assertionConsumerServiceURL = (string)$assertionConsumerServiceURL;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAssertionConsumerServiceURL()
    {
        return $this->assertionConsumerServiceURL;
    }

    /**
     * @param null|int $assertionConsumerServiceIndex
     * @return $this|AuthnRequest
     */
    public function setAssertionConsumerServiceIndex($assertionConsumerServiceIndex)
    {
        $this->assertionConsumerServiceIndex = $assertionConsumerServiceIndex !== null
            ? intval((string)$assertionConsumerServiceIndex)
            : null;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getAssertionConsumerServiceIndex()
    {
        return $this->assertionConsumerServiceIndex;
    }

    //endregion
    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('AuthnRequest', SamlConstants::NS_PROTOCOL, $parent, $context);

        parent::serialize($result, $context);

        $this->attributesToXml(array(
                'ForceAuthn', 'IsPassive', 'ProtocolBinding', 'AssertionConsumerServiceIndex',
                'AssertionConsumerServiceURL', 'AttributeConsumingServiceIndex', 'ProviderName'
            ), $result);

        $this->singleElementsToXml(array('Subject', 'NameIDPolicy', 'Conditions'), $result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'AuthnRequest', SamlConstants::NS_PROTOCOL);

        parent::deserialize($node, $context);

        $this->attributesFromXml($node, array(
            'ForceAuthn', 'IsPassive', 'ProtocolBinding', 'AssertionConsumerServiceIndex',
            'AssertionConsumerServiceURL', 'AttributeConsumingServiceIndex', 'ProviderName'
        ));

        $this->singleElementsFromXml($node, $context, array(
            'Subject' => array('saml', 'AerialShip\LightSaml\Model\Assertion\Subject'),
            'NameIDPolicy' => array('samlp', 'AerialShip\LightSaml\Model\Protocol\NameIDPolicy'),
            'Conditions' => array('saml', 'AerialShip\LightSaml\Model\Assertion\Conditions'),
        ));
    }

}