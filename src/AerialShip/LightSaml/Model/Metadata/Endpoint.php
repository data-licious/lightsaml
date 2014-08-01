<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;

abstract class Endpoint extends AbstractSamlModel
{
    /** @var  string */
    protected $binding;

    /** @var  string */
    protected $location;

    /** @var  string|null */
    protected $responseLocation;



    /**
     * @param string $binding
     * @return $this|Endpoint
     */
    public function setBinding($binding)
    {
        $this->binding = (string)$binding;
        return $this;
    }

    /**
     * @return string
     */
    public function getBinding()
    {
        return $this->binding;
    }

    /**
     * @param string $location
     * @return $this|Endpoint
     */
    public function setLocation($location)
    {
        $this->location = (string)$location;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param null|string $responseLocation
     * @return $this|Endpoint
     */
    public function setResponseLocation($responseLocation)
    {
        $this->responseLocation = $responseLocation ? (string)$responseLocation : null;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getResponseLocation()
    {
        return $this->responseLocation;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->attributesToXml(array('Binding', 'Location', 'ResponseLocation'), $parent);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->attributesFromXml($node, array('Binding', 'Location', 'ResponseLocation'));
    }

}