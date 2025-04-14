<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'tax_id',
        'company_name',
        'trade_name',
        'contact_person',
        'position',
        'phone',
        'phone2',
        'contact_email',
        'billing_email',
        'zip_code',
        'address',
        'number',
        'neighborhood',
        'state',
        'city',
        'lead',
        'interest',
        'segment',
        'legal_representative_name',
        'legal_representative_tax_id',
        'legal_representative_email'
    ];

    protected $casts = [
        'tax_id' => 'string',
        'zip_code' => 'string',
        'legal_representative_tax_id' => 'string'
    ];
}
