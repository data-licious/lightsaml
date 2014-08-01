<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class AuthnContext extends AbstractSamlModel
{
    /**
     * @var string|null
     */
    protected $authnContextClassRef;

    /**
     * @var string|null
     */
    protected $authnContextDecl;

    /**
     * @var string|null
     */
    protected $authnContextDeclRef;

    /**
     * @var string|null
     */
    protected $authenticatingAuthority;



    /**
     * @param string|null $authenticatingAuthority
     * @return $this|AuthnContext
     */
    public function setAuthenticatingAuthority($authenticatingAuthority)
    {
        $this->authenticatingAuthority = (string)$authenticatingAuthority;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthenticatingAuthority()
    {
        return $this->authenticatingAuthority;
    }

    /**
     * @param null|string $authnContextClassRef
     * @return $this|AuthnContext
     */
    public function setAuthnContextClassRef($authnContextClassRef)
    {
        $this->authnContextClassRef = (string)$authnContextClassRef;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAuthnContextClassRef()
    {
        return $this->authnContextClassRef;
    }

    /**
     * @param null|string $authnContextDecl
     * @return $this|AuthnContext
     */
    public function setAuthnContextDecl($authnContextDecl)
    {
        $this->authnContextDecl = (string)$authnContextDecl;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAuthnContextDecl()
    {
        return $this->authnContextDecl;
    }

    /**
     * @param null|string $authnContextDeclRef
     * @return $this|AuthnContext
     */
    public function setAuthnContextDeclRef($authnContextDeclRef)
    {
        $this->authnContextDeclRef = (string)$authnContextDeclRef;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAuthnContextDeclRef()
    {
        return $this->authnContextDeclRef;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('AuthnContext', null, $parent, $context);

        $this->singleElementsToXml(
            array('AuthnContextClassRef', 'AuthnContextDecl', 'AuthnContextDeclRef', 'AuthenticatingAuthority'),
            $result,
            $context
        );
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'AuthnContext', SamlConstants::NS_ASSERTION);

        $this->singleElementsFromXml($node, $context, array(
            'AuthnContextClassRef' => array('saml', null),
            'AuthnContextDecl' => array('saml', null),
            'AuthnContextDeclRef' => array('saml', null),
            'AuthenticatingAuthority' => array('saml', null),
        ));
    }

}