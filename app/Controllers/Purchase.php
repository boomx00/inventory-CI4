<?php namespace App\Controllers;

use App\Models\StockModel;
use App\Models\SalesModel;
use App\Models\PurchaseModel;
use App\Models\UsersModel;
use App\Models\TempEdit;
use App\Models\TempModel;
use App\Models\TempUpdate;
use App\Models\TempDelete;
use App\Models\TempBuy;
use App\Models\TransactionBuyModel;
use App\Models\TransactionSalesModel;
use App\Models\TempEditBuy;

use App\Models\UploadPurchase;


class Purchase extends BaseController
{

	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
			$this->users = new UsersModel();
			$this->tempdelete = new TempDelete();
        $this->stocks= new StockModel();
				$this->sales= new SalesModel();
				$this->temp= new TempModel();
				$this->salesTransaction = new TransactionSalesModel();
				$this->tempedit = new TempEdit();
                $this->tempeditbuy = new TempEditBuy();
                $this->model_upload = new UploadPurchase();


    }

   public function new(){
    $db = \Config\Database::connect();
    $thequery = $db->query("SELECT * FROM stock");
    $datas['products'] = $thequery;

    return redirect()->to('/purchase/create/');

    // return view('transactions/purchase/purchase_create',$datas);   
 }

 public function create(){
    // $orderid = "";

    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    if($pageWasRefreshed){
        $orderid = 'fff';

        $db = \Config\Database::connect();
        $sql = "DELETE FROM tempbuy WHERE user = ? ";
        $query = $db->query($sql, [session()->get('name')]);
    }
    $db = \Config\Database::connect();
    $employeequerry = $db->query("SELECT * FROM employee");
    $supplierquery = $db->query("SELECT * FROM supplier");
    $thequery = $db->query("SELECT * FROM stock");
    $datas['products'] = $thequery;
    $datas['employee'] = $employeequerry;
    $datas['supplier'] = $supplierquery;
          return view('transactions/purchase/purchase_create',$datas);   

 }

 public function process(){
    $db = \Config\Database::connect();
    $stocks = new StockModel();
	$purchase = new PurchaseModel();
	$temp = new TempBuy();
	$purchaseTransaction = new TransactionBuyModel();
	$i = 1;
	$orderid = $this->request->getVar('orderid');
	$date = $this->request->getVar('myDate');
	$supplier = $this->request->getVar('supplier');
    $nopolice = $this->request->getVar('nopolice');
    $statuspayment = $this->request->getVar('statuspayment');
    $hari = $this->request->getVar('hari');
    $ex1 = $this->request->getVar('accTotals'); //total sale
    $accTotals = str_replace(',','',$ex1);
    $ex2 = $this->request->getVar('totBayar');
    $totalPaid	 = str_replace(',','',$ex2);
	$restPaid = $this->request->getVar('sisa');
	$comment = $this->request->getVar('comment');
    $cashier = $this->request->getVar('cashier');
$counter = 0;
    $transaction = "";
    $arrProducts = array();


    if($accTotals-$totalPaid == 0){
        $transaction = "Lunas";
    }else{
        if($totalPaid == 0){
            $transaction = "Bon-Hutang";
        }else{
            $transaction = "Sebagian Lunas";
        }

    };
   

    // echo $transaction;
    $sqls = "SELECT * FROM tempbuy WHERE user = ?";
    $querys = $db->query($sqls,[session()->get('name')]);
    // $searchTemp = $this->temp->where('user',session()->get('name'))->findAll();
    if($querys){
        foreach($querys->getResult() as $val){
            $arrProducts[$val->product_code] = $val->quantity;
            // $purchaseTransaction ->insert([
            //     // 'id' => $id,
            //     'order_id' => $orderid,
            //     'date' => $date,
            //     'supplier' => $supplier,
            //     'status' => $statuspayment,
            //     'days' => $hari,
            //     'product_code' => $val->product_code,
            //     'product_name' => $val->product_name,
            //     'quantity' => $val->quantity,
            //     'price' => $val->price,
            //     'total' => $val->total,
            //     // 'type' => 'x',
            // ]);
            $sql = 'SELECT name,price,stock FROM stock WHERE code = ?';
            $query = $db->query($sql, [$val->product_code]);
            $row   = $query->getRow();
            $addStock = $row->stock+$val->quantity;
    $this->stocks->update($val->product_code,[
                    'stock' => $addStock,
                ]);
                $sql = 'DELETE FROM tempbuy WHERE user = ?';
                $query = $db->query($sql, [session()->get('name')]);
    // $this->temp->delete($orderid);
    $arrProducts[$val->product_code] = $this->request->getVar('quantity'.$i);

        }
    }
    $serialized = serialize($arrProducts);
    $purchase->insert([
        'order_id' => $orderid,
        'supplier' => $supplier,
        'products' => $serialized,
        'date' => $date,
        'total' => $accTotals,
        'paid' => $totalPaid,
        'unpaid' =>$restPaid,
        'status' =>$statuspayment,
        'days' => $hari,
        'transaction' => $transaction,
        'nopolice' => $nopolice,
        'detail' =>$comment,
        'cashier' =>$cashier,

        ]);

        foreach($querys->getResult() as $val){
 $purchaseTransaction ->insert([
                // 'id' => $id,
                'order_id' => $orderid,
                'date' => $date,
                'supplier' => $supplier,
                'status' => $statuspayment,
                'days' => $hari,
                'product_code' => $val->product_code,
                'product_name' => $val->product_name,
                'quantity' => $val->quantity,
                'price' => $val->price,
                'total' => $val->total,
                // 'type' => 'x',
            ]);
        }



        $files = $this->request->getFiles();
        foreach($files['images'] as $img){
            $name = $img->getName();
            if($name == ""){
                        
            }else{
                $name = $img->getRandomName();

            $data = [
              'order_id' => $orderid,
              'gambar' => $name
          ];
      
          $this->model_upload->insert_gambar($data);
      
            $img->move(ROOTPATH . 'public/uploadtrans', $name);
        }
        }
        // print_r($files);
        return redirect()->to('/purchase/');

}


  function settable(){
    $count = 0;
    $datacontent = "";
                $db = \Config\Database::connect();
                $orderid = $_GET['orderid'];
                $sql = "SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM tempbuy WHERE stock.code = tempbuy.product_code and user = ?)";
                // $query = $db->query($sql, [$id]);
                // $row = $query->getRow();
                $thequery = $db->query($sql, [session()->get('name')]);
                foreach ($thequery->getResult() as $row){
                    $count ++;
                    $datacontent .= "<tr><td>".$count."</td>
                    <td id='code".$count."' name='code'>".$row->code."</td>
                    <td id='names".$count."' name='names'>".$row->name."</td>
                    <td id='price".$count."' name='price'>".$row->price."</td>
                    <td id='stock".$count."' name='stock'>".$row->stock."</td>

                    <td> <button type='submit' class='btn btn-primary' name='getProductCode' id='getProductCode' value='".$row->code."' onclick='addTemp(this,".$count.")'>Select</button></tr>
                    ";
                }
echo $datacontent;
}

