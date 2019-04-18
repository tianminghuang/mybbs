<?php
	/**
	 * 功能: 根据大图片名称, 返回缩略图名称
	 * 参数: $info 包含大图片信息的数组
	 * 返回: 缩略图名称
	 */
	function getSm($filename)
	{
		// 拼接缩略图名称
		// $sm_uface = pathinfo($filename);
		// $thumb_name = $sm_uface['dirname'] . '/sm_' . $sm_uface['filename'] . '.' . $sm_uface['extension'];
		// return $thumb_name;
		$arr = explode('/', $filename);
		$arr[3] = 'sm_'.$arr[3];
		return implode('/', $arr);
	}