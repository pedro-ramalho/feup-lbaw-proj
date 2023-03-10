<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['id_community', 'name'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function community() {
        return $this->belongsTo(Community::class, 'id_community');
    }

    public $timestamps = false;

    protected $table = 'tag';
}