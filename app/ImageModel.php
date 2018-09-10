<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    public function word_indices(){
        return $this->hasMany('App\WordIndex');
    }
}
