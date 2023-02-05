<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'customer_id', 'product_id', 'payed', 'payemt_status'
    ];

    public function setPayedAttribute($value)
    {
        $this->attributes['payed'] = ($value) ? 1 : 0;
    }
}
