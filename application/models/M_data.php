<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_data extends CI_Model {
    public function runQuery($query) {
        return $this->db->query($query);
    }

    public function saveData($data, $table) {
        $this->db->insert($table, $data);
    }
    public function updateData($where, $data, $table) {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function deleteData($where, $table) {
        $this->db->where($where);
        $this->db->delete($table);
    }
}