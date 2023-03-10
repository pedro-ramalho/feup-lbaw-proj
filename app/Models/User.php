<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'register_date', 'biography', 'pfp', 'is_deleted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function community_block() {
        return $this->belongsToMany(Community::class);
    }

    public function platform_block() {
        return $this->hasMany(PlatformBlock::class);
    }

    public function community() {
        return $this->hasMany(Community::class, 'id_owner');
    }

    public function content() {
        return $this->hasMany(Content::class, 'id_author');
    }
    
    public function moderator() {
        return $this->belongsToMany(Community::class);
    }

    public function rate() {
        return $this
        ->belongsToMany(Content::class, 'content_rate')
        ->withPivot('id_author');
    }

    public function rated() {
        return $this->belongsToMany(Content::class, 'content_rate', 'id_user', 'id_content')->withPivot('liked');
    }
    
    public function reported() {
        return $this
        ->hasMany(Content::class)
        ->withPivot('reason', 'report_date', 'reviewed');
    }

    public function follows() {
        return $this->belongsToMany(Community::class, 'user_follow_community', 'id_follower', 'id_followee');
    }

    public function like_notification() {
        return $this->belongsToMany(Content::class, 'like_notification', 'id_received', 'id_content')->withPivot('id_triggered');
    }
}