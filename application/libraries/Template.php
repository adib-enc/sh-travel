<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//

class Template{
	protected $_ci;
	protected $content = "";
	protected $scripts = [];
	
	function __construct($select_template = ['null']){
		$this->select = $select_template[0];
		$this->_ci =&get_instance();
		$this->_ci->load->model('db_model');
		// $this->_ci->load->library('visitor_counter');
	}
	
	function strpos_all($haystack, $needle) {
		$offset = 0;
		$allpos = array();
		while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
			$offset   = $pos + 1;
			$allpos[] = $pos;
		}
		return $allpos;
	}

	function parseDirective($content, $tag1, $tag2) {
		$scriptsIdx = $this->strpos_all($content, $tag1);
		$endScriptsIdx = $this->strpos_all($content, $tag2);

		foreach($scriptsIdx as $key => $sc){
			$i1 = $sc;
			$i2 = $endScriptsIdx[$key] - $sc + strlen($tag2);

			$script = substr($content, $i1, $i2);
			$script = str_replace($tag2,"", $script);
			$script = str_replace($tag1,"", $script);

			$this->scripts[] = $script;
			$content = substr_replace($content, "", $i1, $i2);
		}
		
		$this->content = $content;

		return $this;
	}

	function parseScripts($content) {
		return $this->parseDirective($content, "@script", "@endscript");
	}

	function display($template, $data=null) {
		$data['_baseurl'] = base_url("");
		$content = $this->_ci->load->view(''.$template, $data, TRUE);
		
		$this->parseScripts($content);

		$data['_content'] = $this->content;
		
		$_script = sizeof($this->scripts) > 0 ?
			implode("", $this->scripts) : "";
		$data['_script'] = $_script;
		
		// pr($data);
		$this->_ci->load->view('template/template.php', $data);
	}

	function publik($template,$data=null) {
		$data['_baseurl'] = base_url();
		$data['_content']=$this->_ci->load->view(''.$template,$data,TRUE);
		
		// pr($data);
		$this->_ci->load->view('template/publik.php', $data);
	}


	/**
	 * Get the value of content
	 */ 
	public function getContent()
	{
		return $this->content;
	}
}