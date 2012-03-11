<?php namespace app;

// Notice that the namespace here is \app as such you might think the call 
// bellow is redundant. However it has a purpose. If the class defintion was:

# class CLI extends Atom 

// It would have been equivalent in functionality but it is not equivalent 
// syntactically. We want to extend the "global" Atom class, but when you do
// not specify it you are essentially saying "extend the Atom class of this 
// namespace", which just happens to work in this case. 

// You should try to be explicit when extending classes. When a class belongs to
// non \app namespace this will also dramatically improve performanece since the
// autoloading system only checks all modules when the class is in \app, 
// otherwise it only checks if it knows the namespace and then tries to directly
// load the file.

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 * @version    1.0
 */
class CLI extends \app\Atom
{
	protected static $cliname = 'Minion Alternative';
	protected static $version = '1.0';
	
	protected static $cmdname = 'minion';
	protected static $helpcommands = array('help', '--help', '-h', '-?', '-help');
	protected static $command_struct = array
		(
			'description' => array(),
			'flags' => array(),
		);
	protected static $flag_struct = array
		(
			'description' => 'Description not avaiable.',
			'default' => NULL,
			'type' => 'toggle',
			'short' => NULL,
		);

	/**
	 * Execute the task.
	 */
	public function execute()
	{
		// command line?
		if ( ! Kohana::is_cli())
			exit(1); # only allow CLI access
	
		// new line after command for readability
		Console::newline();
		
		// got paramters?
		if ($_SERVER['argc'] === 1)
			CLI::helptext(); # default to help on no command
		
		// load configuration
		$cli = Settings::get('CLI');
		// get command
		$command = \strtolower($_SERVER['argv'][1]);
		
		// help command?
		if (\in_array($command, CLI::$helpcommands))  # handle command internally
		{
			if (isset($_SERVER['argv'][2])) # specific help topic
			{
				CLI::commandhelp($_SERVER['argv'][2]);
			}
			else # general help
			{
				CLI::helptext();
			}
		}
		
		// valid command?
		if ( ! isset($cli[$command]))
		{
			Console::error('Invalid command: '.$command);
			Console::status('Help', 'For help type: php '.CLI::$cmdname.' help');
			exit(1);
		}
		
		// check for help flag
		for ($i = 2; $i < $_SERVER['argc']; ++$i)
		{
			if ($_SERVER['argv'][$i] === '--help' || $_SERVER['argv'][$i] === '-h')
				CLI::commandhelp($command);
		}
		
		// normalize command
		$cli[$command] = static::normalize($cli[$command]);
		
		// initialize configuration
		$config = array();
		foreach ($cli[$command]['flags'] as $flag => $flaginfo)
		{
			$config[$flag] = $flaginfo['default'];
		}
		
		// check flags
		$flags = \array_keys($cli[$command]['flags']);
		foreach ($flags as $flagkey)
		{
			if ( ! isset($cli[$command]['flags'][$flagkey]))
			{
				Console::error('Invalid configuration');
			}
			
			$flag = $cli[$command]['flags'][$flagkey];
			for ($i = 2; $i < $_SERVER['argc']; ++$i)
			{
				if ($_SERVER['argv'][$i] === '--'.$flagkey || $_SERVER['argv'][$i] === '-'.$flag['short'])
				{
					$config[$flagkey] = \call_user_func(array(__CLASS__, $flag['type']), $i, $_SERVER['argv']);
				}
			}
		}
		
		$missing_flags = Task::execute($command, $config);

		if ( ! empty($missing_flags))
		{
			Console::error('Missing required flags. Command terminated.');
			Console::status('Help', 'For help type: php '.CLI::$cmdname.' help '.$command);
			Console::newline();
			Console::subheader('Missing Flags');
			CLI::render_flags($cli[$command], $missing_flags);
			Console::newline();
			exit(1);
		}
		
		// gurantee output exits with newline
		Console::newline();
	}
	
	/**
	 * Flag type. This special flag type will not display a type in help, since 
	 * it's commonly understood as "activate" and hence the type is redundant.
	 * 
	 * @since 1.0
	 * @return bool
	 */
	public static function toggle()
	{
		return true;
	}
	