function setmodal(){
    $db = \Config\Database::connect();
   

    $temp = new TempBuy();
    // $orderid = $_GET['orderid'];
    $tableResult = "";
    $acctotal = 0;
    $sql = "SELECT * FROM tempbuy WHERE user = ?";
    $query = $db->query($sql, [session()->get('name')]);

    // $searchTemp = $this->temp->where('order_code',$orderid)->findAll();
			$link = base_url('/sales/deleterow/');
				foreach($query->getResult() as $val){
					$count = 1;
					$tableResult .= "<tr><td>".$val->counter."</td>
					<td id='code".$val->counter."' name='code".$val->counter."'>".$val->product_code."</td>
					<td id='prodname".$val->counter."' name='prodname".$val->counter."'>".$val->product_name."</td>
					<td id='price".$val->counter."' name='price".$val->counter."'><input type='text' id='pricee".$val->counter."' name='country' value='".number_format($val->price)."' onkeyup='keyip(this,".$val->counter.")' onchange='priceFunction(this,".$val->counter.")'> </td>
					<td> <input type='number' id='quantity".$val->counter."' name='quantity".$val->counter."' value='$val->quantity' onchange='priceFunction(this,".$val->counter.")''>"."</td>
					<td id='totalamount".$val->counter."' ><input type='text' id='totalss".$val->counter."' name='totalss".$val->counter."' value='".number_format($val->total)."' readonly> </td>
					<td><button type='button' class='btn btn-danger' name='getProductCode".$val->counter."' id='getProductCode".$val->counter."' value='".$val->product_code."' onclick='deleteFunction(this,".$val->counter.")'>Delete</button></td><tr>
					";
                    $acctotal = $acctotal + $val->total;
					$count ++;
				}

			echo $tableResult."!".number_format($acctotal)."!"."poop";
}

