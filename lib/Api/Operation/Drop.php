<?php

namespace Salesteer\Api\Operation;

use Salesteer\Exception as Exception;

trait Drop
{
    /**
     * @throws Exception\ApiErrorException
     */
    public function drop($headers = null)
    {
        $url = $this->instanceUrl();
        $this->request('delete', $url, null, $headers);
    }
}
