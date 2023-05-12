<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function compress()
{
    $CI =& get_instance();
    $buffer = $CI->output->get_output();

    $search = array(
        '/\n/',			// replace end of line by a space
        '/\>[^\S ]+/s',		// strip whitespaces after tags, except space
        '/[^\S ]+\</s',		// strip whitespaces before tags, except space
        '/(\s)+/s'		// shorten multiple whitespace sequences
    );

    $replace = array(
        ' ',
        '>',
        '<',
        '\\1'
    );

    $segment_1 = $CI->uri->segment(1);
    $segment_2 = $CI->uri->segment(2);

    if($segment_1 != 'www' && $segment_2 != 'tour') {

        $buffer = preg_replace($search, $replace, $buffer);
    }

    $CI->output->set_output($buffer);
    $CI->output->_display();
}

/* End of file compress.php */
/* Location: ./system/application/hools/compress.php */