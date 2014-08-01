<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;

class SpSsoDescriptor extends SSODescriptor
{
    /** @var  bool|null */
    protected $authnRequestsSigned;

    /** @var  bool|null */
    protected $wantAssertionsSigned;

    /** @var  AssertionConsumerService[]|null */
    protected $assertionConsumerServices;



    /**
     * @param \AerialShip\LightSaml\Model\Metadata\AssertionConsumerService $assertionConsumerService
     * @return $this|SpSsoDescriptor
     */
    public function addAssertionConsumerService(AssertionConsumerService $assertionConsumerService)
    {
        if (false == is_array($this->assertionConsumerServices)) {
            $this->assertionConsumerServices = array();
        }
        $this->assertionConsumerServices[] = $assertionConsumerService;

        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\AssertionConsumerService[]|null
     */
    public function getAllAssertionConsumerServices()
    {
        return $this->assertionConsumerServices;
    }

    /**
     * @param string $binding
     * @return \AerialShip\LightSaml\Model\Metadata\AssertionConsumerService[]
     */
    public function getAllAssertionConsumerServicesByBinding($binding)
    {
        $result = array();
        foreach ($this->getAllAssertionConsumerServices() as $svc) {
            if ($svc->getBinding() == $binding ) {
                $result[] = $svc;
            }
        }

        return $result;
    }

    /**
     * @param bool|null $authnRequestsSigned
     * @return $this|SpSsoDescriptor
     */
    public function setAuthnRequestsSigned($authnRequestsSigned)
    {
        $this->authnRequestsSigned = $authnRequestsSigned !== null ? (bool)$authnRequestsSigned : null;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAuthnRequestsSigned()
    {
        return $this->authnRequestsSigned;
    }

    /**
     * @param bool|null $wantAssertionsSigned
     * @return $this|SpSsoDescriptor
     */
    public function setWantAssertionsSigned($wantAssertionsSigned)
    {
        $this->wantAssertionsSigned = $wantAssertionsSigned !== null ? (bool)$wantAssertionsSigned : null;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getWantAssertionsSigned()
    {
        return $this->wantAssertionsSigned;
    }


    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('md:SPSSODescriptor', SamlConstants::NS_METADATA, $parent, $context);

        parent::serialize($result, $context);

        $this->attributesToXml(array('AuthnRequestsSigned', 'WantAssertionsSigned'), $result);

        $this->manyElementsToXml($this->getAllAssertionConsumerServices(), $result, $context, null);

    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'SPSSODescriptor', SamlConstants::NS_METADATA);

        parent::deserialize($node, $context);

        $this->attributesFromXml($node, array('AuthnRequestsSigned', 'WantAssertionsSigned'));

        $this->manyElementsFromXml($node, $context, 'AssertionConsumerService', 'md',
            'AerialShip\LightSaml\Model\Metadata\AssertionConsumerService', 'addAssertionConsumerService');
    }

}