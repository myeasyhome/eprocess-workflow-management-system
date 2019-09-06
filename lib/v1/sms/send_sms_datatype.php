<?php



/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



abstract class send_sms_datatype extends website_object
{
    protected $sms_action;
    protected $reply_action;


    protected $sms;
    protected $documents;
    protected $clients;




    protected $client_pointer;
    protected $sms_pointer;

    protected $subscribers_sent;

    protected $clients_for_reply;
    protected $clients_for_subscription;


    protected $clients_subscribed;
    protected $client_failed_data;
    protected $sms_failed_data;
    protected $document_failed_data;
    protected $send_failed_data;


    protected $clients_subscribed_display_list;
    protected $sent_display_list;
    protected $subscribers_sent_display_list;

    protected $sms_failed_display_list;
    protected $client_failed_display_list;
    protected $document_failed_display_list;
    protected $send_failed_display_list;



    public function config()
    {
        $this->i_var['send_failed_counter']= 0;


        $this->subscribers_sent= array();
        $this->sms_failed_data= array();
        $this->document_failed_data= array();
        $this->client_failed_data= array();
        $this->send_failed_data= array();


        //---------------

        $this->clients_subscribed_display_list= array("receiver", "id_client", "surname");
        $this->sent_display_list= array("receiver", "id_client", "surname", "sender");
        $this->subscribers_sent_display_list= array("receiver", "id_client", "surname", "sender");
        $this->sms_failed_display_list= array("receiver", "id_client", "surname", "sender");
        $this->client_failed_display_list= array("receiver", "id_client", "surname", "sender");
        $this->document_failed_display_list= array("receiver", "id_client", "surname", "sender");
        $this->send_failed_display_list= array("receiver", "id_client", "surname", "sender");
    }

    

    
    
