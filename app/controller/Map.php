<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use think\facade\Db;

class Map
{
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index()
	{
		//
		return view('map');
	}

	public function markers()
	{
		return json(Db::name('markers')->select());
	}
}
