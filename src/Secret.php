<?php

/**
 * @file
 * Secret object representation of vault secret.
 */

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

    /**
     * Secret constructor.
     *
     * @param string $id            the secret id
     * @param string $value         the secret value
     * @param bool $managed       whether the secrets lifetime is managed by key vault
     * @param bool $enabled       whether the secret is enabled
     * @param int $created       the creation time in UTC
     * @param int $updated       last updated time in UTC
     * @param string $recoveryLevel deletion recovery level
     */
    public function __construct(string $id, string $value, bool $managed, bool $enabled, int $created, int $updated, string $recoveryLevel)
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
     * Returns the secret id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Returns whether the secrets lifetime is managed by the key vault.
     *
     * @return bool
     */
    public function isManaged(): bool
    {
        return $this->managed;
    }

    /**
     * Returns the secret value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Returns whether the secret is enabled.
     *
     * @return bool true if managed else false
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Returns the creation time in UTC.
     *
     * @return int
     */
    public function getCreated(): int
    {
        return $this->created;
    }

    /**
     * Returns the secrets last updated time in UTC.
     *
     * @return int
     */
    public function getUpdated(): int
    {
        return $this->updated;
    }

    /**
     * Returns the deletion recovery level.
     *
     * @return string
     */
    public function getRecoveryLevel(): string
    {
        return $this->recoveryLevel;
    }

    /**
     * Returns the secret value.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
