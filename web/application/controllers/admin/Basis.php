<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Basis extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // untuk mengecek status login
        checking_session($this->username, $this->role, ['admin']);
    }

    // untuk default
    public function index()
    {
        $data = [
            'klasifikasi' => $this->m_klasifikasi->get_all(),
        ];
        // untuk load view
        $this->template->load('admin', 'Basis Pengetahuan', 'basis', 'view', $data);
    }

    // untuk get data
    public function get_data_dt()
    {
        $this->m_basis->get_all_data_dt();
    }

    // untuk get data by id
    public function get()
    {
        $post = $this->input->post(NULL, TRUE);

        $response = $this->crud->gda('tb_basis_data', ['id_basis' => $post['id']]);

        $this->_response_message($response);
    }

    // untuk proses tambah data
    public function process_save()
    {
        $post = $this->input->post(NULL, TRUE);

        $data = [
            'id_classification' => $post['id_classification'],
            'kriteria_1'        => $post['kriteria_1'],
            'kriteria_2'        => $post['kriteria_2'],
        ];

        if (empty($post['id_basis'])) {
            // untuk tambah
            $this->db->trans_start();
            $this->crud->i('tb_basis_data', $data);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
            } else {
                $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
            }
        } else {
            // untuk ubah
            $this->db->trans_start();
            $this->crud->u('tb_basis_data', $data, ['id_basis' => $post['id_basis']]);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
            } else {
                $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
            }
        }
        $this->_response_message($response);
    }

    // untuk proses hapus data
    public function process_del()
    {
        $post = $this->input->post(NULL, TRUE);

        $get = $this->crud->gda('tb_basis_data', ['id_basis' => $post['id']]);

        $check = checking_data($this->db->database, 'tb_basis_data', 'id_basis', $post['id']);

        if ($check > 0) {
            $response = ['title' => 'Gagal!', 'text' => 'Maaf data yang Anda hapus masih digunakan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $this->db->trans_start();
            $this->crud->d('tb_basis_data', $post['id'], 'id_basis');
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $response = ['title' => 'Gagal!', 'text' => 'Gagal Hapus!', 'type' => 'error', 'button' => 'Ok!'];
            } else {
                $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Hapus!', 'type' => 'success', 'button' => 'Ok!'];
            }
        }

        $this->_response_message($response);
    }
}
