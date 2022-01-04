<?php
namespace app\model;

use think\Model;

class Fkd extends Model
{
	public function searchStatusAttr($query, $value)
	{
		return $value ? $query->where('status', $value) : '';
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