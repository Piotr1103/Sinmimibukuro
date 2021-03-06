<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Smb as SmbModel;
use app\validate\Smb as SmbValidate;
use think\exception\ValidateException;
use app\middleware\Auth as AuthMiddleware;
use think\facade\Db;
use app\common\Tool;

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
		$list = SmbModel::withSearch(['yid','cid'], [
			'yid' => request()->param('yid'),
			'cid' => request()->param('cid'),
		])->order('tid')->paginate([
			'list_rows' 	=> Tool::ListRows(),
			'query' 		=> request()->param(),
		]);

		$caps = Db::name('smb')->where([
			'yid' => request()->param('yid'),
			'sid' => 0,
		])->field([
			'cid',
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
		$smb = Db::name('smb');
		$tid = $smb->max('tid');						//tid是資料庫中找到的最大序數
		$yid = $smb->max('yid');						//yid是資料庫中找到的最大夜數
		$cid = $smb->where('yid', $yid)->max('cid');	//cid是資料庫中找到最大夜數的最大章數
		$sid = $smb->where('yid', $yid)->max('sid');	//sid是資料庫中找到最大夜數的最大回數
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
			validate(SmbValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '返回添加',
				//帶上page參數以便在toast可以有依據回到原先的頁面
				'url_path' => url('/smb/create', ['yid'=>$request->param('yid'),'page'=>$request->param('page')]),
			]);
		}

		$id = SmbModel::create($data)->getData('id');

		//添加完新文章後直接回到該夜最大頁面，而不再轉到提示頁面
		return redirect((string)url('/smb', ['yid'=>$request->param('yid'),'page'=>Tool::SmbLastPage((int)$request->param('yid'))]));
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
				//帶上page參數以便在toast可以有依據回到原先的頁面
				'url_path' 	=> url('/smb/'.$id.'/edit', ['yid'=>$request->param('yid'),'page'=>request()->param('page')]),
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
	 * 透過ajax改變文章狀態，不需要進入修改表單更改
	 */
	public function restat($id)
	{
		$text = Db::name('smb')->find($id);

		if($text['status']==0){
			$text['status'] = 1;
		}else{
			$text['status'] = 0;
		}

		return SmbModel::update($text) ? '更新成功' : '更新失敗';
	}

	/**
	 * 删除指定资源
	 *
	 * @param  int  $id
	 * @return \think\Response
	 */
	public function delete($id)
	{
		//為了不打亂默認主鍵，一般建議用修改方法
		return SmbModel::destroy($id) ? view('public/toast', [
			'infos' => ['恭喜，刪除成功！'],
			'url_text' => '返回閱覽',
			//帶上page參數以便在刪除完成時可以有依據回到原先的頁面
			'url_path' => url('/smb', ['yid'=>request()->param('yid'),'page'=>request()->param('page')]),
		]) : '刪除失敗！';
	}
}
