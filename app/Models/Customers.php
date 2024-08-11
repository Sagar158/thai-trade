<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name','MAITOU','CS','DID','address','sub_district','district','state','post_code','telephone1','telephone2','telephone3','Preferred_WULIU','GOOGLE_MAP'
    ];

}
