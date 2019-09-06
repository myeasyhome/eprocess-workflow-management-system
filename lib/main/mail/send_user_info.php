<?php


class send_user_info extends websitemail
{
    public function config()
    {
        parent::config();

        $this->i_var['writable_data_list'][]= "all_data";
    }
    
    
        
        
    

    
    public function set_data($name, $value)
    {
        if (!$this->is['active']) {
            return;
        }
        
        if (($name == "all_data") && in_array($name, $this->i_var['writable_data_list'])) {
            $this->data= $value;
        } else {
            $this->throw_msg("error", "action_failed", "#all_data not writable");
        }
    }
    
    
    
    
    
    
    public function set_details()
    {
        global $c, $s, $m, $t, $q, $u;



        $this->recipient_name= "";

        $this->recipient_email= $this->data['email'];

        $this->sender_name= $s->global_name;

        $this->sender_email= $this->bcc_email= $s->main_email;

        $this->subject= $t->t['your_user_info'];

        $this->set_message();
    }
    
    
    
    
    
    
    
    public function set_message()
    {
        global $c, $s, $m, $t, $q, $u;



        $datetime= f1::custom_date_time("now");
    
        $this->message= <<<TXT

{$datetime}
-------------------------------------------

{$t->t['regis_id']}:
{$this->data['regis_id']}

{$t->t['private_info']}:
{$this->data['private_info']}

{$t->t['description']}:
{$this->data['body_description']}

-------------------------------------------

TXT;
    }
    
    
    
    
    
    public function send_mail()
    {
        global $c, $s, $m, $t, $q, $u;




        if ($_REQUEST['send_user_info']) {
            $headers = "From: ".$this->sender_name." <".$this->sender_email."> \r\n";

            if (empty($this->reply_email)) {
                $this->reply_email= $this->sender_email;
            }
            
            $headers .= "Reply-To: ".$this->reply_email."\r\n";

            $headers .= "X-Mailer: PHP/". phpversion();

            if ($this->bcc_email) {
                $headers .= "Bcc: ".$this->bcc_email."\r\n";
            }

            //----------------------

            if (empty($this->subject)) {
                $this->subject= $t->t['no_subject'];
            }

            //--------------------

            if ($this->recipient_email && $this->message) {
                mail($this->recipient_email, $this->subject, $this->message, $headers);

                $q->set_var("file_id_user", $this->data['file_id_user']);
                $q->sql_action("user_info_sent");
            
                return true;
            } else {
                $this->throw_msg("error", "action_failed", "no #recipient_email or #message");
            }
        } else {
            $this->throw_msg("error", "action_failed", "no #send_user_info");
        }
    }
}
