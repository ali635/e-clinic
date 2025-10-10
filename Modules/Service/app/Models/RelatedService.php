<?php

namespace Modules\Service\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Service\Database\Factories\RelatedServiceFactory;

class RelatedService extends Model
{
    use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'price'
    ];


     public function getDisplayNameAttribute(): ?string
    {
        return $this->name; // auto translated
    }

    // protected static function newFactory(): RelatedServiceFactory
    // {
    //     // return RelatedServiceFactory::new();
    // }
}
