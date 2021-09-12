<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $disk = config('voyager.storage.disk');
        $storage = Storage::disk($disk);
        return [
            'status' => 'authorized',
            'id' => $this->id,
            'name' => !empty($this->name) ? $this->name : 'کاربر',
            'email' => $this->email ? $this->email : false,
            'loginmode' => $this->phone ? 'phone' : 'email',
            'avatar' => str_replace('\\', '/', $storage->url($this->avatar)),
            'is_banned' => $this->is_banned,
            'has_plan' => $this->hasproduct,
            'plantimeleft' => $this->productimeleft,
            'unreadmessage' => $this->support()->where('supports.new', 1)->exists(),
        ];
    }
}
