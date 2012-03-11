<?php namespace app;

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 * @version    1.0
 */
class Task_Get_Files extends Task_Default
{
	/**
	 * @since 1.0
	 */
	public function execute()
	{
		$files = Kohana::list_files($this->flags['path']);
		$filter = $this->flags['filter'];

		if ( ! empty($files))
		{
			self::print_files($files, $filter) or Console::error('No files found.');
		}
	}
	
	/**
	 * @since 1.0
	 * @param array files 
	 */
	private static function print_files(array $files, $filter = false)
	{
		\sort($files);
		$found_files = false;
		foreach ($files as $file)
		{
			if (\is_array($file))
			{
				self::print_files($file, $filter) and $found_files = true;
			}
			else # not an array
			{
				$file = \str_replace(DOCROOT, '', $file);
				if ($filter === false || \strpos($file, $filter) !== false)
				{
					Console::status('File', $file);
				}
				$found_files = true;
			}
		}
		
		return $found_files;
	}
	
} # class