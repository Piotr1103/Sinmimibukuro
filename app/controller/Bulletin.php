<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Bulletin as BulletinModel;
use think\exception\ValidateException;
use app\validate\Bulletin as BulletinValidate;
use app\middleware\Auth as AuthMiddleware;
use think\facade\Db;

class Bulletin
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
		$list = BulletinModel::withSearch(['status'], [
			'status' => request()->param('status'),
		])->order('bid', 'desc')->paginate(5);

		return view('index', [
			'list' => $list,
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
		//
		$bid = BulletinModel::max('bid');

		return view('create', [
			'bid' => $bid,
		]);
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
		$data = $request->param();

		try{
			validate(BulletinValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' 	=> $exception->getError(),
				'url_text' 	=> '繼續新增',
				'url_path' 	=> url('/bulletin/create', ['page'=>$request->param('page')]),
			]);
		}

		$id = BulletinModel::create($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' 	=> ['恭喜，新增成功！'],
			'url_text' 	=> '返回佈告管理',
			'url_path' 	=> url('/bulletin', ['page'=>$request->param('page'),])
		]) : '新增失敗！';
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
			'obj' => BulletinModel::find($id),
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
			validate(BulletinValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' 	=> $exception->getError(),
				'url_text' 	=> '繼續修改',
				'url_path' 	=> url('/bulletin/'.$id.'/edit', ['page'=>$request->param('page')]),
			]);
		}

		$id = BulletinModel::update($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' 	=> ['恭喜，修改成功！'],
			'url_text' 	=> '返回佈告管理',
			'url_path' 	=> url('/bulletin', ['page'=>$request->param('page'),]),
		]) : '修改失敗';
	}

	/**
	 * 透過ajax改變文章狀態，不需要進入修改表單更改
	 */
	public function restat($id)
	{
		$text = Db::name('bulletin')->find($id);

		if($text['status']==0){
			$text['status'] = 1;
		}else{
			$text['status'] = 0;
		}

		return BulletinModel::update($text) ? '更新成功' : '更新失敗';
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
		return BulletinModel::destroy($id) ? '恭喜，'.$id.'號佈告刪除成功！' : '刪除失敗！';
	}
}
