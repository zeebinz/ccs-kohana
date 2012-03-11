<?php namespace app;

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 * @version    1.0
 */
class Task
{
	/**
	 * @since 1.0
	 * @return array|NULL 
	 */
	public static function execute($command, $config)
	{
		// check for missing flags
		$missing_flags = array();
		foreach ($config as $flag => $value)
		{
			if ($value === NULL) 
			{
				$missing_flags[] = $flag;
			}
		}
		if ( ! empty($missing_flags))
		{
			return $missing_flags;
		}
		
		// compute class
		$command_names = \explode(':', $command);
		$command_class = \ucfirst($command_names[0]);
		for ($i = 1; $i < \count($command_names); ++$i)
		{
			$command_class .= '_'.\ucfirst($command_names[$i]);
		}
		$class = 'app\\Task_'.$command_class;
		
		// invoke the class
		if (Kohana::$is_cli)
		{
			$class::instance()
				->flags($config)
				->printflags()
				->execute();
		}
		else # not cli
		{
			Atom::invoke($class)
				->flags($config)
				->execute();
		}
		
		return NULL;
	}
	
} # class