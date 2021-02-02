<?php

/**
 * @file
 * Access token exception from Azure login.
 */

namespace ItkDev\AzureKeyVault\Exception;

use Throwable;

/**
 * Class TokenException.
 *
 * Add URI field to the exception with link to more information at Azure documentation.
 */
class TokenException extends \Exception
{
    public $uri;

    /**
     * TokenException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param string $uri
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null, $uri = '')
    {
        parent::__construct($message, $code, $previous);
        $this->uri = $uri;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }
}
