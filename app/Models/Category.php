<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [];

    public function galangan()
    {
        return $this->hasMany(Campaign::class, 'id_kategori');
    }
}
