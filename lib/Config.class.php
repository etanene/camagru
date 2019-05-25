<?php

class Config {
	private static $settings = [];

	public static function get($key) {
		return (self::$settings[$key]);
	}

	public static function set($key, $value) {
		self::$settings[$key] = $value;
	}
}
