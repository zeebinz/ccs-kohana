<?php namespace app;

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 * @version    1.0
 */
class Task_Get_Class extends Task_Default
{
	/**
	 * @since 1.0
	 */
	public function execute()
	{
		$classfile = \str_replace('_', DIRECTORY_SEPARATOR, $this->flags['class']);
		$files = Kohana::find_file('classes', $classfile, NULL, TRUE);
		if ( ! empty($files))
		{
			\sort($files);
			foreach ($files as $file)
			{
				Console::status('File', $file);
			}
		}
		else # no files found
		{
			Console::error('No files found.');
		}
	}
	
} # class