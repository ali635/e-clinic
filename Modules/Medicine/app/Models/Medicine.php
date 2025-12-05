<?php

namespace Modules\Medicine\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Medicine\Database\Factories\MedicineFactory;

class Medicine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name'
    ];

    // protected static function newFactory(): MedicineFactory
    // {
    //     // return MedicineFactory::new();
    // }
}
