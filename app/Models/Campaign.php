<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'galangan';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nama', 'alamat', 'rekening', 'judul', 'deskripsi', 'target', 'waktu', 'gambar',
        'id_kategori', 'id_penggalang'
    ];

    public function terkumpul()
    {
        return $this->hasOne(CollectedDonation::class, 'id_galangan');
    }

    public function penggalang()
    {
        return $this->belongsTo(User::class, 'id_penggalang');
    }

    public function donasi()
    {
        return $this->hasMany(Donation::class, 'id_galangan');
    }

    public function isAvailable()
    {
        if ($this->tgl_diterima || (Auth::check() && Auth::id() == $this->id_penggalang))
            return true;

        return false;
    }

    public function bukti()
    {
        return $this->hasOne(Proof::class, 'id_galangan');
    }
}
