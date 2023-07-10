<?php
/**
 * overWrite the Env File values.
 */

use Spatie\Permission\Models\Permission;

if (!function_exists('setEnv')) {
	function setEnv($key, $value)
	{
		$path = app()->environmentFilePath();

		$escaped = preg_quote('=' . env($key), '/');

		if (strpos(file_get_contents($path), $key) != false && strpos(file_get_contents($path), $key) >= 0) {
			file_put_contents($path, preg_replace(
				"/^{$key}{$escaped}/m",
				"{$key}={$value}",
				file_get_contents($path)
			));
		} else {
			file_put_contents($path, file_get_contents($path) . PHP_EOL.$key . '=' . $value);
		}
	}
}

if (!function_exists('look')) {
    function look($array, $print_r = 1, $exit = 1)
    {
        echo "<pre>";
        echo PHP_EOL . "=========================" . PHP_EOL;
        if ($print_r == 1) print_r($array);
        else var_dump($array);
        echo PHP_EOL . "=========================" . PHP_EOL;
        echo "</pre>";

        if ($exit)
            exit();
    }
}

if (!function_exists('assetz')) {
    function assetz($src, $version = "")
    {
        $version = (($version == "") ? '?v=' . env('PJVER',2.1) : $version);
        return asset($src . $version);
    }
}
if (!function_exists('allpermissions')) {
    function allpermissions()
    {
        return Permission::pluck("name")->toArray();
    }
}
if (!function_exists('getPeriods')) {
    function getPeriods()
    {
        $options = [ "1" => "daily","7" => "weekly","14" => "biweekly", "31" => "monthly","366" => "yearly"];
        return $options;
    }
}
?>