<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'ID';
    protected $fillable = [
        'Job_Title', 'Email_Address', 'FirstName_LastName', 'registered_since', 'phone',
    ];
}
