<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextPost extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    public $timestamps = false;

    public function post() {
        return $this->belongsTo(Post::class);
    }

    protected $table = 'text_post';
}