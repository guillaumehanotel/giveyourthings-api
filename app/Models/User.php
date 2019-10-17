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
        'username',
        'firstname',
        'lastname',
        'email',
    ];

    public function ads() {
        return $this->hasMany('App\Models\Ad');
    }

}