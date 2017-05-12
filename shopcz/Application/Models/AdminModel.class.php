<?php
//Admin模型
class AdminModel extends Model{
	// 验证用户是否合法
	public function checkUser($username,$password){
		$password = md5($password);
		$sql = "SELECT * FROM {$this->table} 
			    WHERE admin_name = '$username' AND password = '$password' 
			    LIMIT 1";
	    return $this->db->getRow($sql);
	}

	public function test(){
		$sql = "SELECT * FROM {$this->table}";
		return $this->db->getAll($sql);
	}
}