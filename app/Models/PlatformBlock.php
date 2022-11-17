<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformBlock extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['id_admin', 'reason', 'start_date', 'end_date'];


    public function admin() {
        return $this->hasOne(Administrator::class);
    }

    public function user() {
        return $this->belongsTo(Users::class);
    }

    protected $table = 'platform_block';
}