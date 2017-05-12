<?php
// 商品类型模型
class TypeModel extends Model{
	//获取所有的商品类型
	public function getTypes(){
		$sql = "SELECT * FROM {$this->table} ORDER BY type_id";
		return $this->db->getAll($sql);
	}

	/*
	//分页获取商品类型数据
	public function getPageTypes($offset,$pagesize){
		$sql = "SELECT * FROM {$this->table} ORDER BY type_id 
		        LIMIT $offset,$pagesize";
		return $this->db->getAll($sql);
	}
	*/

	//分页获取商品类型数据 改进版
	public function getPageTypes($offset,$pagesize){
		$sql = "SELECT a.*,COUNT(b.attr_name) AS num FROM {$this->table} AS a 
		        LEFT JOIN cz_attribute AS b
				ON a.type_id = b.type_id GROUP BY a.type_id ORDER BY type_id 
		        LIMIT $offset,$pagesize";
		return $this->db->getAll($sql);
	}
}