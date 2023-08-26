<?php

namespace Salesteer\Api\Operation;

use Salesteer\Exception as Exception;

trait UpdatesPipeline
{
    /**
     * @throws Exception\ApiErrorException
     */
    public function setPipelineStep($stepId)
    {
        $this->request('patch', "/pipelines/step", [
            'entity_id' => $this->id,
            'entity_type' => static::OBJECT_NAME,
            'pipeline_step_id' => $stepId
        ], []);

        return $this;
    }
}
