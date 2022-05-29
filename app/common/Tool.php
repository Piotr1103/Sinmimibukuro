<?php
namespace app\common;

use app\model\Smb as SmbModel;

class Tool
{
	protected static int $listRows = 5;

	public static function ListRows()
	{
		return self::$listRows;
	}

	public static function SmbLastPage(int $yoru)
	{
		$smbRows = ceil(SmbModel::where('yid', $yoru)->count()/$this->listRows);

		return $smbRows;
	}
}