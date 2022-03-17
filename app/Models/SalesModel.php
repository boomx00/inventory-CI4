<?php

namespace App\Models;

use CodeIgniter\Model;

class SalesModel extends Model
{
    protected $table = "sales";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id','order_id','date','customer','sales' ,'phone','total','cashier','status','paid','unpaid','transaction','hari'];
}
