<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * We override the default router class to allow hyphens in
 * our method names since PHP does not allow a hyphen (-).
 * This simply replaces hyphens in the routed URL with
 * underscores.
*/
class MY_Router extends CI_Router {

	function __construct()
	{
		parent::__construct();
	}
	
	function _set_request($segments = array())
	{
		for ($i = 0; $i < count($segments) && $i < 2; $i++)
		{
			$segments[$i] = str_replace('-', '_', $segments[$i]);
		}
		
		parent::_set_request($segments);
	}
}