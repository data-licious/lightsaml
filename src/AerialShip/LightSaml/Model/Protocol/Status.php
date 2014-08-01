<?php

namespace AerialShip\LightSaml\Model\Protocol;

use AerialShip\LightSaml\Meta\DeserializationContext;
use AerialShip\LightSaml\Meta\SerializationContext;
use AerialShip\LightSaml\Model\AbstractSamlModel;
use AerialShip\LightSaml\SamlConstants;

class Status extends AbstractSamlModel
{
    /** @var  StatusCode */
    protected $statusCode;

    /** @var string|null */
    protected $message;


    /**
     * @param StatusCode|null $statusCode
     * @param string $message
     */
    public function __construct(StatusCode $statusCode = null, $message = null)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    /**
     * @param \AerialShip\LightSaml\Model\Protocol\StatusCode $statusCode
     */
    public function setStatusCode(StatusCode $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return \AerialShip\LightSaml\Model\Protocol\StatusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string|null $message
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @return bool
     */
    public function isSuccess()
    {
        $result = $this->getStatusCode() && $this->getStatusCode()->getValue() == SamlConstants::STATUS_SUCCESS;

        return $result;
    }

    public function setSuccess()
    {
        $this->setStatusCode(new StatusCode());
        $this->getStatusCode()->setValue(SamlConstants::STATUS_SUCCESS);
    }



    /**
     * @param \DOMNode $parent
     * @param SerializationContext $context
     * @return void
     */
    public function serialize(\DOMNode $parent, SerializationContext $context)
    {
        $result = $this->createElement('samlp:Status', SamlConstants::NS_PROTOCOL, $parent, $context);

        $this->singleElementsToXml(array('StatusCode', 'StatusMessage'), $result, $context);
    }

    /**
     * @param \DOMElement $node
     * @param \AerialShip\LightSaml\Meta\DeserializationContext $context
     * @return void
     */
    public function deserialize(\DOMElement $node, DeserializationContext $context)
    {
        $this->checkXmlNodeName($node, 'Status', SamlConstants::NS_PROTOCOL);

        $this->singleElementsFromXml($node, $context, array(
            'StatusCode' => array('samlp', 'AerialShip\LightSaml\Model\Protocol\StatusCode'),
            'StatusMessage' => array('samlp', null),
        ));
    }


}
