<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Smb as SmbModel;
use app\validate\Smb as SmbValidate;
use think\exception\ValidateException;
use app\middleware\Auth as AuthMiddleware;
use think\facade\Db;

class Smb
{
	protected $middleware = [AuthMiddleware::class];
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
		])->order('tid')->paginate([
			'list_rows' 	=> 5,
			'query' 		=> request()->param(),
		]);

		return view('index', [
			'list' 	=> $list,
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
		$tid = Db::name('smb')->max('tid');
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
			//帶上page參數以便在插入完成時可以有依據回到原先的頁面
			'url_path' 	=> url('/smb', ['yid'=>request()->param('yid'),'page'=>request()->param('page')]),
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
		//修改單一文章內容，藉由默認主鍵搜索
		return view('edit', [
			'obj' => SmbModel::find($id),
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
			validate(SmbValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' 	=> $exception->getError(),
				'url_text' 	=> '繼續修改',
				'url_path' 	=> url('/smb/'.$id.'/edit'),
			]);
		}

		$id = SmbModel::update($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，修改成功！'],
			'url_text' => '返回閱覽',
			//帶上page參數以便在修改完成時可以有依據回到原先的頁面
			'url_path' => url('/smb', ['yid'=>$request->param('yid'),'page'=>request()->param('page')]),
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
