<?php

namespace AerialShip\LightSaml\Model\XmlDSig;

use AerialShip\LightSaml\Error\LightSamlSecurityException;
use AerialShip\LightSaml\Error\LightSamlXmlException;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\SamlConstants;
use AerialShip\LightSaml\Security\KeyHelper;

class SignatureXmlValidator extends SignatureValidator
{
    /** @var \XMLSecurityDSig */
    protected $signature = null;

    /** @var string[] */
    protected $certificates = array();


    /**
     * @param string $certificate
     */
    public function addCertificate($certificate)
    {
        $this->certificates[] = (string)$certificate;
    }

    /**
     * @return \string[]
     */
    public function getAllCertificates()
    {
        return $this->certificates;
    }

    /**
     * @param \XMLSecurityDSig $signature
     */
    public function setSignature(\XMLSecurityDSig $signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return \XMLSecurityDSig
     */
    public function getSignature()
    {
        return $this->signature;
    }



    /**
     * @param \XMLSecurityKey $key
     * @return bool
     * @throws \AerialShip\LightSaml\Error\LightSamlSecurityException
     */
    public function validate(\XMLSecurityKey $key)
    {
        if ($this->signature == null) {
            return false;
        }

        if ($key->type != \XMLSecurityKey::RSA_SHA1) {
            throw new LightSamlSecurityException('Key type must be RSA_SHA1 but got '.$key->type);
        }

        $key = $this->castKeyIfNecessary($key);

        $ok = $this->signature->verify($key);
        if (!$ok) {
            throw new LightSamlSecurityException('Unable to verify Signature');
        }
        return true;
    }


    /**
     * @param \XMLSecurityKey $key
     * @return \XMLSecurityKey
     */
    private function castKeyIfNecessary(\XMLSecurityKey $key)
    {
        $algorithm = $this->getAlgorithm();
        if ($key->type === \XMLSecurityKey::RSA_SHA1 && $algorithm !== $key->type) {
            $key = KeyHelper::castKey($key, $algorithm);
        }

        return $key;
    }

    /**
     * @return string
     * @throws \AerialShip\LightSaml\Error\LightSamlXmlException
     */
    private function getAlgorithm()
    {
        $xpath = new \DOMXPath(
            $this->signature->sigNode instanceof \DOMDocument
            ? $this->signature->sigNode
            : $this->signature->sigNode->ownerDocument
        );
        $xpath->registerNamespace('ds', \XMLSecurityDSig::XMLDSIGNS);

        $list = $xpath->query('./ds:SignedInfo/ds:SignatureMethod', $this->signature->sigNode);
        if (!$list || $list->length == 0) {
            throw new LightSamlXmlException('Missing SignatureMethod element');
        }
        /** @var $sigMethod \DOMElement */
        $sigMethod = $list->item(0);
        if (!$sigMethod->hasAttribute('Algorithm')) {
            throw new LightSamlXmlException('Missing Algorithm-attribute on SignatureMethod element.');
        }
        $algorithm = $sigMethod->getAttribute('Algorithm');

        return $algorithm;
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
     * @throws \AerialShip\LightSaml\Error\LightSamlSecurityException
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Signature', SamlConstants::NS_XMLDSIG);

        $this->signature = new \XMLSecurityDSig();
        $this->signature->idKeys[] = $this->getIDName();
        $this->signature->sigNode = $node;
        $this->signature->canonicalizeSignedInfo();

        if (false == $this->signature->validateReference()) {
            throw new LightSamlSecurityException('Digest validation failed');
        }

        $this->certificates = array();
        $list = $context->getXpath()->query('./ds:KeyInfo/ds:X509Data/ds:X509Certificate', $this->signature->sigNode);
        foreach ($list as $certNode) {
            $certData = trim($certNode->textContent);
            $certData = str_replace(array("\r", "\n", "\t", ' '), '', $certData);
            $this->certificates[] = $certData;
        }
    }

}