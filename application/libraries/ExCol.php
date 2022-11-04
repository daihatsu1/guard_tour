<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExCol
{

	public $_map = [];

	function get($col, $row = null)
	{
		if (!in_array($col, $this->_map)) {
			$this->_map[] = $col;
		}
		$index = array_search($col, $this->_map);
		$columnLetter = Coordinate::stringFromColumnIndex($index + 1);
		return $columnLetter . ($row ? $row : null);
	}

	public function getLast()
	{
		return Coordinate::stringFromColumnIndex(count($this->_map));
	}

	public function reset()
	{
		$this->_map = array();
	}

}
