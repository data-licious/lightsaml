<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class ProxyRestriction extends AbstractSamlModel
{
    /**
     * @var int|null
     */
    protected $count;

    /**
     * @var string[]|null
     */
    protected $audience;


    /**
     * @param string $audience
     * @return $this|ProxyRestriction
     */
    public function addAudience($audience)
    {
        if (false == is_array($this->audience)) {
            $this->audience = array();
        }
        $this->audience[] = (string)$audience;
        return $this;
    }

    /**
     * @return null|\string[]
     */
    public function getAllAudience()
    {
        return $this->audience;
    }

    /**
     * @param int|null $count
     * @return $this|ProxyRestriction
     */
    public function setCount($count)
    {
        $this->count = $count !== null ? intval($count) : null;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }




    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('ProxyRestriction', null, $parent, $context);

        $this->attributesToXml(array('count'), $result);

        $this->manyElementsToXml($this->getAllAudience(), $result, $context, 'Audience');
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'ProxyRestriction', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array('count'));

        $this->manyElementsFromXml($node, $context, 'Audience', 'saml', null, 'addAudience');
    }

} 