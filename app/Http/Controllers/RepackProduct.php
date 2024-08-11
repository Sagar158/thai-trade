<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepackProduct extends Model
{
    use HasFactory;

    protected $table = 'repack_products';

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
        'ct_id',
        'log_status',
        'lc',
        'print',
        'cost',
        'dbt',
        'ntf_cs',
        'paisong_siji',
        'survey',
        'print_time',
        'print_by',
        'products',
        'update_log_status_date_time',
        'manually_status_changed',
        't_cube',
        't_weight'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'product_id', 'MAITOU');
    }
}
