<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class main_queries
{
    public function get_queries($i_var, $filter, $order, $limit, &$queries= array())
    {
        global $c, $s, $m, $t, $q, $u;
    
    
        // date_created is a formatted string, not NOW()
        $queries['insert_action_log1']="INSERT INTO action_log1(id_user, date_created, type_action, describe_action) VALUES (".$i_var['id_user'].", ".$i_var['date_created'].", '".$i_var['type_action']."', '".$i_var['describe_action']."');";


        $queries['select_action_log1']="SELECT * FROM action_log1 ".$filter."ORDER BY id_action DESC".$limit.";";

            
        $queries['insert_carrier1']="INSERT INTO carrier1(id_dept, surname, firstname, num_phone) VALUES ('".$i_var['id_dept']."', '".$i_var['surname']."', '".$i_var['firstname']."', '".$i_var['num_phone']."');";


        $queries['save_carrier1']="INSERT INTO carrier1(id_carrier, id_dept, surname, firstname, num_phone) VALUES (".$i_var['id_carrier'].", '".$i_var['id_dept']."', '".$i_var['surname']."', '".$i_var['firstname']."', '".$i_var['num_phone']."');";


        $queries['delete_carrier1']="DELETE * FROM carrier1;";


        $queries['delete_from_carrier1']="DELETE FROM carrier1 WHERE id_carrier='".$i_var['id_carrier']."';";


        $queries['select_carrier1']="SELECT * FROM carrier1 ".$filter.$order.$limit.";";



        $queries['insert_class1']="INSERT INTO class1(id_rank, scale, work_class, echelon, work_index, id_qual) VALUES (".$i_var['id_rank'].", ".$i_var['scale'].", ".$i_var['work_class'].", ".$i_var['echelon'].", ".$i_var['work_index'].", ".$i_var['id_qual'].");";


        $queries['save_class1']="INSERT INTO class1(id_class, id_rank, scale, work_class, echelon, work_index, id_qual) VALUES (".$i_var['id_class'].", ".$i_var['id_rank'].", ".$i_var['scale'].", ".$i_var['work_class'].", ".$i_var['echelon'].", ".$i_var['work_index'].", ".$i_var['id_qual'].");";


        $queries['delete_class1']="DELETE * FROM class1;";


        $queries['delete_from_class1']="DELETE FROM class1 WHERE id_class='".$i_var['id_class']."';";


        $queries['select_class1']="SELECT * FROM class1 ".$filter.$order.$limit.";";


        $queries['select_class_all']="SELECT * FROM rank1 INNER JOIN class1 ON rank1.id_rank= class1.id_rank INNER JOIN service1 ON rank1.id_serv= service1.id_serv INNER JOIN work1 ON rank1.id_work= work1.id_work".$filter.$order.$limit.";";


        $queries['insert_client1']= "INSERT INTO client1(id_file, id_proj, id_agent, surname, firstname, determ_client, date_birth, town_birth, client_type, sex, num_phone, email) VALUES (".$i_var['id_file'].", ".$i_var['id_proj'].", '".$i_var['id_agent']."', '".$i_var['surname']."', '".$i_var['firstname']."', '".$i_var['determ_client']."', '".$i_var['date_birth']."', '".$i_var['town_birth']."', ".$i_var['client_type'].", ".$i_var['sex'].", '".$i_var['num_phone']."', '".$i_var['email']."');";


        $queries['update_file_status_2']="UPDATE file1 SET file_status='2' WHERE id_file='".$i_var['id_file']."' ;";


        $queries['save_client1']= "INSERT INTO client1(id_client, id_file, id_proj, id_agent, surname, firstname, determ_client, date_birth, town_birth, client_type, sex, num_phone, email) VALUES (".$i_var['id_client'].", ".$i_var['id_file'].", ".$i_var['id_proj'].", '".$i_var['id_agent']."', '".$i_var['surname']."', '".$i_var['firstname']."', '".$i_var['determ_client']."', '".$i_var['date_birth']."', '".$i_var['town_birth']."', ".$i_var['client_type'].", ".$i_var['sex'].", '".$i_var['num_phone']."', '".$i_var['email']."');";



        $queries['delete_client1']="DELETE * FROM client1;";


        $queries['delete_from_client1']="DELETE FROM client1 WHERE id_client='".$i_var['id_client']."';";


        $queries['select_client1']="SELECT * FROM client1 ".$filter.$order.$limit.";";



        //-- clients with  classification in order of id_client

        $queries['client_all']= "SELECT client_class1.*, client1.*, rank1.name_rank, rank1.determ_rank, rank1.work_cat, service1.name_serv, service1.determ_serv, work1.name_work, work1.determ_work, qualification1.name_qual, qualification1.determ_qual, qualification1.qual_level, qualification1.trial_period FROM  client_class1 INNER JOIN client1 ON client_class1.id_client= client1.id_client INNER JOIN rank1 ON rank1.id_rank= client_class1.id_rank INNER JOIN service1 ON rank1.id_serv= service1.id_serv INNER JOIN work1 ON rank1.id_work= work1.id_work INNER JOIN qualification1 ON client_class1.id_qual= qualification1.id_qual".$filter." ORDER BY client_class1.id_client ASC".$limit.";";


        //--list clients with department coming from, for each client parameter or department parameter
        $queries['client_origin']= "SELECT department1.name_dept AS dept_origin, department1.dept_describe, department1.determ_dept FROM client1 INNER JOIN file1 ON client1.id_file= file1.id_file INNER JOIN transfer1 ON file1.id_file = transfer1.id_file INNER JOIN department1 ON transfer1.dept_comingfrom= department1.id_dept WHERE transfer1.status_trans='0'".$filter.$order.$limit.";";




        $queries['insert_client_class1']="INSERT INTO client_class1(id_client, id_rank, scale, work_class, echelon, work_index, start_scale, start_work, id_qual, option_qual, origin_qual) VALUES (".$i_var['id_client'].", ".$i_var['id_rank'].", ".$i_var['scale'].", ".$i_var['work_class'].", ".$i_var['echelon'].", ".$i_var['work_index'].", '".$i_var['start_scale']."', '".$i_var['start_work']."', ".$i_var['id_qual'].", '".$i_var['option_qual']."', '".$i_var['origin_qual']."');";


        $queries['save_client_class1']="INSERT INTO client_class1(id_client_class, id_client, id_rank, scale, work_class, echelon, work_index, start_scale, start_work, id_qual, option_qual, origin_qual) VALUES (".$i_var['id_client_class'].", ".$i_var['id_client'].", ".$i_var['id_rank'].", ".$i_var['scale'].", ".$i_var['work_class'].", ".$i_var['echelon'].", ".$i_var['work_index'].", '".$i_var['start_scale']."', '".$i_var['start_work']."', ".$i_var['id_qual'].", '".$i_var['option_qual']."', '".$i_var['origin_qual']."');";


        $queries['delete_from_client_class1']="DELETE FROM client_class1 WHERE id_client_class='".$i_var['id_client_class']."';";


        $queries['select_client_class1']="SELECT * FROM client_class1 ".$filter.$order.$limit.";";


        $queries['select_client_class_all']="SELECT * FROM rank1 INNER JOIN client_class1 ON rank1.id_rank= client_class1.id_rank INNER JOIN service1 ON rank1.id_serv= service1.id_serv INNER JOIN work1 ON rank1.id_work= work1.id_work".$filter.$order.$limit.";";


        $queries['insert_department1']="INSERT INTO department1(name_dept, dept_describe, dept_type, determ_dept, has_search, has_write_letter, has_send_sms) VALUES ('".$i_var['name_dept']."', '".$i_var['dept_describe']."', ".$i_var['dept_type'].", '".$i_var['determ_dept']."', ".$i_var['has_search'].", ".$i_var['has_write_letter'].", ".$i_var['has_send_sms'].");";


        $queries['save_department1']="INSERT INTO department1(id_dept, name_dept, dept_describe, dept_type, determ_dept, has_search, has_write_letter, has_send_sms) VALUES (".$i_var['id_dept'].", '".$i_var['name_dept']."', '".$i_var['dept_describe']."', ".$i_var['dept_type'].", '".$i_var['determ_dept']."', ".$i_var['has_search'].", ".$i_var['has_write_letter'].", ".$i_var['has_send_sms'].");";


        $queries['delete_from_department1']="DELETE FROM department1 WHERE id_dept='".$i_var['id_dept']."';";


        $queries['select_department1']="SELECT * FROM department1 ".$filter.$order.$limit.";";



        $queries['insert_file1']="INSERT INTO file1(file_dept, file_type, file_category, title, date_created, file_status, file_ref, file_date) VALUES (".$i_var['file_dept'].", ".$i_var['file_type'].", ".$i_var['file_category'].", '".$i_var['title']."', ".$i_var['date_created'].", ".$i_var['file_status'].", '".$i_var['file_ref']."', '".$i_var['file_date']."');";

        $queries['insert_file_trans']= "INSERT INTO transfer1(id_file, date_trans, id_user, dept_comingfrom, dept_goingto, describe_trans, status_trans, id_carrier, info_carrier) VALUES (".$i_var['id_file'].", ".$i_var['date_trans'].", ".$i_var['id_user'].", ".$i_var['dept_comingfrom'].", ".$i_var['dept_goingto'].", '".$i_var['describe_trans']."', ".$i_var['status_trans'].", ".$i_var['id_carrier'].", '".$i_var['info_carrier']."');";

        $queries['update_file_last_trans']= "UPDATE file1 SET last_trans='".$i_var['last_trans']."' WHERE id_file='".$i_var['id_file']."'";

        $queries['update_file_dept']= "UPDATE file1 SET file_dept='".$i_var['id_dept']."' WHERE id_file IN (".$i_var['id_list'].");";


        $queries['save_file1']="INSERT INTO file1(id_file, file_dept, file_type, file_category, title, date_created, file_status, file_ref, file_date, last_trans) VALUES (".$i_var['id_file'].", ".$i_var['file_dept'].", ".$i_var['file_type'].", ".$i_var['file_category'].", '".$i_var['title']."', '".$i_var['date_created']."', ".$i_var['file_status'].", '".$i_var['file_ref']."', '".$i_var['file_date']."', ".$i_var['last_trans'].");";


        $queries['update_file_comingfrom']= "UPDATE transfer1 SET dept_comingfrom='".$i_var['dept_comingfrom']."' WHERE id_trans='".$i_var['id_trans']."' ;";


        $queries['delete_file1']="DELETE * FROM file1;";


        $queries['delete_from_file1']="DELETE FROM file1 WHERE id_file='".$i_var['id_file']."';";


        $queries['select_file1']="SELECT file1.*, transfer1.dept_comingfrom, transfer1.status_trans FROM file1 INNER JOIN transfer1 ON file1.last_trans=transfer1.id_trans ".$filter." ORDER BY file1.id_file DESC".$limit.";";


        $queries['insert_file_category1']="INSERT INTO file_category1(name_cat) VALUES ('".$i_var['name_cat']."');";


        $queries['save_file_category1']="INSERT INTO file_category1(id_file_cat, name_cat) VALUES (".$i_var['id_file_cat'].", '".$i_var['name_cat']."');";


        $queries['delete_file_category1']="DELETE * FROM file_category1;";


        $queries['delete_from_file_category1']="DELETE FROM file_category1 WHERE id_file_cat='".$i_var['id_file_cat']."';";


        $queries['select_file_category1']="SELECT * FROM file_category1 ".$filter.$order.$limit.";";


        $queries['insert_file_type1']="INSERT INTO file_type1(name_type) VALUES ('".$i_var['name_type']."');";


        $queries['save_file_type1']="INSERT INTO file_type1(id_file_type, name_type) VALUES (".$i_var['id_file_type'].", '".$i_var['name_type']."');";


        $queries['delete_file_type1']="DELETE * FROM file_type1;";


        $queries['delete_from_file_type1']="DELETE FROM file_type1 WHERE id_file_type='".$i_var['id_file_type']."';";


        $queries['select_file_type1']="SELECT * FROM file_type1 ".$filter.$order.$limit.";";


        $queries['insert_keep1']="INSERT INTO keep1(id_keep, name_var, value) VALUES (".$i_var['id_keep'].", '".$i_var['name_var']."', '".$i_var['value']."');";


        $queries['delete_from_keep1']="DELETE FROM keep1 WHERE id_keep='".$i_var['id_keep']."';";


        $queries['select_keep1']="SELECT * FROM keep1 ".$filter.$order.$limit.";";


        $queries['update_last_sms_received']="UPDATE keep1 SET value='".$i_var['last_sms_received']."' WHERE name_var='last_sms_received';";


        $queries['select_transfer1']="SELECT * FROM transfer1 ".$filter.$order.$limit.";";


        $queries['update_transfer_set_received']="UPDATE transfer1 SET status_trans='1' WHERE id_trans='".$i_var['id_trans']."' ;";


        $queries['insert_project1'][0]="INSERT INTO project1(proj_ref, proj_dept, proj_type, date_created, id_file, id_bordereau, proj_status) VALUES ('".$i_var['proj_ref']."', ".$i_var['proj_dept'].", ".$i_var['proj_type'].", ".$i_var['date_created'].", ".$i_var['id_file'].", '".$i_var['id_bordereau']."', ".$i_var['proj_status'].");";

        $queries['insert_project1'][1]="UPDATE client1 SET id_proj='".$i_var['new_id']."' WHERE id_client IN (".$i_var['id_list'].");";

        $queries['insert_proj_trans']= "INSERT INTO transfer1(id_proj, date_trans, id_user, dept_comingfrom, dept_goingto, describe_trans, status_trans, id_carrier, info_carrier) VALUES (".$i_var['id_proj'].", ".$i_var['date_trans'].", ".$i_var['id_user'].", ".$i_var['dept_comingfrom'].", ".$i_var['dept_goingto'].", '".$i_var['describe_trans']."', ".$i_var['status_trans'].",  ".$i_var['id_carrier'].", '".$i_var['info_carrier']."');";

        $queries['update_proj_dept']= "UPDATE project1 SET proj_dept='".$i_var['id_dept']."' WHERE id_proj IN (".$i_var['id_list'].");";


        $queries['update_proj_last_trans']= "UPDATE project1 SET last_trans='".$i_var['last_trans']."' WHERE id_proj='".$i_var['id_proj']."'";

        $queries['update_file_status_3']="UPDATE file1 SET file_status='3' WHERE id_file='".$i_var['id_file']."' ;";

        $queries['save_project1'][0]="INSERT INTO project1(id_proj, proj_ref, proj_dept, proj_type, date_created, id_file, id_bordereau, proj_status, last_trans) VALUES (".$i_var['id_proj'].", '".$i_var['proj_ref']."', ".$i_var['proj_dept'].", ".$i_var['proj_type'].", '".$i_var['date_created']."', ".$i_var['id_file'].", '".$i_var['id_bordereau']."', ".$i_var['proj_status'].", ".$i_var['last_trans'].");";

        $queries['save_project1'][1]= "UPDATE client1 SET id_proj='".$i_var['id_proj']."' WHERE id_client IN (".$i_var['id_list'].");";


        $queries['update_file_status_0']="UPDATE file1 SET file_status='0' WHERE id_file='".$i_var['id_file']."' ;";


        $queries['delete_project1']="DELETE * FROM project1;";


        $queries['delete_from_project1']="DELETE FROM project1 WHERE id_proj='".$i_var['id_proj']."';";


        $queries['select_project1']="SELECT project1.*, transfer1.dept_comingfrom, transfer1.status_trans FROM project1 INNER JOIN transfer1 ON project1.last_trans=transfer1.id_trans ".$filter." ORDER BY project1.id_proj DESC".$limit.";";

        $queries['select_project_to_print']="SELECT project1.*, print_letter1.id_user as plt_id_user, print_letter1.total_cc, print_letter1.date_created AS plt_date FROM project1 LEFT JOIN print_letter1 ON project1.id_proj=print_letter1.id_proj ".$filter.$order.$limit.";";


        $queries['update_proj_type_id_bordereau']="UPDATE project_type1 SET id_bordereau='".$i_var['id_bordereau']."' WHERE id_proj_type='".$i_var['id_proj_type']."' ;";


        $queries['update_project_id_bordereau']="UPDATE project1 SET id_bordereau='".$i_var['year_id_bordereau']."' WHERE id_proj='".$i_var['id_proj']."' ;";



        $queries['select_project_origin']= "SELECT department1.* FROM project1 INNER JOIN transfer1 ON project1.id_proj=transfer1.id_proj INNER JOIN department1 ON transfer1.dept_goingto= department1.id_dept WHERE transfer1.status_trans='0'".$filter.$order.$limit.";";


        $queries['select_proj_no_letter']="SELECT project1.*, print_letter1.id_letter, transfer1.dept_comingfrom FROM project1 LEFT JOIN print_letter1 ON project1.id_proj=print_letter1.id_proj INNER JOIN transfer1 ON project1.last_trans=transfer1.id_trans WHERE print_letter1.id_proj IS NULL".$filter.$order.$limit.";";


        $queries['insert_project_status1']="INSERT INTO project_status1(name_proj_status) VALUES ('".$i_var['name_proj_status']."');";


        $queries['save_project_status1']="INSERT INTO project_status1(id_proj_status, name_proj_status) VALUES (".$i_var['id_proj_status'].", '".$i_var['name_proj_status']."');";


        $queries['delete_project_status1']="DELETE * FROM project_status1;";


        $queries['delete_from_project_status1']="DELETE FROM project_status1 WHERE id_proj_status='".$i_var['id_proj_status']."';";


        $queries['select_project_status1']="SELECT * FROM project_status1 ".$filter.$order.$limit.";";


        $queries['insert_project_type1']="INSERT INTO project_type1(name_proj_type, id_dept) VALUES ('".$i_var['name_proj_type']."', ".$i_var['id_dept'].");";


        $queries['save_project_type1']="INSERT INTO project_type1(id_proj_type, name_proj_type, id_dept) VALUES (".$i_var['id_proj_type'].", '".$i_var['name_proj_type']."', ".$i_var['id_dept'].");";


        $queries['delete_from_project_type1']="DELETE FROM project_type1 WHERE id_proj_type='".$i_var['id_proj_type']."';";


        $queries['select_project_type1']="SELECT * FROM project_type1 ".$filter.$order.$limit.";";


        $queries['insert_qualification1']="INSERT INTO qualification1(name_qual, qual_level, determ_qual, trial_period) VALUES ('".$i_var['name_qual']."', '".$i_var['qual_level']."', '".$i_var['determ_qual']."', ".$i_var['trial_period'].");";




        $queries['save_qualification1']="INSERT INTO qualification1(id_qual, name_qual, qual_level, determ_qual, trial_period)  VALUES (".$i_var['id_qual'].", '".$i_var['name_qual']."', '".$i_var['qual_level']."', '".$i_var['determ_qual']."', ".$i_var['trial_period'].");";




        $queries['delete_from_qualification1']="DELETE FROM qualification1 WHERE id_qual='".$i_var['id_qual']."';";


        $queries['select_qualification1']="SELECT * FROM qualification1 ".$filter.$order.$limit.";";


        $queries['user_login']= "SELECT user1.* FROM user1 WHERE username='".$i_var['username']."'".
            " AND password = '".sha1($i_var['password'])."';";

    
        $queries['insert_user1']="INSERT INTO user1(username, firstname, surname, password, user_status, id_dept, has_create_file, has_create_bordereau, has_create_project, has_print_letter, has_stats) VALUES ('".$i_var['username']."', '".$i_var['firstname']."', '".$i_var['surname']."', '".sha1($i_var['password'])."', ".$i_var['user_status'].", ".$i_var['id_dept'].", ".$i_var['has_create_file'].",".$i_var['has_create_bordereau'].", ".$i_var['has_create_project'].", ".$i_var['has_print_letter'].", ".$i_var['has_stats'].");";


        $queries['save_user1']="INSERT INTO user1(id_user, username, firstname, surname, password, user_status, id_dept, has_create_file, has_create_bordereau, has_create_project, has_print_letter, has_stats) VALUES (".$i_var['id_user'].", '".$i_var['username']."', '".$i_var['firstname']."', '".$i_var['surname']."', '".sha1($i_var['password'])."', ".$i_var['user_status'].", ".$i_var['id_dept'].",
 ".$i_var['has_create_file'].", ".$i_var['has_create_bordereau'].", ".$i_var['has_create_project'].", ".$i_var['has_print_letter'].", ".$i_var['has_stats'].");";


        $queries['delete_from_user1']="DELETE FROM user1 WHERE id_user='".$i_var['id_user']."';";


        $queries['select_user1']="SELECT * FROM user1 ".$filter.$order.$limit.";";


        $queries['update_is_minister'][0]="UPDATE user1 SET is_minister='0' WHERE id_user='".$i_var['old_minister']."';";

        $queries['update_is_minister'][1]="UPDATE user1 SET is_minister='1' WHERE id_user='".$i_var['new_minister']."';";


        $queries['update_is_gen_dir'][0]="UPDATE user1 SET is_gen_dir='0' WHERE id_user='".$i_var['old_gen_dir']."';";

        $queries['update_is_gen_dir'][1]="UPDATE user1 SET is_gen_dir='1' WHERE id_user='".$i_var['new_gen_dir']."';";


        $queries['search1']= "SELECT file1.*, transfer1.*, file_type1.*, department1.* FROM file1, file_type1, transfer1, department1 WHERE file1.last_trans=transfer1.id_trans AND file1.file_type=file_type1.id_file_type AND file1.file_dept=department1.id_dept ".$filter." GROUP BY transfer1.id_file".$limit.";";


        $queries['search2']= "SELECT file1.*, transfer1.*, file_type1.*, department1.*, client1.* FROM file1, file_type1, transfer1, department1, client1 WHERE file1.last_trans=transfer1.id_trans AND file1.file_type=file_type1.id_file_type AND file1.file_dept=department1.id_dept AND file1.id_file=client1.id_file ".$filter." GROUP BY transfer1.id_file".$limit.";";


        $queries['search3']=  "SELECT file1.*, transfer1.*, file_type1.*, department1.*, client1.*, project1.* FROM file1, file_type1, transfer1, department1, client1, project1 WHERE file1.last_trans=transfer1.id_trans AND file1.file_type=file_type1.id_file_type AND file1.file_dept=department1.id_dept AND file1.id_file=client1.id_file AND file1.id_file=project1.id_file".$filter." GROUP BY transfer1.id_file".$limit.";";


        $queries['search_project1']=  "SELECT project1.*, transfer1.dept_comingfrom FROM project1 INNER JOIN transfer1 ON project1.last_trans=transfer1.id_trans".$filter.$order.$limit.";";


        $queries['search_project2']=  "SELECT project1.*, transfer1.dept_comingfrom FROM project1 INNER JOIN transfer1 ON project1.last_trans=transfer1.id_trans INNER JOIN client1 ON project1.id_proj=client1.id_proj".$filter.$order.$limit.";";


        $queries['select_client_extra']= "SELECT client1.*, client_class1.*, project_type1.name_proj_type, qualification.name_qual FROM client1, client_class1, project_type1, qualification1 WHERE  client1.id_client=client_class1.id_client AND client_class1.id_qual=qualification1.id_qual".$filter.$order.$limit.";";


        $queries['insert_letter1']="INSERT INTO letter1(id_dept, id_user, title_letter, body_letter ,last_modified, describe_letter) VALUES (".$i_var['id_dept'].", ".$i_var['id_user'].", '".$i_var['title_letter']."', '".$i_var['body_letter']."', ".$i_var['last_modified'].", '".$i_var['describe_letter']."');";


        $queries['save_letter1']="INSERT INTO letter1(id_letter, id_dept, id_user, title_letter, body_letter, last_modified, describe_letter) VALUES (".$i_var['id_letter'].", ".$i_var['id_dept'].", ".$i_var['id_user'].", '".$i_var['title_letter']."', '".$i_var['body_letter']."', ".$i_var['last_modified'].", '".$i_var['describe_letter']."');";


        $queries['delete_from_letter1']="DELETE FROM letter1 WHERE id_letter='".$i_var['id_letter']."';";

        $queries['select_letter1']="SELECT * FROM letter1 ".$filter.$order.$limit.";";


        $queries['insert_print_letter1']="INSERT INTO print_letter1(date_created, id_user, id_proj, id_letter, total_cc, is_printed) VALUES (".$i_var['date_created'].", ".$i_var['id_user'].", ".$i_var['id_proj'].", ".$i_var['id_letter'].", ".$i_var['total_cc'].", ".$i_var['is_printed'].");";


        $queries['delete_from_print_letter1']="DELETE FROM print_letter1 WHERE id_print_letter IN (".$i_var['id_list'].");";



        $queries['select_letter_toprint']="SELECT letter1.*, print_letter1.date_created AS date_letter FROM letter1 LEFT JOIN print_letter1 ON letter1.id_letter= print_letter1.id_letter".$filter.$order." LIMIT 1;";



        $queries['select_print_letter1']="SELECT print_letter1.*, letter1.*, project1.*, project1.id_proj AS pr_id_proj, print_letter1.date_created AS plt_date_created, print_letter1.id_user AS plt_id_user FROM print_letter1 INNER JOIN letter1 ON print_letter1.id_letter= letter1.id_letter INNER JOIN project1 ON print_letter1.id_proj= project1.id_proj INNER JOIN transfer1 ON project1.last_trans=transfer1.id_trans WHERE transfer1.status_trans <> '2'".$filter.$order.$limit.";";


        $queries['update_is_printed'][0]= "UPDATE print_letter1 SET is_printed='1', date_printed=NOW() ".$filter.$order.$limit.";";


        $queries['update_not_printed']= "UPDATE print_letter1 SET is_printed='0' ".$filter.$order.$limit.";";



        $queries['insert_rank1']="INSERT INTO rank1(id_serv, id_work, work_cat, name_rank, determ_rank) VALUES (".$i_var['id_serv'].", ".$i_var['id_work'].", '".$i_var['work_cat']."', '".$i_var['name_rank']."', '".$i_var['determ_rank']."');";



        $queries['save_rank1']="INSERT INTO rank1(id_rank, id_serv, id_work, work_cat, name_rank, determ_rank) VALUES (".$i_var['id_rank'].", ".$i_var['id_serv'].", ".$i_var['id_work'].", '".$i_var['work_cat']."', '".$i_var['name_rank']."', '".$i_var['determ_rank']."');";



        $queries['delete_from_rank1']="DELETE FROM rank1 WHERE id_rank='".$i_var['id_rank']."';";


        $queries['select_rank1']="SELECT * FROM rank1 ".$filter.$order.$limit.";";


        $queries['insert_service1']="INSERT INTO service1(name_serv, determ_serv) VALUES ('".$i_var['name_serv']."', '".$i_var['determ_serv']."');";



        $queries['save_service1']="INSERT INTO service1(id_serv, name_serv, determ_serv) VALUES (".$i_var['id_serv'].", '".$i_var['name_serv']."', '".$i_var['determ_serv']."');";



        $queries['delete_from_service1']="DELETE FROM service1 WHERE id_serv='".$i_var['id_serv']."';";


        $queries['select_service1']="SELECT * FROM service1 ".$filter.$order.$limit.";";


        $queries['insert_stat_report1']="INSERT INTO stat_report1(id_dept, stat_method, title_report, describe_report) VALUES (".$i_var['id_dept'].", '".$i_var['stat_method']."', '".$i_var['title_report']."', '".$i_var['describe_report']."');";


        $queries['save_stat_report1']="INSERT INTO stat_report1(id_stat_report, id_dept, stat_method, title_report, describe_report) VALUES (".$i_var['id_stat_report'].", ".$i_var['id_dept'].", '".$i_var['stat_method']."', '".$i_var['title_report']."', '".$i_var['describe_report']."');";


        $queries['delete_from_stat_report1']="DELETE FROM stat_report1 WHERE id_stat_report='".$i_var['id_stat_report']."';";


        $queries['select_stat_report1']="SELECT * FROM stat_report1 ".$filter.$order.$limit.";";



        $queries['insert_work1']="INSERT INTO work1(id_serv, name_work, determ_work) VALUES (".$i_var['id_serv'].", '".$i_var['name_work']."', '".$i_var['determ_work']."');";



        $queries['save_work1']="INSERT INTO work1(id_work, id_serv, name_work, determ_work) VALUES (".$i_var['id_work'].", ".$i_var['id_serv'].", '".$i_var['name_work']."', '".$i_var['determ_work']."');";



        $queries['delete_from_work1']="DELETE FROM work1 WHERE id_work='".$i_var['id_work']."';";


        $queries['select_work1']="SELECT * FROM work1 ".$filter.$order.$limit.";";


        $queries['last_file_transfers']= "SELECT transfer1.id_file AS t_id_file, transfer1.id_proj AS t_id_proj, file1.*, file_type1.*, transfer1.*, department1.* FROM file1, file_type1, transfer1, department1 WHERE file1.last_trans=transfer1.id_trans AND file1.file_type=file_type1.id_file_type AND file1.file_dept=department1.id_dept AND transfer1.id_proj='0' ".$filter." ORDER BY file1.id_file DESC ".$limit.";";


        $queries['last_project_transfers']= "SELECT transfer1.id_file AS t_id_file, transfer1.id_proj AS t_id_proj, file1.*, file1.id_file AS f_id_file, project1.*, project1.date_created AS p_date_created, file_type1.*, transfer1.*, department1.* FROM project1, file1, file_type1, transfer1, department1 WHERE project1.last_trans=transfer1.id_trans AND project1.id_file=file1.id_file AND project1.proj_dept=department1.id_dept AND file1.file_type=file_type1.id_file_type ".$filter." ORDER BY project1.id_proj DESC ".$limit.";";
    }
}
