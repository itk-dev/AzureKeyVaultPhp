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
     * @param string $message  The Exception message to throw
     * @param int $code     The Exception code
     * @param Throwable|null $previous The previous throwable used for the exception chaining
     * @param string $uri      Link to more information at Azure documentation
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
