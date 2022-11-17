<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Comment extends Model
{
    use HasFactory;
    
    public $timestamps = false; 
    
    protected $fillable = ['text'];

    /**
     * Get the parent content of this comment
     */
    public function parent() {
        return $this->belongsTo(Content::class, 'id_parent');
    }

    public function comment() {
        return $this->belongsTo(Content::class, 'id_parent');
    }

    protected $table = 'comment';
}