function edit($id){
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
    if($pageWasRefreshed){
        $db = \Config\Database::connect();
        $searchsql = "SELECT * FROM purchase WHERE order_id = ?";
        $query = $db->query($searchsql, [$id]);
        $row = $query->getRow();
        $sql = "DELETE FROM tempeditbuy WHERE order_id = ? ";
        $query = $db->query($sql, [$row->order_id]);

        // $sqls = "DELETE FROM tempdelete WHERE order_id = ? ";
        // $query = $db->query($sqls, [$row->order_id]);

        // $sqlss = "DELETE FROM tempupdate WHERE order_id = ? ";
        // $query = $db->query($sqlss, [$row->order_id]);
    }
    $db = \Config\Database::connect();
    $searchtemp = "SELECT * FROM purchase WHERE order_id = ?";
    $tempeditbuy = new TempEditBuy();
    $querytemp = $db->query($searchtemp,[$id]);
    $employeequerry = $db->query("SELECT * FROM employee");


    $row = $querytemp->getRow();
    $purchase = $row->products;
    $unserialize = unserialize($purchase);
    // print_r($unserialize);
    $searchtemps = "SELECT * FROM transaction_purchase WHERE order_id = ?";
    $querytemps = $db->query($searchtemps,[$row->order_id]);
    $builder = $db->table('tempeditbuy');
    $builder -> where('order_id',$row->order_id);
    $result = $builder -> countAllResults();

    if ($result < 1) {
        foreach($querytemps->getResult() as $x){
            $tempeditbuy ->insert([
                'order_id' => $x->order_id,
                'product_code' => $x->product_code,
                'product_name' => $x->product_name,
                'quantity' => $x->quantity,
                'price' => $x->price,
                'total' => $x->total,
            ]);
        }
    }

    $thesql = 'SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM transaction_purchase WHERE stock.code = transaction_purchase.product_code AND order_id = ?)';
    $thequery = $db->query($thesql,[$row->order_id]);
    // foreach ($thequery->getResult() as $row){
    // }
    $data = array(
    'orderid' => $row->order_id,
    'date' =>  $row->date,
    'supplier' => $row->supplier,
    'nopolice' => $row->nopolice,
    'status' => $row->status,
    'days' => $row->days,
    'detail' => $row->detail
        // 'customer' => $row->customer,
);
$sql = 'SELECT * FROM uploadspurchase WHERE order_id = ?';
$query = $db->query($sql,[$row->order_id]);
$result = $query->getResult();
$data['employee'] = $employeequerry;
$data['image'] = $result;
$data['i'] = $id;
$data['orderid'] = $row->order_id;
$data['paid'] = $row->paid;
$data['unpaid'] = $row->unpaid;
$data['products'] = $querytemps;
$data['total'] = $row->total;
$data['cashier'] = $row->cashier;

$data['item'] = $thequery;
    // $sales = $row->sales;
    // $unserialize = unserialize($sales);
    // print_r($unserialize);
    // $data['sales'] = $dataUser;
    // return view('users_edit',$data);
    return view('transactions/purchase/purchase_edit',$data);
}

