<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Smb as SmbModel;

class Smb
{
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index()
	{
		//
		$list = SmbModel::withSearch(['yid'], [
			'yid' => request()->param('yid'),
		])->paginate([
			'list_rows' 	=> 5,
			'query' 		=> request()->param(),
		]);

		return view('index', [
			'list' => $list,
		]);
	}

	/**
	 * 显示创建资源表单页.
	 *
	 * @return \think\Response
	 */
	public function create()
	{
		//叫出新增新耳袋文章的頁面
		return view('create');
	}

	/**
	 * 保存新建的资源
	 *
	 * @param  \think\Request  $request
	 * @return \think\Response
	 */
	public function save(Request $request)
	{
		//
	}

	/**
	 * 显示指定的资源
	 *
	 * @param  int  $id
	 * @return \think\Response
	 */
	public function read($id)
	{
		//
	}

	/**
	 * 显示编辑资源表单页.
	 *
	 * @param  int  $id
	 * @return \think\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * 保存更新的资源
	 *
	 * @param  \think\Request  $request
	 * @param  int  $id
	 * @return \think\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * 删除指定资源
	 *
	 * @param  int  $id
	 * @return \think\Response
	 */
	public function delete($id)
	{
		//
	}
}
