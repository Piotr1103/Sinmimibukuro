<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class Smb extends Model
{
	//按照夜數找出相應文章
	public function searchYidAttr($query, $value)
	{
		return $value ? $query->where('yid', $value) : '';
	}
}
