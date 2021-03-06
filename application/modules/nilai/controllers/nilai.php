 <?php 
  class Nilai extends CI_Controller
 {
	public function __construct()
		{
			parent::__construct();
			$this->load->model('M_nilai');
			$username=$this->session->userdata('username');
			$st=$this->session->userdata('login');
			if($st!='1')
			{
				redirect('home');
			}
		}


	public function indexnilai()
	{
		
		/*$id_pelajaran=$this->M_nilai->dropdownpelajaran();
				foreach($id_pelajaran as $cihuy)
				{
					$c[$cihuy->id_mata_pelajaran]=$cihuy->nama_pelajaran;
				}
				$data['dt_pelajaran']=$c;
			

		$nik=$this->M_nilai->dropdownnik();
				foreach($nik as $unyu)
				{
					$p[$unyu->nik]=$unyu->nama_guru;
				}
				$data['dt_nik']=$p;
		

		$kelas=$this->M_nilai->dropdownkelas();
				foreach($kelas as $kelaskelas)
				{
					$u[$kelaskelas->id_kelas]=$kelaskelas->tingkat_kelas." ".$kelaskelas->jurusan." ".$kelaskelas->grup_kelas;
				}
				$data['dt_kelas']=$u;
		*/		

		$data['list']=$this->M_nilai->tampil_data();
		$this->load->view('v_nilai', $data);
	}


	
	function detail($id_kelas,$id_mata_pelajaran)
	{
		$data['id_kelas']=$id_kelas;
		$data['id_mata_pelajaran']=$id_mata_pelajaran;
		//$data['ket']=$this->db->query("select*from nilai where id_kelas='".$id_kelas."'")->row();
		$data['list']=$this->M_nilai->tampil_data_detail($id_kelas);
		$this->load->view('v_nilai_detail', $data);
	}	

	
	function tambah_data()
	{
	
		$data=array (
		
		'id_nilai' 			=>$this->input->post ('id_nilai'),
		'id_mata_pelajaran'	=>$this->input->post ('id_mata_pelajaran'),
		'id_kelas'			=>$this->input->post ('id_kelas'),
		'tanggal'			=>$this->input->post ('tanggal'),
		'keterangan'		=>$this->input->post ('keterangan'),
		'nik'				=>$this->input->post ('nik')
		
		);
		$id_nilai=$this->M_nilai->masukan_data($data);
		//$this->session->set_flashdata('msg', "<div class='alert alert-warning fade in'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><strong>Data  berhasil ditambah</strong> .</div>");
		echo $id_nilai;
		//redirect ('nilai/indexnilai');
	}
	
	function insert_nilai(){
		$id_kelas=$this->input->post('id_kelas');
		$id_mata_pelajaran=$this->input->post('id_mata_pelajaran');
		$nik=$this->M_nilai->getPengajar($id_kelas,$id_mata_pelajaran);
		$data=array('id_mata_pelajaran'=>$id_mata_pelajaran,
					'nik'=>$nik,
					'keterangan'=>$this->input->post('materi'),
					'id_kelas'=>$id_kelas);
		$this->db->insert('nilai', $data);
		$id_nilai=$this->db->insert_id();

		//insert siswa
		$tgl=date('d-m-Y');
		$siswa=$this->M_nilai->tampil_data_detail($id_kelas);
		echo "<pre>";
		//print_r($siswa);
		if($siswa){
			$arr=array();
			foreach($siswa as $s){
				
				$pesan ="Nilai Telah Dikirim ";
				//insert to outbox
				
					$pelajaran= $this->M_nilai->ambildata($id_mata_pelajaran);
					
					$isipesan="Pada Tanggal".date('d-m-Y')."Nilai harian Mata Pelajaran ".$pelajaran->nama_pelajaran." untuk siswa dengan nama " .$s->nama_siswa." pada materi ".$this->input->post('materi')." adalah ".$this->input->post('nilai_'.$s->nis)." ";
					
					$data = array('DestinationNumber'=>$s->no_orang_tua,
								'TextDecoded'=>$isipesan);
							$this->db->insert('outbox', $data);
							$ID_sentitems=$this->db->insert_id();		
				//print_r($data);
				$dt=array('nis'=>$s->nis,
							'nilai'=>$this->input->post('nilai_'.$s->nis),
							'id_nilai'=>$id_nilai,
							'ID_sentitems'=>$ID_sentitems);
							array_push($arr, $dt);
				//echo $s->nilai."<br>";
			}
			//print_r($arr);
			$this->db->insert_batch('nilai_dtl', $arr);
			
		}



		$this->session->set_flashdata('msg', "<div class='alert alert-warning fade in'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><strong>Data telah tersimpan</strong> , ".$pesan."</div>");
		
		redirect('nilai/indexnilai');
	}
	
}