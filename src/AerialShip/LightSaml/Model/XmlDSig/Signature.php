<?php

namespace AerialShip\LightSaml\Model\XmlDSig;

use AerialShip\LightSaml\Model\AbstractSamlModel;

abstract class Signature extends AbstractSamlModel
{
    /**
     * @return string
     */
    protected function getIDName() {
        return 'ID';
    }

}