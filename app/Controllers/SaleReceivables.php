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
use App\Models\SReceivablesModel;
use App\Models\SReceivablesUpload;



class SaleReceivables extends BaseController
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
                $this->sreceivables = new SReceivablesModel();
                $this->sreceivablesupload = new SReceivablesUpload();


    }
    function getdata(){
        $data = $this->request->getVar();  
        $db      = \Config\Database::connect();
        // $path = $_SERVER['DOCUMENT_ROOT'].'/uploadpreceivables/';
        $path = 'https://inventorytester.000webhostapp.com/uploadsreceivables/';

        $orderid = $data['orderid'];
        $customer = $data['customer'];
        $total = 0;
        $totalpaid = 0;
        $totalunpaid = 0;
        $address = "";
        $phone = "";
        $content = "";
        $sql = "SELECT * FROM sales WHERE status = ?  and customer = ?";
        $query = $db->query($sql,['bon-hutang',$customer]);

        $sqlsupplier = "SELECT * FROM customer WHERE name = ?";
        $querysupplier = $db->query($sqlsupplier,[$customer]);
        $supplierrow = $querysupplier->getRow();
        if($supplierrow){
        $address = $supplierrow->address;
        $phone = $supplierrow->phone;
        }
        $row = $query->getResult();
        foreach($row as $x){
            $total = $total + $x->total ;
            $totalpaid = $totalpaid + $x->paid;
            $totalunpaid = $totalunpaid + $x->unpaid;
        }


        $sql1 = "SELECT * FROM salesreceivables WHERE order_id = ?";
        $querysql1 = $db->query($sql1,[$orderid]);
        $count = 0;
        foreach($querysql1->getResult() as $x){
            $sqlimage = "SELECT * FROM salesreceivablesuploads WHERE payment_id = ?";
            $imagequery = $db->query($sqlimage,[$x->payment_id]);
            $row = $imagequery->getResult();
            $imagecontent = "";
            if($row){
                foreach($row as $xx){

                    $imagecontent .= '<img style="margin:1%" src="'.$path."/".$xx->gambar.'" width="150" height="150">  <input type="hidden" id="imagehidden'.$count.'" name="custId" value="'.$xx->gambar.'">
                    ';
                }

            }else{
                $imagecontent = "No image found";
           
        }
            $count ++;
            $content.= '<input type="hidden" id="orderids'.$count.'" name="orderids" value="'.$x->order_id.'">
            <input type="hidden" id="paymentid'.$count.'" name="paymentid" value="'.$x->payment_id.'">

                        <tr>
                        <td>'.$count.'</td>
                        <td id="datetable'.$count.'" >'.$x->date.'</td>
                        <td id="imagetable'.$count.'">'.$imagecontent.'</td>
                        <td id="amounttable'.$count.'">'.number_format($x->amount).'</td>
                        <td><button type="button" class="btn btn-success" onclick="testfunction('.$count.')">Success</button>
                        </td>
                    </tr>';

        }
        echo json_encode( array( 
                    "address" => $address,
                    "phone" => $phone,
                    "customer" => $customer,
                    "total" => $total,
                    "paid" => $totalpaid,
                    "unpaid" => $totalunpaid,
                    // "supplier" => $supplier,
                    "table" => $content
                )
                );
    }

    function getdataiframe(){
        $data = $this->request->getVar();  
        $db      = \Config\Database::connect();
        // $path = $_SERVER['DOCUMENT_ROOT'].'/uploadpreceivables/';
        $path = 'https://inventorytester.000webhostapp.com/uploadsreceivables/';

        $orderid = $data['orderid'];
        $paymentid = $data['paymentid'];
        $total = 0;
        $totalpaid = 0;
        $totalunpaid = 0;
        $address = "";
        $phone = "";
        $content = "";
        $maintable="";
        $sql = "SELECT * FROM salesreceivables WHERE order_id = ?";
        $sqlsales = "SELECT * FROM sales WHERE status = ? AND transaction <> ?";
        $sqlgetsales = "SELECT * FROM sales WHERE order_id = ?";

        $query = $db->query($sql,[$orderid]);
        $querysales = $db->query($sqlsales,['bon-hutang','Lunas']);
        $querygetsales = $db->query($sqlgetsales,[$orderid]);

        $result = $query->getRow();
        // $row = $query->getResult();
        // foreach($row as $x){
        //     $total = $total + $x->total ;
        //     $totalpaid = $totalpaid + $x->paid;
        //     $totalunpaid = $totalunpaid + $x->unpaid;
        // }

       
        $rowgetsales = $querygetsales->getRow();
        


        
        $count = 0;
        foreach($query->getResult() as $x){

            $totalpaid = $x->amount + $totalpaid;
            $sqlimage = "SELECT * FROM salesreceivablesuploads WHERE payment_id = ?";
            $imagequery = $db->query($sqlimage,[$x->payment_id]);
            $row = $imagequery->getResult();
            $imagecontent = "";
            if($row){
                foreach($row as $xx){

                    $imagecontent .= '<img style="margin:1%" src="'.$path."/".$xx->gambar.'" width="150" height="150">  <input type="hidden" id="imagehidden'.$count.'" name="custId" value="'.$xx->gambar.'">
                    ';
                }

            }else{
                $imagecontent = "No image found";
           
        }
            $count ++;
            $content.= '<input type="hidden" id="paymentid'.$count.'" name="paymentid" value="'.$x->payment_id.'">
            <input type="hidden" id="orderids'.$count.'" name="orderids" value="'.$x->order_id.'">
                        <tr>
                        <td>'.$count.'</td>
                        <td id="datetable'.$count.'" >'.$x->date.'</td>
                        <td id="imagetable'.$count.'">'.$imagecontent.'</td>
                        <td id="amounttable'.$count.'">'.number_format($x->amount).'</td>
                        <td><button type="button" class="btn btn-success" onclick="testfunction('.$count.')">Success</button>
                        </td>
                    </tr>';

        }

        $countt = 0;
        $counter= 0;
        foreach($querysales->getResult() as $x){
            $countt ++;
            $counter ++;

            $maintable .= '
            <tr onclick="button(0);anotherfunc('.$countt.');test('.$countt.')" value="0" id="tr'.$countt.'">    
            <td>'.$counter.'</td>
            <td id="orderid'.$countt.'">'. $x->order_id .'</td>
            <td>'.$x->date .'</td>
            <td id="supplier'.$countt.'">'. $x->customer .'</td>
            <td id="status'.$countt.'">'. $x->status .'</td>
            <td id="transaction'.$countt.'">'. $x->transaction .'</td>

            <td id="total'.$countt.'">'. $x->total.'</td>
            <td id="paid'.$countt.'">'. $x->paid .'</td>
            <td id="unpaid'.$countt.'">'. $x->unpaid .'</td>
            </tr>
            ';

        }

        // $sqlgetamount = "SELECT * FROM sales WHERE order_id = ?";
        // $queryamount = $db->query($sqlgetamount,[$orderid]);
        // $amountrow = $queryamount->getRow();
        // $amount = $amountrow->total;

        // $sql1 = "SELECT * FROM salesreceivables WHERE order_id = ? and payment_id = ?";
        // $querysql1 = $db->query($sql1,[$orderid,$paymentid]);
        // $rowsql1 = $querysql1->getRow();
        // $paid = $rowsql1->amount;

        echo json_encode( array( 
                    "total" => $rowgetsales->total, //total amount for that sales
                    "paid" => $rowgetsales->paid,
                    "unpaid" => $rowgetsales->unpaid,
                    // "supplier" => $supplier,
                    "table" => $content,
                    "maintable" => $maintable
                )
                );
    }

    function addtemp(){
        $db      = \Config\Database::connect();
        $unique = uniqid();
        $date = $this->request->getVar('modaldate');
        $ex = $this->request->getVar('amount');
        $amount = str_replace(',','',$ex);
        $detail = $this->request->getVar('comment');
        $orderid = $this->request->getVar('modalorderid');
        $paymentid = 'S'.$date.$unique;
        $files = $this->request->getFiles();
        $sreceivablesupload = new SReceivablesUpload();
        $sreceivables = new SReceivablesModel();
        $files = $this->request->getFiles();
        print_r($files);
        $sreceivables ->insert([
            'order_id' => $orderid,
            'amount' => $amount,
            'detail' => $detail,
            'payment_id' => $paymentid,
            'date' => $date
        ]);

        $sqlpurchase = "SELECT * FROM sales where order_id = ?";
        $querypurchase = $db->query($sqlpurchase,[$orderid]);
        $queryresult = $querypurchase->getRow();

        foreach($files['images'] as $img){
            $name = $img->getName();
            if($name == ""){
                        
            }else{
                $name = $img->getRandomName();

            $data = [
              'order_id' => $orderid,
              'gambar' => $name,
              'payment_id' => $paymentid
          ];
      
          $this->sreceivablesupload->insert_img($data);
      
            $img->move(ROOTPATH . 'public/uploadsreceivables', $name);
        }
        };
        
        if($queryresult->unpaid-$amount == 0){
            $paid = $queryresult->paid+$amount;
            $unpaid =$queryresult->unpaid-$amount;
            $transaction = "Lunas";
            $this->sreceivables->transactiontest($paid,$unpaid,$transaction,$orderid);
        }else{
            $paid = $queryresult->paid+$amount;
            $unpaid =$queryresult->unpaid-$amount;
            $transaction = "Sebagian-Lunas";
            $this->sreceivables->transactiontest($paid,$unpaid,$transaction,$orderid);

        }

        return redirect()->to('/sales-receivables');

    }

    function getimg(){
        $db      = \Config\Database::connect();
        $content = "";
        $count = 0;
        $data = $this->request->getVar();  
        $paymentid = $data['paymentid'];
        $link =  base_url('/uploadsreceivables/');
        $sql = 'SELECT * FROM salesreceivablesuploads WHERE payment_id = ?';
        $query = $db->query($sql,[$paymentid]);

        foreach($query->getResult() as $x){
            $content.='{id:'.$count.', src:"'.$link."/".$x->gambar.'"},';
        }
        echo json_encode( array( 
            "content"=>$content
        )
        );
    }

    function editsalesreceivables($id){
        $db      = \Config\Database::connect();
        $sql = 'SELECT * FROM salesreceivables WHERE payment_id = ?';
        $sqlimage = 'SELECT * FROM salesreceivablesuploads WHERE payment_id = ?';

        $querysql = $db->query($sql,[$id]);
        $queryimage = $db->query($sqlimage,[$id]);


        $sql1 = 'SELECT * FROM salesreceivablesuploads WHERE payment_id = ?';
$query1 = $db->query($sql1,[$id]);
$result = $query1->getResult();
        $data['sql']=$querysql->getRow();
        $data['image']=$queryimage;
        $data['result']=$result;


        return view('installment/editsalesreceivables',$data);

    }

    function editprocess(){
        $datas = $this->request->getVar();  
        $db      = \Config\Database::connect();
        $files = $this->request->getFiles();
        $sreceivables = new SReceivablesModel();
        $paid = 0;
        $unpaid = 0;
        $transaction = "";
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploadsreceivables/';
// print_r($data);
        // $date = $datas['dates'];
        // $amount = $datas['amount'];
        // $detail = $datas['detail'];
        // $paymentid = $datas['paymentid'];

        $date = $this->request->getVar('modaldate');
        $amount = $this->request->getVar('amount');
        $orderid = $this->request->getVar('modalorderid');
        $detail = $this->request->getVar('comment');
        $paymentid = $this->request->getVar('paymentid');
        $modalorderids = $this->request->getVar('modalorderids');
        $arrays = array();
        $arrayo = array();

        // echo $modalorderids;
     


     

        $sql = "UPDATE salesreceivables SET date = ?, amount = ?, detail = ? WHERE payment_id = ?";
        $query = $db->query($sql,[$date,$amount,$detail,$paymentid]);
        
        $sqlsales = "SELECT * FROM sales WHERE order_id = ?";
        $querysales = $db->query($sqlsales,[$modalorderids]);
        $row = $querysales->getRow();

        
        $sqlsalesrec = "SELECT * FROM salesreceivables WHERE order_id = ?";
        $querysalesrec = $db->query($sqlsalesrec,[$modalorderids]);
        foreach($querysalesrec->getResult() as $x){
            $paid = $paid + $x->amount;
            $unpaid = $row->total - $paid;
        }
        if($unpaid > 0 ){
            $transaction = "Sebagian-Lunas";
        } else if($unpaid == 0){
            $transaction = "Lunas";
        }else{
            $transaction = "Bon-Hutang";
        }
        $this->sreceivables->transactiontest($paid,$unpaid,$transaction,$modalorderids);

        $old = $this->request->getVar('old');
        $original = $this->request->getVar('original');
        if($original == ""){
            $filess = $this->request->getFiles();
          
          foreach($files['photos'] as $img){
              $name = $img->getName();
              if($name == ""){
                
              }else{
                $name = $img->getRandomName();

              $data = [
                'order_id' => $orderid,
                'gambar' => $name,
                'payment_id' => $paymentid
            ];
        
            $this->sreceivablesupload->insert_img($data);
        
              $img->move(ROOTPATH . 'public/uploadsreceivables', $name);
          }
          }
          session()->setFlashdata('message', 'Update Data Success');
          return redirect()->to('/sales-receivables/');
      
          }else{

            if($old == "" and $original != ""){
                $sqlsearch = "SELECT * FROM salesreceivablesuploads WHERE payment_id = ?";
                $querysearch = $db->query($sqlsearch,[$paymentid]);
        
                foreach($querysearch->getResult() as $x){
                  unlink($path."/".$x->gambar);
        
                }
                $sqldelete = "DELETE FROM salesreceivablesuploads WHERE payment_id = ? ";
                $querydelete = $db->query($sqldelete,[$paymentid]);
        
                session()->setFlashdata('message', 'Update Data Success');
                return redirect()->to('/sales-receivables/');
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
            'gambar' => $name,
            'payment_id' => $paymentid
      ];
  
      $this->sreceivablesupload->insert_img($data);
  
        $img->move(ROOTPATH . 'public/uploadsreceivables', $name);
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
                $sqldelete = "DELETE FROM salesreceivablesuploads WHERE payment_id = ? AND gambar = ?";
            $querydelete = $db->query($sqldelete,[$paymentid,$tobedeleted]);
            unlink($path."/".$tobedeleted);
              }
              session()->setFlashdata('message', 'Update Data Success');
              return redirect()->to('/sales-receivables/');
      
            
         
      
            }
           
          session()->setFlashdata('message', 'Update Data Success');
          return redirect()->to('/sales-receivables/');
        }
          }

    }


    function gettable(){
        $data = $this->request->getVar();  
        $db      = \Config\Database::connect();
        $transaction = $data['transaction'];
        $countt = $data['counter'];
        $table = "";
        $sql = 'SELECT * FROM sales WHERE status = ? AND transaction = ? ';
        $query = $db->query($sql,['bon-hutang',$transaction]);

        $counter= 0;
        foreach($query->getResult() as $x){
            $counter ++;
            $countt ++;

            $table .= '
            <tr onclick="button(0);anotherfunc('.$countt.');test('.$countt.')" value="0" id="tr'.$countt.'">    
            <td>'.$counter.'</td>
            <td id="orderid'.$countt.'">'. $x->order_id .'</td>
            <td>'.$x->date .'</td>
            <td id="supplier'.$countt.'">'. $x->customer .'</td>
            <td id="status'.$countt.'">'. $x->status .'</td>
            <td id="transaction'.$countt.'">'. $x->transaction .'</td>

            <td id="total'.$countt.'">'. $x->total.'</td>
            <td id="paid'.$countt.'">'. $x->paid .'</td>
            <td id="unpaid'.$countt.'">'. $x->unpaid .'</td>
            </tr>
            ';

        }
        echo json_encode( array( 
            
            "table" => $table
        ));
    }

}
