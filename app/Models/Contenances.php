<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenances extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'litres';
    public $incrementing = false;
}
