<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @mixin Builder
 */
class User extends Model {

    protected $fillable = [
        'uid',
        'username',
        'firstname',
        'lastname',
        'email',
        'photoUrl'
    ];

    public function ads() {
        return $this->hasMany('App\Models\Ad', 'user_id');
    }

    public function reservedAds() {
        return $this->hasMany('App\Models\Ad', 'booker_id');
    }

    /**
     * Ce sont les discussions dans lesquelles le user est demandeur
     */
    public function discussions() {
        return $this->hasMany('App\Models\Discussion');
    }

    public function discussionReplies() {
        return $this->hasMany('App\Models\DiscussionReply');
    }



}