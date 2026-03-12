<?php

namespace App\Models;


class Pengajuan extends Model
{
    public function jenisBerkas()
    {
        return $this->belongsTo(JenisBerkas::class);
    }
}
