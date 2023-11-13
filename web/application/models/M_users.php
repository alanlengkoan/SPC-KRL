<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_users extends CI_Model
{
    public function get_all_data_dt()
    {
        $this->datatables->select('u.nama, u.email, u.username');
        $this->datatables->order_by('u.ins', 'desc');
        $this->datatables->where('u.roles', 'users');
        $this->datatables->from('tb_users AS u');
        return print_r($this->datatables->generate());
    }
}
