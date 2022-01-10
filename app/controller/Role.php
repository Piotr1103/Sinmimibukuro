<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Role as RoleModel;
use app\validate\Role as RoleValidate;
use think\exception\ValidateException;
use app\middleware\Auth as AuthMiddleware;
use think\facade\Db;

class Role
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
		$list = RoleModel::order('rid')->paginate([
			'list_rows' 	=> 5,
			'query' 		=> request()->param(),
		]);

		foreach($list as $k=>$obj){
			foreach($obj->auth as $au){
				$obj->auths .= $au->name.' | ';
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
		$rid = Db::name('role')->max('rid');

		return view('create', ['rid'=>$rid,]);
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
			validate(RoleValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '繼續新增',
				'url_path' => url('role/create'),
			]);
		}

		$id = RoleModel::create($data)->getData('rid');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，新增成功！'],
			'url_text' => '返回管理',
			'url_path' => url('/role'),
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
			'obj' => RoleModel::find($id),
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

		$id = RoleModel::update($data)->getData('id');

		return $id ? view('public/toast', [
			'infos' => ['恭喜，修改成功！'],
			'url_text' => '返回管理',
			'url_path' => url('/role'),
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
		//先刪除access表中的關聯管理員
		RoleModel::find($id)->auth()->detach();

		return RoleModel::destroy($id) ? '恭喜，'.$id.'刪除成功！' : '刪除失敗！';
	}
}
