<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function user_follow_community() {
        return DB::table('user_follow_community');
    }

    
    protected $table = 'community';
}