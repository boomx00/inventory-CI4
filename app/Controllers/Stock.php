<?php namespace App\Controllers;

use App\Models\StockModel;
use App\Models\UploadModel;

class Stock extends BaseController
{
	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        helper('form');
        $this->stocks= new StockModel();
        $this->model_upload = new UploadModel();

    }

    function process(){
      $stocks = new StockModel();
      $upload = new UploadModel();
      $code = $this->request->getVar('code');
      $name = $this->request->getVar('name');
      $price = $this->request->getVar('price');
      $stock = $this->request->getVar('stock');
      $name = "";
      $stocks->insert([
        'code' => $this->request->getVar('code'),
        'name' => $this->request->getVar('name'),
        'price' => $this->request->getVar('price'),
        'stock' => $this->request->getVar('stock'),
      ]);
      $files = $this->request->getFiles();
      foreach($files['images'] as $img){
        $name = $img->getName();
        $data = [
          'code' => $code,
          'gambar' => $name
      ];
      $this->model_upload->insert_gambar($data);

        $img->move(ROOTPATH . 'public_html/uploads', $name);

    }

      
     
      session()->setFlashdata('message', 'Insert Data Success');
      return redirect()->to('/stock/');
    }
    function create(){
      return view('stock_create');
    }

function edit($id){
  $db = \Config\Database::connect();

  $dataStock = $this->stocks->find($id);
  $sql = 'SELECT * FROM uploads WHERE code = ?';
  $query = $db->query($sql,[$id]);
  $result = $query->getResult();


  // $dataImage = $this->model_upload->find($id);
  $data['item'] = $dataStock;
  $data['image'] = $result;
  return view('stock_edit',$data);
}


  function update(){
    $db = \Config\Database::connect();
    $path = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
    $stocks = new StockModel();
    $code = $this->request->getVar('code');
    $name = $this->request->getVar('name');
    $price = $this->request->getVar('price');
    $stock = $this->request->getVar('stock');
    $upload = new UploadModel();
    $arrays = array();
    $arrayo = array();
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
    
    // $sqlsearch = "SELECT * FROM uploads WHERE code = ?";
    // $querysearch = $db->query($sqlsearch,[$code]);

    // foreach($querysearch->getResult() as $x){
    //   unlink($path."/".$x->gambar);
    // };

    // $sqldelete = "DELETE FROM uploads WHERE code = ?";
    // $querydelete = $db->query($sqldelete,[$code]);
    $old = $this->request->getVar('old');
    $original = $this->request->getVar('original');

   



//stock has no picture initially
    if($original == ""){
      $files = $this->request->getFiles();
    
      // print_r($files);
      // print_r(count($files));
      foreach($files['photos'] as $img){
        $name = $img->getRandomName();
        if($name == ""){
          
        }else{
        $data = [
          'code' => $code,
          'gambar' => $name
      ];
  
      $this->model_upload->insert_gambar($data);
  
        $img->move(ROOTPATH . 'public_html/uploads', $name);
    }
    }
    session()->setFlashdata('message', 'Update Data Success');
    return redirect()->to('/stock/');

    }


    else{
      //when remove all pics
      if($old == "" and $original != ""){
        $sqlsearch = "SELECT * FROM uploads WHERE code = ?";
        $querysearch = $db->query($sqlsearch,[$code]);

        foreach($querysearch->getResult() as $x){
          unlink($path."/".$x->gambar);

        }
        $sqldelete = "DELETE FROM uploads WHERE code = ? ";
        $querydelete = $db->query($sqldelete,[$code]);

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
            'code' => $code,
            'gambar' => $name
        ];
    
        $this->model_upload->insert_gambar($data);
    
          $img->move(ROOTPATH . 'public_html/uploads', $name);
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
          $sqldelete = "DELETE FROM uploads WHERE code = ? AND gambar = ?";
      $querydelete = $db->query($sqldelete,[$code,$tobedeleted]);
      unlink($path."/".$tobedeleted);
        }

        session()->setFlashdata('message', 'Update Data Success');
        return redirect()->to('/stock/');
      
   

      }
    //   $files = $this->request->getFiles();
    
    //   // print_r($files);
    //   // print_r(count($files));
    //   foreach($files['photos'] as $img){
    //     $name = $img->getRandomName();
    //     if($name == ""){
          
    //     }else{
    //     $data = [
    //       'code' => $code,
    //       'gambar' => $name
    //   ];
  
    //   $this->model_upload->insert_gambar($data);
  
    //     $img->move(ROOTPATH . 'public/uploads', $name);
    // }
    // }
              session()->setFlashdata('message', 'Update Data Success');
              return redirect()->to('/stock/');
     
    }

  
}
  
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
