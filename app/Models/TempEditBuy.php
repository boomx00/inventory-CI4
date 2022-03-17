<?php

namespace App\Models;

use CodeIgniter\Model;

class TempEditBuy extends Model
{
    protected $table = "tempeditbuy";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id','order_id','product_code','product_name','quantity' ,'total','price'];
}
