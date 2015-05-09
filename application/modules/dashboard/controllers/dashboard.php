<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_dashboard');
	}
	public function index()
	{
		$role=$this->session->userdata('id_role');
		if($role=='4'){
			$data['status']=$this->m_dashboard->cekStatus();
			$data['siswa']=$this->m_dashboard->getSiswaByNis();
			$this->load->view('page_ortu',$data);
		}else{
			$this->load->view('page_index');
		}
	}
	function update_siswa()
	{
		$data=array('no_orang_tua'=>$this->input->post('nomor_hp'),
					'nama_orang_tua'=>$this->input->post('nama_orang_tua'),
					'alamat'=>$this->input->post('alamat'));
		$this->db->where('nis', $this->session->userdata('username'));
		$this->db->update('siswa', $data);
		$this->session->set_flashdata('msg', "<div class='alert alert-warning fade in'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><strong>Data Berhasil diupdate</strong> .</div>");
		redirect('dashboard');
	}
}	

/* End of file dashboard.php */
/* Location: ./application/modules/dashboard/controllers/dashboard.php */