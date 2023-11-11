<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gpt extends Model
{
    use HasFactory;
    protected $fillable = ['question','answer','user_id'];
}
