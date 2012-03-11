<?php namespace app;

/* Things to know about CLI configs...
 * 
 *  - if a flag is not mentioned for the command it won't be passed
 *  - configuration doubles as documentation
 *  - A NULL value for a flag's default means it's mandatory. 
 *  - A non-NULL value means it's optional
 *  - A false value means it's optional, but has no actual default value
 *  - "toggle" is a special type for boolean flags, no need to pass value
 *  - all "toggle" should have a default of FALSE; using the flag = TRUE
 *  - if you do not specify a type, "toggle" is assumed
 *  - if you do not specify a default, FALSE is assumed
 *  - each entry in the array of the command's description is a paragraph
 *  - first entry in a command's description should be the short gist of it
 *  - ...it's also used as the command's description in general help
 *  - all flag types are methods in the CLI class
 *  - extend CLI and add your own if you need more, or validation on them, etc
 * 
 * Oh and if you need a command along the lines of:
 *  
 *		minion some:command "something"
 *		(meaning no flags)
 * 
 * Just don't give it flags, handle it in the command's execution and explain it
 * in the command's documentation (ie. description). Preferably use flags though
 * and/or have that only as a shorthand and not as the only way. :)
 */

/**
 * @package    ccs
 * @category   Task
 * @author     srcspider
 */
return array
(
	'get:files' => array
		(
			'description' => array('List all files.'),
			'flags' => array
				(
					'path' => array
						(
							'description' => 'Path in which to find files.',
							'short' => 'p',
							'type' => 'text',
						),
					'filter' => array
						(
							'description' => 'File pattern to match.',
							'short' => 'f',
							'type' => 'text',
							'default' => false,
						),
				)
		),
	'get:class' => array
		(
			'description' => array('List all files.'),
			'flags' => array
				(
					'class' => array
						(
							'description' => 'Class name for which to find files in system',
							'short' => 'c',
							'type' => 'text',
						)
				)
		),
	
); # config
