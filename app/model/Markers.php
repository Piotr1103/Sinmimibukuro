<?php
namespace app\model;

use think\Model;

class Markers extends Model
{
	public function searchYoruAttr($query, $value)
	{
		return $value ? $query->where('yoru', $value) : '';
	}
}