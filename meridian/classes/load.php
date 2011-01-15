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

class Load
{
	private static $helpers = array();
	private static $classes = array();
	private static $models = array();
	
	public static function helper($file)
	{
		if(in_array($file, self::$helpers)) return true;
		
		if(file_exists(APPPATH.'helpers/'.strtolower($file).'.php'))
			require_once APPPATH.'helpers/'.strtolower($file).'.php';
		else if(file_exists(COREPATH.'helpers/'.strtolower($file).'.php'))
			require_once COREPATH.'helpers/'.strtolower($file).'.php';
		else
			Meridian::error('Loader Error','Unable to load helper: '.$file);
		
		self::$helpers[] = $file;
		return true;
	}
	
	public static function model($name)
	{
		if(!class_exists('Model')) require_once COREPATH.'classes/model.php';
		
		if(in_array($name, self::$models)) return self::$models[$name];
		
		if(file_exists(APPPATH.'models/'.strtolower($name).'.php'))
			require_once APPPATH.'models/'.strtolower($name).'.php';
		else
			Meridian::error('Loader Error','Unable to load model: '.$name);
		
		$modelName = $name.'Model';
		self::$models[$name] = new $modelName(strtolower($name));
		self::$models[$name]->db = Meridian::$db;
		
		return self::$models[$name];
	}
}