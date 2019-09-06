<?php


class register extends html_form {

protected $form;



	function config () {

global $c, $s, $m, $t, $q, $u;


parent::config();

$this->i_var['member_active_status']=1;
$this->i_var['new_member_status']=1

$this->i_var['form_name']="register";

$this->i_var['submit_name']= "register";
$this->i_var['submit_value']= $t->submit;

$this->set_title($t->register);

$this->define_form();

	}
	
	
	

	
	
	
	function define_form () {
	
$fields= array("username", "password", "confirm_password", "email", "confirm_email", "country", "town");

$this->ignore= array ("country", "town");

$this->set_fields($fields);

$this->make_sections("input_text", 1);
$this->make_sections("password", 2);
$this->make_sections("input_text", 2);
$this->make_sections("select_country", 2);
$this->make_sections("input_text", 1);
	
	}
	
	
	
	
	
	
	
	
	function is_validated () {
	
		if ( (parent::is_validated("register") === true)
			&& ($this->name_taken() === false)
			&& ($this->email_taken() === false) )
				
		return true;
		else
		return false;
	
	}
	
	

	
	
	
	function name_taken () {

global $c, $s, $m, $t, $q, $u;



		if ($_REQUEST['user_name']) {
		
		$q->set_var("user_name", $_REQUEST['user_name']);	
		$q->sql_select("check_user_name_exists", $numrows, $res);

			if ($numrows >= 1)	{
			
			$this->throw_msg ("error", "name_taken", 
									"#cls #register, #met #name_taken" );
			
			return true;
			
			}
			else 
			return false;

		}
	
	}
	
	
	
	
	


	function email_taken () {

global $c, $s, $m, $t, $q, $u;



		if ($_REQUEST['email']) {
		
		$q->set_var("email", $_REQUEST['email']);	
		$q->sql_select("check_user_email_exists", $numrows, $res);

			if ($numrows >= 1) {
			
			$this->throw_msg ("error", "email_taken", 
									"#cls #register, #met #email_taken" );
			
			return true;

			}
			else		
			return false;

		}

		return true;

	}
	
	
	
	
	

	function onsubmit () {
	

global $c, $s, $m, $t, $q, $u;


		if ( $_REQUEST  || $_GET )
		$this->has['update_data_from_global']= true;		

	
	    if ($_REQUEST['form_name'] === $this->i_var['form_name']) {
		

			if (($this->is_validated() === true) && $_REQUEST['email']) {

//--------create random string from random numbers converted into a string

				for ($i = 0; $i < 20; $i++)
				$randomstring .= mt_rand(1,9);

//----verify string----------------
$verifystring = urlencode($randomstring);

//----user email------------------
$verifyemail = urlencode($_REQUEST['email']);

//-------url to use for email verification//-------address of verify page---------

$verifyurl = $s->root_url."?view=register&option=verify";

$verifyurl .= "&email={$verifyemail}&string={$verifystring}";



//-----Register member-----------------

$q->set_var("active", $this->i_var['member_active_status']);
$q->set_var("status", $this->i_var['new_member_status']);

$q->set_var("verify_string", $randomstring);


				foreach ($_REQUEST as $key => $value )		
				$q->set_var($key, $value);		

				
				if (!$q->sql_action("register_member") ) {
				
				f1::echo_warning ("register member failed in cls#".get_class($this));
				return;
				
				}
				
				//---------------------------------------
				
				$this->is['displayable']= false;
				
				//---------------------------------------
				
				if ($this->has['send_email']) {
				
				// Send verify email-------------------
				$this->send_email ($verifyurl);
				
				}
				else {
				
				//-------Transfer user_name
				$t->set_var( "user_name", $_REQUEST['user_name'], true );
				
				$this->throw_msg ("confirm", "successful_register", 
									"#cls #register, #met #onsubmit" );
				
				}


			} // closes: if  $this->is_validated() === true
		
		} // closes: if $_REQUEST['register']

	}

	
	
	

//--------------------Send email verification-----------------------------

	function send_email ($verify_url) {

global $c, $s, $m, $t, $q, $u;


$body= <<<TXT

{$t->t['verify_your_email_body']}
	
{$verify_url}

TXT;


$subject= "{$s->global_name}, {$t->verify_your_email_subject}";


$headers = "From: ".$s->main_email."\r\n".
    "Reply-To: ".$s->main_email."\r\n".
    "X-Mailer: PHP/".phpversion();

$action= mail($_REQUEST['email'], $subject, $body, $headers);


		if ($s->show_messages) {

			if (!$action)
			echo_error("Email not sent!");
			
			else
			echo_comment ("Email sent!");
			
		
		echo_email ($_REQUEST['email'], $subject, $body, $headers);
		
		}		

	}

	
}


