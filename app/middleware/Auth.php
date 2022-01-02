<?php
declare (strict_types = 1);

namespace app\middleware;

use app\model\Auth as AuthModel;
use think\exception\ErrorException;

class Auth
{
	/**
	 * 处理请求
	 *
	 * @param \think\Request $request
	 * @param \Closure       $next
	 * @return Response
	 */
	public function handle($request, \Closure $next)
	{
		//尋找登錄者在管理員表中是否存在
		$roles = [];
		$auth = AuthModel::where('name', session('admin'))->find();

		try{
			foreach($auth->role as $k=>$obj){
				foreach(explode(',', $obj->uri) as $v){
					$roles[] = $v;
				}
			}

			if($roles[0] != 'All'){
				$uri = $request->controller().'/'.$request->action();
				if(!in_array($uri, $roles)){
					return view('public/toast', [
						'infos' => ['您不具備進行這個操作的權限'],
						'url_text' => '去首頁',
						'url_path' => url('/'),
					]);
				}
			}

			return $next($request);
		}catch(ErrorException $exception){
			return redirect('/login');
		}
	}
}
