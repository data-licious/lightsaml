<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Helper;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\Model\XmlDSig\Signature;
use AerialShip\LightSaml\SamlConstants;

class EntitiesDescriptor extends AbstractSamlModel
{
    /** @var  int */
    protected $validUntil;

    /** @var  string */
    protected $cacheDuration;

    /** @var  string */
    protected $id;

    /** @var  string */
    protected $name;

    /** @var  Signature */
    protected $signature;

    /** @var EntitiesDescriptor[]|EntityDescriptor[] */
    protected $items = array();


    /**
     * @param string $cacheDuration
     * @return $this|EntitiesDescriptor
     * @throws \InvalidArgumentException
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
     * @return string
     */
    public function getCacheDuration()
    {
        return $this->cacheDuration;
    }

    /**
     * @param string $id
     * @return $this|EntitiesDescriptor
     */
    public function setID($id)
    {
        $this->id = (string)$id;

        return $this;
    }

    /**
     * @return string
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return $this|EntitiesDescriptor
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \AerialShip\LightSaml\Model\XmlDSig\Signature $signature
     * @return $this|EntitiesDescriptor
     */
    public function setSignature(Signature $signature)
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\XmlDSig\Signature
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param int|string $validUntil
     * @return $this|EntitiesDescriptor
     * @throws \InvalidArgumentException
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
     * @param EntitiesDescriptor|EntityDescriptor $item
     * @return $this|EntitiesDescriptor
     * @throws \InvalidArgumentException
     */
    public function addItem($item)
    {
        if (false == $item instanceof EntitiesDescriptor && false == $item instanceof EntityDescriptor) {
            throw new \InvalidArgumentException('Expected EntitiesDescriptor or EntityDescriptor');
        }
        if ($item === $this) {
            throw new \InvalidArgumentException('Circular reference detected');
        }
        if ($item instanceof EntitiesDescriptor) {
            if ($item->containsItem($this)) {
                throw new \InvalidArgumentException('Circular reference detected');
            }
        }
        $this->items[] = $item;
        return $this;
    }


    /**
     * @param EntitiesDescriptor|EntityDescriptor $item
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function containsItem($item)
    {
        if (false == $item instanceof EntitiesDescriptor && false == $item instanceof EntityDescriptor) {
            throw new \InvalidArgumentException('Expected EntitiesDescriptor or EntityDescriptor');
        }
        foreach ($this->items as $i) {
            if ($i === $item) {

                return true;
            }
            if ($i instanceof EntitiesDescriptor) {
                if ($i->containsItem($item)) {

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return EntitiesDescriptor[]|EntityDescriptor[]
     */
    public function getAllItems()
    {
        return $this->items;
    }


    /**
     * @return EntityDescriptor[]
     */
    public function getAllEntityDescriptors()
    {
        $result = array();
        foreach ($this->items as $item) {
            if ($item instanceof EntitiesDescriptor) {
                $result = array_merge($result, $item->getAllEntityDescriptors());
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * @param string $entityId
     * @return EntityDescriptor|null
     */
    public function getByEntityId($entityId)
    {
        foreach ($this->getAllEntityDescriptors() as $entityDescriptor) {
            if ($entityDescriptor->getEntityID() == $entityId) {
                return $entityDescriptor;
            }
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
        $result = $this->createElement('EntitiesDescriptor', SamlConstants::NS_METADATA, $parent, $context);

        $this->attributesToXml(array('validUntil', 'cacheDuration', 'ID', 'Name'), $result);

        $this->singleElementsToXml(array('Signature'), $result, $context);

        $this->manyElementsToXml($this->getAllItems(), $result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'EntitiesDescriptor', SamlConstants::NS_METADATA);

        $this->attributesFromXml($node, array('validUntil', 'cacheDuration', 'ID', 'Name'));

        $this->singleElementsFromXml($node, $context, array(
            'Signature' => array('ds', 'AerialShip\LightSaml\Model\XmlDSig\Signature'),
        ));

        $this->manyElementsFromXml($node, $context, 'EntitiesDescriptor', 'md',
            'AerialShip\LightSaml\Model\Metadata\EntitiesDescriptor', 'addItem');
        $this->manyElementsFromXml($node, $context, 'EntityDescriptor', 'md',
            'AerialShip\LightSaml\Model\Metadata\EntityDescriptor', 'addItem');
    }

}