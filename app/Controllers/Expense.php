<?php namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\SupplierModel;
use App\Models\ExpenseModel;
use App\Models\UploadExpense;

class Expense extends BaseController
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
        $this->expense = new ExpenseModel();
        $this->upload_expense = new UploadExpense();

    }

   function new(){
    return view('/transactions/expense/expense_create.php');

   }

    function create(){
        // echo "yes";
        $db = \Config\Database::connect();
        $date = $this->request->getVar('date');
        $category = $this->request->getVar('category');
        $amount = $this->request->getVar('amount');
        $detail = $this->request->getVar('comment');
        $id = $date.rand(0,100);
        $builder = $db->table('expense');
        $builder -> where('id',$id);
        $result = $builder -> countAllResults();

        while($result == 1){
            $id = $date.rand(0,100);
        $builder = $db->table('expense');
        $builder -> where('id',$id);
        $result = $builder -> countAllResults();
        }
        $data = [
            'id' => $id,
            'date' => $date,
            'category' => $category,
            'amount' => $amount,
            'detail' => $detail,
        ];

        $this->expense->insert_data($data);

        
        $files = $this->request->getFiles();
        foreach($files['images'] as $img){
          $name = $img->getName();

            if($name == ""){
                        
            }else{
              $name = $img->getRandomName();

            $data = [
              'id' => $id,
              'gambar' => $name
          ];
      
          $this->upload_expense->insert_gambar($data);
      
            $img->move(ROOTPATH . 'public/uploadexpense', $name);
        }
        }
        return redirect()->to('/expense');

    }


    

    function edit($id){
        $db = \Config\Database::connect();
        
        
        $sql = "SELECT * FROM expense WHERE id= ? ";
        $query = $db->query($sql,[$id]);
        $results = $query->getRow();
        $sql = 'SELECT * FROM uploadsexpense WHERE expense_id = ?';
  $query = $db->query($sql,[$id]);
  $result = $query->getResult();
  $data['image'] = $result;

        $data['expense'] = $results;
        $data['id'] = $id;
        return view('/transactions/expense/expense_edit.php',$data);
    }

    function editprocess($id){
        $db = \Config\Database::connect();

        $date = $this->request->getVar('date');
        $category = $this->request->getVar('category');
        $path = $_SERVER['DOCUMENT_ROOT'].'/uploadexpense/';
        $arrays = array();
        $arrayo = array();
        $amount = $this->request->getVar('amount');
        $detail = $this->request->getVar('comment');
        $old = $this->request->getVar('old');
        $original = $this->request->getVar('original');
        $sql = "UPDATE expense SET date = ?,  category = ?, amount = ?, detail = ?  WHERE id = ? ";
        $query = $db->query($sql,[$date,$category,$amount,$detail,$id]);

// stock has no picture initially
if($original == ""){
    $files = $this->request->getFiles();
  
    // print_r($files);
    // print_r(count($files));
    foreach($files['photos'] as $img){
      $name = $img->getRandomName();
      if($name == ""){
        
      }else{
      $data = [
        'expense_id' => $id,
        'gambar' => $name
    ];

    $this->upload_expense->insert_gambar($data);

      $img->move(ROOTPATH . 'public/uploadexpense', $name);
  }
  }
  session()->setFlashdata('message', 'Update Data Success');
  return redirect()->to('/expense/');

  }


  else{
    //when remove all pics
    if($old == "" and $original != ""){
      $sqlsearch = "SELECT * FROM uploadsexpense WHERE expense_id = ?";
      $querysearch = $db->query($sqlsearch,[$id]);

      foreach($querysearch->getResult() as $x){
        unlink($path."/".$x->gambar);

      }
      $sqldelete = "DELETE FROM uploadsexpense WHERE expense_id = ? ";
      $querydelete = $db->query($sqldelete,[$id]);

      echo "yes";
    }
    
    else{
      $files = $this->request->getFiles();
      foreach($files['photos'] as $img){
            $name = $img->getName();
            if($name == ""){
              
            }else{
              $name = $img->getRandomName();

            $data = [
              'expense_id' => $id,
              'gambar' => $name
          ];
      
          $this->upload_expense->insert_gambar($data);
      
            $img->move(ROOTPATH . 'public/uploadexpense', $name);
        }
        }
//stock initially has pictures, check if any changes have been made
foreach($old as $x){
if(strpos($x, 'blob') !== false){
 
  // print_r($files);


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


    
      
      $result=array_diff($arrayo,$arrays);

      // print_r($result);

      foreach($result as $tobedeleted){
        $sqldelete = "DELETE FROM uploadsexpense WHERE expense_id = ? AND gambar = ?";
    $querydelete = $db->query($sqldelete,[$id,$tobedeleted]);
    unlink($path."/".$tobedeleted);
      }

      session()->setFlashdata('message', 'Update Data Success');
      return redirect()->to('/expense/');
    
 

    }
  
            session()->setFlashdata('message', 'Update Data Success');
            return redirect()->to('/expense/');
   
  }


}


    return redirect()->to('/supplier');

    }

    

    function delete($id){
        $db = \Config\Database::connect();
        $sql = "DELETE FROM expense WHERE id = ?";
        $query = $db->query($sql,[$id]);
        return redirect()->to('/expense');
    }
}
