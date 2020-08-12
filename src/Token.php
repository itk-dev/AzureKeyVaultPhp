<?php

namespace Itkdev\Azurekeyvault;

class Token {
    private $accessToken;
    private $expiresIn;
    private $expiresOn;
    private $notBefore;
    private $resource;

    public function __construct($accessToken, $expiresIn, $expiresOn, $notBefore, $resource)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->expiresOn = $expiresOn;
        $this->notBefore = $notBefore;
        $this->resource = $resource;
    }

    public function __toString()
    {
        return $this->accessToken;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return mixed
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @return mixed
     */
    public function getExpiresOn()
    {
        return $this->expiresOn;
    }

    /**
     * @return mixed
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return mixed
     */
    public function getNotBefore()
    {
        return $this->notBefore;
    }
}

