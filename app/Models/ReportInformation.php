<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportInformation extends Model
{
    use HasFactory;

    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_content', 'id_user', 'reason', 'report_date', 'reviewed'
    ];

    protected $table = 'report_information';

    public function content() {
        return $this->belongsTo(Content::class, 'id_content');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
