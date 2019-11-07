<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model {

    protected $fillable = [
        'title',
        'description',
        'type',
        'condition',
        'localisation',
        'is_given'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function booker() {
        return $this->belongsTo('App\Models\User', 'booker_id');
    }

    public function category() {
        return $this->hasOne('App\Models\Category', 'category_id');
    }

    public function discussions() {
        return $this->hasMany('App\Models\Discussion');
    }


}