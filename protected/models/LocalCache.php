<?php

class LocalCache {
	private static $data = array();

	public static function read($key) {
		return !empty(self::$data[$key]) ? self::$data[$key] : null;
	}

	public static function write($key, $val) {
		self::$data[$key] = $val;
	}
}