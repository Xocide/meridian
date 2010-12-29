<?php
class WelcomeController extends AppController
{
	public function index()
	{
		View::set('hello', 'Hello from '.__METHOD__);
	}
	
	public function example()
	{
		$this->_view = 'welcome/index';
		
		View::set('hello', 'Hello from '.__METHOD__);
	}
}