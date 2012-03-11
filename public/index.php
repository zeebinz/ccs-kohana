<?php namespace app;

require '../environment.php';

/**
 * Execute the main request.
 */
echo Request::factory()
	->execute()
	->send_headers(true)
	->body();
