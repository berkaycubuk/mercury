<?php

namespace Core\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'details',
        'type',
        'primary'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\Address::new();
    }

    public function getFirstNameAttribute()
    {
        if (isset(json_decode($this->details)->first_name)) {
            return json_decode($this->details)->first_name;
        }

        return '';
    }

    public function getLastNameAttribute()
    {
        if (isset(json_decode($this->details)->last_name)) {
            return json_decode($this->details)->last_name;
        }

        return '';
    }

    public function getFullNameAttribute()
    {
        if (isset(json_decode($this->details)->first_name) && isset(json_decode($this->details)->last_name)) {
            return json_decode($this->details)->first_name . ' ' . json_decode($this->details)->last_name;
        }

        return '';
    }

    public function getAddressNameAttribute()
    {
        return json_decode($this->details)->address_name;
    }

    public function getAddressAttribute()
    {
        return json_decode($this->details)->address;
    }

    public function getPhoneAttribute()
    {
        if (isset(json_decode($this->details)->phone)) {
            return json_decode($this->details)->phone;
        }

        return '';
    }

    public function getCityAttribute()
    {
        return json_decode($this->details)->city;
    }

    public function getDistrictAttribute()
    {
        return json_decode($this->details)->district;
    }

    public function getNeighborhoodAttribute()
    {
        return json_decode($this->details)->neighborhood;
    }

    public function getBillTypeAttribute()
    {
        if ($this->type == 'billing') {
            return json_decode($this->details)->bill_type;
        }

        return null;
    }

    public function getCompanyNameAttribute()
    {
        if ($this->type == 'billing' && json_decode($this->details)->bill_type == 'company') {
            return json_decode($this->details)->company_name;
        }

        return null;
    }

    public function getCompanyTaxNumberAttribute()
    {
        if ($this->type == 'billing' && json_decode($this->details)->bill_type == 'company') {
            return json_decode($this->details)->company_tax_number;
        }

        return null;
    }

    public function getCompanyTaxAdministrationAttribute()
    {
        if ($this->type == 'billing' && json_decode($this->details)->bill_type == 'company') {
            return json_decode($this->details)->company_tax_administration;
        }

        return null;
    }

    public function getEBillUserAttribute()
    {
        if ($this->type == 'billing' && json_decode($this->details)->bill_type == 'company') {
            return json_decode($this->details)->e_bill_user;
        }

        return null;
    }
}
