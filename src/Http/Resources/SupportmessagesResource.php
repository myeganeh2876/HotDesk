<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;
use \Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class SupportmessagesResource extends JsonResource
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
            'message' => Crypt::decryptString($this->message),
            'is_admin' => $request->user()->id != $this->user_id,
            'date' => [
                'default_en' => Carbon::parse($this->created_at)->format('Y/m/d H:i'),
                'default_fa' => Jalalian::fromDateTime($this->created_at)->format('Y/m/d H:i'),
                'en' => Carbon::parse($this->created_at)->format('j F y H:i'),
                'fa' => Jalalian::fromDateTime($this->created_at)->format('j F y H:i'),
                'ago' => Carbon::parse($this->created_at)->ago(),
            ],
        ];
    }
}
