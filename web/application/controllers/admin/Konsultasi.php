<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends MY_Controller
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
        $this->template->load('admin', 'Konsultasi', 'konsultasi', 'view');
    }

    // untuk get data
    public function get_data_dt()
    {
        $this->m_konsultasi->get_all_data_dt();
    }

    // untuk proses
    public function process()
    {
        $post = $this->input->post(NULL, TRUE);

        $data = [
            'kriteria_1' => $post['kriteria_1'],
            'kriteria_2' => $post['kriteria_2'],
        ];

        $this->db->trans_start();
        $this->crud->i('tb_consultation', $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!', 'id' => $id];
        }
        $this->_response_message($response);
    }

    public function results($id)
    {
        $data_test           = $this->crud->gda('tb_consultation', ['id_consultation' => $id]);
        $data_classification = $this->m_klasifikasi->get_all();
        $get_basis           = $this->m_basis->get_all();

        $data_training = [];
        foreach ($get_basis->result() as $key => $value) {
            $data_training[$value->id_datatraining]  = $value;
        }

        // $a = $this->processEuclidianDistance($data_training, $data_test);

        // $b = $this->processMinToMaxEuclidianDistance($a);

        // $c = $this->processClasificationKToN($b, $data_training, 3);

        // $d = $this->processClasification($c, $data_classification->result());

        // $e = $this->processValiditasKToN($b, $data_training, $d['label'], 3);

        // $f = $this->processWeightVoting($b, $e);

        // debug($data_test, $data_training, $a, $b, $c, $d, $e, $f);

        $data = [
            'ini'                 => $this,
            'data_training'       => $data_training,
            'data_test'           => $data_test,
            'data_classification' => $data_classification->result(),
        ];
        // untuk load view
        $this->template->load('admin', 'Hasil Konsultasi', 'konsultasi', 'result', $data);
    }

    public function processEuclidianDistance($data_training, $data_test)
    {
        $result = [];

        foreach ($data_training as $key => $value) {
            $count = round(sqrt(pow($data_test['kriteria_1'] - $value->kriteria_1, 2) + pow($data_test['kriteria_2'] - $value->kriteria_2, 2)), 2);

            $result[$value->id_datatraining] = $count;
        }

        return $result;
    }

    public function processMinToMaxEuclidianDistance($data)
    {
        asort($data);

        return $data;
    }

    public function processClasificationKToN($data_sort, $data_training, $n)
    {
        $k = 1;
        $result = [];

        foreach ($data_sort as $key_r => $val_r) {
            $check = ($k++ <= $n ? $data_training[$key_r]->nama : '-');

            $result[] = $check;
        }

        return $result;
    }

    public function processClasification($data, $classification)
    {
        $counts = array_count_values($data);
        $result = [];

        foreach ($classification as $key => $value) {
            if (!empty($counts[$value->nama])) {
                $result[] = [
                    'label' => $value->nama,
                    'count' => $counts[$value->nama]
                ];
            }
        }

        foreach ($result as $k => $v) {
            $sort[$k] = $v['count'];
        }

        array_multisort($sort, SORT_DESC, $result);

        return $result[0];
    }

    public function processValiditasKToN($data_sort, $data_training, $classification_name, $n)
    {
        $result = [];

        foreach ($data_sort as $key => $value) {
            $check = ($data_training[$key]->nama === $classification_name ? 1 : 0);
            $count = round((1 / $n) * $check, 2);

            $result[$key] = $count;
        }

        return $result;
    }

    public function processWeightVoting($data_sort, $data_validitas)
    {
        $result = [];

        foreach ($data_sort as $key => $value) {
            $count = round($data_validitas[$key] * (1 / ($value + 0.5)), 2);

            $result[$key] = [
                'euclidian' => $value,
                'validitas' => $data_validitas[$key],
                'weight' => $count
            ];
        }

        return $result;
    }

    public function img_one($id)
    {
        $konsultasi = $this->crud->gda('konsultasi', ['id_consultation' => $id]);

        if (PHP_OS === 'WINNT') {
            $url = getcwd() . '/' . upload_path('gambar') . $konsultasi['image'];
        } else {
            $url = upload_url('gambar') . $konsultasi['image'];
        }

        $imagick = new Imagick($url);
        if (getExtension($konsultasi['image']) === 'png') {
            header("Content-Type: image/png");
        } else {
            header("Content-Type: image/jpeg");
        }
        echo $imagick->getImageBlob();
    }

    public function img_two($id)
    {
        $konsultasi = $this->crud->gda('konsultasi', ['id_consultation' => $id]);

        if (PHP_OS === 'WINNT') {
            $url = getcwd() . '/' . upload_path('gambar') . $konsultasi['image'];
        } else {
            $url = upload_url('gambar') . $konsultasi['image'];
        }

        $imagick = new Imagick($url);
        $imagick->setImageType(2);
        if (getExtension($konsultasi['image']) === 'png') {
            header("Content-Type: image/png");
        } else {
            header("Content-Type: image/jpeg");
        }
        echo $imagick->getImageBlob();
    }

    public function img_three($id)
    {
        $konsultasi = $this->crud->gda('konsultasi', ['id_consultation' => $id]);

        if (PHP_OS === 'WINNT') {
            $url = getcwd() . '/' . upload_path('gambar') . $konsultasi['image'];
        } else {
            $url = upload_url('gambar') . $konsultasi['image'];
        }

        $imagick = new Imagick($url);
        $imagick->quantizeImage(5, Imagick::COLORSPACE_GRAY, 1, TRUE, FALSE);
        if (getExtension($konsultasi['image']) === 'png') {
            header("Content-Type: image/png");
        } else {
            header("Content-Type: image/jpeg");
        }
        echo $imagick->getImageBlob();
    }

    public function img_four($id)
    {
        $konsultasi = $this->crud->gda('konsultasi', ['id_consultation' => $id]);

        if (PHP_OS === 'WINNT') {
            $url = getcwd() . '/' . upload_path('gambar') . $konsultasi['image'];
        } else {
            $url = upload_url('gambar') . $konsultasi['image'];
        }

        $imagick = new Imagick($url);
        $imagick->setImageType(1);
        if (getExtension($konsultasi['image']) === 'png') {
            header("Content-Type: image/png");
        } else {
            header("Content-Type: image/jpeg");
        }
        echo $imagick->getImageBlob();
    }
}
