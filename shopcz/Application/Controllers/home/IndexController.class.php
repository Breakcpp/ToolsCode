<?php
//首页控制器
class IndexController extends Controller{
	//载入首页面
	public function indexAction(){
		$categoryModel = new CategoryModel("category");
		$cats = $categoryModel->frontCats();
		$goodsModel = new GoodsModel("goods");
		$bestGoods = $goodsModel->getBestGoods();
		// echo "<pre>";
		// var_dump($cats);
		include CUR_VIEW_PATH . "index.html";
	}
}