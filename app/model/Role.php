<?php
namespace app\model;

use think\Model;

class Role extends Model
{
	protected $pk = 'rid';

	public function auth()
	{
		return $this->belongsToMany(Auth::class, Access::class, 'auid', 'rid');
	}
}