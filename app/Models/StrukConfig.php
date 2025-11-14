<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrukConfig extends Model
{
    use HasFactory;

    protected $table = 'struk_configs'; // Nama tabel yang lebih spesifik
    protected $primaryKey = 'key';
    public $incrementing = false; // Karena primary key adalah 'key' (string)
    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public $timestamps = false;

    // Fungsi helper untuk mendapatkan nilai berdasarkan kunci
    public static function getValue($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }
}