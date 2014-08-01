<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Error\LightSamlXmlException;
use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Model\SamlElementInterface;
use AerialShip\LightSaml\Model\XmlDSig\SignatureCreator;
use AerialShip\LightSaml\SamlConstants;
use AerialShip\LightSaml\Security\X509Certificate;

abstract class Message
{
    /**
     * @param string $xml
     * @return SamlElementInterface|AuthnRequest|LogoutRequest|LogoutResponse|Response
     * @throws \AerialShip\LightSaml\Error\LightSamlXmlException
     * @throws \Exception
     */
    public static function fromXML($xml)
    {

        $context = new DeserializationContext();
        $context->getDocument()->loadXML($xml);

        if (SamlConstants::NS_PROTOCOL !== $context->getDocument()->namespaceURI) {
            throw new LightSamlXmlException(sprintf("Invalid namespace %s", $context->getDocument()->namespaceURI));
        }

        $map = array(
            'AttributeQuery' => null,
            'AuthnRequest' => '\AerialShip\LightSaml\Model\Protocol\AuthnRequest',
            'LogoutResponse' => '\AerialShip\LightSaml\Model\Protocol\LogoutResponse',
            'LogoutRequest' => '\AerialShip\LightSaml\Model\Protocol\LogoutRequest',
            'Response' => '\AerialShip\LightSaml\Model\Protocol\Response',
            'ArtifactResponse' => null,
            'ArtifactResolve' => null
        );

        if (array_key_exists($context->getDocument()->localName, $map)) {
            if ($class = $map[$context->getDocument()->localName]) {
                /** @var SamlElementInterface $result */
                $result = new $class();
            } else {
                throw new \Exception('Not implemented');
            }
        } else {
            throw new LightSamlXmlException(sprintf("Unknown SAML message '%s'", $context->getDocument()->localName));
        }

        $result->deserialize($context->getDocument()->firstChild, $context);

        return $result;
    }




    public function sign(X509Certificate $certificate, \XMLSecurityKey $key, $object)
    {
        $signature = new SignatureCreator();
        $signature->setCertificate($certificate);
        $signature->setXmlSecurityKey($key);
        $object->setSignature($signature);
    }

} 