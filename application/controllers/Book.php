<?php defined('BASEPATH') or exit('No direct script access allowed');
use Ramsey\Uuid\Uuid;

class Book extends CI_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('m_data');
        $this->load->model('m_pagination');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('isLogging')) {
            redirect(base_url('Auth'));
        }
    }

    public function index() {
        $this->load->view('book/index');
    }

    public function get() {
        $rows = $this->m_pagination->getRows(
            $_POST,
            array(null, 'uuid', 'code', 'cover', 'title', 'categories', 'stock', 'year', 'createdAt', 'updatedAt'),
            array('code', 'title', 'categories', 'stock', 'year'),
            array('createdAt' => 'ASC'),
            'book',
            'uuid, code, cover, title, categories, stock, year, createdAt, updatedAt'
        );

        $data = array();
        $c = $_POST['start'];
        foreach ($rows as $i) {
            $c++;
            $row = array(
                'uuid' => $i->uuid,
                'number' => $c,
                'code' => $i->code,
                'cover' => $i->cover,
                'title' => $i->title,
                'categories' => $i->categories,
                'stock' => $i->stock,
                'year' => $i->year,
                'createdAt' => $i->createdAt,
                'updatedAt' => $i->updatedAt
            );
            $data[] = $row;
        }

        $result = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pagination->countAll('SELECT uuid, code, cover, title, categories, stock, year, createdAt, updatedAt
                FROM book 
                ORDER BY createdAt ASC'),
            "recordsFiltered" => $this->m_pagination->countFiltered(
                $_POST,
                array(null, 'uuid', 'code', 'cover', 'title', 'categories', 'stock', 'year', 'createdAt', 'updatedAt'),
                array('code', 'title', 'categories', 'stock', 'year'),
                array('createdAt' => 'ASC'),
                'book',
                'uuid, code, cover, title, categories, stock, year, createdAt, updatedAt'
            ),
            "data" => $data
        );
        echo json_encode($result);
    }

    public function create() {
        try {
            $cover = NULL;
            $config['file_name'] = $this->input->post('file');
            $config['upload_path'] = './images/cover/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $cover = NULL;
            } else {
                $fileData = $this->upload->data('file_name');
                $cover = base_url().'images/cover/'.$fileData;
            }

            $data = array(
                'uuid' => Uuid::uuid4()->toString(),
                'code' => 'BOOK-' . substr(md5(microtime()), rand(0, 26), 5),
                'title' => $this->input->post('title'),
                'categories' => $this->input->post('categories'),
                'stock' => $this->input->post('stock'),
                'year' => $this->input->post('year'),
                'cover' => $cover,
                'createdAt' => date('Y-m-d H:i:s')
            );
            $this->m_data->saveData($data, 'book');
            echo json_encode(array('code' => '201', 'message' => 'Successfully adding new book.')); 
        } catch (Exception $e) {
            echo json_encode(array('code' => '500', 'message' => 'Internal Server Error'));
        }
    }

    public function update() {
        try {
            $uuid = $this->input->post('uuid');

            $cover = NULL;
            $config['file_name'] = $this->input->post('file');
            $config['upload_path'] = './images/cover/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $cover = NULL;
            } else {
                $fileData = $this->upload->data('file_name');
                $cover = base_url().'images/cover/'.$fileData;
            }

            if ($cover == NULL) {
                $data = array(
                    'title' => $this->input->post('title'),
                    'categories' => $this->input->post('categories'),
                    'stock' => $this->input->post('stock'),
                    'year' => $this->input->post('year'),
                    'updatedAt' => date('Y-m-d H:i:s')
                );
                $this->m_data->updateData(array('uuid' => $uuid), $data, 'book');
            } else {
                $data = array(
                    'title' => $this->input->post('title'),
                    'categories' => $this->input->post('categories'),
                    'stock' => $this->input->post('stock'),
                    'year' => $this->input->post('year'),
                    'cover' => $cover,
                    'updatedAt' => date('Y-m-d H:i:s')
                );
                $this->m_data->updateData(array('uuid' => $uuid), $data, 'book');
            }
            echo json_encode(array('code' => '200', 'message' => 'Successfully updating book.'));
        } catch (Exception $e) {
            echo json_encode(array('code' => '500', 'message' => 'Internal Server Error'));
        }
    }

    public function delete() {
        try {
            $uuid = $this->input->post('uuid');
            $transaction = $this->m_data->runQuery('SELECT * FROM transaction_line WHERE book_uuid = "'.$uuid.'"')->result();
            if (empty($transaction)) {
                $this->m_data->deleteData(array('uuid' => $uuid), 'book');
                echo json_encode(array('code' => '200', 'message' => 'Successfully deleting book.'));
            } else {
                echo json_encode(array('code' => '400', 'message' => 'Failed deleting book.'));
            }
        } catch (Exception $e) {
            echo json_encode(array('code' => '500', 'message' => 'Internal Server Error'));
        }
    }
}