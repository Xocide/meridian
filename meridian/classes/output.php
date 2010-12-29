<?php
/**
 * Meridian
 * Copyright (C) 2010 Jack Polgar
 * 
 * This file is part of Meridian.
 * 
 * Meridian is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 only.
 * 
 * Meridian is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Meridian. If not, see <http://www.gnu.org/licenses/>.
 */

class Output
{
	private static $final_output = '';
	
	public static function append($output)
	{
		self::$final_output .= $output;
	}
	
	public static function display($layout)
	{
		$output = self::$final_output;
		
		foreach(View::vars() as $_var => $val)
			$$_var = $val;
		
		// Check if layout exists.
		if(!file_exists(APPPATH.'views/layouts/'.$layout.'.php'))
			Meridian::error('View Error','Unable to load layout: '.$layout);
		
		ob_start();
		require(APPPATH.'views/layouts/'.$layout.'.php');
		$page = ob_get_contents();
		ob_end_clean();
		
		if(extension_loaded('zlib'))
		{
			if(isset($_SERVER['HTTP_ACCEPT_ENCODING']) and strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)
			{
				if($_SERVER['HTTP_HOST'] != 'localhost') ob_start('ob_gzhandler');
			}
		}
		
		header("X-Powered-By: Meridian/".Meridian::version());
		
		$memory = (!function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
		echo str_replace('{memory_useage}',$memory,$page);
	}
}