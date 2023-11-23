<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_pegawai extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Pegawai_model');
		if($this->session->userdata('status') != "login_admin"){
			redirect(base_url(""));
		}
	}

	public function index()
	{
		$data['title'] = 'Kelola Pegawai';
		$data['pegawai'] = $this->Pegawai_model->getAllPegawai()->result();

		$this->template->load('admin/v_template', 'admin/v_data_pegawai', $data);	
	}

	public function detail($nip)
	{
		$data['title'] = 'Detail Pegawai' ;

		$data['detail_pegawai'] = $this->Pegawai_model->getPegawaiDetails($nip);

		$this->template->load('admin/v_template', 'admin/v_detail_pegawai', $data);	
	}

	public function edit_pegawai($nip)
	{
		$data['title'] = 'Edit Pegawai';

		$data['edit_pegawai'] = $this->Pegawai_model->getPegawaiDetails($nip);

		$this->template->load('admin/v_template', 'admin/v_edit_pegawai', $data);	
	}

	public function tambah()
	{
		$data['title'] = 'Input data';

		$this->template->load('admin/v_template', 'admin/v_form_input', $data);	

	}

	public function prosesinput()
	{

		$nip = $this->input->post('nip');
		$nomor_induk = $this->input->post('nomor_induk');
		$nama_pegawai = $this->input->post('nama_pegawai');
		$jenis_kelamin = $this->input->post('jenis_kelamin');
		$kota_lahir = $this->input->post('kota_lahir');
		$tanggal_lahir = $this->input->post('tanggal_lahir');
		$kd_gol_darah = $this->input->post('kd_gol_darah');
		$kd_agama = $this->input->post('kd_agama');
		$kd_jenis_ketenagaan = $this->input->post('kd_jenis_ketenagaan');

		//sebelum dimasukkan ke model terlebih dahulu tampung di array $data

		$data = [
			'nip' => $nip,
			'nomor_induk' => $nomor_induk,
			'nm_pegawai' => $nama_pegawai,
			'kd_jenis_kelamin' => $jenis_kelamin,
			'kota_lahir' => $kota_lahir,
			'tanggal_lahir' => $tanggal_lahir,
			'kd_gol_darah' => $kd_gol_darah,
			'kd_agama' => $kd_agama,
			'kd_jenis_ketenagaan' => $kd_jenis_ketenagaan

		];

		$this->Pegawai_model->input($data);

	}

	public function prosesupdate()
	{
		//pastikan request menggunkan metode POST
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			// Tangkap data yang dikirimkan melalui formulir
			$nip = $this->input->post('nip');
			$nama_pegawai = $this->input->post('nama_pegawai');
			$kd_jenis_kelamin = $this->input->post('jenis_kelamin');
			$kota_lahir = $this->input->post('kota_lahir');
			$tanggal_lahir = $this->input->post('tanggl_lahir');
			$kd_gol_darah = $this->input->post('kd_gol_darah');
			$kd_agama = $this->input->post('kd_agama');
			$kd_jenis_ketenagaan = $this->input->post('kd_jenis_ketenagaan');
			// Tambahkan field lain sesuai lebutuhan

			// Validasi data jika diperlukan
			$data = [
				'nip' => $nip,
				'nomor_induk' => $nomor_induk,
				'nm_pegawai' => $nama_pegawai,
				'kd_jenis_kelamin' => $kd_jenis_kelamin,
				'kota_lahir' => $kota_lahir,
				'tanggal_lahir' => $tanggal_lahir,
				'kd_gol_lahir' => $kd_gol_darah,
				'kd_agama' => $kd_agama,
				// 'kd_jenis_ketenagaan' => $kd_jenis_ketenagaan,	
			];
			// Panggil model atau laukan operasi database untuk update data
			$this->load->model('Pegawai_model');

			$update_result = $this->Pegawai_model->updateData($nip, $data);
			// Tambahkan field lain sesuai kebutuhan

			// Setelah update, lakukan penanganan sesuai kebutuhan, misalnya kembali ke halaman tertentu
			if ($update_result) {
				redirect('admin/Kelola_pegawai/index'); // Ganti dengan halaman tujuan setelah update
			} else {
				// Penanganan jika update gagal
				echo "Update gagal";
			}
		} else {
			// Jika bukan metode POST, atur penanganan sesuai kebutuhan
			show_error('Metode request tidak valid.');
		}

	}
}