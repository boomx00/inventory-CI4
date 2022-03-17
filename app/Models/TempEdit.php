<?php

namespace App\Models;

use CodeIgniter\Model;

class TempEdit extends Model
{
    protected $table = "tempedit";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['order_id','product_code','product_name','price','quantity','total'];
}
