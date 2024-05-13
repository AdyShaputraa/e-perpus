<?php defined('BASEPATH') or exit('No direct script access allowed');
use Ramsey\Uuid\Uuid;

class Transaction extends CI_Controller {
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
        $this->load->view('transaction/index');
    }

    public function get() {
        $rows = $this->m_pagination->getRows(
            $_POST,
            array(null, 'uuid', 'name', 'address', 'contact', 'start_date', 'exp_date', 'createdAt', 'updatedAt'),
            array('name', 'address', 'contact'),
            array('createdAt' => 'ASC'),
            'transaction_header',
            'uuid, name, address, contact, start_date, exp_date, createdAt, updatedAt',
        );

        $data = array();
        $c = $_POST['start'];
        foreach ($rows as $i) {
            $c++;
            $row = array(
                'uuid' => $i->uuid,
                'number' => $c,
                'name' => $i->name,
                'address' => $i->address,
                'contact' => $i->contact,
                'start_date' => $i->start_date,
                'exp_date' => $i->exp_date,
                'createdAt' => $i->createdAt,
                'updatedAt' => $i->updatedAt
            );
            $data[] = $row;
        }

        $result = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pagination->countAll('SELECT uuid, name, address, contact, start_date, exp_date, createdAt, updatedAt
                FROM transaction_header 
                ORDER BY createdAt ASC'),
            "recordsFiltered" => $this->m_pagination->countFiltered(
                $_POST,
                array(null, 'uuid', 'name', 'address', 'contact', 'start_date', 'exp_date', 'createdAt', 'updatedAt'),
                array('name', 'address', 'contact'),
                array('createdAt' => 'ASC'),
                'transaction_header',
                'uuid, name, address, contact, start_date, exp_date, createdAt, updatedAt'
            ),
            "data" => $data
        );
        echo json_encode($result);
    }

    public function form() {
        $data = array(
            'book' => $this->m_data->runQuery('SELECT * FROM book ORDER BY createdAt ASC')->result()
        );
        $this->load->view('transaction/form', $data);
    }

    public function create() {
        try {
            $uuid = Uuid::uuid4()->toString();
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $contact = $this->input->post('contact');
            $start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
            $exp_date = date('Y-m-d', strtotime($this->input->post('exp_date')));

            $checkHeader = $this->m_data->runQuery('SELECT *
                FROM transaction_header
                WHERE name = "'.$name.'" AND
                address = "'.$address.'" AND
                contact = "'.$contact.'" AND
                start_date = "'.$start_date.'" AND
                exp_date = "'.$exp_date.'"')->result();

            if (empty($checkHeader)) {
                $header = array(
                    'uuid' => $uuid,
                    'name' => $name,
                    'address' => $address,
                    'contact' => $contact,
                    'start_date' => $start_date,
                    'exp_date' => $exp_date,
                    'createdAt' => date('Y-m-d h:i:s')
                );
                $this->m_data->saveData($header, 'transaction_header');
            } else {
                foreach ($checkHeader as $value) {
                    $uuid = $value->uuid;
                }
            }

            $book = $this->input->post('book');
            $qty = $this->input->post('qty');

            $line = array(
                'uuid' => Uuid::uuid4()->toString(),
                'transaction_header_uuid' => $uuid,
                'book_uuid' => $book,
                'qty' => $qty,
                'createdAt' => date('Y-m-d h:i:s')
            );
            $this->m_data->saveData($line, 'transaction_line');
            echo json_encode(array('code' => '201', 'message' => 'Successfully adding to list.', 'uuid' => $uuid)); 
        } catch (Exception $e) {
            echo json_encode(array('code' => '500', 'message' => 'Internal Server Error'));
        }
    }

    public function getBookID() {
        $uuid = $this->input->post('uuid');
        $getBook = $this->m_data->runQuery('SELECT * FROM book WHERE uuid = "'.$uuid.'"')->result();
        echo json_encode($getBook);
    }

    public function getBookList() {
        $where = array();
        $uuid = $this->input->post('header_uuid');
        if (!empty($uuid)) {
            array_push($where, array(
                'parameters' => 'and',
                'field' => 'transaction_header_uuid <',
                'value' => $uuid,
            ));
        }
        $rows = $this->m_pagination->getRows(
            $_POST,
            array(null, 'transaction_line.uuid as transaction_line_uuid', 'transaction_line.qty as transaction_line_qty',
            'book.uuid as book_uuid', 'book.title as book_name'),
            array('book.title as book_name'),
            array('transaction_line.createdAt' => 'ASC'),
            'transaction_line',
            'transaction_line.uuid as transaction_line_uuid, transaction_line.qty as transaction_line_qty,
            book.uuid as book_uuid, book.title as book_name',
            array(
                array(
                    'table' => 'book',
                    'equals' => 'book.uuid = transaction_line.book_uuid',
                    'options' => 'LEFT',
                ),
            ),
            $where
        );

        $data = array();
        $c = $_POST['start'];
        foreach ($rows as $i) {
            $c++;
            $row = array(
                'transaction_line_uuid' => $i->transaction_line_uuid,
                'number' => $c,
                'transaction_line_qty' => $i->transaction_line_qty,
                'book_uuid' => $i->book_uuid,
                'book_name' => $i->book_name,
            );
            $data[] = $row;
        }

        $result = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_pagination->countAll('SELECT transaction_line.uuid as transaction_line_uuid, transaction_line.qty as transaction_line_qty,
                book.uuid as book_uuid, book.title as book_name
                FROM transaction_line
                LEFT JOIN book ON book.uuid = transaction_line.book_uuid
                ORDER BY transaction_line.createdAt ASC'),
            "recordsFiltered" => $this->m_pagination->countFiltered(
                $_POST,
                array(null, 'transaction_line.uuid as transaction_line_uuid', 'transaction_line.qty as transaction_line_qty',
                'book.uuid as book_uuid', 'book.title as book_name'),
                array('book.title as book_name'),
                array('transaction_line.createdAt' => 'ASC'),
                'transaction_line',
                'transaction_line.uuid as transaction_line_uuid, transaction_line.qty as transaction_line_qty,
                book.uuid as book_uuid, book.title as book_name',
                array(
                    array(
                        'table' => 'book',
                        'equals' => 'book.uuid = transaction_line.book_uuid',
                        'options' => 'LEFT',
                    ),
                ),
                $where
            ),
            "data" => $data
        );
        echo json_encode($result);
    }
}