<?php
namespace app\controller;

use app\BaseController;
use app\model\About as AboutModel;
use app\model\Bulletin as BulletinModel;
use app\model\Carousel as CarouselModel;

class Index extends BaseController
{
	public function index()
	{
		//輪播使用的圖片
		$carousel = CarouselModel::where('status', 1)->order('cid', 'desc')->limit(10)->select();
		//摺疊菜單的內容
		$about = AboutModel::order('aid')->select();
		//公告內容的排序方式，未來將製作按鈕來改變排序方式
		$order = request()->param('order') ? request()->param('order') : 'desc';
		//公告內容
		$cont = BulletinModel::where('status', 1)->order('bid', $order)->paginate(5);

		return view('index', [
			'carousel' => $carousel,
			'about' => $about,
			'cont' => $cont,
		]); 
	}
}
