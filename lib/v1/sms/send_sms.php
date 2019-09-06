<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class send_sms extends send_sms_datatype
{
    protected $separator;
    protected $sms_to_send;

        
    
    
    public function set_data()
    {
        if (empty($this->sms)) {
            $this->set_sms();
        }

        if (empty($this->documents)) {
            $this->set_documents();
        }

        
        
        if ($this->sms && $this->documents && $this->clients) {
            $this->client_pointer= 0; // reset
        
            while (($client= $this->use_client()) && $client) {
                $sms= $this->use_sms($client['index_of_sms']);
                $document= $this->use_document($client['index_of_document']);
            

                if (!$this->add_sms_to_send(process_sms::process(
                    $sms,
                    $document,
                    $client
                ))) {
                    $data= $document;
                    $data= array_merge($data, $client);
                    $data['msg']= $sms;

                    $this->add_to_send_failed_data($data);
                }
            }
        }
    }
    
    
    
    
    
    
    public function start()
    {
        global $m, $q;


        $counter= 0;

        if (count($this->sms_to_send)) {
            while ($this->send_sms_to_query_manager()) {
                if (!$q->sql_action("insert_ozekimessageout")) {
                    $this->add_to_send_failed_data($this->sms_to_send[$this->sms_pointer-1]);
                } else {
                    $counter++;
                    $this->add_to_sent_data();
                }
            }
                        
            
            // save subscribers_sent list
            
            if (($this->option == "subscriber") && count($this->sent_data)) {
                $m->subscribers_sent= serialize($this->sent_data);
            
                $q->sql_action("keep_subscribers_sent");
            
                $m->destroy_data("subscribers_sent");
            }
        }
    }
}
