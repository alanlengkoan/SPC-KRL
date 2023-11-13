<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Consultation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function detail($id)
    {
        $get = $this->m_consultation->get_all_user($id);
        $num = $get->num_rows();

        if ($num == 0) {
            $response = ['status' => false, 'data' => []];
        } else {
            $result = [];
            foreach ($get->result() as $key => $value) {
                $result[] = [
                    'id_consultation' => $value->id_consultation,
                    'id_users'        => $value->id_users,
                    'nama'            => $value->nama,
                    'image'           => $value->image,
                    'created_at'      => tgl_indo($value->created_at)
                ];
            }

            $response = ['status' => true, 'data' => $result];
        }

        $this->_response($response);
    }
}
