<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Bulletin extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名' =>  ['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'bid' 		=> 'require|number|gt:0|max:5',
		'title' 	=> 'require|max:20',
		'content' 	=> 'require',
		'__token__' => 'require|token',
	];

	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名' =>  '错误信息'
	 *
	 * @var array
	 */
	protected $message = [
		'bid.require' 		=> '必須輸入序號',
		'bid.number' 		=> '序號必須是數字',
		'bid.gt' 			=> '序號必須大於0',
		'bid.max' 			=> '序號最多只能5位',
		'title.require' 	=> '必須填寫標題',
		'title.max' 		=> '標題最多只能20位',
		'content.require' 	=> '內容不得為空',
		'__token__.require' => '令牌不得為空',
		'__token__.token' 	=> '令牌數據無效',
	];
}
