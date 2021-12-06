<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donator extends Model
{
    use HasFactory;

    protected $table = 'donatur';

    public $timestamps = false;

    public function donasi()
    {
        $this->hasOne(Donasi::class, 'id_donatur');
    }
}
