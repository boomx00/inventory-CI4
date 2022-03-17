<?php namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\SupplierModel;

class Supplier extends BaseController
{
	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        $this->customer = new CustomerModel();
        $this->supplier = new SupplierModel();

    }

   function new(){
    return view('/master/supplier/supplier_create.php');

   }

    function create(){
        $code = $this->request->getVar('code');
        $name = $this->request->getVar('name');
        $address = $this->request->getVar('address');
        $phone = $this->request->getVar('phone');
        $detail = $this->request->getVar('comment');

        $data = [
            'code' => $code,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'detail' => $detail,
        ];

        $this->supplier->insert_gambar($data);
        return redirect()->to('/supplier');

    }

    function edit($id){
        $db = \Config\Database::connect();
        $sql = "SELECT * FROM supplier WHERE id= ? ";
        $query = $db->query($sql,[$id]);
        $result = $query->getRow();
        $data['supplier'] = $result;
        $data['id'] = $id;
        return view('/master/supplier/supplier_edit.php',$data);
    }

    function editprocess($id){
        $code = $this->request->getVar('code');
        $name = $this->request->getVar('name');
        $address = $this->request->getVar('address');
        $phone = $this->request->getVar('phone');
        $detail = $this->request->getVar('comment');

        $db = \Config\Database::connect();
        $sql = "UPDATE supplier SET code = ?, name = ? ,address = ?, phone = ?, detail = ? WHERE id=? ";
        $query = $db->query($sql,[$code,$name,$address,$phone,$detail,$id]);

    return redirect()->to('/supplier');

    }

    function delete($id){
        $db = \Config\Database::connect();
        $sql = "DELETE FROM supplier WHERE id = ?";
        $query = $db->query($sql,[$id]);
        return redirect()->to('/supplier');
    }
}
