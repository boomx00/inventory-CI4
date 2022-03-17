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
use App\Models\PReceivablesModel;
use App\Models\PReceivablesUpload;



class PurchaseReceivables extends BaseController
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
                $this->preceivables = new PReceivablesModel();
                $this->preceivablesupload = new PReceivablesUpload();

    }
    function getdata(){
        $data = $this->request->getVar();  
        $db      = \Config\Database::connect();
        // $path = $_SERVER['DOCUMENT_ROOT'].'/uploadpreceivables/';
        $path = 'http://localhost:8080/uploadpreceivables/';

        $orderid = $data['orderid'];
        $supplier = $data['supplier'];
        $total = 0;
        $totalpaid = 0;
        $totalunpaid = 0;
        $address = "";
        $phone = "";
        $content = "";
        $sql = "SELECT * FROM purchase WHERE status = ?  and supplier = ?";
        $query = $db->query($sql,['bon-hutang',$supplier]);

        $sqlsupplier = "SELECT * FROM supplier WHERE name = ?";
        $querysupplier = $db->query($sqlsupplier,[$supplier]);
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


        $sql1 = "SELECT * FROM purchasereceivables WHERE order_id = ?";
        $querysql1 = $db->query($sql1,[$orderid]);
        $count = 0;
        foreach($querysql1->getResult() as $x){
            $sqlimage = "SELECT * FROM purchasereceivablesuploads WHERE paymentid = ?";
            $imagequery = $db->query($sqlimage,[$x->paymentid]);
            $row = $imagequery->getRow();
            $imagecontent = "No image found";
            if($row){
                $imagecontent = '<img src="'.$path."/".$row->gambar.'" width="200" height="200">';
            }
            $count ++;
            $content.= '<input type="hidden" id="paymentid'.$count.'" name="paymentid" value="'.$x->paymentid.'">
            <input type="hidden" id="orderids'.$count.'" name="orderids" value="'.$x->order_id.'">
            <tr>
                        <td>'.$count.'</td>
                        <td>'.$x->date.'</td>
                        <td>'.$imagecontent.'</td>
                        <td>'.number_format($x->amount).'</td>
                        <td><button type="button" class="btn btn-success" onclick="testfunction('.$count.')">Success</button>

                    </tr>';

        }
        echo json_encode( array( 
                    "address" => $address,
                    "phone" => $phone,
                    "supplier" => $supplier,
                    "total" => $total,
                    "paid" => $totalpaid,
                    "unpaid" => $totalunpaid,
                    "supplier" => $supplier,
                    "table" => $content
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
        $paymentid = $date.$unique;
        $files = $this->request->getFiles();
        $preceivablesupload = new PReceivablesUpload();
        $preceivables = new PReceivablesModel();
        $files = $this->request->getFiles();
        $preceivables ->insert([
            'order_id' => $orderid,
            'amount' => $amount,
            'detail' => $detail,
            'paymentid' => $paymentid
        ]);

        $sqlpurchase = "SELECT * FROM purchase where order_id = ?";
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
              'paymentid' => $paymentid
          ];
      
          $this->preceivablesupload->insert_img($data);
      
            $img->move(ROOTPATH . 'public/uploadpreceivables', $name);
        }
        };
        
        if($queryresult->unpaid-$amount == 0){
            $paid = $queryresult->paid+$amount;
            $unpaid =$queryresult->unpaid-$amount;
            $transaction = "Lunas";
            $this->preceivables->transactiontest($paid,$unpaid,$transaction,$orderid);
        }else{
            $paid = $queryresult->paid+$amount;
            $unpaid =$queryresult->unpaid-$amount;
            $transaction = "Sebagian-Lunas";
            $this->preceivables->transactiontest($paid,$unpaid,$transaction,$orderid);

        }

        return redirect()->to('/purchase-receivables');

    }

    function editpurchasereceivables($id){
        $db      = \Config\Database::connect();
        $sql = 'SELECT * FROM purchasereceivables WHERE paymentid = ?';
        $sqlimage = 'SELECT * FROM purchasereceivablesuploads WHERE paymentid = ?';

        $querysql = $db->query($sql,[$id]);
        $queryimage = $db->query($sqlimage,[$id]);


        $sql1 = 'SELECT * FROM purchasereceivablesuploads WHERE paymentid = ?';
$query1 = $db->query($sql1,[$id]);
$result = $query1->getResult();
        $data['sql']=$querysql->getRow();
        $data['image']=$queryimage;
        $data['result']=$result;


        return view('installment/editpurchasereceivables',$data);

    }

    function editprocess(){
        $datas = $this->request->getVar();  
        $db      = \Config\Database::connect();
        $files = $this->request->getFiles();
        $preceivables = new PReceivablesModel();
        $paid = 0;
        $unpaid = 0;
        $transaction = "";
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploadpreceivables/';
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
     


     

        $sql = "UPDATE purchasereceivables SET date = ?, amount = ?, detail = ? WHERE paymentid = ?";
        $query = $db->query($sql,[$date,$amount,$detail,$paymentid]);
        
        $sqlsales = "SELECT * FROM purchase WHERE order_id = ?";
        $querysales = $db->query($sqlsales,[$modalorderids]);
        $row = $querysales->getRow();

        
        $sqlsalesrec = "SELECT * FROM purchasereceivables WHERE order_id = ?";
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
        $this->preceivables->transactiontest($paid,$unpaid,$transaction,$modalorderids);

        $old = $this->request->getVar('old');
        $original = $this->request->getVar('original');
        if($original == ""){
            $filess = $this->request->getFiles();
          
          foreach($filess['photoz'] as $img){
              $name = $img->getName();
              if($name == ""){
                
              }else{
                $name = $img->getRandomName();

              $data = [
                'order_id' => $orderid,
                'gambar' => $name,
                'paymentid' => $paymentid
            ];
        
            $this->preceivablesupload->insert_img($data);
        
              $img->move(ROOTPATH . 'public/uploadpreceivables', $name);
          }
          }
          session()->setFlashdata('message', 'Update Data Success');
          return redirect()->to('/purchase-receivables/');
      
          }else{

            if($old == "" and $original != ""){
                $sqlsearch = "SELECT * FROM purchasereceivablesuploads WHERE paymentid = ?";
                $querysearch = $db->query($sqlsearch,[$paymentid]);
        
                foreach($querysearch->getResult() as $x){
                  unlink($path."/".$x->gambar);
        
                }
                $sqldelete = "DELETE FROM purchasereceivablesuploads WHERE paymentid = ? ";
                $querydelete = $db->query($sqldelete,[$paymentid]);
        
                session()->setFlashdata('message', 'Update Data Success');
                return redirect()->to('/purchase-receivables/');
              }
              else{
      //stock initially has pictures, check if any changes have been made
      $files = $this->request->getFiles();

      // print_r($files);
      // print_r(count($files));
      foreach($filess['photoz'] as $img){
        $name = $img->getName();
        if($name == ""){
          
        }else{
            $name = $img->getRandomName();
        $data = [
            'order_id' => $orderid,
            'gambar' => $name,
            'paymentid' => $paymentid
      ];
  
      $this->preceivablesupload->insert_img($data);
  
        $img->move(ROOTPATH . 'public/uploadpreceivables', $name);
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
                $sqldelete = "DELETE FROM purchasereceivablesuploads WHERE paymentid = ? AND gambar = ?";
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
        $sql = 'SELECT * FROM purchase WHERE status = ? AND transaction = ? ';
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
            <td id="supplier'.$countt.'">'. $x->supplier .'</td>
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

    function getdataiframe(){
        $data = $this->request->getVar();  
        $db      = \Config\Database::connect();
        // $path = $_SERVER['DOCUMENT_ROOT'].'/uploadpreceivables/';
        $path = 'http://localhost:8080/uploadpreceivables/';

        $orderid = $data['orderid'];
        $paymentid = $data['paymentid'];
        $total = 0;
        $totalpaid = 0;
        $totalunpaid = 0;
        $address = "";
        $phone = "";
        $content = "";
        $maintable="";
        $sql = "SELECT * FROM purchasereceivables WHERE order_id = ?";
        $sqlsales = "SELECT * FROM purchase WHERE status = ? AND transaction <> ?";
        $sqlgetsales = "SELECT * FROM purchase WHERE order_id = ?";

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
            $sqlimage = "SELECT * FROM purchasereceivablesuploads WHERE paymentid = ?";
            $imagequery = $db->query($sqlimage,[$x->paymentid]);
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
            $content.= '<input type="hidden" id="paymentid'.$count.'" name="paymentid" value="'.$x->paymentid.'">
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
            <td id="supplier'.$countt.'">'. $x->supplier .'</td>
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
}
