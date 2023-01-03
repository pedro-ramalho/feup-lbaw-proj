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
        return $this->belongsTo(Tag::class, 'id_tag');
    }

    public function community() {
        return $this->belongsTo(Community::class, 'id_community');
    }

    public function content() {
        return $this->belongsTo(Content::class, 'id');
    }

    public function favorite() {
        return $this->belongsToMany(User::class);
    }
    
    
    protected $table = 'post';
}