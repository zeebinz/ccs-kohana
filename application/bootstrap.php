<?php namespace app;

$ds = DIRECTORY_SEPARATOR;

require PLGPATH.'ccs'.$ds.'ccs'.EXT;
require PLGPATH.'ccs'.$ds.'kohana-ccs-bridge'.EXT;

// Modules
Autoloader::modules
	(
		array
		(
			// using DOCROOT is corret, APPPATH is incorect since it has a 
			// ending slash, that is not the correct format for modules here 
			DOCROOT.'application' => 'app', 
			MODPATH.'helloworld' => 'app',
			MODPATH.'tasks' => 'app',
			MODPATH.'kohana' => 'kohana\\core',
			MODPATH.'base' => 'srcspider\\example',
		)
	);

// Legacy modules
Kohana_Autoloader_Bridge::bridges
	(
		array
		(
			PLGPATH.'kohana'.$ds.'core'.$ds.'3.2' => array
				(
					'namespace' => 'kohana\\core',
					'prefix' => 'kohana',
				),
		)
	);

// this serves no purpose, it's just there for kohana 3.2 and lower
\define('SYSPATH', PLGPATH.'kohana'.$ds.'core'.$ds.'3.2');

// load the very silly __ function :/ this thing should just be I18n::tr
require PLGPATH.'kohana'.$ds.'core'.$ds.'3.2'.$ds.'classes'.$ds.'kohana'.$ds.'i18n'.EXT;

// done with the shortcut
unset($ds);

/**	
 * @see  http://php.net/spl_autoload_register
 */
\spl_autoload_register(array('\\app\\Autoloader', 'auto_load'));
\spl_autoload_register(array('\\app\\Kohana_Autoloader_Bridge', 'auto_load'));

// set the paths for kohana
Kohana::cfs_paths
	(
		Arr::merge
			(
				Autoloader::paths(), Kohana_Autoloader_Bridge::paths()
			)
	);

/**
 * Exception handler.
 */
\set_exception_handler(array('\\app\\Kohana_Exception', 'handler'));

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
\date_default_timezone_set('America/Chicago');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
\setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
\ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set Kohana::$environment if 'KOHANA_ENV' variable has been supplied.
 */
if (\getenv('KOHANA_ENV') !== false)
{
	Kohana::$environment = \getenv('KOHANA_ENV');
}

/**
 * Initialize Kohana, setting the default options.
 */
Kohana::init
	(
		array
		(
			     'base_url' => 'http://127.0.0.1/ccs-kohana/', 
			   'index_file' => '',              # name of index file
			      'charset' => 'utf-8',         # internal charset used for I/O
			    'cache_dir' => APPPATH.'cache', # the internal cache directory
			       'errors' => true,            # error handling
			      'profile' => false,           # internal profiling
			      'caching' => true,            # internal caching
		)
	);


/**
 * Cache all routes.
 */

if ( ! Route::cache())
{
	/**
	 * Setup the routes.
	 */
	require APPPATH.'routes'.EXT;
	
	// load modules, along with any routes they set
	Kohana::modules_init();

	// cache the routes
	if (Kohana::$caching === true)
	{
		Route::cache(true);
	}
}
else # routes were cached
{
	// load modules, Route:set is ignored
	Kohana::modules_init();
}