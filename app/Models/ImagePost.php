<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagePost extends Model
{
    use HasFactory;

    protected $fillable = ['id_image'];

    public $timestamps = false;

    public function post(){
        return $this->belongsTo(Post::class);
    }

    protected $table = 'image_post';
}