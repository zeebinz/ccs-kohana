<?php namespace app;

// See: CLI class for an explanation.

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 * @version    1.0
 */
abstract class Task_Default extends \app\Atom
{
	/**
	 * @var array 
	 */
	protected $flags = array();
	
	/**
	 * Setter/Getter
	 * 
	 * @since 1.0
	 * @return Task_Default|array 
	 */
	public function flags($flags = NULL)
	{
		if ($flags === NULL)
		{
			return $this->flags;
		}
		else # act as setter
		{
			$this->flags = $flags;
			return $this;
		}
	}
	
	/**
	 * Prints the flags passed to the Task in a settings block for transparent
	 * execution. If the task requires clean run then simply overwrite this 
	 * method and have it only return the $this.
	 * 
	 * @since 1.0 
	 * @return Task_Default
	 */
	public function printflags()
	{
		if (Kohana::$is_cli && ! empty($this->flags))
		{
			foreach ($this->flags as $flag => $value)
			{
				if (\is_bool($value))
				{
					$value = $value ? 'ON' : 'OFF';
				}
				
				Console::status('setting', $flag.' = '.$value);
			}
			Console::newline();
		}
		
		return $this;
	}
	
	/**
	 * Execute the task. 
	 */
	public abstract function execute();
	
} # class