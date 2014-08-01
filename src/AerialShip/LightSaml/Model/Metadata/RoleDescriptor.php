<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\Model\XmlDSig\Signature;

abstract class RoleDescriptor extends AbstractSamlModel
{
    /** @var  string|null */
    protected $id;

    /** @var  int|null */
    protected $validUntil;

    /** @var  string|null */
    protected $cacheDuration;

    /** @var  string */
    protected $protocolSupportEnumeration;

    /** @var  string|null */
    protected $errorURL;

    /** @var  Signature[]|null */
    protected $signatures;

    /** @var  KeyDescriptor[]|null */
    protected $keyDescriptors;

    /** @var  Organization[]|null */
    protected $organizations;

    /** @var  ContactPerson[]|null */
    protected $contactPersons;


    /**
     * @param null|string $cacheDuration
     * @throws \InvalidArgumentException
     * @return $this|RoleDescriptor
     */
    public function setCacheDuration($cacheDuration)
    {
        if ($cacheDuration) {
            try {
                new \DateInterval((string)$cacheDuration);
            } catch (\Exception $ex) {
                throw new \InvalidArgumentException('Invalid duration format', 0, $ex);
            }
        }
        $this->cacheDuration = $cacheDuration;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCacheDuration()
    {
        return $this->cacheDuration;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Metadata\ContactPerson $contactPerson
     * @return $this|RoleDescriptor
     */
    public function addContactPerson(ContactPerson $contactPerson)
    {
        if (false == is_array($this->contactPersons)) {
            $this->contactPersons = array();
        }
        $this->contactPersons[] = $contactPerson;

        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\ContactPerson[]|null
     */
    public function getAllContactPersons()
    {
        return $this->contactPersons;
    }

    /**
     * @param null|string $errorURL
     * @return $this|RoleDescriptor
     */
    public function setErrorURL($errorURL)
    {
        $this->errorURL = (string)$errorURL;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getErrorURL()
    {
        return $this->errorURL;
    }

    /**
     * @param null|string $id
     * @return $this|RoleDescriptor
     */
    public function setID($id)
    {
        $this->id = (string)$id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Metadata\KeyDescriptor $keyDescriptor
     * @return $this|RoleDescriptor
     */
    public function addKeyDescriptor(KeyDescriptor $keyDescriptor)
    {
        if (false == is_array($this->keyDescriptors)) {
            $this->keyDescriptors = array();
        }
        $this->keyDescriptors[] = $keyDescriptor;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\KeyDescriptor[]|null
     */
    public function getAllKeyDescriptors()
    {
        return $this->keyDescriptors;
    }

    /**
     * @param string $use
     * @return \AerialShip\LightSaml\Model\Metadata\KeyDescriptor[]
     */
    public function getAllKeyDescriptorsByUse($use)
    {
        $result = array();
        foreach ($this->getAllKeyDescriptors() as $kd) {
            if ($kd->getUse() == $use) {
                $result[] = $kd;
            }
        }

        return $result;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Metadata\Organization $organization
     * @return $this|RoleDescriptor
     */
    public function addOrganization(Organization $organization)
    {
        if (false == is_array($this->organizations)) {
            $this->organizations = array();
        }
        $this->organizations[] = $organization;

        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\Organization[]|null
     */
    public function getAllOrganizations()
    {
        return $this->organizations;
    }

    /**
     * @param string $protocolSupportEnumeration
     * @return $this|RoleDescriptor
     */
    public function setProtocolSupportEnumeration($protocolSupportEnumeration)
    {
        $this->protocolSupportEnumeration = (string)$protocolSupportEnumeration;
        return $this;
    }

    /**
     * @return string
     */
    public function getProtocolSupportEnumeration()
    {
        return $this->protocolSupportEnumeration;
    }

    /**
     * @param \AerialShip\LightSaml\Model\XmlDSig\Signature $signature
     * @return $this|RoleDescriptor
     */
    public function addSignature(Signature $signature)
    {
        if (false == is_array($this->signatures)) {
            $this->signatures = array();
        }
        $this->signatures = $signature;

        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\XmlDSig\Signature[]|null
     */
    public function getAllSignatures()
    {
        return $this->signatures;
    }

    /**
     * @param int|null $validUntil
     * @return $this|RoleDescriptor
     */
    public function setValidUntil($validUntil)
    {
        $this->validUntil = Helper::getTimestampFromValue($validUntil);
        return $this;
    }

    /**
     * @return string
     */
    public function getValidUntilString()
    {
        if ($this->validUntil) {
            return Helper::time2string($this->validUntil);
        }
        return null;
    }

    /**
     * @return int
     */
    public function getValidUntilTimestamp()
    {
        return $this->validUntil;
    }

    /**
     * @return \DateTime|null
     */
    public function getValidUntilDateTime()
    {
        if ($this->validUntil) {
            return new \DateTime('@'.$this->validUntil);
        }
        return null;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->attributesToXml(
            array('protocolSupportEnumeration', 'ID', 'validUntil', 'cacheDuration', 'errorURL'),
            $parent
        );

        $this->manyElementsToXml($this->getAllSignatures(), $parent, $context, null);
        $this->manyElementsToXml($this->getAllKeyDescriptors(), $parent, $context, null);
        $this->manyElementsToXml($this->getAllOrganizations(), $parent, $context, null);
        $this->manyElementsToXml($this->getAllContactPersons(), $parent, $context, null);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->attributesFromXml($node,
            array('protocolSupportEnumeration', 'ID', 'validUntil', 'cacheDuration', 'errorURL'));

        $this->manyElementsFromXml($node, $context, 'Signature', 'ds',
            'AerialShip\LightSaml\Model\XmlDSig\Signature', 'addSignature');
        $this->manyElementsFromXml($node, $context, 'KeyDescriptor', 'md',
            'AerialShip\LightSaml\Model\MetaData\KeyDescriptor', 'addKeyDescriptor');
        $this->manyElementsFromXml($node, $context, 'Organization', 'md',
            'AerialShip\LightSaml\Model\MetaData\Organization', 'addOrganization');
        $this->manyElementsFromXml($node, $context, 'ContactPerson', 'md',
            'AerialShip\LightSaml\Model\MetaData\ContactPerson', 'addContactPerson');
    }


} 