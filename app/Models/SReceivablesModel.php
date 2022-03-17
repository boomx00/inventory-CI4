<?php

namespace App\Models;

use CodeIgniter\Model;

class SReceivablesModel extends Model
{
    protected $table = "salesreceivables";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['order_id', 'amount','detail','images','paymentid','date','payment_id'];

    function transactiontest($paid,$unpaid,$transaction,$orderid){

        $this->db->transBegin();
        $sql1 = "UPDATE sales SET paid = ?, unpaid = ?,transaction=? WHERE order_id = ?";
        $this->db->query($sql1,[$paid,$unpaid,$transaction,$orderid]);
        $this->db->transComplete();

    }
}
