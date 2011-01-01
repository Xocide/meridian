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

class MySQLi_Query
{
	private $type;
	private $table;
	private $cols;
	private $where;
	private $limit;
	private $orderby;
	private $sql;
	
	public function __construct($type, array $cols)
	{
		$this->type = $type;
		$this->cols = $cols;
		return $this;
	}
	
	public function distinct()
	{
		$this->type = $this->type.' DISTINCT';
		return $this;
	}
	
	public function from($table)
	{
		$this->table = $table;
		return $this;
	}
	
	public function groupby($cols)
	{
		$this->groupby = $cols;
		return $this;
	}
	
	public function where($where)
	{
		$this->where = $where;
		return $this;
	}
	
	public function orderby($col, $direction)
	{
		if(!empty($col)) $this->orderby = ' ORDER BY '.$col.' '.$direction;
		return $this;
	}
	
	public function limit($a, $b)
	{
		$this->limit = ' LIMIT '.$a.', '.$b;
		return $this;
	}
	
	private function _assemble()
	{
		// Type
		$sql = $this->type.' ';
		
		// Columns
		$cols = array();
		foreach($this->cols as $col => $as)
		{
			if($col)
				$cols[] = " $col AS {$as}";
			else
				$cols[] = " {$as}";
		}
		$sql .= implode(', ', $cols);
		
		// From
		$sql .= ' FROM '.$this->table;
		
		// Group by
		if($this->groupby != null)
		{
			$sql .= " GROUP BY ".implode(', ', $this->groupby);
		}
		
		// Where
		if($this->where != null)
		{
			$_where = array();
			foreach($this->where as $col => $val)
				$_where[] = "`".$this->table."`.`".$col."`='".$val."'";
			
			$sql .= ' WHERE '.implode(' AND ', $_where);
		}
		
		// Order by
		if($this->orderby != null)
			$sql .= $this->orderby;
		
		// Limit
		if($this->limit != null)
			$sql .= $this->limit;
		
		return $sql;
	}
	
	public function __toString()
	{
		return $this->_assemble();
	}
}