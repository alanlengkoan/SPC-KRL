<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datatraining extends MY_Controller
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
            'klasifikasi' => $this->m_classification->get_all(),
        ];
        // untuk load view
        $this->template->load('admin', 'Basis Pengetahuan', 'datatraining', 'view', $data);
    }

    // untuk get data
    public function get_data_dt()
    {
        $this->m_datatraining->get_all_data_dt();
    }

    // untuk get data by id
    public function get()
    {
        $post = $this->input->post(NULL, TRUE);

        $response = $this->crud->gda('tb_datatraining', ['id_datatraining' => $post['id']]);

        $this->_response_message($response);
    }

    // untuk proses tambah data
    public function process_save()
    {
        $post = $this->input->post(NULL, TRUE);

        if (empty($post['id_datatraining'])) {
            // untuk tambah
            $image = add_picture('image');

            if ($image['status']) {
                $image_loc = upload_path('gambar') . $image['data']['file_name'];

                $this->imagesampler->image($image_loc);
                $glcm        = $this->imagesampler->calculateGLCM();
                $contrast    = $this->imagesampler->calculateContrast($glcm);
                $correlation = $this->imagesampler->calculateCorrelation($glcm);
                $energy      = $this->imagesampler->calculateEnergy($glcm);
                $homogeneity = $this->imagesampler->calculateHomogeneity($glcm);

                $data = [
                    'id_classification' => $post['id_classification'],
                    'image'             => $image['data']['file_name'],
                    'contrast'          => $contrast,
                    'correlation'       => $correlation,
                    'energy'            => $energy,
                    'homogeneity'       => $homogeneity
                ];

                $this->db->trans_start();
                $this->crud->i('tb_datatraining', $data);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
                } else {
                    $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
                }
            } else {
                $response = ['title' => 'Gagal!', 'text' => $image['message'], 'type' => 'error', 'button' => 'Ok!'];
            }
        } else {
            // untuk ubah
            if (isset($post['ubah_gambar']) && $post['ubah_gambar'] === 'on') {
                $get = $this->crud->gda('tb_datatraining', ['id_datatraining' => $post['id_datatraining']]);

                $image = upd_picture('image', $get['image']);

                if ($image['status']) {
                    $image_loc = upload_path('gambar') . $image['data']['file_name'];

                    $this->imagesampler->image($image_loc);
                    $glcm        = $this->imagesampler->calculateGLCM();
                    $contrast    = $this->imagesampler->calculateContrast($glcm);
                    $correlation = $this->imagesampler->calculateCorrelation($glcm);
                    $energy      = $this->imagesampler->calculateEnergy($glcm);
                    $homogeneity = $this->imagesampler->calculateHomogeneity($glcm);


                    $data = [
                        'id_classification' => $post['id_classification'],
                        'image'             => $image['data']['file_name'],
                        'contrast'          => $contrast,
                        'correlation'       => $correlation,
                        'energy'            => $energy,
                        'homogeneity'       => $homogeneity
                    ];

                    $this->db->trans_start();
                    $this->crud->u('tb_datatraining', $data, ['id_datatraining' => $post['id_datatraining']]);
                    $this->db->trans_complete();
                    if ($this->db->trans_status() === FALSE) {
                        $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
                    } else {
                        $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
                    }
                } else {
                    $response = ['title' => 'Gagal!', 'text' => $image['message'], 'type' => 'error', 'button' => 'Ok!'];
                }
            } else {
                $data = [
                    'id_klasifikasi' => $post['id_klasifikasi'],
                ];
                $this->db->trans_start();
                $this->crud->u('tb_datatraining', $data, ['id_datatraining' => $post['id_datatraining']]);
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
                } else {
                    $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!'];
                }
            }
        }
        $this->_response_message($response);
    }

    // untuk proses hapus data
    public function process_del()
    {
        $post = $this->input->post(NULL, TRUE);

        $get = $this->crud->gda('tb_datatraining', ['id_datatraining' => $post['id']]);

        $check = checking_data('spc_kualitastelur', 'tb_datatraining', 'id_datatraining', $post['id']);

        if ($check > 0) {
            $response = ['title' => 'Gagal!', 'text' => 'Maaf data yang Anda hapus masih digunakan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $this->db->trans_start();

            del_picture($get['image']);

            $this->crud->d('tb_datatraining', $post['id'], 'id_datatraining');
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
