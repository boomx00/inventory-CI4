<?php namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
	public function index()
	{
    session()->destroy();
    return redirect()->to('/login');
	}

  function __construct()
    {
        $this->users = new UsersModel();
    }

  public function edit($id)
  {
    $dataUser = $this->users->find($id);
    $data['users'] = $dataUser;
    return view('people/users/users_edit',$data);
  }

  function update($id)
  {
    if(!$this->validate([
      'username' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} cannot be blank',
        ]
      ],
      'password' => [
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

    $this->users->update($id, [
      'username' => $this->request->getVar('username'),
      'password' => $this->request->getVar('password'),
      'name' => $this->request->getVar('name')
    ]);
    session()->setFlashdata('message', 'Update Data Success');
        return redirect()->to('/users');
  }

  function upassword(){
    if(!$this->validate([
      'opassword' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Failed to update password'
        ]
      ],
      'npassword' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Failed to update password'
        ]
      ],
      'password_conf' => [
        'rules' => 'matches[npassword]',
        'errors' => [
          'matches' => 'Failed to update password'
        ]
      ]
    ]))
    {
      session()->setFlashdata('errorr', $this->validator->listErrors());
      // return redirect()->back()->withInput();
    }
    $users = new UsersModel();
    $id = $this->request->getVar('theid');
    $opassword = $this->request->getVar('opassword');
    $dataUser = $users->where([
      'id' => $id,
    ])->first();
    if($dataUser){
      if(password_verify($opassword, $dataUser->password)){

            $this->users->update($id, [
              'password' => password_hash($this->request->getVar('npassword'), PASSWORD_BCRYPT),
            ]);
            session()->setFlashdata('message', 'Update Data Success');
            return redirect()->to('/users/edit/'.$id);
      } else{
        echo "error";
      }
        }

  }
	function delete($id){
		$users = $this->users->find($id);
        if (empty($users)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Pegawai Tidak ditemukan !');
        }
        $this->users->delete($id);
        session()->setFlashdata('message', 'Delete Users Success');
        return redirect()->to('/users');
	}
	//--------------------------------------------------------------------

}
