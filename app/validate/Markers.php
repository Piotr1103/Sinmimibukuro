<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Markers extends Validate
{
	/**
	 * 定义验证规则
	 * 格式：'字段名' =>  ['规则1','规则2'...]
	 *
	 * @var array
	 */
	protected $rule = [
		'mid' 		=> 'require|number|gt:0|max:5',
		'name' 		=> 'require|chsDash|max:20',
		'address' 	=> 'require|max:20',
		'hanasi' 	=> 'chsDash|max:20',
		'yoru' 		=> 'require|number|max:2',
		'lat' 		=> 'require|float|max:10',
		'lng' 		=> 'require|float|max:10',
		'__token__' => 'require|token',
	];

	/**
	 * 定义错误信息
	 * 格式：'字段名.规则名' =>  '错误信息'
	 *
	 * @var array
	 */
	protected $message = [
		'mid.require' 		=> '必須輸入序號',
		'mid.number' 		=> '序號必須是數字',
		'mid.gt' 			=> '序號必須大於0',
		'mid.max' 			=> '序號最多只能5位',
		'name.require' 		=> '必須填寫地名',
		'name.chsDash' 		=> '地名只能用漢字、英數、下劃線和破折號',
		'name.max' 			=> '地名最多只能20位',
		'address.require' 	=> '必須填寫地址',
		'address.max' 		=> '地址最多只能5位',
		'hanasi.chsDash' 	=> '出處只能用漢字、英數、下劃線和破折號',
		'hanasi.max' 		=> '出處最多只能20位',
		'yoru.require' 		=> '必須填寫夜數',
		'yoru.number' 		=> '夜數必須是數字',
		'yoru.max' 			=> '夜數最多只能2位',
		'lat.require' 		=> '必須填寫緯度',
		'lat.float' 		=> '緯度必須是浮點數',
		'lat.max' 			=> '緯度最多只能10位',
		'lng.require' 		=> '必須填寫經度',
		'lng.float' 		=> '經度必須是浮點數',
		'lng.max' 			=> '經度最多只能10位',
		'__token__.require' => '令牌不得為空',
		'__token__.token' 	=> '令牌數據無效',
	];
}
