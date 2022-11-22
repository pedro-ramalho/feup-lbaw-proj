<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'description', 'founded', 'tag', 'icon', 'banner', 'is_deleted'];

    public function posts() {
        return $this->hasMany(Post::class, 'id_community');
    }

    public function owner() {
        return $this->belongsTo(User::class, 'id_owner');
    }

    public function moderators() {
        return $this->hasMany(User::class, 'id_mod');
    }

    public function tags() {
        return $this->hasMany(Tag::class);
    }

    public function block() {
        return $this->hasMany(User::class, 'id_blockee');
    }
    public function followed() {
        return $this->belongsToMany(User::class, 'user_follow_community', 'id_followee', 'id_follower');
    }
    
    protected $table = 'community';
}