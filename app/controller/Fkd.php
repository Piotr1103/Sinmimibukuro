<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Fkd as FkdModel;
use app\validate\Fkd as FkdValidate;
use think\exception\ValidateException;
use think\facade\Db;

class Fkd
{
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index()
	{
		//
		$list = FkdModel::order('tid')->paginate(5);

		$caps = Db::name('fkd')->field([
			'tid',
			'sid',
			'status',
			'title',
		])->paginate(20);

		return view('index', [
			'list' 	=> $list,
			'caps' 	=> $caps,
			'page' 	=> request()->param('page'),	//將page參數傳到下一頁或其他頁面
		]);
	}

	/**
	 * 显示创建资源表单页.
	 *
	 * @return \think\Response
	 */
	public function create()
	{
		//tid是資料庫中找到的最大序數
		$tid = Db::name('fkd')->max('tid');
		return view('create', ['tid'=>$tid]);
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
		$data = request()->param();

		try{
			validate(FkdValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '返回添加',
				//帶上page參數以便在toast可以有依據回到原先的頁面
				'url_path' => url('/fkd/create', ['page'=>request()->param('page')]),
			]);
		}

		$id = FkdModel::create($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，插入成功！'],
			'url_text' => '返回閱覽',
			'url_path' => url('/fkd', ['page'=>request()->param('page')]),
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
		return view('edit', [
			'obj' => FkdModel::find($id),
		]);
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
		$data = $request->param();

		try{
			validate(FkdValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' 	=> $exception->getError(),
				'url_text' 	=> '繼續修改',
				//帶上page參數以便在toast可以有依據回到原先的頁面
				'url_path' 	=> url('/fkd/'.$id.'/edit', ['page'=>request()->param('page')]),
			]);
		}

		$id = FkdModel::update($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，修改成功！'],
			'url_text' => '返回閱覽',
			'url_path' => url('/fkd', ['page'=>request()->param('page')]),
		]) : '修改失敗！';
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
