<?php

namespace AerialShip\LightSaml\Model\Assertion;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class Conditions extends AbstractSamlModel
{
    /**
     * @var int|null
     */
    protected $notBefore;

    /**
     * @var int|null
     */
    protected $notOnOrAfter;

    /**
     * @var AudienceRestriction
     */
    protected $audienceRestriction;




    /**
     * @param \AerialShip\LightSaml\Model\Assertion\AudienceRestriction $audienceRestriction
     * @return $this|Conditions
     */
    public function setAudienceRestriction($audienceRestriction)
    {
        $this->audienceRestriction = $audienceRestriction;
        return $this;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Assertion\AudienceRestriction
     */
    public function getAudienceRestriction()
    {
        return $this->audienceRestriction;
    }

    /**
     * @param int|null $notBefore
     * @return $this|Conditions
     */
    public function setNotBefore($notBefore)
    {
        $this->notBefore = $notBefore;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNotBefore()
    {
        return $this->notBefore;
    }

    /**
     * @param int|null $notOnOrAfter
     * @return $this|Conditions
     */
    public function setNotOnOrAfter($notOnOrAfter)
    {
        $this->notOnOrAfter = $notOnOrAfter;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNotOnOrAfter()
    {
        return $this->notOnOrAfter;
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('Conditions', null, $parent, $context);

        $this->attributesToXml(
            array('NotBefore', 'NotOnOrAfter'),
            $result
        );

        $this->singleElementsToXml(
            array('AudienceRestriction'),
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
        $this->checkXmlNodeName($node, 'Conditions', SamlConstants::NS_ASSERTION);

        $this->attributesFromXml($node, array('NotBefore', 'NotOnOrAfter'));

        $this->singleElementsFromXml($node, $context, array(
            'AudienceRestriction' => array('saml', 'AerialShip\LightSaml\Model\Assertion\AudienceRestriction'),
        ));
    }

} 