<?php
namespace app\model;

use think\Model;

class Bulletin extends Model
{
	public function searchStatusAttr($query, $value)
	{
		return $value ? $query->where('status', $value) : '';
	}
}