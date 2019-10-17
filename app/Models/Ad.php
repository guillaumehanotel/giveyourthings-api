<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model {

    protected $fillable = [
        'title',
        'description',
        'type',
        'condition',
        'localisation'
    ];


    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function category() {
        return $this->hasOne('App\Models\Category');
    }

}