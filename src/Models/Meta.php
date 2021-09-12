<?php

namespace TCG\Voyager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use TCG\Voyager\Events\MenuDisplay;
use TCG\Voyager\Facades\Voyager;

class Meta extends Model{

    public function morph(){
        return $this->hasMany(MetaMorph::class , 'meta_id' , 'id');
    }

}
