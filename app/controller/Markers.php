<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Markers as MarkersModel;
use think\exception\ValidateException;
use app\validate\Markers as MarkersValidate;
use app\middleware\Auth as AuthMiddleware;

class Markers
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
		$list = MarkersModel::withSearch(['yoru'], [
			'yoru' => request()->param('yoru'),
		])->order('mid', 'asc')->paginate([
			'list_rows' => 5,
			'query' 	=> request()->param(),
		]);

		return view('index', [
			'list' => $list,
			'page' => request()->param('page'),
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
		return view('create', [
			'mid' => MarkersModel::max('mid'),
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
			validate(MarkersValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return implode("\n", $exception->getError());
		}

		$mid = MarkersModel::create($data)->getData('mid');

		return $mid ? '新增成功' : '新增失敗';
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
			'obj' => MarkersModel::find($id),
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
			validate(MarkersValidate::class)->batch(true)->check($data);
		}catch(ValidateException $exception){
			return implode("\n", $exception->getError());
		}

		return MarkersModel::update($data) ? '修改成功' : '修改失敗';
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
		return MarkersModel::destroy($id) ? '刪除成功' : '刪除失敗';
	}
}
