<?php

namespace AerialShip\LightSaml\Model\Metadata;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class Organization extends AbstractSamlModel
{
    /** @var  string */
    protected $organizationName;

    /** @var  string */
    protected $organizationDisplayName;

    /** @var  string */
    protected $organizationURL;


    /**
     * @param string $organizationDisplayName
     * @return $this|Organization
     */
    public function setOrganizationDisplayName($organizationDisplayName)
    {
        $this->organizationDisplayName = (string)$organizationDisplayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationDisplayName()
    {
        return $this->organizationDisplayName;
    }

    /**
     * @param string $organizationName
     * @return $this|Organization
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = (string)$organizationName;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param string $organizationURL
     * @return $this|Organization
     */
    public function setOrganizationURL($organizationURL)
    {
        $this->organizationURL = (string)$organizationURL;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganizationURL()
    {
        return $this->organizationURL;
    }


    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('Organization', null, $parent, $context);

        $this->singleElementsToXml(
            array('OrganizationName', 'OrganizationDisplayName', 'OrganizationURL'),
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
        $this->checkXmlNodeName($node, 'ContactPerson', SamlConstants::NS_METADATA);

        $this->singleElementsFromXml($node, $context, array(
            'OrganizationName' => array('md', null),
            'OrganizationDisplayName' => array('md', null),
            'OrganizationURL' => array('md', null),
        ));
    }

} 