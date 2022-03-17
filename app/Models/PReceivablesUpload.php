<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class PReceivablesUpload extends Model
{
    protected $table;
 
    public function __construct() {
 
        parent::__construct();
        $db = \Config\Database::connect();
        $this->table = $this->db->table('purchasereceivablesuploads');
    }
 
    public function get_uploads()
    {
        return $this->table->get()->getResultArray();
    }
    public function insert_img($data)
    {
        return $this->table->insert($data);
    }
} 