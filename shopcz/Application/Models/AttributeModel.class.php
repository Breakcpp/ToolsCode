<?php
//属性模型
class AttributeModel extends Model{

	// 获取所有的商品属性
	public function getAttrs($type_id){
		// $sql = "SELECT * FROM {$this->table} WHERE type_id = $type_id";
		$sql = "select a.*,b.type_name from cz_attribute as a inner join 
		        cz_goods_type as b on a.type_id = b.type_id 
		        where a.type_id = $type_id";
		return $this->db->getAll($sql);
	}

	// 分页获取指定类型下的属性
	public function getPageAttrs($type_id,$offset,$pagesize){
		$sql = "select a.*,b.type_name from cz_attribute as a inner join 
		        cz_goods_type as b on a.type_id = b.type_id 
		        where a.type_id = $type_id
		        limit $offset,$pagesize";
		return $this->db->getAll($sql);
	}

	//获取指定类型下的属性，并构成表单
	public function getAttrsForm($type_id){
		// 获取该类型下所有的属性
		$sql = "select * from {$this->table} where type_id = $type_id";
		$attrs = $this->db->getAll($sql);
		$res = "<table width='100%' id='attrTable'>";
		$res .= "<tbody>";
		foreach ($attrs as $attr){
			$res .= "<tr>";
			$res .= "<td class='label'>{$attr['attr_name']}</td>";
			$res .= "<td>";
			$res .= "<input type='hidden' name='attr_id_list[]' value='".$attr['attr_id']."'>";
			//根据attr_input_type不同的值，生成不同的表单元素
			switch ($attr['attr_input_type']){
				case 0: #文本框
					$res .= "<input name='attr_value_list[]' type='text' size='40'>";
					break;
				case 1: #下拉列表
					$res .= "<select name='attr_value_list[]'>";
					$res .= "<option value=''>请选择...</option>";
					$opts = explode(PHP_EOL, $attr['attr_value']);
					foreach ($opts as $opt){
						$res .= "<option value='$opt'>$opt</option>";
					}
					$res .= "</select>";
					break;
				case 2: #多行文本
					$res .= "<textarea name='attr_value_list[]'></textarea>";
					break;
			}
			$res .= "<input type='hidden' name='attr_price_list[]' value='0'>";
			$res .= "</td>";
			$res .= "</tr>";
		}
		$res .= "</tbody>";
		$res .= "</table>";
		return $res;

		/*
		<tr>
								<td class="label">上市日期</td>
								<td>
									<input type="hidden" name="attr_id_list[]" value="172">
										<select name="attr_value_list[]">
											<option value="">请选择...</option>
											<option value="2008年01月">2008年01月</option>
											<option value="2008年02月">2008年02月</option>
											<option value="2008年03月">2008年03月</option>
											<option value="2008年04月">2008年04月</option>
											<option value="2008年05月">2008年05月</option>
											<option value="2008年06月">2008年06月</option>
											<option value="2008年07月">2008年07月</option>
											<option value="2008年08月">2008年08月</option>
											<option value="2008年09月">2008年09月</option>
											<option value="2008年10月" selected="selected">2008年10月</option>
											<option value="2008年11月">2008年11月</option>
											<option value="2008年12月">2008年12月</option>
											<option value="2007年01月">2007年01月</option>
											<option value="2007年02月">2007年02月</option>
											<option value="2007年03月">2007年03月</option>
											<option value="2007年04月">2007年04月</option>
											<option value="2007年05月">2007年05月</option>
											<option value="2007年06月">2007年06月</option>
											<option value="2007年07月">2007年07月</option>
											<option value="2007年08月">2007年08月</option>
											<option value="2007年09月">2007年09月</option>
											<option value="2007年10月">2007年10月</option>
											<option value="2007年11月">2007年11月</option>
											<option value="2007年12月">2007年12月</option>
										</select>  
									<input type="hidden" name="attr_price_list[]" value="0">
								</td>
			</tr>
			<tr>
				<td class="label">存储卡格式</td>
				<td>	
					<input type="hidden" name="attr_id_list[]" value="180">
					<input name="attr_value_list[]" type="text" value="MicroSD" size="40">  
					<input type="hidden" name="attr_price_list[]" value="0">
				</td>
			</tr>
		*/
	}
}