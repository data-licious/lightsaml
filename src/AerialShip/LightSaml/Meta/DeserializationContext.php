<?php

namespace AerialShip\LightSaml\Meta;

use AerialShip\LightSaml\SamlConstants;

class DeserializationContext
{
    /** @var  \DOMDocument */
    private $document;

    /** @var  \DOMXPath */
    private $xpath;


    public function __construct(\DOMDocument $document = null)
    {
        $this->document = $document ? $document : new \DOMDocument();
    }

    /**
     * @return \DOMDocument
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return \DOMXPath
     */
    public function getXpath()
    {
        if (null == $this->xpath) {
            $this->xpath = new \DOMXPath($this->document);
            $this->xpath->registerNamespace('saml', SamlConstants::NS_ASSERTION);
            $this->xpath->registerNamespace('samlp', SamlConstants::NS_PROTOCOL);
            $this->xpath->registerNamespace('md', SamlConstants::NS_METADATA);
            $this->xpath->registerNamespace('ds', SamlConstants::NS_XMLDSIG);
        }
        return $this->xpath;
    }

} 