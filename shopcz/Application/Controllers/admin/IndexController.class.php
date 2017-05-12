<?php
//后台首页控制器
class IndexController extends BaseController{
	public function indexAction(){
		//echo "admin...index";
		include CUR_VIEW_PATH . "index.html";
	}
	public function topAction(){
		include CUR_VIEW_PATH . "top.html";
	}
	public function menuAction(){
		include CUR_VIEW_PATH . "menu.html";
	}
	public function dragAction(){
		include CUR_VIEW_PATH . "drag.html";
	}
	public function mainAction(){
		include CUR_VIEW_PATH . "main.html";
		//载入辅助函数
		/*
		$this->helper("input");
		f1();
		//实例化admin模型
		$adminModel = new AdminModel("admin"); //传递不要前缀表名
		$admins = $adminModel->test();
		echo "<pre>";
		var_dump($admins);
		echo "</pre>";
		*/
	}
}