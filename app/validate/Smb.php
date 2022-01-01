<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Smb extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名' =>  ['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'yid' 			=> 'require|number|max:3|gt:0|elt:10',
		'cid' 			=> 'require|number|max:3|gt:0',
		'sid' 			=> 'require|number|max:3',
		'title' 		=> 'require|max:40',
		'__token__' 	=> 'require|token',
	];

	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名' =>  '错误信息'
	 *
	 * @var array
	 */
	protected $message = [
		'yid.require' 			=> '必須輸入夜數',
		'yid.number' 			=> '夜數必須是數字',
		'yid.max' 				=> '夜數最多3位',
		'yid.gt' 				=> '夜數不可小於1',
		'yid.elt' 				=> '夜數不可大於10',
		'cid.require' 			=> '必須輸入章數',
		'cid.number' 			=> '章數必須是數字',
		'cid.max' 				=> '章數最多3位',
		'cid.gt' 				=> '章數不可小於1',
		'sid.require' 			=> '必須輸入節數',
		'sid.number' 			=> '節數必須是數字',
		'sid.max' 				=> '節數最多3位',
		'title.require' 		=> '必須輸入標題',
		'title.max' 			=> '標題最多只能40位',
		'__token__.require' 	=> '需要填入令牌',
		'__token__.token' 		=> '令牌數據無效',
	];
}
