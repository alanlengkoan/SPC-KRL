<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_basis');
        $this->load->model('m_konsultasi');
    }

    // untuk simpan
    public function save()
    {
        $post = $this->input->post(NULL, TRUE);

        $parseImage  = base64_decode($post['loc_image']);

        file_put_contents(upload_path('gambar') . '/' . $post['image'], $parseImage);

        $data = [
            'nama'  => $post['nama'],
            'image' => $post['image'],
        ];

        $this->db->trans_start();
        $this->crud->i('konsultasi', $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = ['status' => false, 'title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $response = ['status' => true, 'title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!', 'id' => $id];
        }

        $this->_response($response);
    }

    // untuk proses algoritma
    public function result($id)
    {
        $get_konsultasi = $this->crud->gda('konsultasi', ['id_konsultasi' => $id]);
        $get_basis      = $this->m_basis->get_all();
        $image_loc      = upload_path('gambar') . $get_konsultasi['image'];

        $this->imagesampler->image($image_loc);
        $this->imagesampler->set_steps(1);
        $this->imagesampler->init();

        $rgb       = $this->imagesampler->sample();
        $objek     = $rgb[0][0];
        $hsv_objek = $this->imagesampler->rgb_to_hsv($objek[0], $objek[1], $objek[2]);

        $result = [];
        $sort   = [];
        $basis  = [];
        foreach ($get_basis->result_array() as $key => $value) {
            $hitung     = sqrt(pow($objek[0] - $value['r'], 2) + pow($objek[1] - $value['g'], 2) + pow($objek[2] - $value['b'], 2));

            $basis[$value['id_basis']]  = $value;
            $result[$value['id_basis']] = $hitung;
            $sort[$value['id_basis']]   = $hitung;
        }

        $konsultasi = [
            'nama'  => $get_konsultasi['nama'],
            'image' => $get_konsultasi['image'],
            'r'     => $objek[0],
            'g'     => $objek[1],
            'b'     => $objek[2],
            'h'     => number_format($hsv_objek['H'], 2),
            's'     => number_format($hsv_objek['S'], 2),
            'v'     => number_format($hsv_objek['V'], 2),
        ];

        uasort($sort, function ($a, $b) {
            return $a - $b;
        });

        $data = [
            'konsultasi'  => $konsultasi,
            'klasifikasi' => $basis[array_key_first($sort)]['nama'],
            'deskripsi'   => $basis[array_key_first($sort)]['deskripsi']
        ];

        $this->_response($data);
    }

    public function img_one($id)
    {
        $konsultasi = $this->crud->gda('konsultasi', ['id_konsultasi' => $id]);

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
        $konsultasi = $this->crud->gda('konsultasi', ['id_konsultasi' => $id]);

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
        $konsultasi = $this->crud->gda('konsultasi', ['id_konsultasi' => $id]);

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
        $konsultasi = $this->crud->gda('konsultasi', ['id_konsultasi' => $id]);

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
