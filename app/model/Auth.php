<?php
namespace app\model;

use think\Model;

class Auth extends Model
{
	public function role()
	{
		return $this->belongsToMany(Role::class, Access::class, 'rid', 'auid');
	}
}