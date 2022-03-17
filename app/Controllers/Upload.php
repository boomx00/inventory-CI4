<?php namespace App\Controllers;
 
// Tambahkan Upload Model di sini
use App\Models\UploadModel;
 
class Upload extends BaseController
{
 
    protected $model_upload;
 
    public function __construct() {
 
        // Memanggil form helper
        helper('form');
        // Menyiapkan variabel untuk menampung upload model
        $this->model_upload = new UploadModel();
    }
 
    public function index()
    {
        if (!$this->validate([]))
        {
            $data['validation'] = $this->validator;
            $data['uploads'] = $this->model_upload->get_uploads();
            echo view('form_upload', $data);
        }
    }
  
    public function process()
    {
        // 
        // echo "yes";
        // if ($this->request->getMethod() !== 'post') {
        //     return redirect()->to(base_url('upload'));
        // }
 
        // $validated = $this->validate([
        //     'file_upload' => 'uploaded[file_upload]|mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png]|max_size[file_upload,4096]'
        // ]);
            
        // if ($validated == FALSE) {
             
        //     // Kembali ke function index supaya membawa data uploads dan validasi
        //     return $this->index();
 
        // } else {
 
            $files  = $this->request->getFiles();
            // print_r($files);
            foreach($files['images'] as $img){
                $data_galery = [
                    // 'upload_id' => $random,
                    'gambar' => $img->getName()
                ];       
                $img->move(ROOTPATH . 'public/uploads', $img->getName());

            }
            // print_r($avatar);
        //     $avatar->move(ROOTPATH . 'public/uploads');
 
        //     $data = [
        //         'gambar' => $avatar->getName()
        //     ];
     
        //     $this->model_upload->insert_gambar($data);
        //     return redirect()->to(base_url('upload'))->with('success', 'Upload successfully'); 
        // }
 
    }
 
}