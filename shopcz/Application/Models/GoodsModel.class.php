<?php
//goods模型
class GoodsModel extends Model{
	//获取推荐商品
	public function getBestGoods(){
		$sql = "select * from {$this->table} where is_best = 1 
		and is_onsale = 1 order by add_time desc limit 4";
		return $this->db->getAll($sql);
	}
}