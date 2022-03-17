<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseModel extends Model
{
    protected $table = "purchase";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id','order_id','date','supplier','products' ,'total','paid','unpaid','nopolice','detail','status','days','transaction','cashier'];
}
