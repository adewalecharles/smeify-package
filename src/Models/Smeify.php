<?php

namespace AdewaleCharles\Smeify\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smeify extends Model
{
    use HasFactory;

    protected $fillable = ['token','expires'];
}
