<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Math extends CI_Model {

    function add($a,$b)
    {
        $sum = 0;
//        $a = parseInt($a);
//        $b = parseInt($b);
        $sum = $a +$b;
        return $sum;
    }
    
    function sub($c,$d)
    {
        $sub = 0;
//        $c = parseInt($c);
//        $d = parseInt($d);
        $sub = $c - $d;
        return $sub;
    }
	
	
}
?>