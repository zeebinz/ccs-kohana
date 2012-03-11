<?php namespace app;

Route::set('demo', '')
	->defaults
		(
			array
			(
				'controller' => 'hello',
				'action' => 'index'
			)
		);
