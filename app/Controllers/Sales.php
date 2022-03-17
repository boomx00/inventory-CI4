<?php namespace App\Controllers;

use App\Models\StockModel;
use App\Models\SalesModel;
use App\Models\UsersModel;
use App\Models\TempEdit;
use App\Models\TempModel;
use App\Models\TempUpdate;
use App\Models\TempDelete;

use App\Models\TransactionSalesModel;



class Sales extends BaseController
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

    }

		public function newsales(){
			
// return redirect()->to('/sales/create/'.$result);
return redirect()->to('/sales/create/');

			// print_r($row);
			// echo $row-> MAX(id) ;
						// return redirect()->to('/sales/create/'.$id);
		}

		public function settable(){
			$count = 0;
				$datacontent = "";
							$db = \Config\Database::connect();
							$orderid = $_GET['orderid'];
							$sql = "SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM temptable WHERE stock.code = temptable.product_code and order_code = ?)";
							// $query = $db->query($sql, [$id]);
							// $row = $query->getRow();
							$thequery = $db->query($sql, [$orderid]);
							foreach ($thequery->getResult() as $row){
								$count ++;
								$datacontent .= "<tr><td>".$count."</td>
								<td id='code' name='code'>".$row->code."</td>
								<td id='names' name='names'>".$row->name."</td>
								<td id='price' name='price'>".$row->price."</td>
								<td id='stock' name='stock'>".$row->stock."</td>

								<td> <button type='submit' class='btn btn-primary' name='getProductCode' id='getProductCode' value='".$row->code."' onclick='testFunction(this)'>Select</button></tr>
								";
							}
			echo $datacontent;
		}

		public function create(){
			$orderid = "";

			$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
			if($pageWasRefreshed){
				$db = \Config\Database::connect();
				$sql = "DELETE FROM temptable WHERE user = ? ";
				$query = $db->query($sql, [session()->get('name')]);
			}
			$db = \Config\Database::connect();
			$sql = "DELETE FROM temptable WHERE user = ? ";
				$query = $db->query($sql, [session()->get('name')]);
			$thequery = $db->query("SELECT * FROM stock");
			$employeequerry = $db->query("SELECT * FROM employee");
			// $querytemp = $db->query($searchtemp,[$id]);
			// $temprow = $querytemp -> getRow();
			$data['products'] = $thequery;
			$data['employee'] = $employeequerry;

			// $data['i'] = $id;
			// $builder = $db->table('temptable');
			// $builder -> where('order_id',$id);
			// $result = $builder -> countAll();
			// if($result == 0){
				// return view('transactions/sales_create',$data);
				return view('transactions/sales_create',$data);

			// }
		}

		public function edit($id){
			$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
			
			if($pageWasRefreshed){
				$db = \Config\Database::connect();
				$searchsql = "SELECT * FROM sales WHERE order_id = ?";
				$query = $db->query($searchsql, [$id]);
				$row = $query->getRow();
				$sql = "DELETE FROM tempedit WHERE order_id = ? ";
				$query = $db->query($sql, [$row->order_id]);

				$sqls = "DELETE FROM tempdelete WHERE order_id = ? ";
				$query = $db->query($sqls, [$row->order_id]);

				$sqlss = "DELETE FROM tempupdate WHERE order_id = ? ";
				$query = $db->query($sqlss, [$row->order_id]);
			}
			$db = \Config\Database::connect();
			$searchtemp = "SELECT * FROM sales WHERE order_id = ?";
			$tempedit = new TempEdit();
			$querytemp = $db->query($searchtemp,[$id]);
			$employeequerry = $db->query("SELECT * FROM employee");


			$sql = "SELECT * FROM sales WHERE order_id = ?";
			$query = $db->query($sql, [$id]);
			$row = $query->getRow();
			$dataUser = $this->sales->find($id);
			$saleRow = $querytemp->getRow();
			$sales = $row->sales;
			$unserialize = unserialize($sales);
			// print_r($unserialize);
			$searchtemps = "SELECT * FROM transaction_sales WHERE order_id = ?";
			$querytemps = $db->query($searchtemps,[$row->order_id]);
			$builder = $db->table('tempedit');
			$builder -> where('order_id',$row->order_id);
			$result = $builder -> countAllResults();

			if ($result < 1) {
				foreach($querytemps->getResult() as $x){
					$tempedit ->insert([
						'order_id' => $x->order_id,
						'product_code' => $x->product_code,
						'product_name' => $x->product_name,
						'quantity' => $x->quantity,
						'price' => $x->price,
						'total' => $x->total,
					]);
				}
			}

			$thesql = 'SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM transaction_sales WHERE stock.code = transaction_sales.product_code AND order_id = ?)';
			$thequery = $db->query($thesql,[$row->order_id]);
			// foreach ($thequery->getResult() as $row){
			// }
			$data = array(
				'orderid' => $row->order_id,
				'date' =>  $row->date,
					'customer' => $row->customer,
					'payment' => $row->status,
					'detail' => $row->detail,
					'status' => $row->status,
					'detail' => $row->detail
			);


		$data['i'] = $id;
		$data['orderid'] = $saleRow->order_id;
		$data['products'] = $querytemps;
		$data['total'] = $saleRow->total;
		$data['paid'] = $saleRow->paid;
		$data['hari'] = $saleRow->hari;

		$data['unpaid'] = $saleRow->unpaid;
		$data['cashier'] = $saleRow->cashier;
		$data['item'] = $thequery;
		$data['employee'] = $employeequerry;


			$sales = $row->sales;
			// $unserialize = unserialize($sales);
			// print_r($unserialize);
			// $data['sales'] = $dataUser;
			// return view('users_edit',$data);
			return view('transactions/sales_edit',$data);
		}

		function process(){
			$db = \Config\Database::connect();
				$stocks = new StockModel();
			$sales = new SalesModel();
				$temp = new TempModel();
				$salesTransaction = new TransactionSalesModel();
				$i = 1;
				$orderid = $this->request->getVar('orderid');
				$date = $this->request->getVar('date');
				$customer = $this->request->getVar('customer');
				$ex1 = $this->request->getVar('accTotals'); //total sale
				$accTotal = str_replace(',','',$ex1);
				$transaction = "";
				$ex2 = $this->request->getVar('totBayar');
				$totalPaid	 = str_replace(',','',$ex2);
				$hari	 = $this->request->getVar('hari');

				$restPaid = $this->request->getVar('sisa');
				$payment = $this->request->getVar('statuspayment');
				$comment = $this->request->getVar('comment');
				$cashier = $this->request->getVar('cashier');
				if($accTotal-$totalPaid == 0){
					$transaction = "Lunas";
				}else{
					if($totalPaid == 0){
						$transaction = "Bon-Hutang";
					}else{
						$transaction = "Sebagian Lunas";
					}
			
				};
			// echo $transaction;
				// echo $comment;
				$arrProducts = array();
				$searchTemp = $this->temp->where('order_code',$orderid)->findAll();
				// echo 	$orderid ;
					if($searchTemp){
							foreach($searchTemp as $val){
								$arrProducts[$val->product_code] = $val->quantity;
							
								$sql = 'SELECT name,price,stock FROM stock WHERE code = ?';
										$query = $db->query($sql, [$val->product_code]);
										$row   = $query->getRow();
										$reducedStock = $row->stock-$val->quantity;
								$this->stocks->update($val->product_code,[
												'stock' => $reducedStock,
											]);
											$sql = 'DELETE FROM temptable WHERE order_code = ?';
											$query = $db->query($sql, [$orderid]);
								// $this->temp->delete($orderid);
								$arrProducts[$val->product_code] = $this->request->getVar('quantity'.$i);
								// $i ++;
							}
					}
				
$serialized = serialize($arrProducts);
$sales->insert([
		// 'id' => $id,
  'order_id' => $orderid,
  'customer' => $customer,
		'sales' => $serialized,
  'date' => $date,
  'total' => $accTotal,
  'paid' => $totalPaid,
  'unpaid' =>$restPaid,
  'status' =>$payment,
  'detail' =>$comment,
  'cashier' => $cashier,
  'transaction' => $transaction,
  'hari' => $hari
]);

foreach($searchTemp as $val){

	$salesTransaction ->insert([
		// 'id' => $id,
		'order_id' => $orderid,
		'product_code' => $val->product_code,
		'product_name' => $val->product_name,
		'quantity' => $val->quantity,
		'price' => $val->price,
		'total' => $val->total,
		// 'type' => 'x',
	]);
	};
	return redirect()->to('/sales/');
			}

		public function createqty(){
			$temp = new TempModel();
			$quantity = $_GET['quantity'];
			$id = $_GET['id'];
			$productcode = $_GET['product'];
			$total = $_GET['total'];
			$db      = \Config\Database::connect();

			$sql = 'SELECT * FROM temptable WHERE order_id = ? AND product_code = ?';
	$query = $db->query($sql, [$id,$productcode]);
$row   = $query->getRow();

			$builder = $db->table('temptable');
			$builder -> set('quantity',$quantity);
			$builder -> set('total',$quantity * $row->price);
			$builder -> where('order_id',$id);
			$builder -> where('product_code',$productcode);
			$builder -> update();
			$acctotal = 0;



			$sqlall = 'SELECT * FROM temptable WHERE order_id = ?';


				$queryall = $db->query($sqlall, [$id]);


				$eachtotal = $quantity * $row->price;

				foreach ($queryall->getResult() as $x){
					$acctotal = $acctotal + $x->total;
				}

				$end = number_format($eachtotal)."n".number_format($acctotal);
				echo $end;
				// $result = "$row->total"."n".
			// $builder ->getWhere(['order_id' => $id]);
			// $builder -> getWhere(['product_code' => $productcode]);
			// $query = $builder->get();
			// $rresult = $query->getRow();
			// echo $row->total;
		}
		public function createtest(){
			$this->stocks= new StockModel();
			// $tempcounter = new TempCounter();
			$temp = new TempModel();
			$db = \Config\Database::connect();
			$prodcode = $_GET['prodcode'];
			$id = $_GET['id'];
			$orderid = $_GET['orderid'];
			$date = $_GET['date'];
			$customer = $_GET['customer'];
			$icounter= 0;
			$sql = "SELECT * FROM stock WHERE code = ?";
			$query = $db -> query($sql,[$prodcode]);
			$row = $query->getRow();
			$tableResult = "";
			if($query){
				$builder = $db->table('temptable');
				$builder -> getWhere(['order_code' => $orderid]);
				$builder -> selectMax('counter');
				$theee = $builder->get();
				$roww = $theee->getRow();
				if($roww->counter == ""){
				$temp->insert([
					'order_id' => $id,
					'order_code' => $orderid,
					'customer' => $customer,
					'date' => 	$date,
					'product_code' => $row->code,
					'product_name' => $row->name,
					'price' => 0,
					'counter' => 1,
					'quantity' => 1,
					'user' =>  session()->get('name')
				]);
			}else{
				$temp->insert([
					'order_id' => $id,
					'order_code' => $orderid,
					'customer' => $customer,
					'date' => 	$date,
					'product_code' => $row->code,
					'product_name' => $row->name,
					'price' => 0,
					'counter' => $roww->counter + 1,
					'quantity' => 1,
					'user' =>  session()->get('name')

				]);
			}

			};

			$searchTemp = $this->temp->where('order_code',$orderid)->findAll();
			$link = base_url('/sales/deleterow/');
			if($searchTemp){
				foreach($searchTemp as $val){
					$count = 1;
					$tableResult .= "<tr><td>".$val->counter."</td>
					<td id='code".$val->counter."' name='code".$val->counter."'>".$val->product_code."</td>
					<td id='prodname".$val->counter."' name='prodname".$val->counter."'>".$val->product_name."</td>
					<td id='price".$val->counter."' name='price".$val->counter."'><input type='text' id='prices".$val->counter."' value='".number_format($val->price)."' name='country' onkeyup='keyip(this,".$val->counter.")' onchange='priceFunction(this,".$val->counter.")'> </td>
					<td> <input type='number' id='quantity".$val->counter."' name='quantity".$val->counter."' value='$val->quantity' onchange='myFunction(this,".$val->counter.")''>"."</td>
					<td id='totalamount".$val->counter."' ><input type='text' id='totalamounts".$val->counter."' name='totalamounts".$val->counter."' value='".number_format($val->total)."' readonly> </td>
					<td><button type='button' class='btn btn-danger' name='getProductCode".$val->counter."' id='getProductCode".$val->counter."' value='".$val->product_code."' onclick='deleteFunction(this)'>Delete</button></td><tr>
					";
					$count ++;
				}
			}

			echo $tableResult;
			// print_r($row);


		}

		public function createprice(){
			$db = \Config\Database::connect();

			$product = $_GET['product'];
			$price = $_GET['price'];
			$orderid = $_GET['orderid'];
			$quantity = $_GET['quantity'];
			$total= 0;
			$sql = 'UPDATE temptable SET price = ? , total = ? WHERE order_code =? AND product_code = ?';
			$query = $db->query($sql, [$price,$price*$quantity,$orderid,$product]);

			$totalsql = 'SELECT * FROM temptable WHERE order_code = ? AND product_code = ?';
			$totalquery = $db->query($totalsql, [$orderid,$product]);
			$row = $totalquery ->getRow();

			$acctotal = $row->price * $row->quantity;

			$gettotalsql = 'SELECT * FROM temptable WHERE order_code = ?';
			$acctotalquery = $db->query($gettotalsql, [$orderid]);
			foreach($acctotalquery->getResult() as $x){
				$total = $total + $x->total;
			}

			
			echo number_format($acctotal)."!".number_format($total);

			// echo $orderid;
		}


		public function checkid(){
			$db = \Config\Database::connect();
			$originalid = $_GET['originalid'];
			$newid = $_GET['newid'];


			if($newid == ""){
				$builder = $db->table('sales');
				$builder -> where('order_id',$originalid);
				$resultsales = $builder -> countAllResults();

				// $builders = $db->table('temptable');
				// $builders -> where('order_code',$originalid);
				// $resulttemp = $builders -> countAllResults();

				if($resultsales != 0 ){
					echo "false";
				}

			}else{
				$builder = $db->table('sales');
				$builder -> where('order_id',$newid);
				$resultsales = $builder -> countAllResults();
				if($resultsales != 0 ){
					echo "id exists!";
				}else{
					$sql = 'UPDATE temptable SET order_code = ? WHERE order_code =?';
					$query = $db->query($sql, [$newid,$originalid]);

					echo "true";
				}
			}
			// echo $newid;
		}

		


		public function deleterow(){
			$db = \Config\Database::connect();
			$prodcode = $_GET['code'];
			$id = $_GET['id'];
			$tableResult="";
			$total = 0;
			// echo $id;
			$sql = "DELETE FROM temptable WHERE order_id = ? AND product_code = ?";
			$query = $db->query($sql, [$id,$prodcode]);
			$searchTemp = $this->temp->where('order_id',$id)->findAll();
			$link = base_url('/sales/deleterow/');
			if($searchTemp){
				foreach($searchTemp as $val){
					$count = 1;
					$tableResult .= "<tr><td>".$val->counter."</td>
					<td id='code".$val->counter."' name='code".$val->counter."'>".$val->product_code."</td>
					<td id='prodname".$val->counter."' name='prodname".$val->counter."'>".$val->product_name."</td>
					<td id='price".$val->counter."' name='price".$val->counter."'><input type='text' id='country' name='country' value='".number_format($val->price)."' onchange='priceFunction(this,".$val->counter.")'> </td>
					<td> <input type='text' id='quantity".$val->counter."' name='quantity".$val->counter."' value='$val->quantity' onchange='myFunction(this,".$val->counter.")''>"."</td>
					<td id='totalamoun".$val->counter."'> <input type='text' id='totalamounts".$val->counter."' name='country' value='".number_format($val->total)."' readonly></td>
					<td><button type='button' class='btn btn-danger' name='getProductCode' id='getProductCode' value='".$val->product_code."' onclick='deleteFunction(this)'>Delete</button></td><tr>
					";
					$count ++;
					$total = $total + $val->total;
				}
			}
			echo $tableResult."!".number_format($total);
		}

