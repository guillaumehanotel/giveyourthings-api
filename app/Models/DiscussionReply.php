<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DiscussionReply extends Model {

    protected $table = 'discussion_replies';

    protected $fillable = [
        'user_id',
        'discussion_id',
        'message'
    ];

    public function sender() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function discussion() {
        return $this->belongsTo('App\Models\Discussion');
    }

}