	/**
	 * Flag type.
	 * 
	 * @since 1.0
	 * @return string
	 */
	public static function file($idx, array $argv)
	{
		return $argv[$idx+1];
	}
	
	/**
	 * Flag type.
	 * 
	 * @since 1.0
	 * @return string
	 */
	public static function text($idx, array $argv)
	{
		return $argv[$idx+1];
	}
	
	/**
	 * Flag type.
	 * 
	 * @since 1.0
	 * @return string
	 */
	public static function path($idx, array $argv)
	{
		return $argv[$idx+1];
	}

	/**
	 * General help information.
	 * 
	 * @since 1.0
	 */
	public static function helptext()
	{
		if ( ! Kohana::is_cli())
			return;
		
		Console::header(CLI::$cliname.' v'.CLI::$version);
		Console::puts("    USAGE: php ".CLI::$cmdname." [command] [flags]");
		Console::puts("       eg. php ".CLI::$cmdname." example:cmd -i Joe --greeting \"Greetings, Mr.\" --date");
		Console::newline();
		Console::puts("     Help: php ".CLI::$cmdname." help [command] ");
		Console::newline();
		Console::subheader('Commands');
		$cli = Settings::get('CLI');
		// normalize
		foreach ($cli as $command => $commandinfo)
		{
			$cli[$command] = static::normalize($commandinfo);
		}
		// sort commands
		\ksort($cli);
		// determine max length
		$max_command_length = 4;
		foreach (\array_keys($cli) as $command)
		{
			if (\strlen($command) > $max_command_length)
			{
				$max_command_length = \strlen($command);
			}
		}
		$format = "  %-".$max_command_length."s  - %s".PHP_EOL;
		// internal help command
		Console::printf($format, 'help', 'Help information. (current command)');
		// configuration commands
		foreach ($cli as $command => $info)
		{
			Console::printf
				(
					$format, 
					$command, 
					\wordwrap
						(
							$info['description'][0], 
							Console::screenwidth() - $max_command_length - 6,
							PHP_EOL.\str_repeat(' ', $max_command_length + 6)
						)
				);
		}
		
		// terminate after displaying help
		Console::newline();
		exit;
	}

	
	/**
	 * Help on specific command.
	 * 
	 * @since 1.0
	 * @param string command
	 */
	public static function commandhelp($commandname)
	{
		if ( ! Kohana::$is_cli)
			throw new Exception('This is not a console.');
		
		Console::header('Help for '.$commandname);
		$cli = Settings::get('CLI');
		// normalize
		$command = static::normalize($cli[$commandname]);

		// display quick syntax help
		$helptext = ' php '.CLI::$cmdname.' '.$commandname;
		Console::stdout($helptext);
		$helptext_head_length = \strlen($helptext) + 1;
		$helptext = ''; // reset to be able to handle \wordwrap function properly
		foreach ($command['flags'] as $flag => $flaginfo)
		{
			if ($flaginfo['default'] === NULL) # mandatory paramter
			{
				$helptext .= ' --'.$flag;
				if ($command['flags'][$flag]['type'] !== 'toggle')
				{
					// the & is a placeholder for space to symbolize we don't 
					// want a break; it's pretty stupid but it works and it's 
					// safe since & is a special character in consoles
					$helptext .= '&<'.$command['flags'][$flag]['type'].'>';
				}
			}
			else # optional paramter
			{
				$helptext .= ' [--'.$flag;
				if ($command['flags'][$flag]['type'] !== 'toggle')
				{
					$helptext .= '&<'.$command['flags'][$flag]['type'].'>';
				}
				$helptext .= ']';
			}
		}
		$helptext_info = \wordwrap
			(
				$helptext,
				Console::screenwidth() - $helptext_head_length,
				PHP_EOL.\str_repeat(' ', $helptext_head_length)
			);
		// we replace the & with a space 
		Console::puts(\str_replace('&', ' ', $helptext_info));
		Console::newline();
		// display description
		foreach ($command['description'] as $description)
		{
			Console::puts('    '.\wordwrap($description, Console::screenwidth() - 4, PHP_EOL.'    '));
			Console::newline();
		}
		// display detailed flag information
		Console::subheader('Flags');
		if (\count($command['flags']) === 0)
		{
			Console::stdout("    This command does not accept any flags.");
		}
		else # has flags
		{
			Console::puts(' php '.CLI::$cmdname.' '.$commandname);
			CLI::render_flags($command, NULL);
			Console::newline();
			Console::subheader('Default Values');
			$count = CLI::render_flags($command, NULL, 'default');
			if (empty($count))
			{
				Console::stdout('    All flags are required.');
			}
		}
		
		// terminate after displaying help
		Console::newline();
		exit;
	}

