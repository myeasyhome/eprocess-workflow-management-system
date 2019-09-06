<?php


abstract class websitemail extends html_form
{
    protected $fields;

    protected $data;

    protected $recipient_email;

    protected $recipient_name;

    protected $cc_email;

    protected $bcc_email;

    protected $sender_email;

    protected $sender_name;

    protected $reply_email;

    protected $subject;

    protected $message;

    protected $title_tag="title_subject";

    protected $message_tag="message";




    public function send_mail()
    {
        global $c, $s, $m, $t, $q, $u;



        $datetime= $c->remind_data("last_sendmail");

        if ($datetime && ($datetime > (time() - (3 * 60)))) {
            $this->throw_msg("error", "wait_next_mail_3");
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
    
    
        $this->recipient_name= $s->global_name;

        $this->recipient_email= $s->main_email;

        $this->sender_name= $_REQUEST['firstname']." ".$_REQUEST['surname'];

        $this->sender_email= $_REQUEST['email'];

        $this->subject= $_REQUEST[$this->title_tag];
    }
    
    
    
    
    
    
    
    public function set_message()
    {
        global $c, $s, $m, $t, $q, $u;



        $datetime= f1::custom_date_time("now");
    
        $this->message= <<<TXT

------------------------------------------------
MESSAGE SENT ON {$datetime}
------------------------------------------------

TXT;
    
        foreach ($_REQUEST as $key=>$value) {
            if (!in_array($key, array("form_name", "send_mail", "confirm_email", "subject", "message"))) {
                if (is_array($_REQUEST[$key])) {
                    $list= &$_REQUEST[$key];
                
                    for ($i=0; $i < count($list); $i++) {
                        $n= $i + 1;
                    
                        $this->message .= <<<TXT

{$key} {$n}: {$list[$i]}

TXT;
                    }
                } else {
                    $this->message .= <<<TXT

{$key}: {$value}

TXT;
                }
            }
        }
        
        
        $this->message .= <<<TXT
------------------------------------------------
MESSAGE START
------------------------------------------------

{$_REQUEST[$this->message_tag]}

------------------------------------------------
MESSAGE END
------------------------------------------------
TXT;
    }
}
