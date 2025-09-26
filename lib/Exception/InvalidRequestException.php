<?php

namespace Salesteer\Exception;

/**
 * InvalidRequestException is thrown when a request is initiated with invalid
 * parameters.
 */
class InvalidRequestException extends ApiErrorException
{
    protected $salesteerParam;

    /**
     * Creates a new InvalidRequestException exception.
     *
     * @param  string  $message  the exception message
     * @param  null|int  $httpStatus  the HTTP status code
     * @param  null|string  $httpBody  the HTTP body as a string
     * @param  null|array  $jsonBody  the JSON deserialized body
     * @param  null|array|\Salesteer\Util\CaseInsensitiveArray  $httpHeaders  the HTTP headers array
     * @param  null|string  $salesteerCode  the Salesteer error code
     * @param  null|string  $salesteerParam  the parameter related to the error
     * @return InvalidRequestException
     */
    public static function factory(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null,
        $salesteerCode = null,
        $salesteerParam = null
    ) {
        $instance = parent::factory($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders, $salesteerCode);
        $instance->setSalesteerParam($salesteerParam);

        return $instance;
    }

    /**
     * Gets the parameter related to the error.
     *
     * @return null|string
     */
    public function getSalesteerParam()
    {
        return $this->salesteerParam;
    }

    /**
     * Sets the parameter related to the error.
     *
     * @param  null|string  $salesteerParam
     */
    public function setSalesteerParam($salesteerParam)
    {
        $this->salesteerParam = $salesteerParam;
    }
}
