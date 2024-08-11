<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'cs_did',
        'name',
        'photo1',
        'photo2',
        'photo3',
        'photo4',
        'video',
        'sku',
        'warehouse',
        'option',
        'w',
        'l',
        'h',
        'weight',
        'tpcs',
        'packageid',
        'remarks',
        'type',
        'repack',
        'bill_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'product_id', 'MAITOU');
    }
}
