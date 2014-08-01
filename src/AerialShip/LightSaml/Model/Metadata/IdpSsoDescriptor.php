<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\Assertion\Attribute;
use AerialShip\LightSaml\SamlConstants;

class IdpSsoDescriptor extends SSODescriptor
{
    /** @var  bool|null */
    protected $wantAuthnRequestsSigned;

    /** @var  SingleSignOnService[]|null */
    protected $singleSignOnServices;

    /** @var  Attribute[]|null */
    protected $attributes;



    /**
     * @param bool|null $wantAuthnRequestsSigned
     * @return $this|IdpSsoDescriptor
     */
    public function setWantAuthnRequestsSigned($wantAuthnRequestsSigned)
    {
        $this->wantAuthnRequestsSigned = $wantAuthnRequestsSigned !== null ? (bool)$wantAuthnRequestsSigned : null;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getWantAuthnRequestsSigned()
    {
        return $this->wantAuthnRequestsSigned;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Metadata\SingleSignOnService $singleSignOnService
     * @return $this|IdpSsoDescriptor
     */
    public function addSingleSignOnService(SingleSignOnService $singleSignOnService)
    {
        if (false == is_array($this->singleSignOnServices)) {
            $this->singleSignOnServices = array();
        }
        $this->singleSignOnServices[] = $singleSignOnService;

        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\SingleSignOnService[]|null
     */
    public function getAllSingleSignOnServices()
    {
        return $this->singleSignOnServices;
    }

    /**
     * @param string $binding
     * @return \AerialShip\LightSaml\Model\Metadata\SingleSignOnService[]
     */
    public function getAllSingleSignOnServicesByBinding($binding)
    {
        $result = array();
        foreach ($this->getAllSingleSignOnServices() as $svc) {
            if ($svc->getBinding() == $binding) {
                $result[] = $svc;
            }
        }

        return $result;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Assertion\Attribute $attribute
     * @return $this|IdpSsoDescriptor
     */
    public function addAttribute(Attribute $attribute)
    {
        if (false == is_array($this->attributes)) {
            $this->attributes = array();
        }
        $this->attributes[] = $attribute;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\Attribute[]|null
     */
    public function getAllAttributes()
    {
        return $this->attributes;
    }


    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('IDPSSODescriptor', null, $parent, $context);

        parent::serialize($result, $context);

        $this->attributesToXml(array('WantAuthnRequestsSigned'), $result);

        if ($this->getAllSingleSignOnServices()) {
            foreach ($this->getAllSingleSignOnServices() as $object) {
                $object->serialize($result, $context);
            }
        }
        if ($this->getAllAttributes()) {
            foreach ($this->getAllAttributes() as $object) {
                $object->serialize($result, $context);
            }
        }
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'IDPSSODescriptor', SamlConstants::NS_METADATA);

        parent::deserialize($node, $context);

        $this->attributesFromXml($node, array('WantAuthnRequestsSigned'));

        $this->singleSignOnServices = array();
        $this->manyElementsFromXml($node, $context, 'SingleSignOnService', 'md',
            'AerialShip\LightSaml\Model\Metadata\SingleSignOnService', 'addSingleSignOnService');

        $this->attributes = array();
        $this->manyElementsFromXml($node, $context, 'SingleSignOnService', 'saml',
            'AerialShip\LightSaml\Model\Assertion\Attribute', 'addAttribute');
    }


}