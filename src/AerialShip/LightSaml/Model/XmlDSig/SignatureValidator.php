<?php

namespace AerialShip\LightSaml\Model\XmlDSig;

use AerialShip\LightSaml\Error\LightSamlSecurityException;

abstract class SignatureValidator extends Signature
{
    /**
     * @param \XMLSecurityKey $key
     * @return bool True if validated, False if validation was not performed
     * @throws \AerialShip\LightSaml\Error\LightSamlSecurityException If validation fails
     */
    public abstract function validate(\XMLSecurityKey $key);

    /**
     * @param \XMLSecurityKey[] $keys
     * @throws \LogicException
     * @throws \InvalidArgumentException If some element of $keys array is not \XMLSecurityKey
     * @throws \AerialShip\LightSaml\Error\LightSamlSecurityException If validation fails
     * @return bool True if validated, False if validation was not performed
     */
    public function validateMulti(array $keys)
    {
        $lastException = null;

        foreach ($keys as $key) {

            if (false == $key instanceof \XMLSecurityKey) {
                throw new \InvalidArgumentException('Expected XMLSecurityKey');
            }

            try {
                $result = $this->validate($key);

                if ($result === false) {
                    return false;
                }

                return true;

            } catch (LightSamlSecurityException $ex) {
                $lastException = $ex;
            }
        }

        if ($lastException) {
            throw $lastException;
        } else {
            throw new \LogicException('Should not get here???');
        }
    }

} 