<?php

namespace App\Http\Resources\Options;

use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *     schema="OptionsItem",
 *     @OA\Property(
 *          property="label",
 *          type="string",
 *          readOnly="true"
 *     ),
 *     @OA\Property(
 *          property="value",
 *          type="string",
 *          readOnly="true"
 *     ),
 * )
 */
class OptionsItem extends JsonResource
{
    /**
     * OptionsItem constructor.
     * @param array $options
     * @param string $key
     */
    public function __construct(array $options, string $key)
    {
        $label = !empty($options[$key]) ? $options[$key] : null;

        $resource = [
            $key => $label
        ];
        parent::__construct($resource);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $key = key($this->resource);
        return [
            'label' => $this->resource[$key],
            'value' => $key,
        ];
    }
}
