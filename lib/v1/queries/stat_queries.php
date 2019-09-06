<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class stat_queries
{
    public function get_queries($i_var, $filter, $order, $limit, &$queries= array())
    {
        global $c, $s, $m, $t, $q, $u;


        //--list files by origin, for each file parameter or department parameter
        $queries['stat_files_origin']= "SELECT department1.*, MIN(transfer1.id_trans) FROM file1 INNER JOIN transfer1 ON file1.id_file=transfer1.id_file INNER JOIN department1 ON transfer1.dept_comingfrom= department1.id_dept".$filter." GROUP BY transfer1.dept_comingfrom".$limit.";";


        //--list clients by origin
        $queries['stat_clients_file']= "SELECT file1.*, client1.* FROM file1 INNER JOIN transfer1 ON file1.id_file=transfer1.id_file INNER JOIN client1 ON file1.id_file=client1.id_file".$filter.$order.$limit.";";



        //--list clients with department info
        $queries['stat_clients_dept']= "SELECT file1.*, client1.*, department1.* FROM file1 INNER JOIN client1 ON file1.id_file=client1.id_file INNER JOIN department1 ON file1.file_dept= department1.id_dept ".$filter." ORDER BY file1.file_dept ASC".$limit.";";


        //--count clients for each client parameter
        $queries['stat_num_clients_1']= "SELECT id_client FROM client1".$filter.$order.$limit.";";

        //--count clients for each client parameter or work parameter
        $queries['stat_num_clients_2']= "SELECT MAX(client_class1.id_client_class), qualification1.qual_level FROM client_class1 INNER JOIN qualification1 ON client_class1.id_qual= qualification1.id_qual".$filter." GROUP BY client_class1.id_client".$limit.";";


        //--count clients for each client parameter or rank parameter or qualification parameter
        $queries['stat_num_clients_3']= "SELECT MAX(client_class1.id_client_class), work1.name_work FROM client_class1 INNER JOIN rank1 ON client_class1.id_rank= rank1.id_rank INNER JOIN work1 ON rank1.id_work= work1.id_work".$filter." GROUP BY client_class1.id_client".$limit.";";


        //--count clients for each client parameter or file parameter or project parameter
        $queries['stat_num_clients_4']= "SELECT COUNT(client1.id_client) AS num_client FROM client1 INNER JOIN file1 ON client1.id_file= file1.id_file INNER JOIN project1 ON client1.id_proj= project1.id_proj".$filter." ORDER BY client1.id_client DESC".$limit.";";


        //--list clients classification in reverse order of id_client
        $queries['stat_clients_class']= "SELECT client_class1.*, client1.*, rank1.name_rank, rank1.work_cat, service1.name_serv, work1.name_work, qualification1.name_qual, qualification1.qual_level, file1.date_created FROM  client_class1 INNER JOIN client1 ON client_class1.id_client= client1.id_client INNER JOIN rank1 ON rank1.id_rank= client_class1.id_rank INNER JOIN service1 ON rank1.id_serv= service1.id_serv INNER JOIN work1 ON rank1.id_work= work1.id_work INNER JOIN qualification1 ON client_class1.id_qual= qualification1.id_qual INNER JOIN file1 ON client1.id_file= file1.id_file".$filter." ORDER BY client_class1.id_client DESC".$limit.";";



        //--list clients qualifications in order of id_client
        $queries['stat_clients_qual']= "SELECT client_class1.*, qualification1.* FROM client_class1 INNER JOIN qualification1 ON client_class1.id_qual= qualification1.id_qual".$filter." ORDER BY client_class1.id_client DESC".$limit.";";


        //--count clients for each client_class parameter
        $queries['stat_num_clients_class_1']= "SELECT COUNT(client_class1.id_client) AS num_client FROM client_class1 INNER JOIN rank1 ON client_class1.id_rank= rank1.id_rank INNER JOIN service1 ON rank1.id_serv= service1.id_serv INNER JOIN work1 ON rank1.id_work= work1.id_work INNER JOIN qualification1 ON client_class1.id_qual= qualification1.id_qual".$filter.$order.$limit.";";


        //--count clients for each client_class parameter and for each client parameter and for each work
        $queries['stat_num_clients_class_2']= "SELECT count(client_class1.id_client) AS num_client, work1.name_work FROM client1 INNER JOIN client_class1 ON client1.id_client= client_class1.id_client INNER JOIN rank1 ON client_class1.id_rank= rank1.id_rank INNER JOIN service1 ON rank1.id_serv= service1.id_serv INNER JOIN work1 ON rank1.id_work= work1.id_work".$filter.$order.$limit.";";


        //--count clients for each client_class parameter and for each file parameter and for each department
        $queries['stat_num_clients_class_3']= "SELECT COUNT(client_class1.id_client) AS num_client * FROM client_class1, client1, file1, department1 WHERE client_class1.id_client= client1.id_client AND file1.id_file= client1.id_file AND file1.file_dept= department1.id_dept".$filter.$order.$limit.";";

        $queries['stat_select_project1']="SELECT project1.*, transfer1.date_trans, transfer1.dept_comingfrom, transfer1.dept_goingto, transfer1.status_trans FROM project1 INNER JOIN transfer1 ON project1.last_trans=transfer1.id_trans ".$filter." ORDER BY project1.id_proj DESC".$limit.";";


        $queries['stat_sms_subscribed']="SELECT * FROM sms_user1 INNER JOIN client1 ON sms_user1.id_client=client1.id_client WHERE sms_user1.type_user='2' AND ( ADDDATE(sms_user1.date_saved,INTERVAL 30 DAY) > NOW() )".$filter." ORDER BY client1.id_client ASC".$limit.";";


        $queries['stat_sms_replies']="SELECT * FROM sms_user1 INNER JOIN client1 ON sms_user1.id_client=client1.id_client WHERE sms_user1.type_user='1'".$filter." ORDER BY client1.id_client ASC".$limit.";";
    }
}
