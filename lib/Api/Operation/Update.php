<?php

namespace Salesteer\Api\Operation;

use Salesteer\Exception as Exception;

trait Update
{
    /**
     * @throws Exception\ApiErrorException
     */
    public function save($headers = null)
    {
        $params = $this->serializeParameters();

        $url = $this->instanceUrl();
        $res = $this->_request('patch', $url, $params, $headers);
        $this->refreshFrom($res, $headers);

        return $this;
    }
}
