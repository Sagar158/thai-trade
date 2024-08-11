<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepackProductWithProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'repack_product_id',
    ];
}
