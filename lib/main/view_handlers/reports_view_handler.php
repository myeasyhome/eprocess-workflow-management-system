<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class reports_view_handler extends view_handler_datatype
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
	

	<link rel="stylesheet" href="style/style.css" type="text/css" media="screen, print" />
	
	
    <!--[if IE 6]><link rel="stylesheet" href="style/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style/style.ie7.css" type="text/css" media="screen" /><![endif]-->


</head>

<body style="background-color: #ffffff;">




<div id="page_top" class="main"> 

<?php

$msg_obj->display(); ?>

<?php


    if ($_GET['print_page']) {
        $this->shelf->use_method("main", "display_print_title");
    }
    
        $this->shelf->main; ?>

</div>

<div class="art-footer-text">
<p><a href="<?php echo $s->root_url; ?>"><?php echo $t->home; ?></a> | <a href="#page_top"><?php echo $t->top_of_page; ?></a> </a></p>
<p>Copyright &copy; MFPRE <?php echo date("Y").". ".$t->all_rights; ?></p>
<p>E-PROCESS 1.0</p>
</div>

</body>
</html>



<?php
    }
}
