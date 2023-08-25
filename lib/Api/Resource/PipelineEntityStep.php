<?php

namespace Salesteer\Api\Resource;

use Salesteer\Api\Operation as ApiOperation;

class PipelineEntityStep extends ApiResource
{
    use ApiOperation\Retrieve;

    const OBJECT_NAME = 'pipeline';
}
