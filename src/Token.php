<?php

/**
 * @file
 * Token object representation of Azure access token.
 */

namespace ItkDev\AzureKeyVault;

class Token
{
    private $accessToken;
    private $expiresIn;
    private $expiresOn;
    private $notBefore;
    private $resource;

    /**
     * Token constructor.
     *
     * @param string $accessToken
     *   The access token
     * @param string $expiresIn
     *   Seconds to the token expires
     * @param string $expiresOn
     *   Unix timestamp for when it expires
     * @param string $notBefore
     *   Unix timestamp for when the token is valid
     * @param string $resource
     *   The resource the token can be used for
     */
    public function __construct($accessToken, $expiresIn, $expiresOn, $notBefore, $resource)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->expiresOn = $expiresOn;
        $this->notBefore = $notBefore;
        $this->resource = $resource;
    }

    /**
     * Outputs the access token.
     */
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
