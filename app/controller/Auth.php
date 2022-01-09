<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Auth as AuthModel;
use app\model\Role as RoleModel;
use think\exception\ValidateException;
use app\middleware\Auth as AuthMiddleware;
use think\facade\Db;


class Auth
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
		$list = AuthModel::with('role')->paginate(5);

		foreach($list as $k=>$obj){
			foreach($obj->role as $r){
				$obj->roles .= $r->type.' | ';
			}
		}

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
		//
		$auid = Db::name('auth')->max('auid');
		$roles = RoleModel::order('rid')->select();

		return view('create', [
			'auid' 		=> $auid,
			'roles' 	=> $roles,
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

		$data['password'] = sha1($data['password']);
		$auid = AuthModel::create($data)->getData('auid');
		AuthModel::find($auid)->role()->saveAll($data['role']);

		return $auid ? view('public/toast', [
			'infos' 	=> ['恭喜，新增成功！'],
			'url_text' 	=> '返回權限列表',
			'url_path' 	=> url('/auth'),
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
