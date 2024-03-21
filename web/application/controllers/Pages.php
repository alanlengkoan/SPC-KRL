<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'title'   => 'Home',
            'content'   => 'pages/home/view',
            'css'       => '',
            'js'        => ''
        ];
        // untuk load view
        $this->load->view('pages/base', $data);
    }

    public function tentang()
    {
        $data = [
            'title' => 'Tentang Kami',
            'content' => 'pages/tentang/view',
            'css'     => '',
            'js'      => ''
        ];
        // untuk load view
        $this->load->view('pages/base', $data);
    }
}
