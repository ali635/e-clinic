<?php

namespace Modules\Location\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Location\Database\Factories\AreaFactory;

class Area extends Model
{
  use HasFactory, Translatable;

    protected $with = ['translations'];

    public $translatedAttributes = ['name'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'status',
        'order',
        'city_id'
    ];

     public function getDisplayNameAttribute(): ?string
    {
        return $this->name; // auto translated
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
