<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_classification extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT k.id_classification, k.nama, k.deskripsi FROM tb_classification AS k ORDER BY k.created_at DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('k.id_classification, k.nama, k.deskripsi');
        $this->datatables->order_by('k.created_at', 'desc');
        $this->datatables->from('tb_classification AS k');
        return print_r($this->datatables->generate());
    }
}
