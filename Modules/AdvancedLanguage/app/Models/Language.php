<?php

namespace Modules\AdvancedLanguage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\AdvancedLanguage\Database\Factories\LanguageFactory;

class Language extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'lang_code',
        'lang_flag',
        'lang_name'
    ];
    // protected static function newFactory(): LanguageFactory
    // {
    //     // return LanguageFactory::new();
    // }
}
