<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Surat_ajuan extends CI_Controller { 
    public function __construct()
  { 
    
        parent::__construct();
        $this->load->model("Masuk_model");
        cek_login();
        
        $this->load->library('form_validation');
    } 
    
    public function index()
    {   $user_id = $this->session->userdata('id');
        $data = array(
            'title' => 'View Data Surat Pengajuan',
            'userlog'=> infoLogin(),
            'surat' => $this->db->where('is_active',1)->where('user_id',$user_id)->get('tb_surat_masuk')->result(), 
            'content' => 'surat_ajuan/index'
        ); 
        $this->load->view('template_user/main',$data);
    } 

    public function add()
    {
        $data = array(
            'title' => 'Tambah Data Surat Pengajuan',
            'userlog' => infoLogin(),
            'content' => 'surat_ajuan/add_form'
        );
        $this->load->view('template_user/main',$data);
    }

    public function save()
        {
        $this->Masuk_model->saveAjuan();
        if($this->db->affected_rows()>0){
            $this->session->set_flashdata("success","Data Surat Masuk Berhasil Disimpan");
        }
        redirect('surat_ajuan');
        }
    
        public function getedit($id)
        {
            $data = array(
                'title' => 'Update Data Surat Masuk',
                'userlog' => infoLogin(),
                'surat' => $this->Masuk_model->getByid($id),
                'content' => 'surat_ajuan/add_form'
            );
            $this->load->view('template_user/main',$data);
        }

        public function edit()
        {
            $this->Masuk_mode->editData();
            if($this->db->affected_rows()>0){
                $this->session->set_flashdata("success","Data user Berhasil Diupdate");
            }
            redirect('surat_ajuan');
        }

        public function delete($id)
        {
            $this->deleteImage($id);
            $this->db->where('id',$id)->delete($this->_table);
            if($this->db->affected_rows()>0){
                $this->session->set_flashdata("success","Data user Berhasil DiDelete");
            }
        }
        private function deleteImage($id)
        {
            $surat = $this->getById($id);
            if ($surat->image != "no_image.jpg") {
                $filename = explode(".", $surat->image)[0];
                return array_map('unlink', glob(FCPATH."assets/photo/surat_masuk/$filename.*"));
            }
        }
}
     ?>