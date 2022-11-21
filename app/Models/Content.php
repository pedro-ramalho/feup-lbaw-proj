<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    
    protected $fillable =['id_author', 'created', 'is_post', 'is_deleted', 'is_edited'];

    public function owner() {
        return $this->belongsTo(User::class);
    }

    public function reported() {
        return $this
        ->belongsToMany(User::class)
        ->withPivot('reason', 'report_date', 'reviewed');
    }

    public function liked() {
        return $this->belongsToMany(User::class, 'content_rate', 'id_content', 'id_user')->withPivot('liked');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function is_comment(){
        return $this->hasOne(Comment::class);
    }

    public $timestamps = false;
    protected $table = 'content';
}