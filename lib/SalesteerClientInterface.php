<?php

namespace Salesteer;


interface SalesteerClientInterface
{
    /**
     * Sends a request to Salesteer's API.
     *
     * @param 'delete'|'get'|'post' $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array $headers
     *
     * @return SalesteerObject the object returned by Salesteer's API
     */
    public function request($method, $path, $params, $headers);
}
