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
		$list = null;
		$caps = null;

		switch($kaidan){
			case 'smb':
				$list = SmbModel::withSearch(['status','cid'], [
					'status' 	=> 1,
					'cid' 		=> request()->param('cid'),
				])->paginate([
					'list_rows' => 5,
					'query' 	=> request()->param(),
				]);

				$caps = Db::name('smb')->where([
					'yid' => request()->param('yid'),
					'sid' => 0,
				])->field([
					'cid',
					'title',
				])->select();

				break;
			case 'fkd':
				$list = FkdModel::withSearch(['status','tid'], [
					'status' 	=> 1,
					'tid' 		=> request()->param('tid'),
				])->paginate([
					'list_rows' => 5,
					'query' 	=> request()->param(),
				]);

				$caps = Db::name('fkd')->where([
					'status' => 1,
				])->field([
					'tid',
					'sid',
					'title',
				])->paginate(20);

				break;
		}

		//以內容請求參數作為模板名稱
		return view($kaidan, [
			'list' 	=> $list,
			'caps' 	=> $caps,
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