function displaymainedit(){
	$db = \Config\Database::connect();
    $orderid = $_GET['orderid'];
	$acctotal = 0;
	$finaltotal=0;
	$counttt = 1;
    $maintable = "";
    $subtable = "";
	$totalssql = 'SELECT * FROM tempeditbuy WHERE order_id = ?';
	$totalsquery = $db->query($totalssql,[$orderid]);
	foreach($totalsquery->getResult() as $x){
        $maintable .= "<tr><td>".$counttt."</td>
		<td id='code".$counttt."' name='code".$counttt."'>".$x->product_code."</td>
		<td id='names".$counttt."' name='names".$counttt."'>".$x->product_name."</td>
		<td id='price' name='price'><input type='text' id='pricee".$counttt."' name='pricee".$counttt."' value='".number_format($x->price)."' onkeyup='keyip(this,".$counttt.")' onchange='PriceFunction(this,".$counttt.")'></td>
		<td name='quantity' id='quantity'> <input type='number' id='quantity".$counttt."' name='quantity".$counttt."' value='".$x->quantity."' onchange='PriceFunction(this,".$counttt.")''>"."</td>
		<td id='totals".$counttt."' ><input type='text' id='totalss".$counttt."' name='totalss' value='".number_format($x->total)."' readonly> </td>
		<td><button type='button' class='btn btn-danger' name='getProductCode".$counttt."' id='getProductCode".$counttt."' value='".$x->product_code."' onclick='deleteFunction(this,".$counttt.")'>Delete</button></td><tr>
		";
		$counttt ++;
		$finaltotal = $finaltotal + $x->total;
	}

    $thesql = 'SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM tempeditbuy WHERE stock.code = tempeditbuy.product_code AND order_id = ?)';
    $modalquery = $db->query($thesql,[$orderid]);
    $countt = 0;
    foreach($modalquery->getResult() as $row){
        $countt ++;
        $subtable .= "<tr><td>".$countt."</td>
        <td id='code".$countt."' name='code'>".$row->code."</td>
        <td id='namess".$countt."' name='names'>".$row->name."</td>
        <td id='prices".$countt."' name='price'>".$row->price."</td>
        <td id='stock".$countt."' name='stock'>".$row->stock."</td>
    
        <td> <button type='submit' class='btn btn-primary' name='getProductCode' id='getProductCode' value='".$row->code."' onclick='testFunction(this,".$countt.")'>Select</button></tr>
        ";
    }
    echo $maintable."!".$finaltotal."!".$subtable;

}

