<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model {

    protected $fillable = [
        'ad_id',
        'requester_id',
    ];

    public function requester() {
        return $this->belongsTo('App\Models\User', 'requester_id');
    }

    public function ad() {
        return $this->belongsTo('App\Models\Ad', 'ad_id');
    }

    public function replies() {
        return $this->hasMany('App\Models\DiscussionReply');
    }

}