<?php 
$db['host']="localhost";//数据库主机
$db['user']="root";//数据库用户名
$db['password']="";//数据库密码
$db['database']="";//数据库名
$db['pre']="madfan_";//数据库表
date_default_timezone_set("PRC");
global $db;
	$link = mysqli_connect(   
        	      $db['host'], 
       	  	      $db['user'],
         	      $db['password'], 
          	      $db['database']);          
    if (!$link) {   
     	 	 printf("无法连接数据库. 错误信息为: %s ", mysqli_connect_error());   
      	 	 exit;   
    }else{
			 mysqli_set_charset ($link,'utf8');	
	}
	/*数据库操作模块*/
	function sql($action,$table,$values,$if){
		global $link;
		$rows="";
		/*查询数据*/
		if($action=="s"){
			$sql_str="SELECT ".$values." FROM ".$table." ".$if;
		}/*查询数据影响行数*/
		if($action=="frow"){
			$sql_str="SELECT ".$values." FROM ".$table." ".$if;
		}
		/*删除数据*/
		elseif($action=="d"){
			$sql_str="DELETE FROM ".$table." ".$if;
		}
		/*增加数据*/
		elseif($action=="i"){
			$kv=get_key_value($values);
			$keys=$kv[0];
			$values=$kv[1];
			$sql_str="INSERT INTO ".$table." (".$keys.") VALUES (".$values.")";
		}
		/*增加数据返回id*/
		elseif($action=="addid"){
			$kv=get_key_value($values);
			$keys=$kv[0];
			$values=$kv[1];
			$sql_str="INSERT INTO ".$table." (".$keys.") VALUES (".$values.")";
		}
		/*修改数据*/
		elseif($action=="u"){
			$set_str=array();
			$kv=get_key_value($values);
			$keys=explode(",",$kv[0]);
			//$values=explode(",",$kv[1]);
			foreach ($keys as $key){
				if(stristr($values[$key],"///")){//通过"///"规定提交结果为运算式，不加引号；
					$set_str[]=$key."=".str_replace("///","",$values[$key]);	
				}else{
					$set_str[]=$key."='".$values[$key]."'";	
				}
			}
			$set_str=implode(",",$set_str);
			$sql_str="UPDATE ".$table." SET ".$set_str." ".$if;
		}
		//echo $sql_str."\n";
		$result = mysqli_query($link, $sql_str);
		if($result=='0'){
			echo mysqli_error($link);
		}
		if ($action=="addid") {
			$result=mysqli_insert_id($link);
		}elseif ($action=='frow'){
			$result=mysqli_num_rows($result);
		}
		
		//$action=="s"&&$result?mysqli_free_result($result):null;//释放查询结果内存
		//mysqli_close($link); //关闭数据库连接
		/*输出结果 成功：非Select语句为True，Select直接返回结果;失败:返回False*/
		if($action=="s"&&$result){
			$num_results = mysqli_num_rows($result);//返回行数
			while($row = mysqli_fetch_assoc($result)){
				/*如果只有一行，直接返回一维数组
				if($num_results==1)
				return $row;
				如果有多行，累加进二维数组，并返回
				else*/
				$rows[]=$row;
			} 
			$action=="s"&&$result?mysqli_free_result($result):null;
			return $rows;
		}else{
			return $result;
		}
	}
	/*Post信息键名和键值分开存储*/
	function get_key_value($post){
		$keys=array();
		$values=array();
  	 	foreach($post as $k=>$v)
   		{
	   		$keys[]=$k;
			$values[]="'".$v."'";
   		}
   		$keys=implode(",",$keys);
   		$values=implode(",",$values);
   		return array($keys,$values);
	}
	function firstrow($res){
		if($res){
		 foreach ($res as $info){
			 return $info;
			 exit();
			 }
		  }
		}
		function gv($bian,$nei){
			if(isset($bian[$nei])){
				return $bian[$nei];
				}else{
					return '';
					}
			}
			function zt($i){
				if($i=='1'){
					return "确认中";
				}elseif($i=='9'){
					return "已确认";
				}elseif($i=='10'){
					return "假单";
				}elseif($i=='11'){
					return "联系不上";
				}elseif($i=='2'){
					return "已发货";
				}elseif($i=='3'){
					return "未返款";
				}elseif($i=='4'){
					return "申请退货";
				}elseif($i=='5'){
					return "同意退货";
				}elseif($i=='6'){
					return "退货完成";
				}elseif($i=='7'){
					return "拒收";
				}elseif($i=='0'){
					return "未付款";
				}elseif($i=='8'){
					return "已返款";
				}elseif($i=='12'){
					return "已付款";
				}
			}