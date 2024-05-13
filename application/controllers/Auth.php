<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('m_data');
    }

    public function index() {
        $this->load->view('auth/sign_in/index');
    }

    public function sign_in() {
        try {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
    
            $users = $this->m_data->runQuery('SELECT * FROM users WHERE username = "'.$username.'"')->result();
            if (!empty($users)) {
                $users_uuid = ''; $users_name = ''; $users_username = ''; $passwordDB = '';
                foreach ($users as $value) { $users_uuid = $value->uuid; $users_name = $value->name; $users_username = $value->username; $passwordDB = $value->password; }
                if (password_verify($password, $passwordDB)) {
                    $session = array(
                        'users_uuid' => $users_uuid,
                        'users_name' => $users_name,
                        'users_username' => $users_username,
                        'isLogging' => TRUE
                    );

                    $this->session->set_userdata($session);
                    echo json_encode(array('code' => '200', 'message' => 'Wellcome.'));
                } else {
                    echo json_encode(array('code' => '400', 'message' => 'username or password doesnt match.')); 
                }
            } else {
                echo json_encode(array('code' => '400', 'message' => 'your credentials cannot found.')); 
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => '500', 'message' => 'Internal Server Error'));
        }
    }

    public function sign_out() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Success Loggout.');
        redirect(base_url('Auth'));
    }
}