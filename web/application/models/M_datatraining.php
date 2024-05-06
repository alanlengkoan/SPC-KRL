<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_datatraining extends CI_Model
{
    public function get_all()
    {
        $result = $this->db->query("SELECT dt.id_datatraining, dt.image, dt.contrast, dt.correlation, dt.energy, dt.homogeneity, k.nama, k.deskripsi FROM tb_datatraining AS dt LEFT JOIN tb_classification AS k ON k.id_classification = dt.id_classification ORDER BY dt.created_at DESC");
        return $result;
    }

    public function get_all_data_dt()
    {
        $this->datatables->select('dt.id_datatraining, dt.image, dt.contrast, dt.correlation, dt.energy, dt.homogeneity, dt.created_at, k.nama, k.deskripsi');
        $this->datatables->join('tb_classification AS k', 'k.id_classification = dt.id_classification', 'left');
        $this->datatables->order_by('dt.created_at', 'desc');
        $this->datatables->from('tb_datatraining AS dt');
        return print_r($this->datatables->generate());
    }
}
