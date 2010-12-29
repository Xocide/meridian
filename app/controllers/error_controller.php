<?php
class ErrorController extends AppController
{
	public function notFound()
	{
		die('Not Found, OMG!: '.Request::$request);
	}
}