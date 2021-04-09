<?php

namespace App\Api\V1\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     * @param $resourceKey
     * @param array $data
     * @return array
     */
    public function collection($resourceKey, array $data): array
    {
        return ($resourceKey) ? [$resourceKey => $data] : $data;
    }

    /**
     * Serialize an item.
     * @param $resourceKey
     * @param array $data
     * @return array
     */
    public function item($resourceKey, array $data): array
    {
        return ($resourceKey) ? [$resourceKey => $data] : $data;
    }
}
