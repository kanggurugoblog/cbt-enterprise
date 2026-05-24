<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    // Izinkan pengisian massal untuk nama dan kode mapel
    protected $fillable = ['name', 'code'];

    // Relasi: Satu Mapel bisa dipakai di banyak Paket Bank Soal
    public function questionBanks(): HasMany
    {
        return $this->hasMany(QuestionBank::class);
    }
}