	/**
	 * @since 1.0
	 * @param array command
	 * @param array|NULL flagkeys
	 * @param string description key
	 * @return int 
	 */
	protected static function render_flags($command, $flagkeys = NULL, $descriptionkey = 'description')
	{		
		if ($flagkeys === NULL)
		{
			$flagkeys = \array_keys($command['flags']);
		}
		
		// detect maximum flag length
		$max_flag_length = 0;		
		foreach ($flagkeys as $flag)
		{
			$length = \strlen($flag);
			if ($command['flags'][$flag]['type'] !== 'toggle')
			{
				$length += \strlen($command['flags'][$flag]['type']) + 5;
			}
			if ($length > $max_flag_length)
			{
				$max_flag_length = $length;
			}
		}
		$displaycount = 0;
		$format = " %4s %-".$max_flag_length."s  - %s".PHP_EOL;
		foreach ($flagkeys as $flag)
		{
			$flaginfo = $command['flags'][$flag];
			// only display flags with description data
			if ($flaginfo[$descriptionkey] !== NULL)
			{
				$type = $flaginfo['type'] === 'toggle' ? '' : '<'.$flaginfo['type'].'>';
				$short = $flaginfo['short'] === NULL ? '' : '-'.$flaginfo['short'];
				if (\is_bool($flaginfo[$descriptionkey]))
				{
					$description = $flaginfo[$descriptionkey] ? 'ON' : 'OFF';
				}
				else # not boolean
				{
					$description = \wordwrap
						(
							$flaginfo[$descriptionkey], 
							Console::screenwidth() - 10 - $max_flag_length, 
							PHP_EOL.\str_repeat(' ', 10 + $max_flag_length)
						);
				}
				Console::printf
					(
						$format,
						$short,
						'--'.$flag.' '.$type,
						$description
					);
				++$displaycount;
			}
		}
		
		return $displaycount;
	}
		
	/**
	 * Gurantees the default structure is set for the command and it's flags.
	 * 
	 * @since 1.0
	 * @param array command
	 * @return array
	 */
	protected static function normalize($command)
	{
		$command = Arr::merge(static::$command_struct, $command);
		if (empty($command['description']))
		{
			$command['description'] = array('No description available at this time.');
		}
		$normalizedflags = array();
		foreach ($command['flags'] as $flag => $flaginfo)
		{
			$normalizedflags[$flag] = Arr::merge(static::$flag_struct, $flaginfo);
			// gurantee toggles are boolean
			if ($normalizedflags[$flag]['type'] === 'toggle' && $normalizedflags[$flag]['default'] === NULL)
			{
				$normalizedflags[$flag]['default'] = FALSE;
			}
		}
		
		// re-arranging; sort functions would achive the same result but may not
		// maintain the configuration order -- which may help in understanding
		// the command's flags
		$sortedflags = array();
		// required flags
		foreach ($normalizedflags as $key => $flag)
		{
			if ($flag['type'] !== 'toggle' && $flag['default'] === NULL)
			{
				$sortedflags[$key] = $flag;
			}
		}
		// optional flags
		foreach ($normalizedflags as $key => $flag)
		{
			if ($flag['type'] !== 'toggle' && $flag['default'] !== NULL)
			{
				$sortedflags[$key] = $flag;
			}
		}
		// toggle's (automatically optional flags)
		foreach ($normalizedflags as $key => $flag)
		{
			if ($flag['type'] === 'toggle')
			{
				$sortedflags[$key] = $flag;
			}
		}		
		$command['flags'] = $sortedflags;
		
		return $command;
	}
	
} # class
