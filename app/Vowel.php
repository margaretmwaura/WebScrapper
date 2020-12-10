<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vowel extends Model
{
    protected $table = 'vowels';

    protected $fillable = [
        'name', 'description', 'filename',
    ];
}
