<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class letters_view_handler extends view_handler_datatype
{
    protected $i_var;


    

    public function display(&$msg_obj)
    {
        global $s, $u, $t;

        ini_set('default_charset', 'UTF-8'); ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	
    <title><?php echo $s->global_name; ?></title>
	

	<link rel="stylesheet" href="style/letter_style.css" type="text/css" media="screen, print" />
	
	
	
    <!--[if IE 6]><link rel="stylesheet" href="style/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style/style.ie7.css" type="text/css" media="screen" /><![endif]-->


</head>
<body>


  <?php $this->shelf->main; ?> 
    
    
</body>
</html>



<?php
    }
}
