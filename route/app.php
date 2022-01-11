<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::group(function(){
	Route::get('login', 'Login/index')->middleware(function($request, \Closure $next){
		if(session('admin')){
			return redirect('/');
		}
		return $next($request);
	});
	Route::post('login_check', 'Login/check');
	Route::get('logout', 'Login/out');
});

Route::group(function(){
	Route::resource('smb', 'Smb');
	Route::resource('fkd', 'Fkd');
	Route::resource('role', 'Role');
	Route::resource('auth', 'Auth');
})->middleware(function($request, \Closure $next){
	if(!session('?admin')){
		return redirect('/');
	}

	return $next($request);
});