    public function set_data_from_received_sms($name, $value)
    {
        $list= array("sms_failed_data", "clients_for_reply", "clients_for_subscription");


        if (in_array($name, $list)) {
            $this->$name= $value;
        } else {
            f1::echo_error("invalid #name in met#set_data_from_received_sms
		cls#".get_class($this));
        }
    }
    
    
    
    
    
    
    public function set_sms_action($action)
    {
        $this->sms_action= $action;
    }
    
    
    


    public function set_sms($sms="", $index=-1)
    {
        global $q;


        if ($sms && ($index >= 0)) {
            $this->sms[$index]= $sms;
        } elseif ($sms) {
            $this->sms[]= $sms;
        } else {
        
        // get sms from database

            $q->set_filter("action= '".f1::fix_slashes($this->sms_action)."'");
            $q->sql_select("select_sms1", $numrows, $res, "all");

            if ($numrows >= 1) {
                $data= mysql_fetch_assoc($res);
                        
                if ($index >= 0) {
                    $this->sms[$index]= $data['sms'];
                } else {
                    $this->sms[]= $data['sms'];
                }
            }
        }
    }
    
    
    
    
    
    
    public function set_documents($documents= array())
    {
        if ($documents) {
            $this->documents= $documents;
        } elseif ($this->clients && is_array($this->clients)) {
            for ($i=0; $i < count($this->clients); $i++) {
                $data= &$this->clients[$i];
            
                if ($data && ($data['document_type'] == 1)) {
                    $q->set_filter("file1.id_file='".$data['id_document']."'");
                    $file_data= $this->set_data_from_id("sms_file_name_client", "", "", $numrows);
                
                    if (!empty($file_data)) {
                
                    //----process data or add extra data
                
                
                
                        //-----------------
                    
                        $this->documents[$i]= &$file_data;
                    } else {
                        $this->client_failed_data[]= $data;
                        f1::echo_warning("client_failed_data ref#1");
                    }
                } elseif ($data && ($data['document_type'] == 2)) {
                    $q->set_filter("project1.id_proj='".$data['id_proj']."'");
                    $proj_data= $this->set_data_from_id("sms_project_name_client", "", "", $numrows);
                
                    if (!empty($proj_data)) {
                
                    //----process data or add extra data------
                
                
                
                        //-----------------
                
                        $this->documents[$i]= &$proj_data;
                    } else {
                        $this->client_failed_data[]= $data;
                        f1::echo_warning("client_failed_data ref#2");
                    }
                }
            }
        }
    }
    
    
    
    


    public function set_clients($clients=array())
    {
        if (is_array($clients) && $clients) {
            $this->clients= $clients;
        } else {
            $this->throw_msg("fatal_error", "invalid_request", "#met #set_clients, 
				cls#".get_class($this).", #clients is empty or not an array");
        }
    }
    
    
    
    
    
    
    public function use_client()
    {
        $client= array();

        if (!is_numeric($this->client_pointer)) {
            $this->client_pointer= 0;
        }
        
        if ($this->client_pointer < count($this->clients)) {
            $client= $this->clients[$this->client_pointer];
            $this->client_pointer++;
        }

    
        return(!empty($client) ? $client : null);
    }
    
    
    
    
    
    
    public function add_sms_to_send($processed_sms_data)
    {
        if ($processed_sms_data && is_array($processed_sms_data)) {
            $this->sms_to_send[]= $processed_sms_data;
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    public function use_sms($index)
    {
        if ($this->sms[$index]) {
            return $this->sms[$index];
        }
    }
    
    
    
    
    
    
    public function use_document($index)
    {
        if ($this->documents[$index]) {
            return $this->documents[$index];
        } else {
            return array();
        }
    }
    
    
    
    
    
    
    
    public function send_sms_to_query_manager()
    {
        global $q;


        if (empty($this->sms_pointer)) {
            $this->sms_pointer= 0;
        }
        
        if ($this->sms_pointer < count($this->sms_to_send)) {
            $data= $this->sms_to_send[$this->sms_pointer];


            foreach ($data as $key => $value) {
                $q->set_var($key, $value);
            }
                    
            $this->sms_pointer++;
        
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    
    
    public function send_replies()
    {
        global $s, $q;
        
        
        //get documents

        for ($i=0; $i < count($this->clients_for_reply); $i++) {
            $data= &$this->clients_for_reply[$i];
        

            if ($data && ($data['type_document'] == 1)) {
            
                // get sms from database

                $q->set_filter("action= '".$s->sms_file_reply_action."'");
                $q->sql_select("select_sms1", $numrows0, $res0, "all");

                if ($numrows0 >= 1) {
                    $data0= mysql_fetch_assoc($res0);
                    $this->sms[$i]= $data0['sms'];
                    $this->clients_for_reply[$i]['index_of_sms']= $i;
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#3");
                    unset($this->clients_for_reply[$i]);
                    continue;
                }
                        
                //-------------------
            
                $q->set_var("id_file", $data['id_document']);
                $q->set_var("surname", $data['surname']);

                $q->sql_select("sms_file_name_client", $numrows1, $res1, "all");

                if ($numrows1 == 1) {
                    $file_data= mysql_fetch_assoc($res1);
            
                    //----process data or add extra data
            
                    $file_data['sender']= $data['sender'];
                    $file_data['receiver']= $data['receiver'];
                    $file_data['date_trans']= f1::custom_date($file_data['date_trans']);
                    $file_data['today']= f1::custom_long_date(date("Y-m-d", time()));
                
                    //-----------------
        
                    $this->documents[$i]= $file_data;
                    $this->clients_for_reply[$i]['index_of_document']= $i;
                

                    $q->set_filter("client1.id_client='".$file_data['id_client']."'");
                    $this->set_data_from_id("select_sms_user1", "", "", $numrows2);
                
                    if ($numrows2 < 1) {
                        $q->set_var("id_client", $file_data['id_client']);
                        $q->set_var("id_file", $file_data['id_file']);
                        $q->set_var("type_user", 1);
                    
                        $q->sql_action("insert_sms_user1");
                    }
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#4");
                    unset($this->clients_for_reply[$i]);
                }
            } elseif ($data && ($data['document_type'] == 2)) {
            
                    
                // get sms from database

                $q->set_filter("action= '".$s->sms_project_reply_action."'");
                $q->sql_select("select_sms1", $numrows0, $res0, "all");

                if ($numrows0 >= 1) {
                    $data0= mysql_fetch_assoc($res0);
                    $this->sms[$i]= $data0['sms'];
                    $this->clients_for_reply[$i]['index_of_sms']= $i;
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#3");
                    unset($this->clients_for_reply[$i]);
                    continue;
                }
                        
                //-------------------
            
            
                $q->set_var("id_proj", $data['id_document']);
                $q->set_var("surname", $data['surname']);

                $q->sql_select("sms_project_name_client", $numrows1, $res1, "all");
            
                if ($numrows1 == 1) {
                    $proj_data= mysql_fetch_assoc($res1);
            
            
                    //----process data or add extra data-----------
            
                    $proj_data['sender']= $data['sender'];
                    $proj_data['receiver']= $data['receiver'];
                    $proj_data['date_trans']= f1::custom_date($proj_data['date_trans']);
                    $proj_data['today']= f1::custom_long_date(date("Y-m-d", time()));
                
                    //-----------------
            
                    $this->documents[$i]= $proj_data;
                    $this->clients_for_reply[$i]['index_of_document']= $i;
                

                    $q->set_filter("client1.id_client='".$proj_data['id_client']."'");
                    $this->set_data_from_id("select_sms_user1", "", "", $numrows2);
                
                    if ($numrows2 < 1) {
                        $q->set_var("id_client", $proj_data['id_client']);
                        $q->set_var("id_proj", $proj_data['id_proj']);
                        $q->set_var("type_user", 1);
                    
                        $q->sql_action("insert_sms_user1");
                    }
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#4");
                    unset($this->clients_for_reply[$i]);
                }
            }
        }
        
        //----------------------

        $this->clients= &$this->clients_for_reply;

        $this->set_data();
        $this->start();
    }
    

        
    
    
    
    
    public function record_subscriptions()
    {
        global $s, $q;

    
        for ($i=0; $i < count($this->clients_for_subscription); $i++) {
            $data= &$this->clients_for_subscription[$i];
        
            if ($data && ($data['type_document'] == 1)) {
            
                
            // get sms from database

                $q->set_filter("action= '".$s->sms_file_subscription_action."'");
                $q->sql_select("select_sms1", $numrows0, $res0, "all");

                if ($numrows0 >= 1) {
                    $data0= mysql_fetch_assoc($res0);
                    $this->sms[$i]= $data0['sms'];
                    $this->clients_for_subscription[$i]['index_of_sms']= $i;
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#5");
                    unset($this->clients_for_subscription[$i]);
                    continue;
                }
                    
                //-------------------
                
                $q->set_var("id_file", $data['id_document']);
                $q->set_var("surname", $data['surname']);
            
                $q->sql_select("sms_file_name_client", $numrows0, $res0, "all");
            
                if ($numrows0 == 1) {
                    $file_data= mysql_fetch_assoc($res0);
            
            
                    //----process data or add extra data-----------
            
                    $file_data['num_file']= $file_data['id_file'];
                    $file_data['num_proj']= $file_data['num_proj'] ? $file_data['num_proj'] : "---";
                
                    $file_data['sender']= $data['sender'];
                    $file_data['receiver']= $data['receiver'];
                    $file_data['today']= f1::custom_long_date(date("Y-m-d", time()));
            
                    //-----------------
        
                    $this->documents[$i]= $file_data;
                    $this->clients_for_subscription[$i]['index_of_document']= $i;
                
                
                    $q->set_filter("client1.id_client='".$file_data['id_client']."'");
                    $this->set_data_from_id("select_sms_user1", "", "", $numrows1);
                
                    if ($numrows1 < 1) {
                        $q->set_var("id_client", $file_data['id_client']);
                        $q->set_var("id_file", $file_data['id_file']);
                        $q->set_var("type_user", 2);
                    
                        if ($q->sql_action("insert_sms_user1")) {
                            $this->clients_subscribed[]= $file_data;
                        }
                    }
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#6");
                    unset($this->clients_for_subscription[$i]);
                }
            } elseif ($data && ($data['type_document'] == 2)) {
            
                                        
            // get sms from database

                $q->set_filter("action= '".$s->sms_project_subscription_action."'");
                $q->sql_select("select_sms1", $numrows0, $res0, "all");

                if ($numrows0 >= 1) {
                    $data0= mysql_fetch_assoc($res0);
                    $this->sms[$i]= $data0['sms'];
                    $this->clients_for_subscription[$i]['index_of_sms']= $i;
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#6");
                    unset($this->clients_for_subscription[$i]);
                    continue;
                }
                    
                //-------------------
            
            
                $q->set_var("id_proj", $data['id_document']);
                $q->set_var("surname", $data['surname']);
            
                $q->sql_select("sms_project_name_client", $numrows0, $res0, "all");
            
                if ($numrows0 == 1) {
                    $proj_data= mysql_fetch_assoc($res0);
            
                    //----process data or add extra data-----------
                
                    $proj_data['num_proj']= $proj_data['id_proj'];
                    $proj_data['num_file']= $proj_data['num_file'] ? $proj_data['num_file'] : "---";
                
                    $proj_data['sender']= $data['sender'];
                    $proj_data['receiver']= $data['receiver'];
                    $proj_data['today']= f1::custom_long_date(date("Y-m-d", time()));
                
                    //-----------------
        
                    $this->documents[$i]= $proj_data;
                    $this->clients_for_subscription[$i]['index_of_document']= $i;
                
                
                    $q->set_filter("client1.id_client='".$proj_data['id_client']."'");
                    $this->set_data_from_id("select_sms_user1", "", "", $numrows1);
                        
                
                    if ($numrows1 < 1) {
                        $q->set_var("id_client", $proj_data['id_client']);
                        $q->set_var("id_proj", $proj_data['id_proj']);
                        $q->set_var("type_user", 2);
                    
                        if ($q->sql_action("insert_sms_user1")) {
                            $this->clients_subscribed[]= $proj_data;
                        }
                    }
                } else {
                    $this->client_failed_data[]= $data;
                    f1::echo_warning("client_failed_data ref#7");
                    unset($this->clients_for_subscription[$i]);
                }
            }
        }
        
        //----------------------

        $this->clients= &$this->clients_for_subscription;

        $this->set_data();
        $this->start();
    }
    
    

    
    
    

    
    public function add_to_send_failed_data(&$data)
    {
        $this->send_failed_data[]= $data;
        f1::echo_warning("send_failed_data ref#".(++$this->i_var['send_failed_counter']));
    }
    
    
    
    
    
    
    public function add_to_sent_data()
    {
        $data= $this->sms_to_send[$this->sms_pointer-1];
        
        $this->sent_data[]= $data;


        f1::echo_comment("An sms was sent to client {$data['id_client']}, document type was {$data['document_type']} and
 id_document was {$data['id_document']}.");
    }

    
    
    
    
    
    public function set_subscribers_sms_sent()
    {
        global $c, $m, $u, $q, $t;
                        

        if (($m->view_ref == "send_receive_sms") && empty($this->subscribers_sent)
                && !isset($this->has['no_subscribers_sent'])) {
            $this->subscribers_sent=array();
        
            $q->set_filter("name_var='subscribers_sent'");
            $q->sql_select("select_keep1", $numrows, $res, "all");

            if ($numrows >= 1) {
                $data= mysql_fetch_assoc($res);
                $value= unserialize($data['value']);
            
                if (is_array($value)) {
                    $this->subscribers_sent= $value;
                }
            
                $q->sql_action("empty_subscribers_sent");
            } else {
                $this->has['no_subscribers_sent']= true;
            }
        }
    }
    
    
    
    
    
    
    public function display_clients_subscribed()
    {
        global $t;
        
        $this->display_list= $this->clients_subscribed_display_list;


        if (count($this->clients_subscribed)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
        

        if (is_array($this->clients_subscribed) && count($this->clients_subscribed)) {
            for ($i=0; $i < count($this->clients_subscribed); $i++) {
                $this->data= $this->clients_subscribed[$i];
            
                $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
        
                $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
            
                $this->view_data();
            }
        }
    }
    
    
    
    
    
    
    
    public function display_sent()
    {
        global $t;
    
    
        $this->display_list= $this->sent_display_list;
    
        if (count($this->sent_data)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    
        for ($i=0; $i < count($this->sent_data); $i++) {
            $this->data= $this->sent_data[$i];
        
            $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
            $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
        
            $this->view_data();
        }
    }
    
    
    
    
    
    
    public function display_subscribers_sent()
    {
        global $t;

        
        $this->display_list= $this->subscribers_sent_display_list;
    
        if (count($this->subscribers_sent)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    
        for ($i=0; $i < count($this->subscribers_sent); $i++) {
            $this->data= $this->subscribers_sent[$i];
        
            $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
        
            $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
        
            $this->view_data();
        }
    }
    
    
    
    
    
    
    public function display_client_failed()
    {
        global $t;
        
        $this->display_list= $this->client_failed_display_list;

        if (count($this->client_failed_data)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    
        for ($i=0; $i < count($this->client_failed_data); $i++) {
            $this->data= $this->client_failed_data[$i];
        
            $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
        
            $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
        
            $this->view_data();
        }
    }
    

    
    
    
    
    public function display_document_failed()
    {
        global $t;
    
        $this->display_list= $this->document_failed_display_list;

        if (count($this->document_failed_data)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
        

        if (is_array($this->document_failed_data) && count($this->document_failed_data)) {
            for ($i=0; $i < count($this->document_failed_data); $i++) {
                $this->data= $this->document_failed_data[$i];
            
                $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
        
                $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
            
                $this->view_data();
            }
        }
    }
    
    
    
    
    
    
    
    public function display_sms_failed()
    {
        global $t;
    
    
        $this->display_list= $this->sms_failed_display_list;

        if (count($this->sms_failed_data)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
        

        if (is_array($this->sms_failed_data) && count($this->sms_failed_data)) {
            for ($i=0; $i < count($this->sms_failed_data); $i++) {
                $this->data= $this->sms_failed_data[$i];
            
                $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
        
                $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
            
                $this->view_data();
            }
        }
    }
    
            
    
    
    
    
    
    public function display_send_failed()
    {
        global $t;

                
        $this->display_list= $this->send_failed_display_list;

        if (count($this->send_failed_data)) {
            $this->display_headings();
        } else {
            echo "<div class=\"no_result_msg\">".$this->no_result_msg."</div>";
        }
    
        for ($i=0; $i < count($this->send_failed_data); $i++) {
            $this->data= $this->send_failed_data[$i];
        
            $this->data['id_client']= $this->data['id_client'] ? $this->data['id_client'] : $t->unknown;
        
            $this->data['sender']=
                $this->data['sender'] ? $this->data['sender'] : $t->unknown;
        
            $this->view_data();
        }
    }
    
    
    
    
    
    
    public function display()
    {
        global $s, $t;



        echo "<h3>{$t->clients_subscribed}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_clients_subscribed();
        echo "</table></div>"; // closes main table



        echo "<h3>{$t->request_sms_sent}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_sent();
        echo "</table></div>"; // closes main table



        echo "<h3>{$t->subscribers_sent}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_subscribers_sent();
        echo "</table></div>"; // closes main table


        echo "<h3>{$t->client_failed}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_client_failed();
        echo "</table></div>"; // closes main table



        echo "<h3>{$t->sms_failed}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_sms_failed();
        echo "</table></div>"; // closes main table


        echo "<h3>{$t->document_failed}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_document_failed();
        echo "</table></div>"; // closes main table


        echo "<h3>{$t->send_failed}</h3>
<div class=\"wrap_main_table\">".$s->open_main_table; //---div with html table tag;
        $this->display_send_failed();
        echo "</table></div>"; // closes main table
    }
}
