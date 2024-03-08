<?php

namespace App\Http\Resources\Options;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OptionsArrayResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="DictionaryOption",
     *     @OA\Property(
     *         property="id",
     *         type="string",
     *         description="id"
     *     ),
     * )
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $options = [];
        foreach ($this->resource as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key
            ];
        }

        return $options;
    }
}
