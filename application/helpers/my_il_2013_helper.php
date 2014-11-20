<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('css_get'))
{
	function css_get() {
      	
        return "http://". $_SERVER['HTTP_HOST']."/il2013/css/";
	}
}