<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Captcha Config Variables
  *
  *  These come directly from the documentation of Code Igniter 2.2.0 website.
  *  https://ellislab.com/codeigniter/user-guide/helpers/captcha_helper.html
  *
	$vals = array(
		'word'	=> 'Random word',
		'img_path'	=> './captcha/',
		'img_url'	=> 'http://example.com/captcha/',
		'font_path'	=> './path/to/fonts/texb.ttf',
		'img_width'	=> '150',
		'img_height' => 30,
		'expiration' => 7200
		);

	$cap = create_captcha($vals);
	echo $cap['image'];
  *  
  */                       
$config['captcha'] = array(
    'word'		=> random_string('alpha', 4),
    'img_path'	=> 'assets/captcha/image/',
    'img_url'	=> base_url().'assets/captcha/image/',
    'font_path'	=> 'assets/captcha/fonts/DejaVuSerif.ttf',
    'img_width'	=> '120',
    'img_height' => '32',
    'expiration' => 3600
    );

/* End of file email.php */
/* Location: ./system/application/config/captcha.php */ 