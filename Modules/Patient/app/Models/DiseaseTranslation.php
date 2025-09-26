<?php

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Patient\Database\Factories\DiseaseTranslationFactory;

class DiseaseTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'locale',
        'disease_id',
    ];

    public $timestamps = false;

    public function disease()
    {
        return $this->belongsTo(disease::class);
    }

    // protected static function newFactory(): DiseaseTranslationFactory
    // {
    //     // return DiseaseTranslationFactory::new();
    // }
}
