<?php

namespace Salesteer\Api\Resource;

use Salesteer\Exception;

class OfferProduct extends ApiResource
{
    const OBJECT_NAME = 'offer_product';

    public static function retrieve(string|int $id, $headers = null)
    {
        throw new Exception\BadMethodCallException('Retrieving individual offer products is not supported by the API. Retrieve the offer instead.');
    }

    public function refresh()
    {
        throw new Exception\BadMethodCallException('Refreshing individual offer products is not supported by the API. Refresh the offer instead.');
    }

    public function save($headers = null)
    {
        throw new Exception\BadMethodCallException('Saving individual offer products is not supported by the API. Use Offer::saveProducts() instead.');
    }

    public function drop($headers = null)
    {
        throw new Exception\BadMethodCallException('Deleting individual offer products is not supported by the API. Use Offer::saveProducts() instead.');
    }
}
