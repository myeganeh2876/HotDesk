<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model{

    protected $fillable = ['title', 'status', 'message_count', 'new'];

    protected $casts = [
        'new' => 'boolean',
    ];

    protected $appends = [
        'messagesparse' => '',
    ];

    public function getMessagesparseAttribute(){
        if(is_array($this->messages)){
            return $this->messages;
        } else {
            return false;
        }
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function client(){
        return $this->belongsTo('App\Models\\Client', 'user_id');
    }

    public function unread(){
        return $this->belongsToMany('App\User', 'user_unread_support_rel');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_support_rel');
    }

    public function messages(){
        return $this->hasMany('App\Models\Supportmessage');
    }
}
