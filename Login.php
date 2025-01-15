<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_login');
    }

    public function index()
    {
        $data['message'] = $this->session->flashdata('message');

        $this->load->view('login/index', $data);
    }

    public function aksi_login()
    {
        $nama_karyawan = $this->input->post('nama', true);
        $id_karyawan = $this->input->post('id', true);

        if (empty($nama_karyawan) || empty($id_karyawan)) {
            $this->session->set_flashdata('message', [
                'type' => 'error',
                'text' => 'Nama dan ID karyawan wajib diisi!'
            ]);
            redirect('login');
        }

        $karyawan = $this->M_login->cek_karyawan($nama_karyawan, $id_karyawan);

        if ($karyawan) {
            $this->session->set_userdata('login', [
                'nama' => $karyawan->nama_karyawan,
                'status' => 'Login'
            ]);

            redirect('dashboard');
        } else {
            $this->session->set_flashdata('message', [
                'type' => 'error',
                'text' => 'Login gagal! Nama atau ID karyawan salah.'
            ]);
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('login');
        $this->session->set_flashdata('message', [
            'type' => 'success',
            'text' => 'Anda telah berhasil logout.'
        ]);

        redirect('login');
    }
}
