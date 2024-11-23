<?php

namespace App\Models\Sislap\Lapsubjar\Bintibsos;

use App\Traits\SislapModelTrait;
use Illuminate\Database\Eloquent\Model;

class GiatLinsek extends Model
{
    use SislapModelTrait;

    protected $fillable = ['kesatuan', 'jenis_kegiatan', 'materi_pembahasan', 'instansi_terlibat', 'keterangan', 'user_id', 'kode_satuan'];
    protected $guarded  = ['id'];
    protected $appends  = ['need_approve'];
}
