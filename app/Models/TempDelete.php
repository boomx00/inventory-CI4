<?php

namespace App\Models;

use CodeIgniter\Model;

class TempDelete extends Model
{
    protected $table = "tempdelete";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['order_id','product_code','quantity'];
}
