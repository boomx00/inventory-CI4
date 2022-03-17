<?php

namespace App\Models;

use CodeIgniter\Model;

class TempModel extends Model
{
    protected $table = "temptable";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['order_id','customer','date','product_code','product_name','price','counter','quantity','total','order_code','user' ];
}
