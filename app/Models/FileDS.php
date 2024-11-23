<?php

namespace App\Models;

use App\Models\OSS\Checklist;
use App\Traits\StringPrimaryTrait;
use Illuminate\Database\Eloquent\Model;

class FileDS extends Model
{
    use StringPrimaryTrait;

    protected $primaryKey = 'id_izin';
    protected $table = 'file_ds';
    protected $fillable = ['id_izin', 'nib', 'file_izin'];

    public function bujp()
    {
        return $this->belongsTo(Bujp::class, 'nib', 'nib');
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class, 'id_izin', 'id_izin');
    }
}
