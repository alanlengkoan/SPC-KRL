<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_consultation extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT c.id_consultation, u.nama AS users, c.image FROM tb_consultation AS c LEFT JOIN tb_users AS u ON u.id_users = c.id_users ORDER BY c.created_at DESC");
        return $result;
    }

    public function get_all_user($id)
    {
        $result = $this->db->query("SELECT c.id_consultation, u.id_users, u.nama AS users, c.image, c.created_at FROM tb_consultation AS c LEFT JOIN tb_users AS u ON u.id_users = c.id_users WHERE c.id_users = '$id' ORDER BY c.created_at DESC");
        return $result;
    }

    public function get_detail($id)  {
        $result = $this->db->query("SELECT c.id_consultation, u.nama AS users, c.image, cl.nama, cl.deskripsi FROM tb_consultation AS c LEFT JOIN tb_users AS u ON u.id_users = c.id_users LEFT JOIN tb_classification AS cl ON cl.id_classification = c.id_classification WHERE c.id_consultation = '$id'");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('c.id_consultation, u.nama AS users, c.image, cl.nama AS keterangan');
        $this->datatables->join('tb_users AS u', 'u.id_users = c.id_users');
        $this->datatables->join('tb_classification AS cl', 'cl.id_classification = c.id_classification');
        $this->datatables->order_by('c.created_at', 'desc');
        $this->datatables->from('tb_consultation AS c');
        return print_r($this->datatables->generate());
    }
}
