<?php

namespace AerialShip\LightSaml\Model\XmlDSig;

use AerialShip\LightSaml\Error\LightSamlSecurityException;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Security\KeyHelper;

class SignatureStringValidator extends SignatureValidator
{
    /** @var string */
    protected $signature;

    /** @var string */
    protected $algorithm;

    /** @var string */
    protected $data;


    /**
     * @param string|null $signature
     * @param string|null $algorithm
     * @param string|null $data
     */
    public function __construct($signature = null, $algorithm = null, $data = null)
    {
        $this->signature = $signature;
        $this->algorithm = $algorithm;
        $this->data = $data;
    }



    /**
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = (string)$algorithm;
    }

    /**
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = (string)$data;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->signature = (string)$signature;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }



    /**
     * @param \XMLSecurityKey $key
     * @return bool True if validated, False if validation was not performed
     * @throws \AerialShip\LightSaml\Error\LightSamlSecurityException If validation fails
     */
    public function validate(\XMLSecurityKey $key)
    {
        if ($this->getSignature() == null) {
            return false;
        }

        if ($key->type !== \XMLSecurityKey::RSA_SHA1) {
            throw new LightSamlSecurityException('Invalid key type for validating signature on query string');
        }
        if ($key->type !== $this->getAlgorithm()) {
            $key = KeyHelper::castKey($key, $this->getAlgorithm());
        }

        $signature = base64_decode($this->getSignature());
        if (!$key->verifySignature($this->getData(), $signature)) {
            throw new LightSamlSecurityException('Unable to validate signature on query string');
        }

        return true;
    }

    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @throws \LogicException
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        throw new \LogicException('SignatureValidator can not be serialized');
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @throws \LogicException
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        throw new \LogicException('SignatureStringValidator can not be serialized');
    }


}