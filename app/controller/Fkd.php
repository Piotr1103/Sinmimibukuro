<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Fkd as FkdModel;
use app\validate\Fkd as FkdValidate;
use think\exception\ValidateException;
use app\middleware\Auth as AuthMiddleware;
use think\facade\Db;

class Fkd
{
	protected $middleware = [AuthMiddleWare::class];
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index()
	{
		//
		$list = FkdModel::withSearch(['tid'], [
			'tid' => request()->param('tid'),
		])->order('tid')->paginate(5);

		$caps = Db::name('fkd')->field([
			'tid',
			'sid',
			'status',
			'title',
		])->select();

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
		//
		$fkd = Db::name('fkd');
		$tid = $fkd->max('tid');						//tid是資料庫中找到的最大序數
		$yid = $fkd->max('yid');						//yid是資料庫中找到的最大夜數
		$cid = $fkd->where('yid', $yid)->max('cid');	//tid是資料庫中找到最大夜數的最大章數
		$sid = $fkd->where('yid', $yid)->max('sid');	//sid是資料庫中找到最大夜數的最大回數
		return view('create', [
			'tid' => $tid,
			'yid' => $yid,
			'cid' => $cid,
			'sid' => $sid,
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
			validate(FkdValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '返回添加',
				//帶上page參數以便在toast可以有依據回到原先的頁面
				'url_path' => url('/fkd/create', ['page'=>$request->param('page')]),
			]);
		}

		$id = FkdModel::create($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，插入成功！'],
			'url_text' => '返回閱覽',
			'url_path' => url('/fkd', ['page'=>$request->param('page')]),
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
				'url_path' 	=> url('/fkd/'.$id.'/edit', ['page'=>$request->param('page')]),
			]);
		}

		$id = FkdModel::update($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，修改成功！'],
			'url_text' => '返回閱覽',
			'url_path' => url('/fkd', ['page'=>$request->param('page')]),
		]) : '修改失敗！';
	}

	/**
	 * 透過ajax改變文章狀態，不需要進入修改表單更改
	 */
	public function restat($id)
	{
		$text = Db::name('fkd')->find($id);

		if($text['status']==0){
			$text['status'] = 1;
		}else{
			$text['status'] = 0;
		}

		return FkdModel::update($text) ? '更新成功' : '更新失敗';
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
		return FkdModel::destroy($id) ? view('public/toast', [
			'infos' => ['恭喜，刪除成功！'],
			'url_text' => '返回閱覽',
			'url_path' => url('/fkd', ['yid'=>request()->param('yid'),'page'=>request()->param('page')]),
		]) : '刪除失敗！';
	}
}
