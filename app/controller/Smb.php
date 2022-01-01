<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Smb as SmbModel;
use app\validate\Smb as SmbValidate;
use think\exception\ValidateException;

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
		//插入資料庫
		$data = request()->param();

		try{
			validate(SmbValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '返回添加',
				'url_path' => url('/smb/create'),
			]);
		}

		$id = SmbModel::create($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' 	=> ['恭喜，插入成功！'],
			'url_text' 	=> '返回閱覽',
			'url_path' 	=> url('/smb'),
		]) : '插入失敗！';
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
