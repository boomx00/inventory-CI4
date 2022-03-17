<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionBuyModel extends Model
{
    protected $table = "transaction_purchase";
    protected $primaryKey = "order_id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['order_id','product_code','product_name','quantity','price','total','status','days','transaction'];
}
