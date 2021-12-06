<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'status', 'tgl_donasi'
    ];


    public function donatur()
    {
        return $this->hasOne(Donator::class, 'id_donasi');
    }

    public function galangan()
    {
        return $this->belongsTo(Campaign::class, 'id_galangan');
    }
}
