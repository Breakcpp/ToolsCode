<?php
//商品类型控制器
class TypeController extends BaseController{
	//显示商品类型
	public function indexAction(){
		// 1. 获得所有的商品类型数据
		$typeModel = new TypeModel("goods_type");
		//$types = $typeModel->getTypes();
		//改进版, 分页输出
		// 获取当前分页，通过url的参数(page)
		$current = isset($_GET['page']) ? $_GET['page'] : 1;
		// 获取每页显示的记录数
		$pagesize = 2;
		$offset = ($current - 1) * $pagesize;
		$types = $typeModel->getPageTypes($offset,$pagesize);
		//使用分页类来获取分页信息
		//获取总的记录数
		$where = "" ; //此时条件为空
		$total = $typeModel->total($where);
		$this->library("Page");
		$page = new Page($total,$pagesize,$current,'index.php',
			             array('p'=>'admin','c'=>'type','a'=>'index'));
		$pageinfo = $page->showPage();
		// 2.展示到视图
		include CUR_VIEW_PATH . "goods_type_list.html";
	}
	//展示添加界面
	public function addAction(){
		include CUR_VIEW_PATH . "goods_type_add.html";
	}

	//添加类动作
	public function insertAction(){
		// 1. 接受表单数据
		$data['type_name'] = trim($_POST['type_name']);
		// 2. 验证及处理
		if ($data['type_name'] === ''){
			$this->jump("index.php?p=admin&c=type&a=add","商品类型名称不能为空",3);
		}
		// 载入辅助函数
		$this->helper('input');
		$data = deepspecialchars($data);
		$data = deepslashes($data);
		// 3. 调用模型完成入库，并给出提示
		$typeModel = new TypeModel('goods_type');
		if ($typeModel->insert($data)){
			$this->jump('index.php?p=admin&c=type&a=index',"添加商品类型成功",2);
		} else {
			$this->jump('index.php?p=admin&c=type&a=add',"添加商品类型失败",3);
		}
	}
}