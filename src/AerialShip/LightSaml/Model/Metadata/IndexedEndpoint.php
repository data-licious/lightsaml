<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;

class IndexedEndpoint extends Endpoint
{
    /** @var  int */
    protected $index;

    /** @var  bool|null */
    protected $isDefault;


    /**
     * @param bool|null $isDefault
     * @return $this|IndexedEndpoint
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault !== null ? (bool)$isDefault : null;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param int $index
     * @return $this|IndexedEndpoint
     */
    public function setIndex($index)
    {
        $this->index = (int)$index;
        return $this;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }



    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $this->attributesToXml(array('index', 'isDefault'), $parent);
        parent::serialize($parent, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->attributesFromXml($node, array('index', 'isDefault'));

        parent::deserialize($node, $context);
    }

} 