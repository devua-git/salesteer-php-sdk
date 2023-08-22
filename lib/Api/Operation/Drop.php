<?php

namespace Salesteer\Api\Operation;

use Salesteer\Exception as Exception;

trait Drop
{
    /**
     * @throws Exception\ApiErrorException
     */
    public function save($headers = null)
    {
        $url = $this->instanceUrl();
        $this->_request('delete', $url, null, $headers);
    }
}
