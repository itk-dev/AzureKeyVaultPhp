<?php

namespace Itkdev\Azurekeyvault;

class Certificate {

    private $id;
    private $cert;
    private $enabled;
    private $created;
    private $update;
    private $expired;

    public function __construct($id, $cert, $enabled, $created, $update, $expired)
    {
        $this->id = $id;
        $this->cert = $cert;
        $this->enabled = $enabled;
        $this->created = $created;
        $this->update = $update;
        $this->expired = $expired;
    }

    public function __toString()
    {
        return $this->getCert();
    }

    public function isValid() {
        $valid = true;

        if (is_null($this->id)) {
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