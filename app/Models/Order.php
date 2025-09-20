<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id','product_id','liters','delivery_date'];


    public function customer(){ 
        return $this->belongsTo(Customer::class); 
    }
    public function product(){ 
        return $this->belongsTo(Product::class); 
    }
    public function invoice(){ 
        return $this->hasOne(Invoice::class); 
    }
}
