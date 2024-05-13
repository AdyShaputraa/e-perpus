<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('m_data');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('isLogging')) {
            redirect(base_url('Auth'));
        }
    }

    public function index() {
        $this->load->view('dashboard/index');
    }
}