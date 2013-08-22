<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masterpage {
	
	/* @property string $header Path to header view.
	 * @property array $header_vars Header variables passed to header view.
	 * @property string $footer Path to footer view.
	 * @property array $footer_vars Footer variables passed to footer view.
	 * @property string $mobile_prefix Prefix path to be applied to views loaded by mobile user agents.
	 * @property bool $mobile_enabled Enable mobile prefixing.
	 * @property CI_Controller $CI CodeIgniter Instance.
	 */
	public $header = FALSE;
	public $header_vars = array();
	public $footer = FALSE;
	public $footer_vars = array();
	public $mobile_prefix = "";
	public $mobile_enabled = TRUE;
	private $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->_config();
	}
	
	private function _config()
	{
		$this->CI->config->load('master_page', TRUE, TRUE);
		$this->header = $this->CI->config->item('header', 'master_page');
		$this->header_vars = $this->CI->config->item('header_vars', 'master_page');
		$this->footer = $this->CI->config->item('footer', 'master_page');
		$this->footer_vars = $this->CI->config->item('footer_vars', 'master_page');
		$this->mobile_enabled = $this->CI->config->item('mobile_enabled', 'master_page');
		$this->mobile_prefix = $this->CI->config->item('mobile_prefix', 'master_page');
	}
	
	/* Masterpage style view method, uses views supplied by the $header and $footer properties. You can specify variables for these views by populating the $header_data and $footer_data array properties.
	 * 
	 * Mobile prefixing is also supported by setting the $mobile_prefix property. For example is $mobile_prefix = "mobile" and load_view("myview") is called from a mobile client, the "mobile/myview" view file is loaded.
	 *
	 * @param string $view Name of the "view" file to be included.
	 * @param array $vars Associative array to be extracted for use in the view.
	 * @param bool $return Wether to return the view or output it.
	 * @return void
	 */
	function view($view, $vars = array(), $return = FALSE)
	{
		$CI =& $this->CI;
		$prefix = "";
		$CI->load->library('user_agent');
		
		if ($this->mobile_enabled and $this->mobile_prefix and $CI->agent->is_mobile())
		{
			$prefix = trim($this->mobile_prefix, '/') . '/';
		}
		
		$out  = array('header' => "", 'body' => "", 'footer' => "");
		
		if ($this->header)
		{
			$out['header'] = $CI->load->view($prefix . $this->header, $this->header_vars, $return);
		}
		
		$out['body'] = $CI->load->view($prefix . $view, $vars, $return);
		
		if ($this->footer)
		{
			$out['footer'] = $CI->load->view($prefix . $this->footer, $this->footer_vars, $return);
		}
		
		return ($return ? implode('', $out) : $out['body']);
	}
}