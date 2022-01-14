<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Auth extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名' =>  ['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'auid' 			=> 'require|number|max:3|unique:auth',
		'name' 			=> 'require|chsDash|max:20|unique:auth',
		'password' 		=> 'require|min:6|max:20',
		'passwordnot' 	=> 'require|confirm:password',
		'role' 			=> 'require',
		'__token__' 	=> 'require|token',
		//edit場景下才進行驗證
		'newpasswordnot' 	=> 'min:6|requireWith:newpassword|confirm:newpassword',
	];

	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名' =>  '错误信息'
	 *
	 * @var array
	 */
	protected $message = [
		'auid.require' 			=> '必須填寫管理序號',
		'auid.number' 			=> '管理序號必須是數字',
		'auid.max' 				=> '管理序號最多3位',
		'auid.unique' 			=> '這個管理序號已經存在',
		'name.require' 			=> '必須填寫管理名稱',
		'name.chsDash' 			=> '管理名稱只能用漢字、英數、下劃線和破折號',
		'name.max' 				=> '管理名稱最多20位',
		'name.unique' 			=> '這個管理名稱已經存在',
		'password.require' 		=> '管理密碼必須填寫',
		'password.min' 			=> '管理密碼最少6位',
		'password.max' 			=> '管理密碼最多20位',
		'passwordnot.require' 	=> '未確認密碼',
		'passwordnot.confirm' 	=> '密碼不符',
		'role.require' 			=> '管理員至少要有一個權限',
		'__token__.require' 	=> '令牌不得為空',
		'__token__.token' 		=> '令牌數據無效',
		//edit場景的錯誤訊息
		'newpasswordnot.min' 			=> '新密碼不得少於6位',
		'newpasswordnot.requireWith' 	=> '新密碼必須跟確認密碼一起填寫才能更改密碼',
		'newpasswordnot.confirm' 		=> '新密碼與確認不符',
	];

	protected $scene = [
		'insert' => [
			'auid',
			'name',
			'password',
			'passwordnot',
			'role',
			'__token__',
		],
		'edit' => [
			'name',
			'role',
			'__token__',
			'newpasswordnot',
		],
	];
}