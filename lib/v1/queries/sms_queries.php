<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/



class sms_queries
{
    public function get_queries($i_var, $filter, $order, $limit, &$queries= array())
    {
        global $c, $s, $m, $t, $q, $u;

        $queries['insert_ozekimessagein']="INSERT INTO ozekimessagein(sender, receiver, msg, senttime, receivedtime, msgtype, operator, reference) VALUES ('".$i_var['sender']."', '".$i_var['receiver']."', '".$i_var['msg']."', '".$i_var['senttime']."', '".$i_var['receivedtime']."', '".$i_var['msgtype']."', '".$i_var['operator']."', '".$i_var['reference']."');";


        $queries['delete_ozekimessagein']="DELETE * FROM ozekimessagein;";


        $queries['delete_from_ozekimessagein']="DELETE FROM ozekimessagein WHERE id='".$i_var['id']."';";


        $queries['select_ozekimessagein']=$queries['sms_received']="SELECT * FROM ozekimessagein ".$filter.$order.$limit.";";


        $queries['insert_ozekimessageout']="INSERT INTO ozekimessageout(sender, receiver, msg, senttime, receivedtime, reference, msgtype, operator, errrormsg, status) VALUES ('".$i_var['sender']."', '".$i_var['receiver']."', '".$i_var['msg']."', '".$i_var['senttime']."', '".$i_var['receivedtime']."', '".$i_var['reference']."', ".$i_var['msgtype'].", '".$i_var['operator']."', '".$i_var['errrormsg']."', 'send');";


        $queries['delete_ozekimessageout']="DELETE * FROM ozekimessageout;";


        $queries['delete_from_ozekimessageout']="DELETE FROM ozekimessageout WHERE id='".$i_var['id']."';";


        $queries['select_ozekimessageout']="SELECT * FROM ozekimessageout ".$filter.$order.$limit.";";



        $queries['insert_sms1']="INSERT INTO sms1(id_user, sms, last_modified, action) VALUES (".$i_var['id_user'].", '".$i_var['sms']."', ".$i_var['last_modified'].", '".$i_var['action']."');";


        $queries['save_sms1']="INSERT INTO sms1(id_sms, id_user, sms, last_modified, action) VALUES (".$i_var['id_sms'].", ".$i_var['id_user'].", '".$i_var['sms']."', ".$i_var['last_modified'].", '".$i_var['action']."');";


        $queries['delete_from_sms1']="DELETE FROM sms1 WHERE id_sms='".$i_var['id_sms']."';";


        $queries['select_sms1']="SELECT * FROM sms1 ".$filter.$order.$limit.";";


        $queries['insert_sms_user1']="INSERT INTO sms_user1(id_client, id_file, id_proj, date_saved, type_user, last_sent) VALUES (".$i_var['id_client'].", ".$i_var['id_file'].", ".$i_var['id_proj'].", ".$i_var['date_saved'].", ".$i_var['type_user'].", ".$i_var['last_sent'].");";


        $queries['save_sms_user1']="INSERT INTO sms_user1(id_client, id_file, id_proj, date_saved, type_user, last_sent) VALUES (".$i_var['id_client'].", ".$i_var['id_file'].", ".$i_var['id_proj'].", '".$i_var['date_saved']."', ".$i_var['type_user'].", '".$i_var['last_sent']."');";


        $queries['delete_from_sms_user1']="DELETE FROM sms_user1 WHERE id_client='".$i_var['id_client']."';";


        $queries['select_sms_user1']="SELECT * FROM sms_user1 INNER JOIN client1 ON sms_user1.id_client=client1.id_client".$filter.$order.$limit.";";


        $queries['sms_file_dept']= "SELECT file1.*, department1.name_dept, transfer1.date_trans FROM file1 INNER JOIN department1 ON file1.file_dept= department1.id_dept INNER JOIN transfer1 ON file1.last_trans = transfer1.id_trans".$filter.$order.$limit.";";


        $queries['sms_file_name_client']= "SELECT client1.*, file1.*, department1.name_dept, transfer1.date_trans FROM client1 INNER JOIN file1 ON client1.id_file= file1.id_file INNER JOIN department1 ON file1.file_dept= department1.id_dept INNER JOIN transfer1 ON file1.last_trans = transfer1.id_trans WHERE client1.id_file='".$i_var['id_file']."' AND client1.surname LIKE '%".$i_var['surname']."%'".$filter.$order.$limit.";";


        $queries['sms_proj_dept']= "SELECT project1.*, department1.name_dept, transfer1.date_trans FROM project1 INNER JOIN department1 ON project1.proj_dept= department1.id_dept INNER JOIN transfer1 ON project1.last_trans = transfer1.id_trans".$filter.$order.$limit.";";


        $queries['sms_project_name_client']= "SELECT client1.*, project1.*, department1.name_dept, transfer1.date_trans FROM client1 INNER JOIN project1 ON client1.id_proj= project1.id_proj  INNER JOIN department1 ON project1.proj_dept= department1.id_dept INNER JOIN transfer1 ON project1.last_trans = transfer1.id_trans WHERE client1.id_proj='".$i_var['id_proj']."' AND client1.surname LIKE '%".$i_var['surname']."%'".$filter.$order.$limit.";";

        $queries['keep_subscribers_sent']="UPDATE keep1 SET value='".$m->subscribers_sent."' WHERE name_var='subscribers_sent' ".$filter.$order.$limit.";";


        $queries['empty_subscribers_sent']="UPDATE keep1 SET value='' WHERE name_var='subscribers_sent' ".$filter.$order.$limit.";";


        $queries['new_project_subcribers']="UPDATE sms_user1 SET id_proj='".$i_var['id_proj']."', id_file='0' WHERE id_client IN (".$i_var['id_list'].")".$filter.$order.$limit.";";
    }
}
