<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Error\LightSamlModelException;
use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\Model\XmlDSig\Signature;
use AerialShip\LightSaml\SamlConstants;

class Assertion extends AbstractSamlModel
{
    //region Attributes

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $version = SamlConstants::VERSION_20;

    /**
     * @var int
     */
    protected $issueInstant;

    //endregion


    //region Elements

    /**
     * @var Issuer
     */
    protected $issuer;

    /**
     * @var Signature|null
     */
    protected $signature;

    /**
     * @var Subject|null
     */
    protected $subject;

    /**
     * @var Conditions|null
     */
    protected $conditions;

    /**
     * @var AuthnStatement|null
     */
    protected $authnStatement;

    /**
     * @var AttributeStatement|null
     */
    protected $attributeStatement;

    //endregion





    //region Getters & Setters

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\Conditions|null $conditions
     * @return $this|Assertion
     */
    public function setConditions(Conditions $conditions = null)
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
     * @param string $id
     * @return $this|Assertion
     */
    public function setId($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|int|\DateTime $issueInstant
     * @throws \InvalidArgumentException
     * @return $this|Assertion
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
     * @return string
     */
    public function getIssueInstantDateTime()
    {
        if ($this->issueInstant) {
            return new \DateTime('@'.$this->issueInstant);
        }
        return null;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\Issuer $issuer
     * @return $this|Assertion
     */
    public function setIssuer(Issuer $issuer = null)
    {
        $this->issuer = $issuer;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Issuer
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param \AerialShip\LightSaml\Model\XmlDSig\Signature $signature
     * @return $this|Assertion
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
     * @param \AerialShip\LightSaml\Model\Assertion\Subject $subject
     * @return $this|Assertion
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $version
     * @return $this|Assertion
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
     * @param \AerialShip\LightSaml\Model\Assertion\AttributeStatement|null $attributeStatement
     * @return $this|Assertion
     */
    public function setAttributeStatement(AttributeStatement $attributeStatement = null)
    {
        $this->attributeStatement = $attributeStatement;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\AttributeStatement|null
     */
    public function getAttributeStatement()
    {
        return $this->attributeStatement;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\AuthnStatement|null $authnStatement
     * @return $this|Assertion
     */
    public function setAuthnStatement(AuthnStatement $authnStatement = null)
    {
        $this->authnStatement = $authnStatement;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\AuthnStatement|null
     */
    public function getAuthnStatement()
    {
        return $this->authnStatement;
    }
    //endregion


    protected function prepareForXml()
    {
        if (false == $this->getIssuer()) {
            throw new LightSamlModelException('Assertion must have Issuer set');
        }
        if (false == $this->getId()) {
            $this->setId(Helper::generateID());
        }
        if (false == $this->getIssueInstantTimestamp()) {
            $this->setIssueInstant(time());
        }
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->prepareForXml();

        $result = $this->createElement('saml:Assertion', SamlConstants::NS_ASSERTION, $parent, $context);

        $this->attributesToXml(array('ID', 'Version', 'IssueInstant'), $result);

        $this->singleElementsToXml(
            array('Issuer', 'Subject', 'Conditions', 'AttributeStatement', 'AuthnStatement'),
            $result,
            $context
        );

        // must be added at the end
        $this->singleElementsToXml(array('Signature'), $parent, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Assertion', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array('ID', 'Version', 'IssueInstant'));

        $this->singleElementsFromXml($node, $context, array(
            'Issuer' => array('saml', 'AerialShip\LightSaml\Model\Assertion\Issuer'),
            'Subject' => array('saml', 'AerialShip\LightSaml\Model\Assertion\Subject'),
            'Conditions' => array('saml', 'AerialShip\LightSaml\Model\Assertion\Conditions'),
            'AttributeStatement' => array('saml', 'AerialShip\LightSaml\Model\Assertion\AttributeStatement'),
            'AuthnStatement' => array('saml', 'AerialShip\LightSaml\Model\Assertion\AuthnStatement'),
        ));
    }

}