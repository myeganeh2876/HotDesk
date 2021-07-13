<?php

namespace TCG\Voyager\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Contracts\User as UserContract;
use TCG\Voyager\Traits\VoyagerUser;

class User extends Authenticatable implements UserContract{
    use VoyagerUser;

    protected $guarded = [];

    public $additional_attributes = ['locale'];

    public function getAvatarAttribute($value){
        return $value ?? config('voyager.user.default_avatar', 'users/default.png');
    }

    public function setCreatedAtAttribute($value){
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setSettingsAttribute($value){
        $this->attributes['settings'] = $value ? $value->toJson() : json_encode([]);
    }

    public function getSettingsAttribute($value){
        return collect(json_decode($value));
    }

    public function setLocaleAttribute($value){
        $this->settings = $this->settings->merge(['locale' => $value]);
    }

    public function getLocaleAttribute(){
        return $this->settings->get('locale');
    }

    public function unreadsupport(){
        return $this->belongsToMany(Support::class, 'user_unread_support_rel');
    }

    public function support(){
        return $this->hasOne(Support::class);
    }

    public function supportmessage(){
        return $this->belongsToMany(Support::class, 'user_support_rel');
    }

    public function personalizemenu(){
        return $this->hasOne(Personalizemenu::class);
    }

    public function notes(){
        return $this->hasMany(Note::class)->orWhere('forall', true)->orderby('created_at', 'desc');
    }

    public function note(){
        return $this->hasMany(Note::class);
    }



}
