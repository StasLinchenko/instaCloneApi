<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'desc' => $this->desc,
            'img' => $this->img,
            'created_at' => $this->creted_at,//->format('d/m/Y'),
            'updated_at' => $this->updated_at//->format('d/m/Y'),
        ];
    }
}
