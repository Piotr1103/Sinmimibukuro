<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Auth as AuthModel;
use app\model\Role as RoleModel;
use think\exception\ValidateException;
use app\validate\Auth as AuthValidate;
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
		$list = AuthModel::with('role')->order('auid')->paginate(5);

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

		try{
			validate(AuthValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '返回新增',
				'url_path' => url('/auth/create'),
			]);
		}

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
		$auth = AuthModel::find($id);
		$authRoles = $auth->role()->select();
		$roles = [];

		foreach($authRoles as $r){
			array_push($roles, $r['pivot']['rid']);
		}

		return view('edit', [
			'auth' => $auth,
			'roles' => $roles,
			'list' => RoleModel::order('rid')->select(),
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
			validate(AuthValidate::class)->scene('edit')->batch(true)->check($data);
		}catch(ValidateException $exception){
			return view('public/toast', [
				'infos' => $exception->getError(),
				'url_text' => '返回修改',
				'url_path' => url('/auth/'.$id.'/edit'),
			]);
		}

		//新密碼欄位若不為空，代表要修改密碼
		if(!empty($data['newpassword'])){
			$data['password'] = sha1($data['newpassword']);
		}
		//改變權限欄位若有勾選，則先刪除access表中全部舊有的權限資料，然後再加上新資料
		if(!empty($data['change'])){
			$auth = AuthModel::find($id);
			$auth->role()->detach();
			$auth->role()->attach($data['role']);
		}

		return AuthModel::update($data) ? view('public/toast', [
			'infos' => ['恭喜，修改成功！'],
			'url_text' => '返回權限列表',
			'url_path' => url('/auth'),
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
		//先刪除access表中的關聯角色
		AuthModel::find($id)->role()->detach();

		return AuthModel::destroy($id) ? '恭喜，'.$id.'號管理員刪除成功！' : '刪除失敗！';
	}
}