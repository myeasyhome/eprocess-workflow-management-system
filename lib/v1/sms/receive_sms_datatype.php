<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



abstract class receive_sms_datatype extends website_object
{
    protected $sms;
    protected $documents;
    protected $clients;

    protected $next_id_sms;
    protected $sms_received;

    protected $sms_for_reply;
    protected $sms_for_subscription;

    protected $request_marker;
    protected $subscription_marker;

    protected $num_phone_request;
    protected $num_phone_subscription;

    protected $sender_request_params;
    protected $clients_for_reply;

    protected $sender_subscription_params;
    protected $clients_for_subscription;


    protected $sms_failed_data;

    protected $sender;





    public function config()
    {
        global $s;
    
        parent::config();

        $this->next_id_sms= 0;
        $this->sms_received= array();

        $this->request_marker= "*#1*";
        $this->subscription_marker= "*#2*";

        $this->num_phone_request= $s->num_phone_request;
        $this->num_phone_subscription= $s->num_phone_subscription;

        $this->sender_request_params= array("type_document", "id_document", "surname");
        $this->sender_subscription_params= array("type_document", "id_document", "surname");


        $this->clients_subscribed_display_list= array("id_client", "num_phone", "surname", "firstname", "num_file", "num_proj");

        //--------------------

        $this->sender= new send_sms();
        $this->sender->initialize();
        $this->sender->config();
    }
    
    
    


    public function set_next_id_sms()
    {
        global $q;

        $q->set_filter("name_var='last_sms_received'");
        $last_id= $this->set_data_from_id("select_keep1", "", "value", $numrows);

        if ($numrows == 1) {
            $this->next_id_sms= ++$last_id;
        } else {
            $this->throw_msg(
            "error",
            "action_failed",
                                    "next id_sms not set in met#set_next_id_sms, cls#".get_class($this)
        );
        }
    }
    
    
    
    
    
    public function set_sms_received()
    {
        global $q;


        //$this->next_id_sms=1; // tests


        if ($this->next_id_sms) {
            $q->set_filter("id >= ".$this->next_id_sms);
            $q->set_order("ORDER BY id ASC");
            $q->sql_select("sms_received", $numrows, $res, "all");
        
        
            if ($numrows >= 1) {
                $this->has['new_sms']= true;
                $countdown= $numrows;
            
                while ($data= mysql_fetch_assoc($res)) {
                    $countdown--;
                
                    $this->sms_received[]= $data;
                
                    if ($countdown == 0) {
                        $q->set_var("last_sms_received", $data['id']);
                        $q->sql_action("update_last_sms_received");
                    }
                }
            } else {
                $this->has['new_sms']= false;
                f1::echo_warning("set_sms_received failed in met#set_sms_received, cls#".get_class($this));
            }
        } else {
            f1::echo_warning("next id_sms not set in met#set_sms_received, cls#".get_class($this));
        }
    }
    
    
    
    
    public function process_sms_received()
    {
        $this->sms_for_reply= array();
        $this->sms_for_subscription= array();
        $this->sms_rejected= array();

    
        for ($i=0; $i < count($this->sms_received); $i++) {
            $data= &$this->sms_received[$i];
            $data['index_sms_received']= $i;
        

            if ((strpos($data['msg'], $this->request_marker) !== false)
                && ($data['receiver'] == $this->num_phone_request)) {
                $this->sms_for_reply[]= $data;
            } elseif ((strpos($data['msg'], $this->subscription_marker) !== false)
                && ($data['receiver'] == $this->num_phone_subscription)) {
                $this->sms_for_subscription[]= $data;
            } else {
                $this->sms_failed_data[]= $data;
                f1::echo_warning("sms_failed_data ref#1");
                unset($this->sms_received[$i]);
            }
        }
    }
    
    
    
    
    public function process_sms_for_reply()
    {
        for ($i=0; $i < count($this->sms_for_reply); $i++) {
            $data= &$this->sms_for_reply[$i];
            $sms= &$data['msg'];
        
            $sms= trim($sms);
            $sms= substr($sms, strlen($this->request_marker));
    
            $list= explode("*", $sms);
                
            for ($j=0; $j < count($this->sender_request_params); $j++) {
                $name= $this->sender_request_params[$j];
            
                $this->clients_for_reply[$i][$name]= $list[$j];
            }
            
            $this->clients_for_reply[$i]['index_sms_for_reply']= $i;
            $this->clients_for_reply[$i]['sender']= $data['receiver'];
            $this->clients_for_reply[$i]['receiver']= $data['sender'];
        }
    }
    
    
    
    
    
    
    public function process_sms_for_subscription()
    {
        for ($i=0; $i < count($this->sms_for_subscription); $i++) {
            $data= &$this->sms_for_subscription[$i];
            $sms= &$data['msg'];
        
            $sms= trim($sms);
            $sms= substr($sms, strlen($this->subscription_marker));
        
            $list= explode("*", $sms);
                
            for ($j=0; $j < count($this->sender_subscription_params); $j++) {
                $name= $this->sender_subscription_params[$j];
            
                $this->clients_for_subscription[$i][$name]= $list[$j];
            }
            
            $this->clients_for_subscription[$i]['index_sms_for_subscription']= $i;
            $this->clients_for_subscription[$i]['sender']= $data['receiver'];
            $this->clients_for_subscription[$i]['receiver']= $data['sender'];
        }
    }
    
    
    
    
    
    
    
    public function transfer_sender_data()
    {
        $this->sender->set_data_from_received_sms("sms_failed_data", $this->sms_failed_data);
        $this->sender->set_data_from_received_sms("clients_for_reply", $this->clients_for_reply);
        $this->sender->set_data_from_received_sms("clients_for_subscription", $this->clients_for_subscription);
    }
}
