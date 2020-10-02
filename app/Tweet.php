<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tweet_post';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'tweet_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pk_profile', 'pk_comment', 'pk_like', 'content',
    ];

    public function user() {
        return $this->belongsTo('App\user', 'pk_user');
    }
}
