<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guards = ['id'];
    protected $fillable = [
        'id_izin',
        'handphone',
        'kendala',
        'hasil_pengecekan',
        'penanganan',
        'status',
        'user_id'
    ];
    protected $appends = [
        'file_url'
    ];

    const STATUS = [
        0 => [
            'text' => 'Todo',
            'color' => 'danger'
        ],
        1 => [
            'text' => 'Doing',
            'color' => 'warning'
        ],
        2 => [
            'text' => 'Done',
            'color' => 'success'
        ],
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'ticket_id', 'id');
    }

    public function latest_comment() {
        return $this->hasOne(Comment::class, 'ticket_id', 'id')->latest();
    }

    public function getFileUrlAttribute()
    {
        return config('filesystems.storage_url') . preg_replace('/\/\//', '/', $this->file);
    }
}
