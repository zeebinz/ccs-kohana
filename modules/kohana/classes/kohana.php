<?php namespace kohana\core;

/**
 * The bridge still needs a little help to work. :)
 */
class Kohana extends \Kohana_Core
{
	// bridging can't handle this mismatching of files
	const FILE_SECURITY = '<?php namespace app;';
	
	/**
	 * Sets the paths for the CFS.
	 * 
	 * @param array paths
	 */
	public static function cfs_paths($paths)
	{
		static::$_paths = $paths;
	}
	
	/**
	 * @return array paths in the CFS
	 */
	public static function paths()
	{
		return static::$_paths;
	}
	
	/**
	 * Initialize modules. More or less, this means the system just calls 
	 * init.php for every module registered on the system.
	 */
	public static function modules_init()
	{
		foreach (static::$_paths as $path)
		{
			$init = $path.'init'.EXT;

			if (\is_file($init))
			{
				// include the module initialization file
				require $init;
			}
		}
	}
	
	/**
	 * @return bool is commnad line interface?
	 */
	public static function is_cli()
	{
		return static::$is_cli;
	}
	
} # class
