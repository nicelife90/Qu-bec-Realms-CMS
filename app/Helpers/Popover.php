<?php
/**
 * Created by PhpStorm.
 * User: ylafontaine
 * Date: 2018-02-28
 * Time: 13:13
 */

namespace ThreenityCMS\Helpers;


class Popover
{

	public static function help($msg)
	{
		echo "&nbsp;<i style='color: red;' class=\"fa fa-question-circle fa-fw\" data-toggle=\"popover\" title=\"Help\" data-content=\"$msg\"></i>";
	}
}