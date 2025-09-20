<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['company_id','first_name','last_name','email','billing_address','delivery_address','mobile_number','send_docket_to'];


    public function company(){ 
        return $this->belongsTo(Company::class); 
    }
    public function orders(){ 
        return $this->hasMany(Order::class); 
    }
}
