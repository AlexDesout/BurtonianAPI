<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bieres extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'type';
    public $incrementing = false;
}
