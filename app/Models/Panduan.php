<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panduan extends Model
{
    protected $guarded = ['id'];

    public function scopeParentOnly($query)
    {
        return $query->whereNull("parent_id");
    }

    public function children()
    {
        return $this->hasMany(Panduan::class, "parent_id");
    }

    public function parent()
    {
        return $this->belongsTo(Panduan::class, "parent_id");
    }

    public function allChildren()
    {
        return $this->children()->with("allChildren");
    }

    public static function justParent()
    {
        return self::where("parent_id", null)->get();
    }

    public function getFileAttribute($value) {
        return $value ? config('filesystems.storage_url') . substr($value, 1) : '';
    }
}
