<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbyssDemo extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'file', 'created_at', 'updated_at'];

    protected $fillable = ['name', 'description', 'file', 'type'];
}
