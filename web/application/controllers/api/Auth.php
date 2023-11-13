<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $post = $this->input->post(NULL, TRUE);

        $username = $post['username'];
        $password = $post['password'];

        $where = [
            'username' => $username
        ];

        $user  = $this->db->get_where('tb_users', $where);
        $count = $user->result();

        if (count($count) >= 1) {
            $row = $user->row_array();
            if (password_verify($password, $row['password'])) {
                $data = [
                    'id'       => $row['id'],
                    'id_users' => $row['id_users'],
                    'nama'     => $row['nama'],
                    'email'    => $row['email'],
                    'username' => $row['username'],
                    'role'     => $row['roles'],
                    'status'   => true
                ];

                $this->_response($data);
            } else {
                $this->_response(['status' => false, 'title' => 'Gagal!', 'text' => 'Username atau Password Anda salah!', 'type' => 'error', 'button' => 'Ok!']);
            }
        } else {
            $this->_response(['status' => false, 'title' => 'Gagal!', 'text' => 'Username atau Password Anda salah!', 'type' => 'error', 'button' => 'Ok!']);
        }
    }

    public function register()
    {
        $post = $this->input->post(NULL, TRUE);

        $users = [
            'id_users' => acak_id('tb_users', 'id_users'),
            'nama'     => $post['nama'],
            'email'    => $post['email'],
            'username' => $post['username'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'roles'    => 'users',
        ];

        $this->db->db_debug = FALSE;

        $this->db->trans_start();
        $this->crud->i('tb_users', $users);

        $db_error = $this->db->error();
        if ($db_error['code'] != 0) {
            $response = ['status' => FALSE, 'title' => 'Gagal!', 'text' => 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'], 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $response = ['status' => FALSE, 'title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
            } else {
                $response = ['status' => TRUE, 'title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
            }
        }

        $this->_response($response);

        $this->db->db_debug = TRUE;
    }

    public function user($id)
    {
        $where = [
            'id_users' => $id
        ];

        $get = $this->db->get_where('tb_users', $where);
        $num = $get->num_rows();
        $row = $get->row_array();

        if ($num == 0) {
            $response = ['status' => false, 'title' => 'Gagal!', 'text' => 'User tidak ditemukan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $data = [
                'id'       => $row['id'],
                'id_users' => $row['id_users'],
                'nama'     => $row['nama'],
                'email'    => $row['email'],
                'username' => $row['username'],
                'role'     => $row['roles'],
                'status'   => true
            ];

            $response = ['status' => true, 'data' => $data];
        }

        $this->_response($response);
    }
}