<?php namespace app;

// see: CLI class in tasks module for the reason why it's \app\Controller and 
// not just Controller even though we're in the namespace \app\

/**
 * This is just an example controller. :)
 * 
 * @package    ccs
 * @category   Example
 * @author     srcspider
 * @version    1.0
 */
class Controller_Hello extends \app\Controller
{
	public function action_index()
	{
		$this->response->body('hello world');
	}
	
} # class
