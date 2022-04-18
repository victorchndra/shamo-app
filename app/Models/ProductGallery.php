<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'products_id',
        'url',
    ];

    // Laravel mutator : Untuk konversi field yang ada ke output yang kita inginkan
    // Ini akan digunakan untuk API, jadi nanti keluarnya adalah full url dari gambar tsb
    public function getUrlAttribute($url) {
        // config('app.url') => digunakan untuk memanggil full url web kita
        return config('app.url') . Storage::url($url);
    }
}
