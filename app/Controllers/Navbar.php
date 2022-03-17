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




class Navbar extends BaseController
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

  public function users()
  {
    $data['user'] = $this->users->findAll();
    return view('people/users/view_users',$data);
  }

	public function stock()
  {
    $data['stock'] = $this->stock->findAll();
    return view('view_barang',$data);
  }

	public function employee()
	{
		$data['employee'] = $this->employee->findAll();
		return view('people/employee/view_employee',$data);
	}

	public function customer()
	{
		$data['customer'] = $this->customer->findAll();
		return view('people/customer/view_customer',$data);
	}


	public function sales()
	{
		$db = \Config\Database::connect();
		$sql = "SELECT *,format(total,0) as total,format(paid,0) as paid,format(unpaid,0) as unpaid FROM sales";
		$query = $db->query($sql);
		$result = $query->getResult();
		
		$data['sales'] = $result;
		return view('transactions/view_sales',$data);
	}

	public function purchase()
	{
		$db = \Config\Database::connect();

		$sql = "SELECT *,format(total,0) as total,format(paid,0) as paid,format(unpaid,0) as unpaid FROM purchase";
		$query = $db->query($sql);
		$result = $query->getResult();
		$data['purchase'] = $result;
		return view('transactions/purchase/view_purchase' ,$data);
	}

	public function supplier()
	{

		$data['supplier'] = $this->supplier->get_uploads();
		return view('master/supplier/view_supplier',$data);
	}

	public function expense()
	{
		$db = \Config\Database::connect();

		$sql = "SELECT *,format(amount,0) as amount FROM expense";
		$query = $db->query($sql);
		$result = $query->getResult();
		$data['expense'] = $result;
		return view('transactions/expense/view_expense',$data);
	}

	public function othersales(){
		$db = \Config\Database::connect();

		$sql = "SELECT *,format(amount,0) as amount FROM othersales";
		$query = $db->query($sql);
		$result = $query->getResult();
		$data['othersales'] = $result;

		return view('transactions/othersales/view_othersales',$data);
	}

	public function salesreport(){
		// echo "yes";
		// $data['othersales'] = $this->othersales->get_uploads();

		return view('report/salesreport/view_salesreport');
	}
	public function purchasereport(){
		// echo "yes";
		// $data['othersales'] = $this->othersales->get_uploads();

		return view('report/purchasereport/view_purchasereport');
	}

	public function purchasereceivables(){
		$db = \Config\Database::connect();
		$sqls = 	"SELECT * FROM purchase WHERE status = ? AND transaction = ?";
		$sql1 = "SELECT * FROM purchase WHERE status = ? AND transaction = ? ORDER BY created_at DESC";
		$sql2 = "SELECT * FROM purchase WHERE status = ? AND transaction <> ?";

		// $query = $db->query($sql,['bon-hutang','Bon-Hutang']);
		// $query1 = $db->query($sql,['bon-hutang','Sebagian-Lunas']);
		$querylunas = $db->query($sqls,['bon-hutang','Lunas']);
		$query3 = $db->query($sql2,['bon-hutang','Lunas']);

		// $data['purchase'] = $query->getResult();
		// $data['some'] = $query1->getResult();
		$data['all'] = $query3->getResult();
		$data['lunas'] = $querylunas->getResult();

		return view('installment/purchasereceivables',$data);
	}

	public function salesreceivables(){
		$db = \Config\Database::connect();
		$sql = 	"SELECT * FROM sales WHERE status = ? AND transaction = ?";

		$sqls = 	"SELECT * FROM sales WHERE status = ? AND transaction = ?";
		$sql1 = "SELECT * FROM sales WHERE status = ? AND transaction = ? ORDER BY created_at DESC";
		$sql2 = "SELECT * FROM sales WHERE status = ? AND transaction <> ?";

		// $query = $db->query($sql,['bon-hutang','Bon-Hutang']);
		// $querysome = $db->query($sqls,['bon-hutang','Sebagian Lunas']);
		$query3 = $db->query($sql2,['bon-hutang','Lunas']);
		$querylunas = $db->query($sqls,['bon-hutang','Lunas']);

		
		// $data['purchase'] = $query->getResult();
		// $data['some'] = $querysome->getResult();
		$data['all'] = $query3->getResult();
		$data['lunas'] = $querylunas->getResult();

		return view('installment/salesreceivables',$data);
	}
	//--------------------------------------------------------------------

}
