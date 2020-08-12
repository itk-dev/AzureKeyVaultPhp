<?php

namespace Itkdev\Azurekeyvault\Exception;

use Throwable;

class TokenException extends \Exception {
    public $uri;

    public function __construct($message = '', $code = 0, Throwable $previous = null, $uri = '')
    {
        parent::__construct($message, $code, $previous);
        $this->uri;
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