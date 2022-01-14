<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Role extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名' =>  ['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'rid' 		=> 'require|number|max:3',
		'type' 		=> 'require|chsDash|max:20',
		'uri' 		=> 'require|max:100',
		'__token__' => 'require|token',
	];

	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名' =>  '错误信息'
	 *
	 * @var array
	 */
	protected $message = [
		'rid.require' 		=> '序號不得為空',
		'rid.number' 		=> '序號必須是數字',
		'rid.max' 			=> '序號最多3位',
		'type.require' 		=> '種類不得為空',
		'type.chsDash' 		=> '種類只能是漢字、英數、下劃線及破折號',
		'type.max' 			=> '種類最多20位',
		'uri.require' 		=> 'URI不得為空',
		'uri.max' 			=> 'URI最多100位',
		'__token__.require' => '令牌不得為空',
		'__token__.token' 	=> '令牌數據無效',
	];
}