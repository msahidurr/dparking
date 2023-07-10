<?php
/**
 * overWrite the Env File values.
 */
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
        $version = (($version == "") ? '?v=' . env('PJVER',2.5) : $version);
        return asset($src . $version);
    }
}

if (!function_exists('appDate')) {
    function appDate($dateP, $time = true)
    {
        $format = cache('settings')->date_format;
        try {
        	if(is_string($dateP))
            	$date = new \DateTime($dateP);
           	else
           		$date = $dateP;
        } catch (\Exception $e) {
            return $dateP;
        }

        return $date->format(explode(' ', $format)[0] . (($time) ? ' '.explode(' ', $format)[1] : ''));
    }
}

/**
 * overWrite the Env File values.
 * @param  String type
 * @param  String value
 * @param  Bool forceAdd
 * @return \Illuminate\Http\Response
 */
if (!function_exists('overWriteEnvFile')) {
	function overWriteEnvFile($type, $val, $old, $forceAdd = false)
	{
		$path = base_path('.env');
		if (file_exists($path)) {			
			$val = '"'.trim($val).'"';
			if(strpos(file_get_contents($path), $type) != false && strpos(file_get_contents($path), $type) >= 0){
				if($forceAdd)
				{
					file_put_contents($path, file_get_contents($path).$type.'='.$val.PHP_EOL);
				}
				
				file_put_contents($path, str_replace(
					$type.'="'.$old.'"', $type.'='.$val, file_get_contents($path)
				));								
			}
			else{
				file_put_contents($path, file_get_contents($path).PHP_EOL.$type.'='.$val.PHP_EOL);
			}
		}
	}
}
?>