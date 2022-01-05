<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Smb as SmbModel;
use app\model\Fkd as FkdModel;
use think\facade\Db;

class Reader
{
	/**
	 * 显示资源列表
	 *
	 * @return \think\Response
	 */
	public function index()
	{
		//先判斷讀者想要的內容,選取對應模型和模板
		$kaidan = request()->param('kaidan');
		//防止沒有夜數導致目錄列表為空的情況
		$yid = request()->param('yid') ? request()->param('yid') : 1;
		//article文章列表
		$list = null;
		//aside目錄列表
		$caps = null;

		switch($kaidan){
			case 'smb':
				$list = SmbModel::withSearch(['status','cid'], [
					'status' 	=> 1,
					'cid' 		=> request()->param('cid'),	//選擇從屬於同一章的所有文章
				])->paginate([
					'list_rows' => 5,
					'query' 	=> request()->param(),
				]);

				$caps = Db::name('smb')->where([
					'yid' => $yid,
					'sid' => 0,
				])->field([
					'cid',		//用以請求所有屬於該章的章節
					'title',
				])->select();

				break;
			case 'fkd':
				$list = FkdModel::withSearch(['status','tid'], [
					'status' 	=> 1,
					'tid' 		=> request()->param('tid'),	//選擇該單一文章
				])->paginate([
					'list_rows' => 5,
					'query' 	=> request()->param(),
				]);

				$caps = Db::name('fkd')->where([
					'status' => 1,
				])->field([
					'tid',		//用以形成文號請求
					'sid',		//判斷是否為章
					'title',
				])->paginate(20);

				break;
		}

		//以內容請求參數作為模板名稱
		return view($kaidan, [
			'list' 	=> $list,
			'caps' 	=> $caps,
			'yid' 	=> $yid,	//沒有指定夜數時默認為1
			'page' 	=> request()->param('page'),
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
