<?php
namespace app\model;

use think\Model;

class Role extends Model
{
	public function auth()
	{
		return $this->belongsToMany(Auth::class, Access::class, 'auid', 'rid');
	}
}