function priceajax(){
    $db      = \Config\Database::connect();

    $data = $this->request->getVar(); // all form data into $data variable
    $csrf = $data['csrf_test_name'];   
    $product = $data['product']; 
    $price = $data['price'];
    $orderid=$data['orderid'];
    $quantity = $data['quantity'];
    $acctotal = 0;
    $sql = 'UPDATE tempeditbuy SET price = ? , quantity = ?, total = ? WHERE order_id =? AND product_code = ?';
    $query = $db->query($sql, [$price,$quantity ,$price*$quantity, $orderid,$product]);

    $gettotal = 'SELECT total FROM tempeditbuy WHERE order_id = ? ';
    $totalquery = $db->query($gettotal,[$orderid]);

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

function deleterowedit(){
	$db = \Config\Database::connect();
    $data = $this->request->getVar(); // all form data into $data variable
    $csrf = $data['csrf_test_name'];   
    $product = $data['product']; 
    $total = $data['total'];
    $orderid= $data['orderid'];
    $acctotal = 0;
	$count = 0;
    $tableResult = "";
    $datacontent = "";
    $sql = "DELETE FROM tempeditbuy WHERE order_id = ? AND product_code = ?";
	$query = $db->query($sql, [$orderid,$product]);

    $sql = 'SELECT * FROM `tempeditbuy` WHERE order_id = ?';
	$thequery = $db->query($sql,[$orderid]);
	foreach ($thequery->getResult() as $val){
		$count = 1;
		$tableResult .= "<tr><td>".$count."</td>
		<td id='code".$count."' name='code".$count."'>".$val->product_code."</td>
		<td id='names".$count."' name='names".$count."'>".$val->product_name."</td>
		<td id='price".$count."' name='price".$count."'><input type='text' id='pricee".$count."' name='pricee".$count."' value='".number_format($val->price)."' onchange='PriceFunction(this,".$count.")'></td>
		<td> <input type='number' id='quantity".$count."' name='quantity".$count."' value='$val->quantity' onchange='PriceFunction(this,".$count.")''>"."</td>
		<td id='totalamount".$count."'> <input type='text' id='totalss".$count."' name='totalss' value='".number_format($val->total)."' readonly></td>
		<td><button type='button' class='btn btn-danger' name='getProductCode' id='getProductCode' value='".$val->product_code."' onclick='deleteFunction(this,".$count.")'>Delete</button></td><tr>
		";
		$count ++;
}

$thesql = 'SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM tempeditbuy WHERE stock.code = tempeditbuy.product_code AND order_id = ?)';
$modalquery = $db->query($thesql,[$orderid]);
$countt = 0;
foreach($modalquery->getResult() as $row){
	$countt ++;
	$datacontent .= "<tr><td>".$countt."</td>
	<td id='code".$countt."' name='code'>".$row->code."</td>
	<td id='namess".$countt."' name='names'>".$row->name."</td>
	<td id='prices".$countt."' name='price'>".$row->price."</td>
	<td id='stock".$countt."' name='stock'>".$row->stock."</td>

	<td> <button type='submit' class='btn btn-primary' name='getProductCode' id='getProductCode' value='".$row->code."' onclick='testFunction(this,".$countt.")'>Select</button></tr>
	";
}
$gettotal = 'SELECT total FROM tempeditbuy WHERE order_id = ? ';
        $totalquery = $db->query($gettotal,[$orderid]);

        foreach($totalquery->getResult() as $x){
            $acctotal = $acctotal + $x->total;
        }
$final = $tableResult."!".number_format($acctotal)."!".$datacontent;
echo $final;

}

function editprocess($orderid){
    $db = \Config\Database::connect();

	$tempeditbuy = new TempEditBuy();
	$purchase = new PurchaseModel();
	$buyTransaction = new TransactionBuyModel();
    $path = $_SERVER['DOCUMENT_ROOT'].'/uploadtrans/';
	$newid = $this->request->getVar('orderid');
	$supplier = $this->request->getVar('supplier');
    $nopolice = $this->request->getVar('nopolice');
    $status = $this->request->getVar('statuspayment');
    $days = $this->request->getVar('hari');
    $detail = $this->request->getVar('comment');
    $date =  $this->request->getVar('myDate');
    $cashier = $this->request->getVar('cashier');
    $ex = $this->request->getVar('totBayar');
    $paid = str_replace(',','',$ex);
    $ex1 = $this->request->getVar('accTotals'); //total sale
    $accTotals = str_replace(',','',$ex1);
	$unpaid = $this->request->getVar('sisa');
    if($accTotals-$paid == 0){
        $transaction = "Lunas";
    }else{
        if($paid == 0){
            $transaction = "Bon-Hutang";
        }else{
            $transaction = "Sebagian Lunas";
        }

    };
    $arrays = array();
    $arrayo = array();
	$arrProducts = array();
	$acctotal = 0;
	$quantadded = 0;
	$searchTemp = $this->tempeditbuy->where('order_id',$orderid)->findAll();

		if($searchTemp){
			$getqty = "SELECT * FROM transaction_purchase WHERE order_id = ?";
			$updateone = "SELECT * FROM stock WHERE code = ?";

			$qtyquery = $db->query($getqty,[$orderid]);

			foreach($qtyquery->getResult() as $x){
					$stockquery = $db->query($updateone,[$x->product_code]);
					$row = $stockquery->getRow();

					$stockupdate = 'UPDATE stock SET stock = ? WHERE code = ?';
					$stockquery = $db->query($stockupdate, [$row->stock-$x->quantity,$x->product_code]);
					// $stock = $row->stock+$x->quantity	;
			};

			$sqll = "DELETE FROM transaction_purchase WHERE order_id = ? ";
			$query = $db->query($sqll, [$orderid]);
				foreach($searchTemp as $val){
					$arrProducts[$val->product_code] = $val->quantity;
					$buyTransaction ->insert([
						// 'id' => $id,
						'order_id' => $newid,
						'product_code' => $val->product_code,
						'product_name' => $val->product_name,
						'quantity' => $val->quantity,
						'price' => $val->price,
						'total' => $val->total,
						// 'type' => 'x',
					]);
					$acctotal = $acctotal + $val->total;

					$getstock= "SELECT * FROM stock WHERE code = ?";
					$getstockquery = $db->query($getstock,[$val->product_code]);
					$getstockrow = $getstockquery->getRow();
					$stockupdate = 'UPDATE stock SET stock = ? WHERE code = ?';
					$stockquery = $db->query($stockupdate, [$getstockrow->stock + $val->quantity,$val->product_code]);
				}
				$serialized = serialize($arrProducts);
				$sql = 'UPDATE purchase SET transaction = ?,order_id = ?, supplier = ?, products = ?, total = ?, date = ?,status = ?,detail = ?,days = ?, nopolice = ?,cashier = ?,paid = ?, unpaid = ? WHERE order_id =? ';
				$totalsquery = $db->query($sql,[$transaction,$newid,$supplier,$serialized,$accTotals,$date,$status,$detail, $days,$nopolice,$cashier,$paid,$unpaid,$orderid ]);
				
				$sqll = "DELETE FROM tempeditbuy WHERE order_id = ? ";
				$query = $db->query($sqll, [$orderid]);
				

                $sqll = "DELETE FROM tempdelete WHERE order_id = ? ";
				$query = $db->query($sqll, [$orderid]);
				$sqll = "DELETE FROM tempupdate WHERE order_id = ? ";
				$query = $db->query($sqll, [$orderid]);



                $old = $this->request->getVar('old');
                $original = $this->request->getVar('original');
                if($original == ""){
                    $files = $this->request->getFiles();
                  
                 
                    foreach($files['photos'] as $img){
                      $name = $img->getName();
                      if($name == ""){
                        
                      }else{
                        $name = $img->getRandomName();

                      $data = [
                        'order_id' => $orderid,
                        'gambar' => $name
                    ];
                
                    $this->model_upload->insert_gambar($data);
                
                      $img->move(ROOTPATH . 'public/uploadtrans', $name);
                  }
                  }
                  session()->setFlashdata('message', 'Update Data Success');
                  return redirect()->to('/purchase/');
              
                  }else{

                    if($old == "" and $original != ""){
                        $sqlsearch = "SELECT * FROM uploadspurchase WHERE order_id = ?";
                        $querysearch = $db->query($sqlsearch,[$orderid]);
                
                        foreach($querysearch->getResult() as $x){
                          unlink($path."/".$x->gambar);
                
                        }
                        $sqldelete = "DELETE FROM uploadspurchase WHERE order_id = ? ";
                        $querydelete = $db->query($sqldelete,[$orderid]);
                
                        session()->setFlashdata('message', 'Update Data Success');
                        return redirect()->to('/purchase/');
                      }
                      else{
              //stock initially has pictures, check if any changes have been made
              $files = $this->request->getFiles();
    
              // print_r($files);
              // print_r(count($files));
              foreach($files['photos'] as $img){
                $name = $img->getName();
                if($name == ""){
                  
                }else{
                    $name = $img->getRandomName();
                $data = [
                    'order_id' => $orderid,
                    'gambar' => $name
              ];
          
              $this->model_upload->insert_gambar($data);
          
                $img->move(ROOTPATH . 'public/uploadtrans', $name);
            }
            }
              foreach($old as $x){
                if(strpos($x, 'blob') !== false){
                  
                }else{
                  $piece = explode("/",$x);
                      array_push($arrays,str_replace(" ", "",$piece[4]));
                }
              }
              
              
                    $x = count($arrays);
                    $y = count($original);
              
                    // echo $x;
                    // // echo $y;
                    //if there are changes, then delete all from original,and reinput with the changed ones
                    if($x != $y){
                      
                      foreach($old as $x){
                        if(strpos($x, 'blob') !== false){
              
                        }else{
                        $piece = explode("/",$x);
                        array_push($arrays,str_replace(" ", "",$piece[4]));
                         } ;
                      };
                      foreach($original as $b){
                        array_push($arrayo,str_replace(" ", "",$b));
                      }
              
                      $result=array_diff($arrays,$arrayo);
              
                    
                      
                      $result=array_diff($arrayo,$arrays);
                      // print_r($result);
              
                      foreach($result as $tobedeleted){
                        $sqldelete = "DELETE FROM uploadspurchase WHERE order_id = ? AND gambar = ?";
                    $querydelete = $db->query($sqldelete,[$orderid,$tobedeleted]);
                    unlink($path."/".$tobedeleted);
                      }
                      session()->setFlashdata('message', 'Update Data Success');
                      return redirect()->to('/purchase/');
              
                    
                 
              
                    }
                   
                  session()->setFlashdata('message', 'Update Data Success');
                  return redirect()->to('/purchase/');
                }
                  }
                 
                // print_r($files);



		} else{
			$getid= "SELECT id FROM purchase WHERE order_id = ?";
					$getidquery = $db->query($getid,[$orderid]);
					$getidrow = $getidquery->getRow();
					session()->setFlashdata('error','transactions cannot be null');

			return redirect()->to("/purchase/edit/".$getidrow->id);
		};


}
public function checkid(){
    $db = \Config\Database::connect();
    $orderid = $_GET['orderid'];
    $builder = $db->table('purchase');
    $builder -> where('order_id',$orderid);
    $resultsales = $builder -> countAllResults();
    if($resultsales != 0 ){
        echo "id exists!";
    }else{

    }

    // echo $newid;
}

function delete($id){
    $db = \Config\Database::connect();
    echo $id;
    $sql = 'DELETE FROM purchase WHERE order_id = ?';
    $query = $db->query($sql,[$id]);
    return redirect()->to("/purchase");

}
}
