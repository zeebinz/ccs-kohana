<?php namespace app;

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 * @version    1.0
 */
class Console
{
	protected static $screenwidth = 80;
	
	/**
	 * @since 1.0
	 * @return int
	 */
	public static function screenwidth()
	{
		return static::$screenwidth;
	}
	
	/**
	 * Command line message.
	 * 
	 * @since 1.0
	 * @param string status
	 * @param string message
	 */
	private static function status_message($status, $message, $newline = TRUE)
	{
		if (Kohana::is_cli())
		{
			\printf
				(
					" %10s %s%s",
					empty($status) ? '' : '['.$status.']', 
					$message, 
					$newline ? PHP_EOL : ''
				);
		}
	}
	
	/**
	 * @since 1.0
	 * @param string status
	 * @param string message
	 */
	public static function status($status, $message)
	{
		static::status_message($status, $message, TRUE);
	}
	
	/**
	 * An ellipsis and space is added at the end of the message. Use 
	 * Console::status_end for resolution, thus completing the status message.
	 * 
	 * @since 1.0
	 * @param string status
	 * @param string message
	 * @see Console::status_end
	 */
	public static function status_pending($status, $message)
	{
		static::status_message($status, $message.'... ', FALSE);
	}
	
	/**
	 * @since 1.0
	 * @param string end message (eg. done, complete, failed, skipped)
	 * @see Console::status_pending
	 */
	public static function status_end($end_message = 'done.')
	{
		if (Kohana::is_cli())
		{
			\printf('%s%s', $end_message, PHP_EOL);
		}
	}
	
	/**
	 * Error message.
	 * 
	 * @since 1.0
	 * @param string message 
	 */
	public static function error($message)
	{
		static::status_message('ERROR', $message);
	}
	
	/**
	 * Print to console. 
	 * 
	 * @since 1.0
	 */
	public static function stdout($text)
	{
		if (Kohana::is_cli())
		{
			echo $text;
		}
	}
	
	/**
	 * Print to console. 
	 * 
	 * @since 1.0
	 */
	public static function puts($text = '')
	{
		if (Kohana::is_cli())
		{
			echo $text.PHP_EOL;
		}
	}
	
	/**
	 * \printf to consoles
	 * 
	 * @since 1.0
	 */
	public static function printf()
	{
		if (Kohana::is_cli())
		{
			$args = func_get_args();
			\call_user_func_array('printf', $args);
		}
	}
	
	/**
	 * Print to console. 
	 * 
	 * @since 1.0
	 */
	public static function newline($count = 1)
	{
		if (Kohana::is_cli())
		{
			echo \str_repeat(PHP_EOL, $count);
		}
	}
	
	/**
	 * Displays header. Function is used to allow for consistent rendering.
	 * 
	 * @since 1.0
	 * @param string title
	 */
	public static function header($title)
	{
		static::stdout(' '.$title.PHP_EOL);
		static::stdout(' '.\str_repeat('-', static::$screenwidth-1).PHP_EOL.PHP_EOL);
	}
	
	/**
	 * Displays header. Function is used to allow for consistent rendering.
	 * 
	 * @since 1.0
	 * @param string title
	 */
	public static function subheader($title)
	{
		static::stdout
			(
				' === '.$title.' '.\str_repeat('=', 
				static::$screenwidth-6-\strlen($title)).PHP_EOL.PHP_EOL
			);
	}
	
	
} # class