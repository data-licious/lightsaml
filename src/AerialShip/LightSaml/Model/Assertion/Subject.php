<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class Subject extends AbstractSamlModel
{
    /** @var NameID */
    protected $nameId;

    /** @var SubjectConfirmation[] */
    protected $subjectConfirmation = array();



    /**
     * @param \AerialShip\LightSaml\Model\Assertion\NameID $nameId
     * @return $this|Subject
     */
    public function setNameID(NameID $nameId = null)
    {
        $this->nameId = $nameId;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\NameID
     */
    public function getNameID()
    {
        return $this->nameId;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\SubjectConfirmation $subjectConfirmation
     * @return $this|Subject
     */
    public function addSubjectConfirmation(SubjectConfirmation $subjectConfirmation)
    {
        $this->subjectConfirmation[] = $subjectConfirmation;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\SubjectConfirmation[]
     */
    public function getAllSubjectConfirmations()
    {
        return $this->subjectConfirmation;
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('Subject', null, $parent, $context);

        $this->singleElementsToXml(array('NameID'), $result, $context);
        $this->manyElementsToXml($this->getAllSubjectConfirmations(), $result, $context, null);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Subject', SamlConstants::NS_ASSERTION);

        $this->singleElementsFromXml($node, $context, array(
            'NameID' => array('saml', 'AerialShip\LightSaml\Model\Assertion\NameID'),
        ));

        $this->manyElementsFromXml($node, $context, 'SubjectConfirmation', 'saml',
            'AerialShip\LightSaml\Model\Assertion\SubjectConfirmation', 'addSubjectConfirmation');
    }

}