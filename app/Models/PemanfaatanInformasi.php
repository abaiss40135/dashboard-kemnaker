<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemanfaatanInformasi extends Model
{
    const DOWNLOAD = 'download';
    const COPY_LINK = 'copy_link';

    protected $table = 'pemanfaatan_informasi';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function content()
    {
        return $this->morphTo()->withDefault([
            'judul' => 'Konten tidak ditemukan',
            'url_gambar' => '',
            'caption' => 'Konten mungkin sudah dihapus atau ada kesalahan dengan sistem',
        ]);
    }
}
