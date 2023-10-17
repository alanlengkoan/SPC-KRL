<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // untuk mengecek status login
        checking_session($this->username, $this->role, ['admin']);
    }

    // untuk konsultasi
    public function konsultasi()
    {
        // untuk load view
        $this->template->load('admin', 'Laporan Konsultasi', 'laporan', 'konsultasi');
    }
}
