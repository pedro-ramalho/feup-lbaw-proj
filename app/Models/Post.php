<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['id_community', 'id_tag', 'title', 'is_image'];

    public $timestamps = false;

    public function comments() {
        return $this->hasMany(Comment::class);
    }


    public function tag() {
        return $this->hasOne(Tag::class);
    }

    public function community() {
        return $this->belongsTo(Community::class);
    }

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function content() {
        return $this->belongsTo(Content::class, 'id');
    }

    public function favorite() {
        return $this->belongsToMany(User::class);
    }
    protected $appends= ['likes'];
    protected $table = 'post';
}