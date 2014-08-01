<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;

abstract class SSODescriptor extends RoleDescriptor
{
    /** @var  SingleLogoutService[]|null */
    protected $singleLogoutServices;

    /** @var  string[]|null */
    protected $nameIDFormats;



    /**
     * @param \AerialShip\LightSaml\Model\Metadata\SingleLogoutService $singleLogoutService
     * @return $this|SSODescriptor
     */
    public function addSingleLogoutService(SingleLogoutService $singleLogoutService)
    {
        if (false == is_array($this->singleLogoutServices)) {
            $this->singleLogoutServices = array();
        }
        $this->singleLogoutServices[] = $singleLogoutService;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Metadata\SingleLogoutService[]|null
     */
    public function getAllSingleLogoutServices()
    {
        return $this->singleLogoutServices;
    }

    /**
     * @param string $binding
     * @return \AerialShip\LightSaml\Model\Metadata\SingleLogoutService[]
     */
    public function getAllSingleLogoutServicesByBinding($binding)
    {
        $result = array();
        foreach ($this->getAllSingleLogoutServices() as $svc) {
            if ($binding == $svc->getBinding()) {
                $result[] = $svc;
            }
        }

        return $result;
    }

    /**
     * @param string $nameIDFormat
     * @return $this|SSODescriptor
     */
    public function addNameIDFormat($nameIDFormat)
    {
        $this->nameIDFormats[] = $nameIDFormat;
        return $this;
    }

    /**
     * @return null|string[]
     */
    public function getAllNameIDFormats()
    {
        return $this->nameIDFormats;
    }

    /**
     * @param string $nameIdFormat
     * @return bool
     */
    public function hasNameIDFormat($nameIdFormat)
    {
        if ($this->nameIDFormats) {
            foreach ($this->nameIDFormats as $format) {
                if ($format == $nameIdFormat) {
                    return true;
                }
            }
        }

        return false;
    }

    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        parent::serialize($parent, $context);

        $this->manyElementsToXml($this->getAllNameIDFormat(), $parent, $context, 'NameIDFormat');

        $this->manyElementsToXml($this->getAllSingleLogoutServices(), $parent, $context, null);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        parent::deserialize($node, $context);

        $this->manyElementsFromXml($node, $context, 'NameIDFormat', 'md', null, 'addNameIDFormat');

        $this->manyElementsFromXml($node, $context, 'SingleLogoutService', 'md',
            'AerialShip\LightSaml\Model\Metadata\SingleLogoutService', 'addSingleLogoutService');
    }

}