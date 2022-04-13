<?php

namespace App\Http\Resources\Nilai;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AverageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return new AverageResource($item);
        });
    }
}
