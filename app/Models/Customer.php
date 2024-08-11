<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'MAITOU',
        'CS',
        'DID',
        'address',
        'sub_district',
        'district',
        'state',
        'post_code',
        'telephone1',
        'telephone2',
        'telephone3',
        'Preferred_WULIU',
        'GOOGLE_MAP',
    ];

    public function addressDetails()
    {
        return $this->name . "<br>" . $this->address .
            $this->sub_district .
            $this->district .
            $this->state .
            $this->post_code .
            $this->telephone1 .
            $this->telephone2;
    }
}
