<?php namespace srcspider\example;

// Example file used in tasks module. 
// See: tasks module. In particular: Task_Default and CLI classes

/** 
 * The purpose of the Atom class is to provide the standard OOP principle of 
 * "everything is derived from Object", applied in particular in pure object 
 * oriented languages.
 * 
 * To allow for extra flexibility and also abstract the concept of signletons, 
 * when it is applied, the constructor is private thus effectively denying 
 * access to it from anywhere. Instead object creation must go though the method
 * instance. This has the added benefit of allowing NULL as a acceptable value 
 * in  cases where creation of an object fails, such as the creation of an 
 * object based on a database entry, when said database entry does not exist, 
 * and exception handling makes less sense. 
 * 
 * By implementing an class as an Atom the class can also easily be replaced by
 * a mockup class.
 * 
 * The class is called Atom and not Object because the "object" is a keyword and
 * can not be used.
 * 
 * @package    ccs
 * @category   Base
 * @author     srcspider
 * @version    1.0
 */
abstract class Atom
{
	/**
	 * Private constructor to deny access to it.
	 */
	private function __construct()
	{
		// intentionally empty
	}
	
	/**
	 * Returns an instance of the class. The instance may very well be a 
	 * singleton or it can be a new object, or it can be a an old object. 
	 * 
	 * Any class *should* provide a "default" object accessed via calling this 
	 * method with no parameters. Meaning, all parameters must be optional. If
	 * error_reporting uses E_STRICT, to conform to the PHP standards for 
	 * classes which require all methods in an inheratance to be able to replace 
	 * each other this recomendation becomes a requirement
	 * 
	 * The instance returned by this method may also be NULL.
	 * 
	 * Summary:
	 * 
	 *  - will return the instance of the class or NULL
	 *  - the instance of the class may be new
	 *  - the instance of the class may be a singleton
	 *  - the instance of the class may be an existing instance
	 *  - in testing the instance may be a mockup object
	 *  - may provide default behaviour
	 * 
	 * @since 1.0
	 * @return static
	 */
	public static function instance()
	{
		return new static;
	}
	
} # class
