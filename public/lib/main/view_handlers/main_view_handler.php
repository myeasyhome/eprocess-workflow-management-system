<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class main_view_handler extends view_handler_datatype
{
    protected $i_var;




    public function config()
    {
        global $c, $s, $m, $t, $q, $u;

        $this->i_var= array();
    }





    public function display_print_button()
    {
        global $m, $c, $u, $t;


        $hidden= array("home", "public_search", "login", "logout", "letter_preview");

        if (empty($_GET['v']) || in_array($_GET['v'], $hidden)
            || $m->no_print_button
            || !($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator"))) {
            $m->no_print_button= null;
            return;
        }


        $current_url= $c->update_current_url("print_page");

        echo "<a id=\"top_print\" class=\"anchor_button\" href=\"{$current_url}&print_page=true\">{$t->print}</a>";
    }





    public function display(&$msg_obj)
    {
        global $s, $u, $t;

        ini_set('default_charset', 'UTF-8'); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<meta http-equiv="Pragma" content="no-cache" />

    <title><?php echo $s->global_name; ?></title>


	<link rel="stylesheet" href="<?php echo $s->app_url; ?>/style/window.css" type="text/css" media="screen" />

    <link rel="stylesheet" href="<?php echo $s->app_url; ?>/style/style.css" type="text/css" media="screen" />

	<link rel="stylesheet" href="<?php echo $s->app_url; ?>/style/letter_style.css" type="text/css" media="screen" />


    <!--[if IE 6]><link rel="stylesheet" href="<?php echo $s->app_url; ?>/style/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="<?php echo $s->app_url; ?>/style/style.ie7.css" type="text/css" media="screen" /><![endif]-->


</head>
<body>


<?php

$this->shelf->display_window($msg_obj); ?>


<div id="art-main">
        <div class="art-sheet">
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">



			 <!-- start header -->


                <div class="art-header">
				<img class="art-logo" src="<?php echo $s->app_url; ?>/images/eprocess_logo.png">

				<div class="wrap-art-header-png">
                        <div class="art-header-png"></div>
				</div>

                </div>

				<?php $this->shelf->header; ?>

			 <!-- end header -->


			 <!-- start top menu -->

                <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">

					<?php

                    $this->shelf->menu_top; ?>

                	</ul>
                </div>

				<!-- end top menu -->


				<!-- start main section -->
			  <div class="art-content-layout">
				<div class="art-content-layout-row">
					<div class="art-layout-cell art-content">


					<noscript><div class="error">
					<?php echo $t->no_javascript; ?>
					</div></noscript>


						<?php $msg_obj->display(); ?>

						 <?php $this->shelf->fill_letter; ?>

							<?php if ($this->shelf->has("main")) {
                        ?>

							<div class="main">

							<?php

                            $this->display_print_button();

                        $this->shelf->main; ?>

							</div>

							<?php
                    } ?>

                        <div class="cleared"></div>
                       </div>

						<!--end main section -->

						<?php

                        if ($u->is_logged_in("zn_observer") || $u->is_logged_in("zn_operator")) {
                            ?>

						 <!-- start first right column -->

                        <div class="art-layout-cell art-sidebar1">

							<div class="art-vmenublock">
								  <div class="art-vmenublock-body">
											  <div class="art-vmenublockheader">
												  <div class="l"></div>
												  <div class="r"></div>
												  <h3 class="t"><?php echo $t->navigation; ?></h3>
											  </div>
								</div>
							</div>

						  <!-- start type 1 menu -->

							<div class="art-block">
								<div class="art-block-body">
                                          <div class="art-blockcontent">
                                              <div class="art-blockcontent-body">
                                                          <div>

														  <ul>
														  <?php

                                                          $this->shelf->menu_right_col1_a1;
                            $this->shelf->menu_right_col1_a2; ?>
														  </ul>

														   </div>

                                          		<div class="cleared"></div>
                                              </div>
                                          </div>
                          		<div class="cleared"></div>
                              </div>
                          </div>

						   <!-- end type 1 menu -->

						    <!-- start type 2 menu -->

						     <div class="art-vmenublock">
                              <div class="art-vmenublock-body">

                                          <div class="art-vmenublockcontent">
                                              <div class="art-vmenublockcontent-body">

                                                          <ul class="art-vmenu">
                                                         <?php

                                                         $this->shelf->menu_right_col1_b1;
                            $this->shelf->menu_right_col1_b2; ?>
                                                         </ul>

                                          		<div class="cleared"></div>
                                              </div>
                                          </div>
                          		<div class="cleared"></div>
                              </div>
                          </div>

						 <!-- end type 2 menu -->

                          <div class="cleared"></div>
                        </div>

						  <!-- end first right column -->



						 <!-- start second right column -->

                        <div class="art-layout-cell art-sidebar2">

						<div class="art-vmenublock">
								  <div class="art-vmenublock-body">
											  <div class="art-vmenublockheader">
												  <div class="l"></div>
												  <div class="r"></div>
												  <h3 class="t"><?php echo $t->actions; ?></h3>
											  </div>
								</div>
							</div>

						  <!-- start type 1 menu -->

							<div class="art-block">
								<div class="art-block-body">
                                          <div class="art-blockcontent">
                                              <div class="art-blockcontent-body">
                                                          <div>

														  <ul>
														  <?php

                                                          $this->shelf->menu_right_col2_1; ?>
														  </ul>

														   </div>

                                          		<div class="cleared"></div>
                                              </div>
                                          </div>
                          		<div class="cleared"></div>
                              </div>
                          </div>

						   <!-- end type 1 menu -->

						    <!-- start type 2 menu -->

						     <div class="art-vmenublock">
                              <div class="art-vmenublock-body">

                                          <div class="art-vmenublockcontent">
                                              <div class="art-vmenublockcontent-body">

                                                          <ul class="art-vmenu">
                                                         <?php

                                                         ?>
                                                         </ul>

                                          		<div class="cleared"></div>
                                              </div>
                                          </div>
                          		<div class="cleared"></div>
                              </div>
                          </div>

						 <!-- end type 2 menu -->

                          <div class="cleared"></div>
                        </div>

					<!-- end second right column -->


					<?php
                        } ?>
				</div>
				</div>
                <div class="cleared"></div>
                <div class="art-footer">
                    <div class="art-footer-t"></div>
                    <div class="art-footer-b"></div>
                    <div class="art-footer-body">

                        <div class="art-footer-text">
                            <p><a href="<?php echo $s->app_url; ?>#art-main"><?php echo $t->top_of_page; ?></a> </a></p>
							<p>Copyright &copy; MFPRE <?php echo date("Y").". ".$t->all_rights; ?></p>
							<p>E-PROCESS 1.0</p>
                        </div>
                		<div class="cleared"></div>
                    </div>
               </div>
			<div class="cleared"></div>
			  </div>
       </div>
</div>


</body>
</html>


<?php
    }
}
