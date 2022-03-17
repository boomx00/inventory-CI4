<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\EmployeeModel;
use App\Models\CustomerModel;
use App\Models\StockModel;
use App\Models\SalesModel;
use App\Models\PurchaseModel;
use App\Models\SupplierModel;
use App\Models\ExpenseModel;
use App\Models\OthersalesModel;




class PurchaseReport extends BaseController
{
	public function index()
	{
		return view('view_home');
	}

  function __construct()
    {
        $this->users = new UsersModel();
				$this->employee = new EmployeeModel();
				$this->customer = new CustomerModel();
				$this->stock = new StockModel();
				$this->sales = new SalesModel();
				$this->purchase= new PurchaseModel();
				$this->supplier= new SupplierModel();
				$this->expense= new ExpenseModel();
				$this->othersales= new OthersalesModel();

    }

  function getpurchase(){
    $from = $_GET['from'];
    $to = $_GET['to'];
    $db = \Config\Database::connect();
    $table = "";
    $total = 0;
    $counter = 0;
    $sql = "SELECT *,format(total,0) as totals,format(paid,0) as paid,format(unpaid,0) as unpaid FROM purchase WHERE date = ? ";
    $transaction = "SELECT *,format(price,0) as price,format(total,0) as total FROM transaction_purchase WHERE order_id = ?";
    $query = $db->query($sql,[$from]);
    $array = "";
    $color = "";
    if($to == "" and $from !=""){
    
    foreach($query->getResult() as $x){
        $arraytable = "";

    $transactionquery = $db->query($transaction,[$x->order_id]);
    $row = $transactionquery->getResult();

    if($x->status == 'lunas-cash'){
        $color = "green";
    }else{
        $color = "red";
    }
    foreach($row as $y){
        $arraytable .= "<tr>
                    <td style='width:5%'>".$y->product_name."</td>
                    <td style='width:1%'>".$y->quantity."x".$y->price."</td>
                    <td style='width:1%'>".$y->total."</td>
                    </tr>";
        // $array .= "products are " .$y->product_code ."\r\n";
    }
        // $array = unserialize($x->sales);
        $counter++;
        $table .= "<tr><td>".$counter."</td>
                   <td>".$x->date."</td>
                   <td>".$x->order_id."</td>
                   <td style='background-color:".$color."'>".$x->status."</td>
                   <td><table class='table table-borderless'>".$arraytable."</table></td>
                   <td>".$x->paid."</td>
                   <td>".$x->unpaid."</td>
                   <td>".$x->totals."</td></tr>";

        $total = $total + $x->total;

    }
}else{
    $sql = "SELECT *,format(total,0) as totals,format(paid,0) as paid,format(unpaid,0) as unpaid FROM purchase WHERE date BETWEEN ? and ? ";
    $query = $db->query($sql,[$from,$to]);
    foreach($query->getResult() as $x){
        $arraytable = "";

    $transactionquery = $db->query($transaction,[$x->order_id]);
    $row = $transactionquery->getResult();
    foreach($row as $y){
        $arraytable .= "<tr>
                    <td style='width:5%'>".$y->product_name."</td>
                    <td style='width:1%'>".$y->quantity."x".$y->price."</td>
                    <td style='width:1%'>".$y->total."</td>
                    </tr>";
        // $array .= "products are " .$y->product_code ."\r\n";
    }
        // $array = unserialize($x->sales);
        $counter++;
        $table .= "<tr><td>".$counter."</td>
                   <td>".$x->date."</td>
                   <td>".$x->order_id."</td>
                   <td style='background-color:".$color."'>".$x->status."</td>
                   <td><table class='table table-borderless'>".$arraytable."</table></td>
                   <td>".$x->paid."</td>
                   <td>".$x->unpaid."</td>
                   <td>".$x->totals."</td></tr>";

                   $total = $total + $x->total;


    }

}

    $result = $table . "!".$total  ;
    echo($result);

}
	//--------------------------------------------------------------------

}
