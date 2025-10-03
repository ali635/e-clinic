<?php

namespace Modules\Slider\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Slider\Database\Factories\SliderTransaltionFactory;

class SliderTranslation extends Model
{
    use HasFactory;
 /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'locale',
        'slider_id',
        'description'
    ];

    public $timestamps = false;

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}
