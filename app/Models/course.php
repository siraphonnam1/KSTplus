<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "title",
        "description",
        "permission",
        "teacher",
        "dpm",
        "studens",
        "code",
    ] ;

    public function getDpm() {
        return $this->belongsTo(department::class, 'dpm');
    }
}
