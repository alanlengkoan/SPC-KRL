<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_basis extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT dt.id_datatraining, dt.kriteria_1, dt.kriteria_2, k.nama, k.deskripsi FROM tb_datatraining AS dt LEFT JOIN tb_classification AS k ON k.id_classification = dt.id_classification ORDER BY dt.created_at DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('dt.id_datatraining, dt.kriteria_1, dt.kriteria_2, k.nama, k.deskripsi');
        $this->datatables->join('tb_classification AS k', 'k.id_classification = dt.id_classification', 'left');
        $this->datatables->order_by('dt.created_at', 'desc');
        $this->datatables->from('tb_datatraining AS dt');
        return print_r($this->datatables->generate());
    }
}
