<?php

namespace ItkDev\AzureKeyVault;

/**
 * Class Secret.
 */
class Secret
{
    private $id;
    private $managed;
    private $value;
    private $enabled;
    private $created;
    private $updated;
    private $recoveryLevel;

    public function __construct($id, $value, $managed, $enabled, $created, $updated, $recoveryLevel)
    {
        $this->id = $id;
        $this->value = $value;
        $this->managed = $managed;
        $this->enabled = $enabled;
        $this->created = $created;
        $this->updated = $updated;
        $this->recoveryLevel = $recoveryLevel;
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
    public function getManaged()
    {
        return $this->managed;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
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
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return mixed
     */
    public function getRecoveryLevel()
    {
        return $this->recoveryLevel;
    }

    /**
     * Returns the secret value.
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->value;
    }
}
