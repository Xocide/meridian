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

class View
{
	private static $ob_level;
	private static $vars = array();
	
	public static function render($file)
	{
		if(self::$ob_level === null) self::$ob_level = ob_get_level();
		
		foreach(self::$vars as $_var => $_val)
			$$_var = $_val;
		
		$file = strtolower($file);
		if(!file_exists(APPPATH.'views/'.$file.'.php'))
			Meridian::error('View Error', 'Unable to load view: '.$file);
		
		ob_start();
		include(APPPATH.'views/'.$file.'.php');
		if(ob_get_level() > self::$ob_level + 1)
		{
			ob_end_flush();
		}
		else
		{
			Output::append(ob_get_contents());
			@ob_end_clean();
		}
	}
	
	public static function set($var, $val)
	{
		self::$vars[$var] = $val;
	}
	
	public static function vars()
	{
		return self::$vars;
	}
}