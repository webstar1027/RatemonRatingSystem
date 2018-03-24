<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('asset_dir'))
{
    function asset_dir()
    {
        return base_url().'assets/';
    }
}

if ( ! function_exists('dashboard_dir'))
{
    function dashboard_dir($link)
    {
        return base_url().$link;
    }
}

if ( ! function_exists('view'))
{
    function view($page, $data = array())
    {
        $CI =& get_instance();
        $CI->load->view('admin/header', $data);
        $CI->load->view($page);
        $CI->load->view('admin/footer');
    }
}

if ( ! function_exists('url_link'))
{
    function url_link()
    {
        $path=str_replace("\\","/",base_url());
        $path=explode("/",rtrim($path,'/'));
        $path=implode("/",$path);
        $ci =& get_instance();
        return $path;
    }   
}

if ( ! function_exists('time_ago'))
{
    function time_ago($date)
    {
        if(empty($date))
		{
            return "None Hits";
        }

        $periods = array("Second", "Minute", "Hour", "Day", "Week", "Month", "Year", "Decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();
        $unix_date = $date;
        
        if(empty($unix_date)) {   
            return "Time Unknown";
        }
		
        if($now > $unix_date) {   
            $difference	= $now - $unix_date;
            $tense = "ago";

        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
		{
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1)
		{
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
}

if ( ! function_exists('escape_data'))
{
    function escape_data($value)
    {
        return mysql_real_escape_string($value);
    }
}

if ( ! function_exists('code_2_country'))
{
    function code_2_name($code)
    {
        $country = '';
        if( $code == 'DUI' ) $country = 'Dubai';
        if( $code == 'AUH' ) $country = 'Abu Dhabi';
        if( $code == 'SHJ' ) $country = 'Sharjah';
        if( $code == 'AJM' ) $country = 'Ajman';
        if( $code == 'RKT' ) $country = 'Ras Al-Khaimah';
        if( $code == 'OFJ' ) $country = 'Fujairah';
        if( $code == 'UAQ' ) $country = 'Um Al-Quwain';
        if( $country == '') $country = 'Unknown';
        return $country;
    }
}