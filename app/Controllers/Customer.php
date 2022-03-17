<?php namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        $this->customer = new CustomerModel();
    }

    function create(){
      $id = $this->request->getVar('id');
      $name = $this->request->getVar('name');
      $address = $this->request->getVar('address');
      $phone = $this->request->getVar('phone');

      $customer = new CustomerModel();
      $customer->insert([
        'name' => $name,
        'address' => $address,
        'phone' => $phone,

      ]);
      session()->setFlashdata('message', 'Input Customer Success');
      return redirect()->to('/customer/');
    }

  function update()
  {
    $customer = new CustomerModel();

    if(!$this->validate([
      'phone' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} cannot be blank',
        ]
      ],
      'name' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} cannot be blank'
        ]
      ]
    ]))
    {
      session()->setFlashdata('error',$this->validator->listErrors());
      return redirect()->back();
    }
    $id = $this->request->getVar('id');
    $this->customer->update($id, [
      'name' => $this->request->getVar('name'),
      'address' => $this->request->getVar('address'),
      'phone' => $this->request->getVar('phone')
    ]);
    session()->setFlashdata('message', 'Update Data Success');
        return redirect()->to('/customer');
  }


	function delete($id){
		$customer = $this->customer->find($id);
        if (empty($customer)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }
        $this->customer->delete($id);
        session()->setFlashdata('message', 'Delete Customer Success');
        return redirect()->to('/customer');
	}
	//--------------------------------------------------------------------

}
