<?php



class send_email_to_list extends websitemail
{
    protected $email_list;
    
    
    public function config()
    {
        global $c, $s, $m, $t, $q, $u;


        if (!$_SESSION['email_list']) {
            $this->throw_msg("fatal_error", "invalid_request", "#met #config, 
						#cls #send_email_to_list, email list not found");
            return;
        }

        //----------------------------------------

        parent::config();


        //---Default values------------------------------------

        $this->set_title($t->send_mail);


        $this->i_var['submit_name']= "send_mail";
        $this->i_var['submit_value']= $t->send_mail;

        $this->i_var['form_name']= "send_email_to_list";

        $this->i_var['target_url']= $s->root_url."?view=send_email_to_list";

        $this->i_var['input_size']=65;
        $this->i_var['input_maxlength']=65;
        $this->i_var['textarea_rows']=8;
        $this->i_var['textarea_cols']=50;

        $this->i_var['form_method']= "POST";

        $this->has['form']= true; // default
$this->has['submit']= true; // default

//-----------------------------------------

        $fields= array();


        $fields[]= "subject";
        $fields[]= "message";
        $fields[]= "email_list";


        $this->make_sections("undefined", 1);
        $this->make_sections("textarea", 2);

        //----------------
    
        $this->i_var['fields']= $fields;
        $this->set_fields($this->i_var['fields']);
    }
    
    
    
    
    
    public function set_data()
    {
        parent::set_data();

        $this->fields['email_list']= $_SESSION['email_list'];
    }
    
    
    
    
    
    
    public function send_mail()
    {
        global $c, $s, $m, $t, $q, $u;



        $datetime= $c->remind_data("last_sendmail");

        if ($datetime && ($datetime > (time() - (2 * 60)))) {
            $this->throw_msg("error", "wait_next_mail_2");
            return;
        }

        if ($_REQUEST['send_mail']) {
            $headers = "From: ".$this->sender_name." <".$this->sender_email."> \r\n";

            if (empty($this->reply_email)) {
                $this->reply_email= $this->sender_email;
            }
            
            $headers .= "Reply-To: ".$this->reply_email."\r\n";

            $headers .= "X-Mailer: PHP/". phpversion();

            if ($this->cc_email) {
                $headers .= "Cc: ".$this->cc_email."\r\n";
            }

            if ($this->bcc_email) {
                $headers .= "Bcc: ".$this->bcc_email."\r\n";
            }

            //----------------------

            if (empty($this->subject)) {
                $this->subject= $t->no_subject;
            }

            //--------------------

            if ($this->recipient_email && $this->message) {
                mail($this->recipient_email, $this->subject, $this->message, $headers);

                $c->remember_data("last_sendmail", time());

                $this->throw_msg("confirm", "mail_was_sent");
            } else {
                $this->throw_msg("error", "action_failed");
            }
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    public function onsubmit()
    {
        global $c, $s, $m, $t, $q, $u;






        if ($this->is_validated()) {
            if (($_REQUEST['form_name'] === $this->i_var['form_name']) && $_REQUEST['send_mail']) {
                $this->set_details();

                $this->set_message();

                $this->send_mail();
            }
        }
    }
    
    
    
    
    
    
    
    
    public function set_details()
    {
        global $c, $s, $m, $t, $q, $u;
    
    
        $this->recipient_name= "";

        $this->recipient_email= $s->main_email;

        $this->bcc_email= $_REQUEST['email_list'];

        $this->sender_name= $s->global_name;

        $this->sender_email= $s->main_email;

        $this->subject= $_REQUEST[$this->title_tag];
    }
    
    
    
    
    
    
    
    public function set_message()
    {
        global $c, $s, $m, $t, $q, $u;



        $datetime= f1::custom_date_time("now");
    
        $this->message= <<<TXT

---------------------------------------------------

{$this->sender_name}, 

{$_SESSION['account_name']}

---------------------------------------------------

{$_REQUEST[$this->message_tag]}


TXT;
    }

    
    

    
    
    public function textarea_section($name)
    {
        global $c, $s, $m, $t, $q, $u;
    
    
        if ($name == "email_list") {
            $this->i_var['textarea_rows']=6;
            $this->i_var['textarea_cols']=75;
        } elseif ($name == "message") {
            $this->i_var['textarea_rows']=20;
            $this->i_var['textarea_cols']=75;
        }
    
        parent::textarea_section($name);
    }
}
