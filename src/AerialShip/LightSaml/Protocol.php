<?php

namespace AerialShip\LightSaml;


final class Protocol
{
    const AC_PASSWORD = 'urn:oasis:names:tc:SAML:2.0:ac:classes:Password';
    const AC_UNSPECIFIED = 'urn:oasis:names:tc:SAML:2.0:ac:classes:unspecified';
    const AC_WINDOWS = 'urn:federation:authentication:windows';


    const CM_BEARER = 'urn:oasis:names:tc:SAML:2.0:cm:bearer';
    const CM_HOK = 'urn:oasis:names:tc:SAML:2.0:cm:holder-of-key';


    const ENCODING_DEFLATE = 'urn:oasis:names:tc:SAML:2.0:bindings:URL-Encoding:DEFLATE';


    protected function __construct() { }
}