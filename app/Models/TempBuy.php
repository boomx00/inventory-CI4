<?php

namespace App\Models;

use CodeIgniter\Model;

class TempBuy extends Model
{
    protected $table = "tempbuy";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['order_code','product_code','price','quantity','total','counter','product_name','user' ];
}
