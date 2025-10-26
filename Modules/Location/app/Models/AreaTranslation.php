<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Location\Database\Factories\AreaTranslationFactory;

class AreaTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'locale',
        'area_id',
    ];

    public $timestamps = false;

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
