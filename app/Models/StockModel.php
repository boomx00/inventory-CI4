<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModel extends Model
{
    protected $table = "stock";
    protected $primaryKey = "code";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['code', 'name','price','stock','gambar','imageid','image'];

    
}
