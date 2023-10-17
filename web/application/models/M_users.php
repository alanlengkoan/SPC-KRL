<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_users extends CI_Model
{
    public function getRoleUsers($role, $id_users)
    {
        $result = $this->db->query("SELECT tu.id_users, tu.nama, tu.email, tu.roles, tu.foto, tu.username FROM tb_users AS tu WHERE tu.roles = '$role' AND tu.id_users = '$id_users'")->row();
        return $result;
    }

    public function getRoleUsersSupplier($id_users)
    {
        $result = $this->db->query("SELECT ts.id_supplier, ts.id_users, ts.kd_supplier, ts.kd_pos, ts.npwp, ts.fax, ts.telepon, ts.alamat, u.nama, u.email, u.foto FROM tb_supplier AS ts LEFT JOIN tb_users AS u ON ts.id_users = u.id_users WHERE ts.id_users = '$id_users'");
        return $result;
    }

    public function getRoleUsersDsitribusi($id_users)
    {
        $result = $this->db->query("SELECT dis.id_distribusi, dis.id_users, dis.kd_distribusi, dis.kd_pos, dis.npwp, dis.fax, dis.telepon, dis.alamat, u.nama, u.email, u.foto FROM tb_distribusi AS dis LEFT JOIN tb_users AS u ON dis.id_users = u.id_users WHERE dis.id_users = '$id_users'");
        return $result;
    }
}
