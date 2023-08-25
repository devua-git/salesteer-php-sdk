<?php

namespace Salesteer\Service;

use Salesteer\Api\Resource\PipelineEntityStep;
use Salesteer\SalesteerObject;


class PipelineService extends AbstractService
{
    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function retrieve(int $id, array $params = null, array $headers = []): PipelineEntityStep
    {
        $url = $this->buildPath('%s', $id, PipelineEntityStep::classUrl());
        $res = $this->request('get', $url, $params, $headers, PipelineEntityStep::class);
        return $res;
    }

    /**
     * @throws Exception\ApiErrorException if the request fails
     */
    public function updateEntityStep(string $entityType, int $entityId, int $pipelineEntityStepId)
    {
        $url = $this->buildPath('%s', 'step',  PipelineEntityStep::classUrl(true));
        $res = $this->request('patch', $url, [
            'entity_id' => $entityId,
            'entity_type' => $entityType,
            'pipeline_step_id' => $pipelineEntityStepId
        ], null, PipelineEntityStep::class);
        return $res;
    }
}
