<?php




/*////////////////////////////////////////////////////////////////////////////////////////////////////////////

@author Novi Sonko 2012

////////////////////////////////////////////////////////////////////////////////////////////////////////*/




class import_queries
{
    public function get_queries($i_var, $filter, $order, $limit, &$queries= array())
    {
        global $t;


        $queries['old_select_file']= "SELECT * FROM arret ".$filter.$order.$limit.";";


        $queries['new_insert_file']= "INSERT INTO file1(file_dept, file_type, file_category, title, date_created, file_status, file_ref, file_date, last_trans) VALUES (1, 1, 1, '".$i_var['file_ref']."', ".$i_var['date_created'].", 1, '".$i_var['file_ref']."', '000-00-00', 0);";


        $queries['new_insert_file_trans']= "INSERT INTO transfer1(id_file, date_trans, id_user, dept_comingfrom, dept_goingto, describe_trans, status_trans, id_carrier, info_carrier) VALUES (".$i_var['new_id'].", NOW(), 1, 0, 1, '".$t->file_created."', 0, ".$i_var['id_carrier'].", '".$i_var['info_carrier']."');";


        $queries['old_select_project']= "SELECT * FROM arret ".$filter.$order.$limit.";";


        $queries['new_insert_project']= "INSERT INTO project1(proj_ref, proj_dept, proj_type, date_created, id_file, id_bordereau, proj_status, last_trans) VALUES ('".$i_var['proj_ref']."', 1, 1, NOW(), ".$i_var['id_file'].", '', 0, 0);";


        $queries['new_insert_proj_trans']= "INSERT INTO transfer1(id_proj, date_trans, id_user, dept_comingfrom, dept_goingto, describe_trans, status_trans, id_carrier, info_carrier) VALUES (".$i_var['new_id'].", NOW(), 1, 1, 1, '".$t->project_created."', 0, ".$i_var['id_carrier'].", '".$i_var['info_carrier']."');";


        $queries['old_select_client']= "SELECT * FROM arret INNER JOIN dossier ON arret.idarr=dossier.idarr INNER JOIN candidat ON dossier.Matricule=candidat.idcd ".$filter.$order.$limit.";";



        $queries['new_insert_client']= "INSERT INTO client1(id_file, id_proj, id_agent, surname, firstname, determ_client, date_birth, town_birth, client_type, sex, num_phone, email) VALUES (".$i_var['id_file'].", ".$i_var['id_proj'].", 0, '".$i_var['surname']."', '".$i_var['firstname']."', '".$i_var['determ_client']."', '".$i_var['date_birth']."', '".$i_var['town_birth']."', 0, ".$i_var['sex'].", 0, '');";



        $queries['old_select_id_bordereau']= "SELECT NumBordT, idarr FROM bordereaut".$filter.$order.$limit.";";


        $queries['new_insert_id_bordereau']= "UPDATE project1 SET id_bordereau='".$i_var['year_id_bordereau']."' WHERE id_proj='".$i_var['id_proj']."' ;";
    }
}
