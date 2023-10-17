<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Klasifikasi extends MY_Controller
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
        // untuk load view
        $this->template->load('admin', 'Klasifikasi', 'klasifikasi', 'view');
    }

    // untuk get data
    public function get_data_dt()
    {
        $this->m_klasifikasi->get_all_data_dt();
    }

    // untuk get data by id
    public function get()
    {
        $post = $this->input->post(NULL, TRUE);

        $response = $this->crud->gda('tb_classification', ['id_classification' => $post['id']]);

        $this->_response_message($response);
    }

    // untuk proses tambah data
    public function process_save()
    {
        $post = $this->input->post(NULL, TRUE);

        $data = [
            'id_classification' => $post['id_classification'],
            'nama'           => $post['nama'],
            'deskripsi'      => $post['deskripsi'],
        ];

        $this->db->trans_start();
        if (empty($post['id_classification'])) {
            $this->crud->i('tb_classification', $data);
        } else {
            $this->crud->u('tb_classification', $data, ['id_classification' => $post['id_classification']]);
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
        }

        $this->_response_message($response);
    }

    // untuk proses hapus data
    public function process_del()
    {
        $post = $this->input->post(NULL, TRUE);

        $check = checking_data($this->db->database, 'tb_classification', 'id_classification', $post['id']);

        if ($check > 0) {
            $response = ['title' => 'Gagal!', 'text' => 'Maaf data yang Anda hapus masih digunakan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $this->db->trans_start();
            $this->crud->d('tb_classification', $post['id'], 'id_classification');
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
