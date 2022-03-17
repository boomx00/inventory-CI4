<?php namespace App\Controllers;

use App\Models\StockModel;
use App\Models\SalesModel;
use App\Models\TempModel;
use App\Models\TransactionSalesModel;
use App\src\Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\src\Mike42\Escpos\Printer;

class Test extends BaseController
{

	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        $this->stocks= new StockModel();
				$this->sales= new SalesModel();
				$this->temp= new TempModel();
				$this->salesTransaction = new TransactionSalesModel();
    }

	function test(){
		$db = \Config\Database::connect();
		$sql = "SELECT * FROM transaction_sales WHERE order_id = ?";
		$query = $db->query($sql,'SM20210304.22');
		$result = $query->getResult();

		foreach($result as $x){
			echo $x->product_code;
		}
	    $connector = new WindowsPrintConnector("XP-80C2");
$date = "2-05-2021";
$cashier = "Teng";
$customer = "cash";
$id = "2021031105";

    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("TB SUBUR MAKMUR \n");
	$printer -> text("Jl Mt Haryono No 59, Telpon: (024) 3511888, WA: 0813881888 \n");
	$printer -> feed(1);
	$printer -> text("--------------------------");
	$printer -> feed(1);
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("Date:" . $date ."\n");
	$printer -> text("Salesman:" . $cashier ."\n");
	$printer -> text("Customer:" . $customer ."\n");
	$printer -> text("Order ID:" . $id ."\n");
	$printer -> text("___________________________");
	$printer -> feed(1);
	$printer -> setJustification(Printer::JUSTIFY_CENTER);

	$printer -> text("Item Name                   Amount         Total");
	$printer -> text("________________________________________________");
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	foreach($result as $x){
		$line = sprintf('%-26.26s %-10.10s %10.10s',$x->product_code." ".$x->product_name, $x->quantity."x".$x->price, $x->price * $x->quantity);
		$printer->text($line);
		$printer->text("\n"); 

	}
 



	$printer -> feed(1);


    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
	return redirect()->to('/sales');

	}

    function process($id){
			$i = 1;
			$j = 1;
			$db = \Config\Database::connect();
			$stock = new StockModel();
      $sales = new SalesModel();
			$temp = new TempModel();
			$salesTransaction = new TransactionSalesModel();
      $orderid = $this->request->getVar('orderid');
      $orderDate = $this->request->getVar('date');
      $orderCustomer = $this->request->getVar('customer');
			if($orderid != $id){
				$this->temp->update($id, [
					'order_id' => $orderid,

				]);

			}


			$accTotal = $this->request->getVar('accTotal');
			$arrProducts = array();
			$searchTemp = $this->temp->where('order_id',$orderid)->findAll();

			if($searchTemp){
					foreach($searchTemp as $val){
						$arrProducts[$val->product_code] = $this->request->getVar('quantity'.$i);
						$i ++;
					}
			}

			$serialized = serialize($arrProducts);

			foreach($arrProducts as $prodcode => $amount) {
				// echo $this->request->getVar('type'.$j);
				$sql = 'SELECT name,price,stock FROM stock WHERE code = ?';
					$query = $db->query($sql, [$prodcode]);
					$row   = $query->getRow();
					$reducedStock = $row->stock - $amount;

			$salesTransaction ->insert([
				'order_id' => $this->request->getVar('orderid'),
				'product_code' => $prodcode,
				'product_name' => $row->name,
				'quantity' => $amount,
				'price' => $row->price,
				'total' => $amount * $row->price,
				'type' => $this->request->getVar('type'.$j),
			]);




			// 	$this->stocks->update($prodcode,[
			// 		'stock' => $reducedStock,
			// 	]);
			$j ++;
	};

	$sqlfilter = 'SELECT product_code, quantity, type FROM transaction_sales WHERE `type` = ?';
	$sqlfilterQuery = $db->query($sqlfilter,['Stock']);

	foreach ($sqlfilterQuery->getResult() as $key) {
		$sqlReduce = 'SELECT name,price,stock FROM stock WHERE code = ?';
			$query = $db->query($sql, [$key->product_code]);
			$row   = $query->getRow();
			$reducedStock = $row->stock - $key->quantity;
				$this->stocks->update($key->product_code,[
					'stock' => $reducedStock,
				]);
	};
			$unserialized = unserialize($serialized);
			print_r($unserialized);
      $sales->insert([
        'order_id' => $this->request->getVar('orderid'),
        'customer' => $this->request->getVar('customer'),
				'sales' => $serialized,
        'date' => $this->request->getVar('date'),
        'total' => $this->request->getVar('accTotal'),
      ]);

			$this->temp->delete($this->request->getVar('orderid'));

			echo $this->request->getVar('type2');
      	session()->setFlashdata('message', 'Insert Data Success');
      return redirect()->to('/stock/');
    }




		public function deleterow($id,$row){
			$db = \Config\Database::connect();
			$sql = "DELETE FROM temptable WHERE order_id = ? AND product_code = ?";
			$query = $db->query($sql, [$id,$row]);
			return redirect()->back()->withInput();
			// echo "success";
		}

    public function create($id){
			if($id == "new"){
				$db = \Config\Database::connect();

				$thequery = $db->query("SELECT * FROM stock");

				$data = array('order_id' => "",'customer' => "", 'date' => "");
				$data['products'] = $thequery;
				$data['query'] = $this->temp->where('order_id',$id)->findAll();

				echo "new";
	      return view('transactions/sales_create',$data);
			}else{


				$datatemp = $this->temp->find($id);
				$db = \Config\Database::connect();
				$sql = "SELECT * FROM temptable WHERE order_id = ?";
				$query = $db->query($sql, [$id]);
				$row = $query->getRow();
				$datta = array('order_id' => $row->order_id,'customer' => $row->customer, 'date' => $row->date);
				$thequery = $db->query("SELECT * FROM stock WHERE NOT EXISTS (SELECT * FROM temptable WHERE stock.code = temptable.product_code)");
// 				foreach ($thequery->getResult() as $row)
// {
//     echo $row->name;
//
// }


				$datta['products'] = $thequery;
				$datta['query'] = $this->temp->where('order_id',$id)->findAll();
				return view('transactions/sales_create',$datta);
			}
			//
			// $dataStock = $this->temp->find($id);
			// $datta['order'] = $dataStock;
			// $data['products'] = $this->stocks->findAll();
      // return view('transactions/sales_create',$data);
    }
		//
		// public function createx($id){
		// 	$dataStock = $this->temp->find($id);
		// 	$datta['products'] = $this->stocks->findAll();
		// 	$datta['order'] = $dataStock;
		// 	return view('transactions/sales_test',$datta);
		// }


function edit($id){
  $dataStock = $this->stocks->find($id);
  $data['item'] = $dataStock;
  return view('stock_edit',$data);
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

	function delete($id){
		$stock = $this->stocks->find($id);
        if (empty($stock)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }
        $this->stocks->delete($id);
        session()->setFlashdata('message', 'Delete Users Success');
        return redirect()->to('/stock');
	}
	//--------------------------------------------------------------------

}
