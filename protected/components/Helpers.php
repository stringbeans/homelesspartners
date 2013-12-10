<?php

class Helpers {
	// return true if the key/val pair are in the array
	public static function isValueInArray($key, $val, $arr) {
		foreach ($arr as $obj) {
			$obj = (object) $obj;
			if ($obj->$key == $val) {
				return true;
			}
		}
		return false;
	}

	public static function extractFromArray($key, $arr) {
		$vals = array();
		foreach ($arr as $obj) {
			$obj = (object)$obj;
			$vals[] = $obj->$key;
		}
		return $vals;
	}

	public static function debug($obj) {
		echo '<pre>';
		print_r($obj);
		echo '</pre>';
	}
}