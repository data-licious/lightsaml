<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class SubjectConfirmation extends AbstractSamlModel
{
    /** @var string */
    protected $method;

    /** @var NameID|null */
    protected $nameId;

    /** @var EncryptedElement|null */
    protected $encryptedId;

    /** @var SubjectConfirmationData|null */
    protected $subjectConfirmationData;



    /**
     * @param string $method
     * @return $this|SubjectConfirmation
     */
    public function setMethod($method)
    {
        $this->method = (string)$method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\EncryptedElement|null $encryptedId
     * @return $this|SubjectConfirmation
     */
    public function setEncryptedId(EncryptedElement $encryptedId = null)
    {
        $this->encryptedId = $encryptedId;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\EncryptedElement|null
     */
    public function getEncryptedId()
    {
        return $this->encryptedId;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\NameID|null $nameId
     * @return $this|SubjectConfirmation
     */
    public function setNameID(NameID $nameId = null)
    {
        $this->nameId = $nameId;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\NameID|null
     */
    public function getNameID()
    {
        return $this->nameId;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\SubjectConfirmationData|null $subjectConfirmationData
     * @return $this|SubjectConfirmation
     */
    public function setSubjectConfirmationData(SubjectConfirmationData $subjectConfirmationData = null)
    {
        $this->subjectConfirmationData = $subjectConfirmationData;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\SubjectConfirmationData|null
     */
    public function getSubjectConfirmationData()
    {
        return $this->subjectConfirmationData;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('SubjectConfirmation', null, $parent, $context);

        $this->attributesToXml(array('Method'), $result);

        $this->singleElementsToXml(
            array('NameID', 'EncryptedID', 'SubjectConfirmationData'),
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
        $this->checkXmlNodeName($node, 'SubjectConfirmation', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array('Method'));

        $this->singleElementsFromXml($node, $context, array(
            'NameID' => array('saml', 'AerialShip\LightSaml\Model\Assertion\NameID'),
            'EncryptedID' => array('saml', 'AerialShip\LightSaml\Model\Assertion\EncryptedID'),
            'SubjectConfirmationData' => array('saml', 'AerialShip\LightSaml\Model\Assertion\SubjectConfirmationData'),
        ));
    }

}