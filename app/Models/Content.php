<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Content extends Model
{
    use HasFactory;
    
    protected $fillable = ['id_author', 'created', 'is_post', 'is_deleted', 'is_edited'];

    public function owner() {
        return $this->belongsTo(User::class, 'id_author');
    }

    public function reported() {
        return $this
        ->belongsToMany(User::class)
        ->withPivot('reason', 'report_date', 'reviewed');
    }

    public function liked() {
        return $this->belongsToMany(User::class, 'content_rate', 'id_content', 'id_user')->withPivot('liked');
    }
    
    public function raters() {
        return $this->belongsToMany(User::class, 'content_rate', 'id_content', 'id_user');
    }

    public function likers() {
        return $this->belongsToMany(User::class, 'content_rate', 'id_content', 'id_user')->where('liked', 1);
    }

    public function dislikers() {
        return $this->belongsToMany(User::class, 'content_rate', 'id_content', 'id_user')->where('liked', 0);
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'id_parent');
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function is_comment(){
        return $this->hasOne(Comment::class);
    }

    public function reports() {
        return $this->hasMany(ReportInformation::class, 'id_content');
    }

    public $timestamps = false;
    protected $table = 'content';
}