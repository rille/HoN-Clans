<?

class Base_model extends CI_Model {
	
	function getAll() {
		$query = $this->db->get('test');
		
		if($query->num_rows() > 0) {			
			foreach ($query->result() as $row)
			{
			    $data[] = $row;
			}
			return $data;
		}
		
	}
}

?>