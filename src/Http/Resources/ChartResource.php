<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Morilog\Jalali\Jalalian;

class ChartResource extends JsonResource
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
            'dayleft' => $this->timeleft ? $this->timeleft : false,
            'episode_date' => Jalalian::fromDateTime($this->next_episode_date)->format('Y/m/d H:i'),
            'episode_date_dayid' => Jalalian::fromDateTime($this->next_episode_date)->getDayOfWeek(),
            'status' => $this->status,
            'info' => $this->info ? $this->info : false,

        ];
    }
}
