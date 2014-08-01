<?php

namespace AerialShip\LightSaml;

final class SamlConstants
{
    const PROTOCOL_SAML2 = 'urn:oasis:names:tc:SAML:2.0:protocol';
    const PROTOCOL_SAML1 = 'urn:oasis:names:tc:SAML:1.0:protocol';
    const PROTOCOL_SAML11 = 'urn:oasis:names:tc:SAML:1.1:protocol';
    const PROTOCOL_SHIB1 = 'urn:mace:shibboleth:1.0';
    const PROTOCOL_WS_FED = 'http://schemas.xmlsoap.org/ws/2003/07/secext???';

    const VERSION_20 = '2.0';

    const NS_PROTOCOL = 'urn:oasis:names:tc:SAML:2.0:protocol';
    const NS_METADATA = 'urn:oasis:names:tc:SAML:2.0:metadata';
    const NS_ASSERTION = 'urn:oasis:names:tc:SAML:2.0:assertion';
    const NS_XMLDSIG = 'http://www.w3.org/2000/09/xmldsig#';

    const BEARER_METHOD = 'urn:oasis:names:tc:SAML:2.0:cm:bearer';

    const NAME_ID_FORMAT_NONE = null;
    const NAME_ID_FORMAT_PERSISTENT = 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent';
    const NAME_ID_FORMAT_TRANSIENT = 'urn:oasis:names:tc:SAML:2.0:nameid-format:transient';
    const NAME_ID_FORMAT_EMAIL = 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress';
    const NAME_ID_FORMAT_SHIB_NAME_ID = 'urn:mace:shibboleth:1.0:nameIdentifier';

    const BINDING_SAML2_HTTP_REDIRECT = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect';
    const BINDING_SAML2_HTTP_POST = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST';
    const BINDING_SAML2_HTTP_ARTIFACT = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact';
    const BINDING_SAML2_SOAP = 'urn:oasis:names:tc:SAML:2.0:bindings:SOAP';
    const BINDING_SAML2_HTTP_POST_SIMPLE_SIGN = 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST-SimpleSign';
    const BINDING_SHIB1_AUTHN_REQUEST = 'urn:mace:shibboleth:1.0:profiles:AuthnRequest';
    const BINDING_SAML1_BROWSER_POST = 'urn:oasis:names:tc:SAML:1.0:profiles:browser-post';
    const BINDING_SAML1_ARTIFACT1 = 'urn:oasis:names:tc:SAML:1.0:profiles:artifact-01';
    const BINDING_WS_FED_WEB_SVC = 'http://schemas.xmlsoap.org/ws/2003/07/secext';

    const STATUS_SUCCESS = 'urn:oasis:names:tc:SAML:2.0:status:Success';
    const STATUS_REQUESTER = 'urn:oasis:names:tc:SAML:2.0:status:Requester';
    const STATUS_RESPONDER = 'urn:oasis:names:tc:SAML:2.0:status:Responder';
    const STATUS_VERSION_MISMATCH = 'urn:oasis:names:tc:SAML:2.0:status:VersionMismatch';
    const STATUS_NO_PASSIVE = 'urn:oasis:names:tc:SAML:2.0:status:NoPassive';
    const STATUS_PARTIAL_LOGOUT = 'urn:oasis:names:tc:SAML:2.0:status:PartialLogout';
    const STATUS_PROXY_COUNT_EXCEEDED = 'urn:oasis:names:tc:SAML:2.0:status:ProxyCountExceeded';
    const STATUS_INVALID_NAME_ID_POLICY = 'urn:oasis:names:tc:SAML:2.0:status:InvalidNameIDPolicy';

    const XMLSEC_TRANSFORM_ALGORITHM_ENVELOPED_SIGNATURE = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature';



    public static function isNameIdPolicyValid($value)
    {
        static $arr = array(
            self::NAME_ID_POLICY_NONE,
            self::NAME_ID_POLICY_PERSISTENT,
            self::NAME_ID_POLICY_TRANSIENT,
            self::NAME_ID_POLICY_EMAIL,
            self::NAME_ID_POLICY_SHIB_NAME_ID,
        );

        return in_array($value, $arr);
    }

    private function __construct() { }
} 