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

	public function searchCidAttr($query, $value)
	{
		return $value ? $query->where('cid', $value) : '';
	}

	public function getStatusAttr($value)
	{
		$status = [
			0 => '待審核',
			1 => '已公開',
		];

		return $status[$value];
	}

	public function getBadgeAttr($value, $data)
	{
		return $data['status'] ? 'success' : 'warning';
	}
}
