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

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::resource('smb', 'Smb');

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
	Route::get('create_smb', 'Smb/create');
})->middleware(function($request, \Closure $next){
	if(!session('?admin')){
		return redirect('/login');
	}

	return $next($request);
});