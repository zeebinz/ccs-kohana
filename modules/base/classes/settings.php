<?php namespace srcspider\example;

// This file is an example of how module a distributable module is coded. Notice
// how Kohana is called as \app\Kohana that tells the system to look for the 
// class. If it was merely Kohana then the system would try to find the file 
// Kohana in this module--and only in this module! :)

// Writing \app\ is not that hard, but if you feel you're writing it too much or
// you want to convert a class that was designed for \app to, in this case, 
// \srcspider\example\ then you can also do it like this:
use \app\Arr as Arr; # every time you call Arr PHP will interpret as \app\Arr

/** 
 * Simple settings retrieval. Kohana's Config class is too intrusive and also 
 * prevents simple things like calling a file with a period in it. This class
 * does just one thing: get the damn settings. How it does it is not exposed so
 * the process may be improved or altered to meet requirements. :)
 * 
 * @package    ccs
 * @category   Base
 * @author     srcspider
 * @version    1.0
 */
class Settings
{
	/**
	 * @since 1.0
	 * @param string settings name
	 * @param string file extention
	 * @return array final config
	 */
	public static function get($settings, $ext = EXT)
	{
		$setting_files = \app\Kohana::find_file
			(
				'config',          # configuration directory
				$settings,         # setting name
				\ltrim($ext, '.'), # extention
				true               # return a list of all files
			);
		
		$config = array(); # final output
		foreach ($setting_files as $file)
		{
			$setting = include $file;
			$config = Arr::merge($config, $setting);
		}
		
		return $config;
	}
	
} # class
