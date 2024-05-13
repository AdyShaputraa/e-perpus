<?php defined('BASEPATH') or exit('No direct script access allowed');
class M_pagination extends CI_Model {
    public function getRows($POST, $allowedField, $allowedFieldSearch, $orderingField, $table, $selectedField = NULL, $tableJoin = array(), $where = array()) {
		$this->_get_datatables_query($POST, $allowedField, $allowedFieldSearch, $orderingField, $table, $selectedField, $tableJoin, $where);
        if ($POST['length'] != -1) $this->db->limit($POST['length'], $POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

    public function countAll($query) {
		$this->db->query($query);
		return $this->db->count_all_results();
	}

	public function countFiltered($POST, $allowedField, $allowedFieldSearch, $orderingField, $table, $selectedField = NULL, $tableJoin = array(), $where = array()) {
		$this->_get_datatables_query($POST, $allowedField, $allowedFieldSearch, $orderingField, $table, $selectedField, $tableJoin, $where);
		return $this->db->get()->num_rows();
	}

	private function _get_datatables_query($POST, $allowedField, $allowedFieldSearch, $orderingField, $table, $selectedField = NULL, $tableJoin = array(), $where = array()) {
		$this->db->select($selectedField);
		$this->db->from($table);
		if (!empty($tableJoin)) {
			for ($i=0; $i < COUNT($tableJoin); $i++) { 
				$this->db->join($tableJoin[$i]['table'], $tableJoin[$i]['equals'], $tableJoin[$i]['options']);
			}
		}

		if (!empty($where)) {
			$this->db->group_start();
			for ($index=0; $index < COUNT($where); $index++) {
				if ($where[$index]['parameters'] == 'query') {
					$this->db->where($where[$index]['value']);
				} else if ($where[$index]['parameters'] == 'and') {
					$this->db->where($where[$index]['field'], $where[$index]['value']);
				} else if ($where[$index]['parameters'] == 'or') {
					$this->db->or_where($where[$index]['field'], $where[$index]['value']);
				} else if ($where[$index]['parameters'] == 'in') {
					$this->db->where_in($where[$index]['field'], $where[$index]['value']);
				} else if ($where[$index]['parameters'] == 'or_in') {
					$this->db->or_where_in($where[$index]['field'], $where[$index]['value']);
				} else if ($where[$index]['parameters'] == 'not_in') {
					$this->db->where_not_in($where[$index]['field'], $where[$index]['value']);
				} else if ($where[$index]['parameters'] == 'or_not_in') {
					$this->db->or_where_not_in($where[$index]['field'], $where[$index]['value']);
				}
			}
			$this->db->group_end();
		}

		$i = 0;
        foreach($allowedFieldSearch as $item) {
			if ($POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $POST['search']['value']);
				} else {
					$this->db->or_like($item, $POST['search']['value']);
				}

				if (count($allowedFieldSearch) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
		}

		if (isset($POST['order'])) {
			$this->db->order_by($allowedField[$POST['order']['0']['column']], $POST['order']['0']['dir']);
		} else if (isset($orderingField)) {
			$orderKey = $orderingField;
			$this->db->order_by(key($orderKey), $orderKey[key($orderKey)]);
		}
	}
}