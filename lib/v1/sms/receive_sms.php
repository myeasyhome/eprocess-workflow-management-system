<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/


class receive_sms extends receive_sms_datatype
{
    public function set_data()
    {
        $this->set_next_id_sms(); // id of next sms to select in table sms_in

        $this->set_sms_received();
    }
    
    
    
    
    
    
    public function start()
    {
        global $q;


        if ($this->has['new_sms']) {
            $this->process_sms_received(); // make a list for each possible option

            $this->process_sms_for_reply(); // option 1
        $this->process_sms_for_subscription(); // option 2
        
        $this->transfer_sender_data();
        
            $this->sender->send_replies(); // option 1
        $this->sender->record_subscriptions(); // option 2
        }
        
        $this->sender->set_subscribers_sms_sent();
    }
    
    
    
    
    
    public function display()
    {
        global $s, $t;

        $this->sender->display();
    }
}
