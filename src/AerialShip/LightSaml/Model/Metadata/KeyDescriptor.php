<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Error\LightSamlXmlException;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;
use AerialShip\LightSaml\Security\X509Certificate;

class KeyDescriptor extends AbstractSamlModel
{
    const USE_SIGNING = 'signing';
    const USE_ENCRYPTION = 'encryption';


    /** @var string */
    protected $use;

    /** @var X509Certificate */
    private $certificate;


    /**
     * @param string|null $use
     * @param X509Certificate|null $certificate
     */
    public function __construct($use = null, X509Certificate $certificate = null)
    {
        $this->use = $use;
        $this->certificate = $certificate;
    }


    /**
     * @param string $use
     * @throws \InvalidArgumentException
     */
    public function setUse($use)
    {
        $use = trim($use);
        if (false != $use && self::USE_ENCRYPTION != $use && self::USE_SIGNING != $use) {
            throw new \InvalidArgumentException(sprintf("Invalid use value '%s'", $use));
        }
        $this->use = $use;
    }

    /**
     * @return string
     */
    public function getUse()
    {
        return $this->use;
    }


    /**
     * @param X509Certificate $certificate
     */
    public function setCertificate(X509Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * @return X509Certificate
     */
    public function getCertificate()
    {
        return $this->certificate;
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('md:KeyDescriptor', SamlConstants::NS_METADATA, $parent, $context);

        $this->attributesToXml(array('use'), $result);

        $keyInfo = $context->getDocument()->createElementNS(SamlConstants::NS_XMLDSIG, 'ds:KeyInfo');
        $result->appendChild($keyInfo);
        $xData = $context->getDocument()->createElementNS(SamlConstants::NS_XMLDSIG, 'ds:X509Data');
        $keyInfo->appendChild($xData);
        $xCert = $context->getDocument()->createElementNS(SamlConstants::NS_XMLDSIG, 'ds:X509Certificate');
        $xData->appendChild($xCert);
        $xCert->nodeValue = $this->getCertificate()->getData();
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @throws \AerialShip\LightSaml\Error\LightSamlXmlException
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'KeyDescriptor', SamlConstants::NS_METADATA);

        $this->attributesFromXml($node, array('use'));

        $list = $context->getXpath()->query('./ds:KeyInfo/ds:X509Data/ds:X509Certificate', $node);
        if (1 != $list->length) {
            throw new LightSamlXmlException("Missing X509Certificate node");
        }

        /** @var $x509CertificateNode \DOMElement */
        $x509CertificateNode = $list->item(0);
        $certificateData = trim($x509CertificateNode->textContent);
        if (false == $certificateData) {
            throw new LightSamlXmlException("Missing certificate data");
        }

        $this->certificate = new X509Certificate();
        $this->certificate->setData($certificateData);
    }
}