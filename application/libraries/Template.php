<?php

Class Template
{
	var $template_data = array();

	function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	function load_admin($view = '', $view_data = array(), $return = FALSE)
	{
		$this->CI =& get_instance();
		$this->set('contents', $this->CI->load->view('admins/' . $view, $view_data, TRUE));
		return $this->CI->load->view('admins/index', $this->template_data, $return);
	}

	function front_slider($view = '', $data = array(), $return = FALSE)
	{
		$this->CI =& get_instance();
		$content = $this->CI->load->view('front/' . $view, $data, TRUE);
		$data['content'] = $content;
		$data['menu'] = $this->CI->load->view('front/components/menu', $data, TRUE);
		$data['footer'] = $this->CI->load->view('front/components/footer', $data, TRUE);
		return $this->CI->load->view('front/index_slider', $data, $return);
	}

	function front($view = '', $data = array(), $return = FALSE)
	{
		$this->CI =& get_instance();
		$content = $this->CI->load->view('front/' . $view, $data, TRUE);
		$data['content'] = $content;
		$data['shop_modal'] = $this->CI->load->view('front/component/shop_modal', $data, TRUE);
		return $this->CI->load->view('front/index', $data, $return);
	}
}
