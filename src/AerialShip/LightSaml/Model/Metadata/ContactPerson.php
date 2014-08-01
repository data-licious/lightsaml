<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class ContactPerson extends AbstractSamlModel
{
    /** @var  string|null */
    protected $company;

    /** @var  string|null */
    protected $givenName;

    /** @var  string|null */
    protected $surName;

    /** @var  string|null */
    protected $emailAddress;

    /** @var  string|null */
    protected $telephoneNumber;

    /**
     * @param null|string $company
     * @return $this|ContactPerson
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null|string $emailAddress
     * @return $this|ContactPerson
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @param null|string $givenName
     * @return $this|ContactPerson
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * @param null|string $surName
     * @return $this|ContactPerson
     */
    public function setSurName($surName)
    {
        $this->surName = $surName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSurName()
    {
        return $this->surName;
    }

    /**
     * @param null|string $telephoneNumber
     * @return $this|ContactPerson
     */
    public function setTelephoneNumber($telephoneNumber)
    {
        $this->telephoneNumber = $telephoneNumber;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTelephoneNumber()
    {
        return $this->telephoneNumber;
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->createElement('ContactPerson', null, $parent, $context);

        $this->singleElementsToXml(
            array('Company', 'GivenName', 'SurName', 'EmailAddress', 'TelephoneNumber'),
            $parent,
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
        $this->checkXmlNodeName($node, 'ContactPerson', SamlConstants::NS_METADATA);

        $this->singleElementsFromXml($node, $context, array(
            'Company' => array('md', null),
            'GivenName' => array('md', null),
            'SurName' => array('md', null),
            'EmailAddress' => array('md', null),
            'TelephoneNumber' => array('md', null),
        ));
    }


} 