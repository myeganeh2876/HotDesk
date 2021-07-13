<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatGroupResource extends JsonResource
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
            'title' => $this->title ?? "",
            'chat_room_id' => $this->chat_room_id ?? "",
            'max_capacity' => (int)$this->max_capacity ?? 0,
            'image_url' => get_image($this->image_url ?? "")
        ];
    }
}
