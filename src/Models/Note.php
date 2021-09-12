<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model{

    protected $fillable = ['content', 'forall', 'status'];

    protected $casts = [
        'forall' => 'boolean',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