public function addedit(){
	$db = \Config\Database::connect();
	$tempedit = new TempEdit();
	$prodcode = $_GET['prodcode'];
	$prodname = $_GET['prodname'];
	$id = $_GET['orderid'];
	$price = $_GET['price'];
	$modalcontent ="";
	$maintable ="";
	$subtable = "";
	$tempedit->insert([
		'order_id' => $id,
		'product_code' => $prodcode,
		'product_name' => $prodname,
		'price' => $price,
		'quantity' => 1,
		'total' => $price * 1,
	]);

	// $searchTemp = 'SELECT * FROM tempedit WHERE order_id = ?';
	// $searchquery = $db->query($searchTemp, [$id]);
	$acctotal = 0;
	$finaltotal=0;
	$counttt = 1;

	$totalssql = 'SELECT total FROM tempedit WHERE order_id = ?';
	$totalsquery = $db->query($totalssql,[$id]);
	foreach($totalsquery->getResult() as $x){
		$finaltotal = $finaltotal + $x->total;
	}


	$totalsql = 'SELECT * FROM tempedit WHERE order_id = ?';
	$totalquery = $db->query($totalsql,[$id]);
	foreach($totalquery->getResult() as $x){
		
		$maintable .= "<tr><td>".$counttt."</td>
		<td id='code".$counttt."' name='code".$counttt."'>".$x->product_code."</td>
		<td id='names".$counttt."' name='names".$counttt."'>".$x->product_name."</td>
		<td id='price' name='price'><input type='number' id='price".$counttt."' name='price".$counttt."' value='".$x->price."' onchange='PriceFunction(this,".$counttt.")'></td>
		<td> <input type='number' id='quantity".$counttt."' name='quantity".$counttt."' value='".$x->quantity."' onchange='myFunction(this,".$counttt.")''>"."</td>
		<td id='totals".$counttt."' ><input type='text' id='total".$counttt."' name='country' value='$x->total' readonly> </td>
		<td><button type='button' class='btn btn-danger' name='getProductCode".$counttt."' id='getProductCode".$counttt."' value='".$x->product_code."' onclick='deleteFunction(this,".$counttt.")'>Delete</button></td><tr>
		";
		$counttt ++;
	}

	$thesql = 'SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM tempedit WHERE stock.code = tempedit.product_code AND order_id = ?)';
$modalquery = $db->query($thesql,[$id]);
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

public function deleterowedit(){
	$db = \Config\Database::connect();
	$tempdelete = new TempDelete();
	$prodcode = $_GET['code'];
	$tableResult="";
	$datacontent = "";
	$id = $_GET['id'];
	$total = $_GET['total'];
	$acctotal = 0;
	$count = 0;

	$tempdelete->insert([
		'order_id' => $id,
		'product_code' => $prodcode,
		'quantity' => $total
	]);



	$sql = "DELETE FROM tempedit WHERE order_id = ? AND product_code = ?";
	$query = $db->query($sql, [$id,$prodcode]);


	$sql = 'SELECT * FROM `tempedit` WHERE NOT EXISTS (SELECT * FROM tempdelete WHERE tempedit.product_code=tempdelete.product_code AND order_id = ?) AND order_id = ?';
	$thequery = $db->query($sql,[$id,$id]);
	foreach ($thequery->getResult() as $val){
		$count = 1;
		$tableResult .= "<tr><td>".$count."</td>
		<td id='code".$count."' name='code".$count."'>".$val->product_code."</td>
		<td id='prodname".$count."' name='prodname".$count."'>".$val->product_name."</td>
		<td id='price".$count."' name='price".$count."'><input type='text' id='price".$count."' name='price".$count."' value='".number_format($val->price)."' onchange='PriceFunction(this,".$count.")'></td>
		<td> <input type='number' id='quantity".$count."' name='quantity".$count."' value='$val->quantity' onchange='myFunction(this,".$count.")''>"."</td>
		<td id='totalamount".$count."'> <input type='text' id='total".$count."' name='country' value='".number_format($val->total)."' readonly></td>
		<td><button type='button' class='btn btn-danger' name='getProductCode' id='getProductCode' value='".$val->product_code."' onclick='deleteFunction(this,".$count.")'>Delete</button></td><tr>
		";
		$count ++;
}

$thesql = 'SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM tempedit WHERE stock.code = tempedit.product_code AND order_id = ?)';
$modalquery = $db->query($thesql,[$id]);
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
$gettotal = 'SELECT total FROM tempedit WHERE order_id = ? ';
        $totalquery = $db->query($gettotal,[$id]);

        foreach($totalquery->getResult() as $x){
            $acctotal = $acctotal + $x->total;
        }
$final = $tableResult."!".number_format($acctotal)."!".$datacontent;
echo $final;

}

public function editqty(){
		$db = \Config\Database::connect();

	$data = $this->request->getVar(); // all form data into $data variable
	$total = $data['total']; 
	$product = $data['product']; 
	$quantity = $data['quantity']; 
	$orderid = $data['orderid'];
	$price = $data['price'];
	$acctotal = 0;
	$sql = 'UPDATE tempedit SET quantity = ?, total = ? WHERE order_id =? AND product_code = ?';
			$totalsquery = $db->query($sql,[$quantity,$quantity*$price,$orderid,$product]);


			$gettotal = 'SELECT total FROM tempedit WHERE order_id = ? ';
        $totalquery = $db->query($gettotal,[$orderid]);

        foreach($totalquery->getResult() as $x){
            $acctotal = $acctotal + $x->total;
        }
			echo json_encode( array( 
				"status" => 1, 
				"price" => number_format($price), 
				"total" => number_format($price*$quantity),
				"acctotal" => number_format($acctotal),
				"quantity" => $quantity, 
			 ));
}
 

public function editprocess($orderid){
	$db = \Config\Database::connect();

	$tempedit = new TempEdit();
	$sales = new SalesModel();
	$salesTransaction = new TransactionSalesModel();

	$newid = $this->request->getVar('orderid');
	$customer = $this->request->getVar('customer');
    $payment = $this->request->getVar('statuspayment');
    $detail = $this->request->getVar('comment');
	$date = $this->request->getVar('date');
	$cashier = $this->request->getVar('cashier');
	$ex = $this->request->getVar('totBayar');
	$unpaid = $this->request->getVar('sisa');
	
	$paid = str_replace(',','',$ex);


	$ex1 = $this->request->getVar('accTotals'); //total sale
	$accTotal = str_replace(',','',$ex1);
	$transaction = "";
	$ex2 = $this->request->getVar('totBayar');
	$totalPaid	 = str_replace(',','',$ex2);
	$hari	 = $this->request->getVar('hari');

	$restPaid = $this->request->getVar('sisa');
	if($accTotal-$totalPaid == 0){
		$transaction = "Lunas";
	}else{
		if($totalPaid == 0){
			$transaction = "Bon-Hutang";
		}else{
			$transaction = "Sebagian Lunas";
		}

	};

// echo $totalPaid;
	// echo $paid;
	$arrProducts = array();
	$acctotal = 0;
	$quantadded = 0;
	$searchTemp = $this->tempedit->where('order_id',$orderid)->findAll();

		if($searchTemp){
			$getqty = "SELECT * FROM transaction_sales WHERE order_id = ?";
			$updateone = "SELECT * FROM stock WHERE code = ?";

			$qtyquery = $db->query($getqty,[$orderid]);

			foreach($qtyquery->getResult() as $x){
					$stockquery = $db->query($updateone,[$x->product_code]);
					$row = $stockquery->getRow();

					$stockupdate = 'UPDATE stock SET stock = ? WHERE code = ?';
					$stockquery = $db->query($stockupdate, [$row->stock+$x->quantity,$x->product_code]);
					// $stock = $row->stock+$x->quantity	;
			};

			$sqll = "DELETE FROM transaction_sales WHERE order_id = ? ";
			$query = $db->query($sqll, [$orderid]);
				foreach($searchTemp as $val){
					$arrProducts[$val->product_code] = $val->quantity;
					$salesTransaction ->insert([
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
					$stockquery = $db->query($stockupdate, [$getstockrow->stock - $val->quantity,$val->product_code]);
				}
				$serialized = serialize($arrProducts);
				$sql = 'UPDATE sales SET order_id = ?, customer = ?, sales = ?, total = ?, date = ? ,status = ?, detail = ? ,cashier = ?,paid = ?, unpaid = ? ,transaction = ?, hari = ?WHERE order_id =? ';
				$totalsquery = $db->query($sql,[$newid,$customer,$serialized,$acctotal,$date,$payment,$detail,$cashier,$paid,$unpaid,$transaction,$hari,$orderid ]);
				
				$sqll = "DELETE FROM tempedit WHERE order_id = ? ";
				$query = $db->query($sqll, [$orderid]);
				
				$sqll = "DELETE FROM tempdelete WHERE order_id = ? ";
				$query = $db->query($sqll, [$orderid]);
				$sqll = "DELETE FROM tempupdate WHERE order_id = ? ";
				$query = $db->query($sqll, [$orderid]);
				return redirect()->to("/sales");
		} else{
			$getid= "SELECT id FROM sales WHERE order_id = ?";
					$getidquery = $db->query($getid,[$orderid]);
					$getidrow = $getidquery->getRow();
					session()->setFlashdata('error','transactions cannot be null');

			return redirect()->to("/sales/edit/".$getidrow->id);
		};

		// echo $acctotal;
		// print_r(serialize($arrProducts));

}


function view($orderid){
	$db = \Config\Database::connect();

	$dataOrder = $this->sales->find($orderid);
	$sql = "SELECT * FROM sales WHERE order_id = ?";
	$query = $db->query($sql, [$orderid]);
	$row = $query->getRow();

	$salesArray = unserialize($row->sales);
	$salesArraykeys = array_keys($salesArray);
	// foreach($salesArray as $key => $value) {
	//   echo "Key=" . $key . ", Value=" . $value;
	//   echo "<br>";
	// }

// $query = $this->salesTransaction->where('order_id',$orderid)->findAll()
	$data['transactions'] = $this->salesTransaction->where('order_id',$orderid)->findAll();
	$data['sales'] = $dataOrder;


	// echo $salesArraykeys[0];
		return view('sales_detail', $data);
}

function temp(){

	$temp = new TempModel();
	$id = $this->request->getVar('idx');
	$customer = $this->request->getVar('ordercustomer');
	$date = $this->request->getVar('orderdate');

// get product code clicked from the form modal
	$code = $this->request->getVar('getProductCode');
	$db = \Config\Database::connect();
	$sql = "SELECT * FROM stock WHERE code = ?";
	$query = $db->query($sql, [$code]);
	$row = $query->getRow();

	echo $row->code;
	if($query){
		$temp->insert([
			'order_id' => $id,
			'customer' => $customer,
			'date' => $date,
			'product_code' => $row->code,
			'product_name' => $row->name,
			'price' => $row->price,
		]);
	}
	return redirect()->to("/sales/create/".$id);

	// $db      = \Config\Database::connect();
	// $builder = $db->table('stock');
	// $code = $this->request->getVar('xx');
	// $builder -> where('code',$code);
	// $query = $builder->getRow();
	// if($query){
	// 	echo $query->name;
	//
	// }


}
  function update(){

    $stocks = new StockModel();
    $code = $this->request->getVar('code');
    $name = $this->request->getVar('name');
    $price = $this->request->getVar('price');
    $stock = $this->request->getVar('stock');

    $dataStock = $stocks->where([
      'code' => $code,
    ])->first();
    if($dataStock){
            $this->stocks->update($code, [
              'code' => $this->request->getVar('code'),
              'name' => $this->request->getVar('name'),
              'price' => $this->request->getVar('price'),
              'stock' => $this->request->getVar('stock'),
            ]);
            session()->setFlashdata('message', 'Update Data Success');
            return redirect()->to('/stock/');
     // else{
     //    echo "error";
     //  }
        }

  }

	public function testadd(){
		$this-> temp = new TempModel();

	}

	function delete($id){
		$db = \Config\Database::connect();
		// echo $id;
		// $sales = $this->sales->find($id);
    //     if (empty($sales)) {
    //         throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
    //     }
	$getqty = "SELECT * FROM transaction_sales WHERE order_id = ?";
			$updateone = "SELECT * FROM stock WHERE code = ?";

			$qtyquery = $db->query($getqty,[$id]);

			foreach($qtyquery->getResult() as $x){
					$stockquery = $db->query($updateone,[$x->product_code]);
					$row = $stockquery->getRow();

					$stockupdate = 'UPDATE stock SET stock = ? WHERE code = ?';
					$stockquery = $db->query($stockupdate, [$row->stock+$x->quantity,$x->product_code]);
					// $stock = $row->stock+$x->quantity	;
			};

			$sqll = "DELETE FROM transaction_sales WHERE order_id = ? ";
			$query = $db->query($sqll, [$id]);
				
				$sales = new SalesModel();
			$sql = 'DELETE FROM sales WHERE order_id = ?';
			$query= $db->query($sql,[$id]);

			$sql = 'DELETE FROM transaction_sales WHERE order_id = ?';
			$query= $db->query($sql,[$id]);
        return redirect()->to('/sales');
	}
	//--------------------------------------------------------------------

}
