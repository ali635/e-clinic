<?php

namespace Modules\Service\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Service\Database\Factories\ServiceTranslationFactory;

class ServiceTranslation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'service_translations';

     protected $fillable = [
        'name',
        'locale',
        'service_id',
        'short_description',
        'description'
    ];

    public $timestamps = false;

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
