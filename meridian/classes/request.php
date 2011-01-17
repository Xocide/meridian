<?php
/**
 * Meridian
 * Copyright (C) 2010-2011 Jack Polgar
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

class Request
{
	public static $root;
	public static $request;
	public static $query;
	public static $segments;
	private static $file = 'index.php';
	
	public static function process()
	{
		// Set the entry file, usually index.php
		self::$file = COREFILE;
		
		self::$request = trim(self::_getUri(), '/');
		self::$segments = explode('/', self::$request);
		self::$query = $_SERVER['QUERY_STRING'];
		self::$root = '/'.trim(str_replace(array(self::$request, '?'.$_SERVER['QUERY_STRING'], '?'), '', $_SERVER['REQUEST_URI']), '/').'/';
	}
	
	public static function seg($num)
	{
		return self::$segments[$num];
	}
	
	private static function _getUri()
	{
		// Check if there is a PATH_INFO variable
		// Note: some servers seem to have trouble with getenv()
		$path = (isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');
		if(trim($path, '/') != '' && $path != "/".self::$file)
			return $path;
		
		// Check if ORIG_PATH_INFO exists
		$path = str_replace($_SERVER['SCRIPT_NAME'], '', (isset($_SERVER['ORIG_PATH_INFO'])) ? $_SERVER['ORIG_PATH_INFO'] : @getenv('ORIG_PATH_INFO'));
		if (trim($path, '/') != '' && $path != "/".self::$file)
			return $path;
		
		// Check for ?uri=x/y/z
		if(isset($_REQUEST['url']))
			return $_REQUEST['url'];
		
		// Check the _GET variable
		if (is_array($_GET) && count($_GET) == 1 && trim(key($_GET), '/') != '')
			return key($_GET);
		
		// Check for QUERY_STRING
		$path = (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
		if(trim($path, '/') != '')
			return $path;
		
		// I dont know what else to try, screw it..
		return '';
	}
}