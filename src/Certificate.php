<?php

/**
 * @file
 * Certificate object representation of vault certificate.
 */

namespace ItkDev\AzureKeyVault;

/**
 * Class Certificate.
 */
class Certificate
{
    private $id;
    private $cert;
    private $enabled;
    private $created;
    private $update;
    private $expired;

    /**
     * Certificate constructor.
     *
     * @param $id
     *   Certificate ID
     * @param $cert
     *   The certificate data
     * @param $enabled
     *   True if the certificate is enabled at Azure
     * @param $created
     *   When the certificate was created
     * @param $update
     *   When the certificate was last updated
     * @param $expired
     *   When the certificate expires
     */
    public function __construct($id, $cert, $enabled, $created, $update, $expired)
    {
        $this->id = $id;
        $this->cert = $cert;
        $this->enabled = $enabled;
        $this->created = $created;
        $this->update = $update;
        $this->expired = $expired;
    }

    /**
     * Returns the certificate.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCert();
    }

    /**
     * Check if the certificate is vaild.
     *
     * @return bool
     *   If valid true else false
     */
    public function isValid(): bool
    {
        $valid = true;

        if (is_null($this->id)) {
            $valid = false;
        }

        if ($this->expired <= time()) {
            $valid = false;
        }

        return $valid;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCert()
    {
        return $this->cert;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * @return mixed
     */
    public function getExpired()
    {
        return $this->expired;
    }
}
