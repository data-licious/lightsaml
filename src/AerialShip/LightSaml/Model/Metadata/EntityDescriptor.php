<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\Model\XmlDSig\Signature;
use AerialShip\LightSaml\SamlConstants;

class EntityDescriptor extends AbstractSamlModel
{
    /** @var string */
    protected $entityID;

    /** @var  int|null */
    protected $validUntil;

    /** @var  string|null */
    protected $cacheDuration;

    /** @var  string|null */
    protected $id;

    /** @var  Signature|null */
    protected $signature;

    /** @var IdpSsoDescriptor[]|SpSsoDescriptor[] */
    protected $items;

    /** @var  Organization|null */
    protected $organization;

    /** @var  ContactPerson|null */
    protected $contactPerson;



    /**
     * @param string|null $cacheDuration
     * @throws \InvalidArgumentException
     * @return $this|EntityDescriptor
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
     * @return string|null
     */
    public function getCacheDuration()
    {
        return $this->cacheDuration;
    }

    /**
     * @param string $entityID
     * @return $this|EntityDescriptor
     */
    public function setEntityID($entityID)
    {
        $this->entityID = (string)$entityID;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityID()
    {
        return $this->entityID;
    }

    /**
     * @param string|null $id
     * @return $this|EntityDescriptor
     */
    public function setID($id)
    {
        $this->id = $id !== null ? (string)$id : null;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Metadata\IdpSsoDescriptor|\AerialShip\LightSaml\Model\Metadata\SpSsoDescriptor $item
     * @throws \InvalidArgumentException
     * @return $this|EntityDescriptor
     */
    public function addItem($item)
    {
        if (false == $item instanceof IdpSsoDescriptor &&
            false == $item instanceof SpSsoDescriptor
        ) {
            throw new \InvalidArgumentException("EntityDescriptor item must be IdpSsoDescriptor or SpSsoDescriptor");
        }

        if (false == is_array($this->items)) {
            $this->items = array();
        }

        $this->items[] = $item;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\IdpSsoDescriptor[]|\AerialShip\LightSaml\Model\Metadata\SpSsoDescriptor[]
     */
    public function getAllItems()
    {
        return $this->items;
    }

    /**
     * @return IdpSsoDescriptor[]
     */
    public function getAllIdpSsoDescriptors()
    {
        $result = array();
        foreach ($this->getAllItems() as $item) {
            if ($item instanceof IdpSsoDescriptor) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @return SpSsoDescriptor[]
     */
    public function getAllSpSsoDescriptors()
    {
        $result = array();
        foreach ($this->getAllItems() as $item) {
            if ($item instanceof SpSsoDescriptor) {
                $result[] = $item;
            }
        }

        return $result;
    }

    /**
     * @return IdpSsoDescriptor|null
     */
    public function getFirstIdpSsoDescriptor()
    {
        return array_shift($this->getAllIdpSsoDescriptors());
    }

    /**
     * @return SpSsoDescriptor|null
     */
    public function getFirstSpSsoDescriptor()
    {
        return array_shift($this->getAllSpSsoDescriptors());
    }

    /**
     * @param \AerialShip\LightSaml\Model\XmlDSig\Signature|null $signature
     * @return $this|EntityDescriptor
     */
    public function setSignature(Signature $signature)
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
     * @param int $validUntil
     * @return $this|EntityDescriptor
     */
    public function setValidUntil($validUntil)
    {
        $this->validUntil = Helper::getTimestampFromValue($validUntil);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getValidUntilTimestamp()
    {
        return $this->validUntil;
    }

    /**
     * @return string|null
     */
    public function getValidUntilString()
    {
        if ($this->validUntil) {
            return Helper::time2string($this->validUntil);
        }
        return null;
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
        $result = $this->createElement('EntityDescriptor', SamlConstants::NS_METADATA, $parent, $context);

        $this->attributesToXml(array('entityID', 'validUntil', 'cacheDuration', 'ID'), $result);

        $this->manyElementsToXml($this->getAllItems(), $result, $context, null);

        $this->singleElementsToXml(array('Signature'), $result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'EntityDescriptor', SamlConstants::NS_METADATA);

        $this->attributesFromXml($node, array('entityID', 'validUntil', 'cacheDuration', 'ID'));

        $this->items = array();

        $this->manyElementsFromXml($node, $context, 'IDPSSODescriptor', 'md',
            'AerialShip\LightSaml\Model\Metadata\IdpSsoDescriptor', 'addItem');

        $this->manyElementsFromXml($node, $context, 'SPSSODescriptor', 'md',
            'AerialShip\LightSaml\Model\Metadata\SpSsoDescriptor', 'addItem');

        $this->singleElementsFromXml($node, $context, array(
            'Signature' => array('ds', 'AerialShip\LightSaml\Model\XmlDSig\SignatureXmlValidator')
        ));
    }


}