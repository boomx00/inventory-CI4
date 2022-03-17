<?php namespace App\Controllers;

use App\Models\UsersModel;

class Register extends BaseController
{
	public function index()
	{
		return view('view_register');
	}

  public function process(){
      if(!$this->validate([
          'username' => [
              'rules' => 'required|min_length[4]|max_length[20]|is_unique[users.username]',
              'errors' => [
                  'required' => '{field} Harus diisi',
                  'min_length' => '{field} Minimal 4 Karakter',
                  'max_length' => '{field} Maksimal 20 Karakter',
                  'is_unique' => 'Username sudah digunakan sebelumnya'
              ]
          ],
          'password' => [
            'rules' => 'required|min_length[4]|max_length[20]',
            'errors' => [
              'required' => '{field} cannot be blank',
              'min_length' => '{field} is too short',
            ]
          ],
          'password_conf' => [
            'rules' => 'matches[password]',
            'errors' => [
              'matches' => 'passwords do not match'
            ]
          ],
          'name' => [
            'rules' => 'required',
            'errors' => ' {field} cannot be blank',
          ]
        ])){
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $users = new UsersModel();
        $users -> insert([
          'username' => $this->request->getVar('username'),
          'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
          'name' => $this->request->getVar('name'),
          'role'=>  $this->request->getVar('role'),
        ]);
        return redirect()->to('/login');


  }
}
