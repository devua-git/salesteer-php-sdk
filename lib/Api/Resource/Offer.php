<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;
use Salesteer\Api\Contract as ApiContract;

class Offer extends ApiResource
{
    use ApiOperation\Retrieve;
    use ApiOperation\Update;
    use ApiOperation\Drop;
    use ApiOperation\UpdatesPipeline;

    use ApiContract\HasAssignees;

    const OBJECT_NAME = 'offer';

    const RELATION_TO_CLASS = [
        'products' => OfferProduct::class
    ];

    public function saveProducts(array $products = null)
    {
        $url = $this->instanceUrl() . '/products';
        $res = $this->request('patch', $url, $products, null, Offer::class);
        $this->refreshFrom($res);
    }
}
