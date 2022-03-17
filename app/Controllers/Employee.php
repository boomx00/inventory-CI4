<?php namespace App\Controllers;

use App\Models\EmployeeModel;

class Employee extends BaseController
{
	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        $this->employee = new EmployeeModel();
    }

    function create(){
      $id = $this->request->getVar('id');
      $fName = $this->request->getVar('fName');
      $city = $this->request->getVar('city');
      $address = $this->request->getVar('address');
      $phoneone = $this->request->getVar('phoneone');
      $phonetwo = $this->request->getVar('phonetwo');

      $employee = new EmployeeModel();
      $employee->insert([
        'firstname' => $fName,
        'city' => $city,
        'address' => $address,
        'phoneone' => $phoneone,
        'phonetwo' => $phonetwo,
      ]);
      session()->setFlashdata('message', 'Update Data Success');
      return redirect()->to('/employee/');
    }

  function update(){

    $employee = new EmployeeModel();
    $id = $this->request->getVar('id');
    $fName = $this->request->getVar('fName');
    $city = $this->request->getVar('city');
    $address = $this->request->getVar('address');
    $phoneone = $this->request->getVar('phoneone');
    $phonetwo = $this->request->getVar('phonetwo');

    $dataUser = $employee->where([
      'id' => $id,
    ])->first();
    if($dataUser){
            $this->employee->update($id, [
              'firstname' => $this->request->getVar('fName'),
              'city' => $city,
              'address' => $this->request->getVar('address'),
              'phoneone' => $this->request->getVar('phoneone'),
              'phonetwo' => $this->request->getVar('phonetwo'),
            ]);
            session()->setFlashdata('message', 'Update Data Success');
            return redirect()->to('/employee/');
     // else{
     //    echo "error";
     //  }
        }

  }
	function delete($id){
		$users = $this->employee->find($id);
        if (empty($users)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }
        $this->employee->delete($id);
        session()->setFlashdata('message', 'Delete Users Success');
        return redirect()->to('/employee');
	}
	//--------------------------------------------------------------------

}
