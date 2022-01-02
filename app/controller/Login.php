<?php
namespace app\controller;

use think\Request;
use think\facade\Validate;

class Login
{
	public function index()
	{
		return view('index');
	}

	public function out()
	{
		session('admin', null);
	}

	public function check(Request $request)
	{
		$errors = [];
		$data = $request->param();

		$validate = Validate::rule([
			'name|用戶名' => 'unique:auth,name^password',
		]);

		$result = $validate->batch(true)->check([
			'name' 		=> $data['name'],
			'password' 	=> sha1($data['password']),
		]);

		if(!captcha_check($data['captcha'])){
			$errors[] = '驗證碼錯誤！';
		}

		if($result){
			$errors[] = '帳戶或密碼不匹配';
		}

		if(!empty($errors)){
			return redirect('/login');
		}else{
			session('admin', $data['name']);
			return redirect('/');
		}
	}
}