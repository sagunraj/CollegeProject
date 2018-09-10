<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WordIndex extends Model
{
    public function image_models(){
        return $this->belongsTo('App\ImageModel');
    }
}
