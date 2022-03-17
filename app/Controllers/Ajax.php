<?php namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\TempBuy;
use App\Models\TempEditBuy;

class Ajax extends BaseController
{
	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        $this->customer = new CustomerModel();
        $this->tempbuy = new TempBuy();
        $this->tempeditbuy = new TempEditBuy();
    }


    function priceajax(){
         $db      = \Config\Database::connect();
        $builder = $db->table('tempedit');

        $data = $this->request->getVar(); // all form data into $data variable
        $csrf = $data['csrf_test_name'];   
        $price = $data['price']; 
        $product = $data['product']; 
        $quantity = $data['quantity']; 
        $orderid = $data['orderid'];
        $acctotal = 0;
        $sql = 'UPDATE tempedit SET price = ? , total = ? WHERE order_id =? AND product_code = ?';
        $query = $db->query($sql, [$price,$price*$quantity,$orderid,$product]);

        $gettotal = 'SELECT total FROM tempedit WHERE order_id = ? ';
        $totalquery = $db->query($gettotal,[$orderid]);

        foreach($totalquery->getResult() as $x){
            $acctotal = $acctotal + $x->total;
        }
        echo json_encode( array( 
           "status" => 1, 
           "message" => $price, 
           "total" => number_format($price*$quantity),
           "acctotal" => number_format($acctotal),
           "data" => $data 
        ));
        
    }

    function tempajax(){
        $db      = \Config\Database::connect();
        $data = $this->request->getVar(); // all form data into $data variable
        $csrf = $data['csrf_test_name'];   
        $product = $data['product']; 
        $orderid = $data['orderid'];
        $name = $data['name'];
        $tempbuy = new TempBuy();
        $builder = $db->table('tempbuy');
        $builder -> getWhere(['order_code' => $orderid]);
        $builder -> selectMax('counter');
        $theee = $builder->get();
        $roww = $theee->getRow();
        if($roww->counter == ""){
        $tempbuy->insert([
            'order_code' => $orderid,
            'product_code' => $product,
            'product_name' => $name,
            'price' => 0,
            'counter' => 1,
            'quantity' => 1,
            'user' => session()->get('name'),
        ]);
    }else{
        $tempbuy->insert([
            // 'order_id' => $id,
            'order_code' => $orderid,
            'product_code' =>  $product,
            'product_name' =>  $name,
            'price' => 0,
            'counter' => $roww->counter + 1,
            'quantity' => 1,
            'user' => session()->get('name'),

        ]);
    }
        // print_r($data);
    }

    function pricetemp(){
        $db      = \Config\Database::connect();

        $data = $this->request->getVar(); // all form data into $data variable
        $csrf = $data['csrf_test_name'];   
        $product = $data['product']; 
        $ex1 = $data['price'];
        $price = str_replace(',','',$ex1);
        $quantity = $data['quantity'];
        $acctotal = 0;
        $sql = 'UPDATE tempbuy SET price = ? , quantity = ?, total = ? WHERE user =? AND product_code = ?';
        $query = $db->query($sql, [$price,$quantity ,$price*$quantity,session()->get('name'),$product]);

        $gettotal = 'SELECT total FROM tempbuy WHERE user = ? ';
        $totalquery = $db->query($gettotal,[session()->get('name')]);

        foreach($totalquery->getResult() as $x){
            $acctotal = $acctotal + $x->total;
        }
        echo json_encode( array( 
            "status" => 1, 
            "message" => $price, 
            "total" => number_format($price*$quantity),
            "quantity" => $quantity,
            "acctotal" => number_format($acctotal),
            "data" => $data 
         ));
    }

    function deleterow(){
        $db      = \Config\Database::connect();

        $data = $this->request->getVar(); // all form data into $data variable
        $product = $data['product']; 
        $sql = 'DELETE FROM tempbuy WHERE product_code = ? and user = ?';
        $query = $db->query($sql, [$product,session()->get('name')]);
    }

    function addedit(){
        $db = \Config\Database::connect();
        $tempeditbuy = new TempEditBuy();

        $data = $this->request->getVar(); // all form data into $data variable
        $csrf = $data['csrf_test_name'];   
        $product = $data['product']; 
        $orderid = $data['orderid'];
        $name = $data['name'];
        $tempeditbuy->insert([
            'order_id' => $orderid,
            'product_code' => $product,
            'product_name' => $name,
            'price' => 0,
            'quantity' => 1,
            'total' => 0,
        ]);
    }
	//--------------------------------------------------------------------

}
