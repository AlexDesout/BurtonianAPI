<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'nom_client';
    public $incrementing = false;
    protected $keyType = 'varchar';
}
