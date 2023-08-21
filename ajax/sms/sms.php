<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] =='GET') {
        include("../../connections/conn1.php");
        include("../../connections/conn2.php");
        if (isset($_GET['getMyStaff'])) {
            $select = "SELECT `fullname`,`phone_number` FROM `user_tbl` WHERE `school_code` = ? AND `deleted` = 0";
            $stmt = $conn->prepare($select);
            $schoolcode = $_SESSION['schoolcode'];
            $stmt->bind_param("s",$schoolcode);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<select id='select_staff_sms'><option value='' hidden>Select staff..</option>";
                $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $data_to_display.="<option value='".$row['phone_number']."'>".$row['fullname']."</option>";
                }
                $data_to_display.="</select>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No staff present.</p>";
                }
            }
        }elseif (isset($_GET['send_sms'])) {
            include("../../sms_apis/sms.php");
            $phone_number = $_GET['phone_no'];
            $message = $_GET['message'];
            $school = 1;
            $api_key = getApiKeySms($conn2);
            //check if the school has its own api keys
            if ($api_key == 0) {
                $school = 0;
                $api_key = getApiKeySms($conn);
            }
            //echo $api_key;
            if ($api_key !== 0) {
                    if ($school == 0) {
                        $partnerID = getPatnerIdSms($conn);
                        $shortcodes = getShortCodeSms($conn);
                    }else {
                        $partnerID = getPatnerIdSms($conn2);
                        $shortcodes = getShortCodeSms($conn2);
                    }
                //send sms
                echo sendSmsToClient($phone_number,$message,$api_key,$partnerID,$shortcodes);
            }else {
                echo "<p class='red_notice'>Activate your sms account!</p>";
            }
        }elseif (isset($_GET['check_delivery'])) {
            include("../../sms_apis/sms.php");
            $message_id = $_GET['message_id'];
            $api_key = getApiKeySms($conn);
            if ($api_key !== 0) {
                $partnerID = getPatnerIdSms($conn);
                echo checkDelivery($api_key,$partnerID,$message_id);
            }else {
                echo "<p class='red_notice'>Activate your sms account!</p>";
            }
        }elseif (isset($_GET['sms_val'])) {
            //$select = "INSERT INTO `sms_table` (`message_count`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`message_description`,`sender_no`,`message`) VALUES (?,?,?,?,?,?,?)";
            $select = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_undelivered`,`message_sent_succesfully`,`message_type`,`sender_no`,`message_description`,`message`) VALUES (?,?,?,?,?,?,?,?)";
            $message_type = $_GET['message_type'];
            $message_count = $_GET['message_count'];
            $recipient_no = $_GET['recipient_no'];
            $text_message = $_GET['text_message'];
            $message_desc = substr($_GET['text_message'],0,45)."...";
            $stmt = $conn2->prepare($select);
            $date = date("Y-m-d", strtotime("3 hour"));
            $stmt->bind_param("ssssssss",$message_count,$date,$message_count,$message_count,$message_type,$recipient_no,$message_desc,$text_message);
            $stmt->execute();
        }elseif (isset($_GET['mystaff_list'])) {
            $select = "SELECT `fullname`,`phone_number` FROM `user_tbl` WHERE `school_code` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$_SESSION['schoolcode']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<div class='staff_list'>";
                $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $data_to_display.="<div class='staff_dets'>
                                        <label style='font-size:12px;'>".$xs.".</label>
                                        <label for='p".$row['phone_number']."' style='font-size:12px;'>".ucwords($row['fullname'])."</label>
                                        <input type='checkbox' class='snamesd112e' name='p".$row['phone_number']."' id='p".$row['phone_number']."'>
                                    </div>";
                }
                $data_to_display.="</div>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No teachers present!</p>";
                }
            }
        }elseif (isset($_GET['parents_lists'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $valued = $row['valued'];
                    $data_to_display = "<select id='my-class'><option value='' hidden>Select class..</option>";
                    if (strlen($valued)>0) {
                        $class_list = explode(",",$valued);
                        if (count($class_list) > 0) {
                            for ($indez=0; $indez < count($class_list); $indez++) { 
                                $data_to_display.="<option value='".$class_list[$indez]."'>".majinaDarasa($class_list[$indez])."</option>";
                            }
                            $data_to_display.="</select>";
                            echo $data_to_display;
                        }else {
                            echo "<p class = 'red_notice'>No class avalable!</p>";
                        }
                    }else {
                        echo "<p class = 'red_notice'>No class avalable!</p>";
                    }
                }
            }
        }elseif (isset($_GET['get_parents_list'])) {
            $get_parents_list = $_GET['get_parents_list'];
            $select = "SELECT `first_name`,`second_name`,`adm_no` FROM `student_data` WHERE `stud_class` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$get_parents_list);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = 
                "<div class='w-50 my-2'>
                <hr>
                <h6 class='text-primary text-center'><u>Student to exempt in ".majinaDarasa($get_parents_list)."</u></h6>
                <div class='row'>
                    <div class='col-md-6'>
                    </div>
                    <div class='col-md-6'>
                        <input type='text' class='form-control w-100' placeholder='Search here...' id='search_student_sms'>
                    </div>
                </div>
                </div>
                <div class='staff_list w-50'><div class='staff_dets'>
                <label for='staff123s' style='color:cadetblue;'>Select all</label>
                <input type='checkbox' name='staff123s' id='staff123s'>
                </div>";
                $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $data_to_display.="<div class='staff_dets hide_students' id='hide_students".$row['adm_no']."'>
                                        <label style='font-size:12px;'>".$xs.".</label>
                                        <label class='text-left students_sms_names' style='font-size:14px;' id='imr".$row['adm_no']."' for='adm".$row['adm_no']."'>".ucwords(strtolower($row['first_name']." ".$row['second_name']))." <small style='color:red;'>(".$row['adm_no'].")</small></label>
                                        <input type='checkbox' class='student-class-par' name='adm".$row['adm_no']."' id='adm".$row['adm_no']."'>
                                    </div>";
                }
                $data_to_display.="</div><hr class='w-50'>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<div class='p-1 my-2 text-danger border border-danger w-50'>No students available in ".majinaDarasa($get_parents_list)."</div>";
                }
            }
        }elseif (isset($_GET['all_parents'])) {
            $select = "SELECT COUNT(*) AS 'Total' FROM `student_data` WHERE `stud_class` != '-1' AND `stud_class` != '-2'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    echo $row['Total'];
                }else {
                    echo 0;
                }
            }else {
                echo 0;
            }
        }elseif (isset($_GET['tr_ids_excempt'])) {
            include("../../sms_apis/sms.php");
            $tr_ids_excempt = $_GET['tr_ids_excempt'];
            $teacher_no = explode(",",$tr_ids_excempt);
            $db_tr_no = getTrNo($conn);
            $expl_db_trno = explode(",",$db_tr_no);
            //set the timeout to 300 seconds so that it can accomodate more requests
            set_time_limit(300);
            
            //get the tr that are not present

            $new_list = array();
            $string = "";
            for ($index=0; $index < count($expl_db_trno); $index++) { 
                $presnt = checkPresnt($teacher_no,$expl_db_trno[$index]);
                if ($presnt == 0) {
                    array_push($new_list,$expl_db_trno[$index]);
                    $string.=$expl_db_trno[$index].",";
                }
            }
            if (strlen($string) > 0 ) {
                $string = substr($string,0,(strlen($string)-1));
            }
            $echo_name = explode(",",$string);
            $message = $_GET['messages'];
            //the value below is used to determine of we can use the school api or the company`s api
            $school = 1;
            $api_key = getApiKeySms($conn2);
            //check if the school has its own api keys
            if ($api_key == 0) {
                $school = 0;
                $api_key = getApiKeySms($conn);
            }
            if ($api_key !== 0) {
                    if ($school == 0) {
                        $partnerID = getPatnerIdSms($conn);
                        $shortcodes = getShortCodeSms($conn);
                    }else {
                        $partnerID = getPatnerIdSms($conn2);
                        $shortcodes = getShortCodeSms($conn2);
                    }
                    
                    $count = 0;
                    $balance = 0;
                for ($index=0; $index < count($echo_name); $index++) { 
                    //send message to the numbers
                    $output_name = sendSmsToClient($echo_name[$index],$message,$api_key,$partnerID,$shortcodes);
                    //echo $output_name."<br>";
                    $json = json_decode($output_name);
                    //echo $json->{'response-description'}."<br>";
                    if (!isset($json->{'response-description'})) {
                        if (isset($json->{'responses'}[0]->{'response-description'})) {
                            if( $json->{'responses'}[0]->{'response-description'} !== null ||  $json->{'responses'}[0]->{'response-description'} === "Sucess"){
                                $count++;
                                //echo $json->{'responses'}[0]->{'response-description'}."<br>";
                            }
                        }
                    }elseif ($json->{'response-description'} == "Low bulk credits, Balance is 0.00") {
                        $balance++;
                    }
                    usleep(25000);
                    /***
                    if ($index == 0) {
                        //test one
                        break;
                    } */
                }
              //echo $count." ".$balance." ".count($echo_name);
                if ($balance == 0) {
                    echo "<p class='green_notice'>Messages sent successfully is ".$count." out of ".count($echo_name)." "."!</p>";
                    //send the information to the database
                    $insert = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`message_description`,`sender_no`,`message`) VALUES (?,?,?,?,?,?,?,?)";
                    $stmt = $conn2->prepare($insert);
                    $message_count = count($echo_name);
                    $message_undelivered = $message_count - $count;
                    $message_type = "Broadcast";
                    $message_desc = $message."...";
                    if (strlen($message) > 43) {
                        $message_desc = substr($message,0,45)."...";
                    }
                    $date = date("Y-m-d", strtotime("3 hour"));
                    $stmt->bind_param("ssssssss",$message_count,$date,$count,$message_undelivered,$message_type,$message_desc,$message_count,$message);
                    if($stmt->execute()){
                        echo "<p class='green_notice'>Done!</p>";
                    }else {
                        echo "<p class='red_notice'>Error!</p>";
                    }
                }else {
                    $out_of = count($echo_name) - $balance;
                    if ($out_of == 0) {
                        $out_of = $balance;
                    }
                    echo "<p class='green_notice'>Messages sent successfully is ".$count." out of ".$out_of."!<br>".$balance." not sent due to low credit</p>";
                    //send the information to the database
                    if ($count>0) {
                        $insert = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`message_description`,`sender_no`,`message`) VALUES (?,?,?,?,?,?,?,?)";
                        $stmt = $conn2->prepare($insert);
                        $message_count = $out_of;
                        $message_undelivered = $message_count - $count;
                        $message_type = "Broadcast";
                        $message_desc = $message."...";
                        if (strlen($message) > 43) {
                            $message_desc = substr($message,0,45)."...";
                        }
                        $date = date("Y-m-d",strtotime("3 hour"));
                        $stmt->bind_param("ssssssss",$message_count,$date,$count,$message_undelivered,$message_type,$message_desc,$message_count,$message);
                        if($stmt->execute()){
                            echo "<p class='green_notice'>Done!</p>";
                        }else {
                            echo "<p class='red_notice'>Error!</p>";
                        }
                    }

                }
            }
            //echo $string;
        }elseif (isset($_GET['parents_ids_excempt'])) {
            // get all student information excluding those transfered and the alumni
            $student_data = getStudentData($conn2);
            // var_dump($student_data);
            $which_parent = $_GET['to_whom'];
            $data = $_GET['parents_ids_excempt'];
            $xeploded_data = explode(",",$data);
            $api_key = getApiKeySms($conn);
            if ($api_key !== 0){
                $partnerID = getPatnerIdSms($conn);
                $shortcodes = getShortCodeSms($conn);
                $balance = 0;
                $count = 0;
                // send my sms
                include("../../sms_apis/sms.php");
                include("../finance/financial.php");
                for ($index=0; $index < count($student_data); $index++) { 
                    $primary_parent = $student_data[$index]['parentContacts'];
                    $secondary_parent = $student_data[$index]['parent_contact2'];
                    $phone_number = $primary_parent;
                    $message_count = 0;
                    if ($which_parent == "both") {
                        $phone_number = $primary_parent.",".$secondary_parent;
                        $message_count = 1;
                    }elseif ($which_parent == "primary") {
                        $phone_number = $primary_parent;
                        $message_count = 1;
                    }elseif ($which_parent == "secondary") {
                        $phone_number = $secondary_parent;
                        $message_count = 1;
                    }else {
                        $phone_number = $primary_parent;
                        $message_count = 1;
                    }
                    if (checkPresnt($xeploded_data,$student_data[$index]['adm_no']) == 0) {
                        // process message
                        $message = $_GET['messages'];
                        if ($which_parent == "both") {
                            $phone_number = explode(",",$phone_number);
                            $message1 = process_sms($student_data,$message,$student_data[$index]['adm_no'],$conn2,"primary");
                            $message2 = process_sms($student_data,$message,$student_data[$index]['adm_no'],$conn2,"secondary");
                            // echo "<br>".$message1."<br>". $message2;
                            
                            // SEND MESSAGE TO THE FIRST PARENT
                            //send message to the numbers
                            $output_name = sendSmsToClient($phone_number[0],$message1,$api_key,$partnerID,$shortcodes);
                            //echo $output_name;
                            $json = json_decode($output_name);
                            if (strlen($output_name) > 0) {
                                try {
                                    if (!isset($json->{'response-description'})) {
                                        if (isset($json->{'responses'}[0]->{'response-description'})) {
                                            if( $json->{'responses'}[0]->{'response-description'} != null ||  $json->{'responses'}[0]->{'response-description'} == "Sucess"){
                                                $count++;
                                            }
                                        }
                                    }elseif ($json->{'response-description'} == "Low bulk credits, Balance is 0.00") {
                                        // $balance++;
                                    }
                                } catch (Exception $th) {
                                    echo "<p class='red_notice'>Not sent</p>";
                                }
                                /***
                                if ($index == 0) {
                                    //test one
                                    break;
                                } */
                            }
                            // save the data in the database
                            $insert = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`message_description`,`sender_no`,`message`) VALUES (?,?,?,?,?,?,?,?)";
                            $stmt = $conn2->prepare($insert);
                            $message_undelivered = 0;
                            $message_type = "Broadcast";
                            $message_desc = $message."...";
                            if (strlen($message) > 43) {
                                $message_desc = substr($message,0,45)."...";
                            }
                            $date = date("Y-m-d", strtotime("3 hour"));
                            $stmt->bind_param("ssssssss",$message_count,$date,$message_count,$message_undelivered,$message_type,$message_desc,$message_count,$message1);
                            if($stmt->execute()){
                                // echo "<p class='green_notice'>Messages sent successfully!</p>";
                                $count +=$message_count;
                            }else {
                                // echo "<p class='red_notice'>Error!</p>";
                            }

                            // SEND MESSAGE TO THE SECOND PARENT
                            //send message to the numbers
                            $output_name = sendSmsToClient($phone_number[1],$message2,$api_key,$partnerID,$shortcodes);
                            //echo $output_name;
                            $json = json_decode($output_name);
                            if (strlen($output_name) > 0) {
                                try {
                                    if (!isset($json->{'response-description'})) {
                                        if (isset($json->{'responses'}[0]->{'response-description'})) {
                                            if( $json->{'responses'}[0]->{'response-description'} != null ||  $json->{'responses'}[0]->{'response-description'} == "Sucess"){
                                                $count++;
                                            }
                                        }
                                    }elseif ($json->{'response-description'} == "Low bulk credits, Balance is 0.00") {
                                        // $balance++;
                                    }
                                } catch (Exception $th) {
                                    echo "<p class='red_notice'>Not sent</p>";
                                }
                                /***
                                if ($index == 0) {
                                    //test one
                                    break;
                                } */
                            }
                            // save the data in the database
                            $insert = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`message_description`,`sender_no`,`message`) VALUES (?,?,?,?,?,?,?,?)";
                            $stmt = $conn2->prepare($insert);
                            $message_undelivered = 0;
                            $message_type = "Broadcast";
                            $message_desc = $message."...";
                            if (strlen($message) > 43) {
                                $message_desc = substr($message,0,45)."...";
                            }
                            $date = date("Y-m-d", strtotime("3 hour"));
                            $stmt->bind_param("ssssssss",$message_count,$date,$message_count,$message_undelivered,$message_type,$message_desc,$message_count,$message2);
                            if($stmt->execute()){
                                // echo "<p class='green_notice'>Messages sent successfully!</p>";
                                $count +=$message_count;
                            }else {
                                // echo "<p class='red_notice'>Error!</p>";
                            }
                            // break;
                        }else {
                            $message = process_sms($student_data,$message,$student_data[$index]['adm_no'],$conn2,$which_parent);
                            // echo $message;
                            
                            //send message to the numbers
                            $output_name = sendSmsToClient($phone_number,$message,$api_key,$partnerID,$shortcodes);
                            //echo $output_name;
                            $json = json_decode($output_name);
                            if (strlen($output_name) > 0) {
                                try {
                                    if (!isset($json->{'response-description'})) {
                                        if (isset($json->{'responses'}[0]->{'response-description'})) {
                                            if( $json->{'responses'}[0]->{'response-description'} != null ||  $json->{'responses'}[0]->{'response-description'} == "Sucess"){
                                                $count++;
                                            }
                                        }
                                    }elseif ($json->{'response-description'} == "Low bulk credits, Balance is 0.00") {
                                        // $balance++;
                                    }
                                } catch (Exception $th) {
                                    echo "<p class='red_notice'>Not sent</p>";
                                }
                                /***
                                if ($index == 0) {
                                    //test one
                                    break;
                                } */
                            }
                            // save the data in the database
                            $insert = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`message_description`,`sender_no`,`message`) VALUES (?,?,?,?,?,?,?,?)";
                            $stmt = $conn2->prepare($insert);
                            $message_undelivered = 0;
                            $message_type = "Broadcast";
                            $message_desc = $message."...";
                            if (strlen($message) > 43) {
                                $message_desc = substr($message,0,45)."...";
                            }
                            $date = date("Y-m-d", strtotime("3 hour"));
                            $stmt->bind_param("ssssssss",$message_count,$date,$message_count,$message_undelivered,$message_type,$message_desc,$message_count,$message);
                            if($stmt->execute()){
                                // echo "<p class='green_notice'>Messages sent successfully!</p>";
                                $count +=$message_count;
                            }else {
                                // echo "<p class='red_notice'>Error!</p>";
                            }
                            // break;
                        }
                    }
                }
                echo "<p class='text-success'>You have successfully sent ".$count." message(s)!</p>";
            }
        }elseif (isset($_GET['get_my_trs'])) {
            $select = "SELECT `user_id`, `fullname` FROM `user_tbl` WHERE `school_code` = ? AND  NOT `user_id` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$_SESSION['schoolcode'],$_SESSION['userids']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<select id='select_staff_infors'>
                                        <option hidden value ='' >Select staff</option>";
                                        $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $data_to_display.="<option value ='".$row['user_id']."' >".$row['fullname']."</option>";
                }
                $data_to_display.="</select>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No staff present</p>";
                }
            }
        }elseif (isset($_GET['send_message_notice'])) {
            $reciever_id = $_GET['recpt_id'];
            $message = $_GET['message'];
            $messageName = "New Message";
            $reciever_auth = 'all';
            $sender_ids = $_SESSION['userids'];
            $notice_stat = 0;
            insertNotifcation_sms($conn2,$messageName,$message,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
            echo "<p class='green_notice'>Message sent successfully!</p>";
        }elseif (isset($_GET['recent_messages'])) {
            $select = "SELECT `message_count`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`date_sent`,`sender_no`,`message_description`,`message`,`charged` FROM `sms_table` ORDER BY `send_id` DESC LIMIT 7";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                $data_to_display = "";
                $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $charged = "<div class='charged'>
                                        <img src='images/coined.png' alt='charged'>
                                    </div>";
                    if ($row['charged'] == 0) {
                        $charged = "<div class='chargedd'>
                                        <!-- <img src='images/coined.png' alt='charged'> -->
                                    </div>";
                    }
                    $data_to_display.="<div class='one_message'>
                                        <div class='status'>
                                            <div class='message_type'>
                                                <p>".$row['message_type']."</p>
                                            </div>
                                            <div class='message_status'>
                                                <p>Delivered <small>(".$row['message_sent_succesfully']."/".$row['message_count'].")</small></p>
                                            </div>
                                        </div>
                                        <div class='message_detail'>
                                            <p class ='norm_unseen'>".$row['message_description']."</p>
                                            <p class = 'norm_seen'>".$row['message']."</p>
                                        </div>
                                        <div class='date_sent'>
                                            <div class='conts'>
                                                <p>".date("M-d-Y",strtotime($row['date_sent']))."</p>
                                            </div>
                                            ".$charged."
                                        </div>
                                    </div>";
                }
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p style='color:gray;font-weight:600;'>No recent messages!</p>";
                }
            }
        }elseif (isset($_GET['sms_history'])) {
            $from_date = isset($_GET['from']) ? $_GET['from'] : "";
            // $to_date = strlen(isset($_GET['to'])) > 0 ? $_GET['to'] : "";
            $to_date = isset($_GET['to']) ? $_GET['to'] : null;
            // echo $to_date." pine";
            $select = "SELECT `send_id`,`message_count`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`date_sent`,`sender_no`,`message_description`,`message`,`charged` FROM `sms_table` ORDER BY `send_id` DESC";
            if (isset($from_date) && isset($to_date)) {
                $select = "SELECT `send_id`,`message_count`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`date_sent`,`sender_no`,`message_description`,`message`,`charged` FROM `sms_table` WHERE date_sent BETWEEN '$from_date' AND '$to_date'  ORDER BY `send_id` DESC";
            }
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<div class = 'recent_messages'>";
                $xs = 0;
                $totalMessages = 0;
                $message_undelivered = 0;
                $message_delivered = 0;
                $to_charged_sh = 0;
                $deduct_charge = 0;
                $sms_data = [];
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $charged = "<div class='charged'>
                                        <img src='images/coined.png' alt='charged'>
                                    </div>";
                    if ($row['charged'] == 0) {
                        $charged = "<div class='chargedd'>
                                        <!-- <img src='images/coined.png' alt='charged'> -->
                                    </div>";
                    }
                    if ($row['charged'] == 1){
                        $deduct_charge+=1;
                    }
                    $date = date("dS M Y",strtotime($row['date_sent']));
                    $row = array_merge($row,array("date_sent2"=> $date));
                    array_push($sms_data,$row);
                    $totalMessages+= ($row['message_count']*1);
                    $message_delivered+=($row['message_sent_succesfully']*1);
                    $to_charged_sh+=($row['message_sent_succesfully']*1);//this is the amount to be charged
                    $message_undelivered+=($row['message_undelivered']*1);
                    $data_to_display.="<div class='one_message'>
                                        <div class='status'>
                                            <div class='message_type'>
                                                <p>".$row['message_type']."</p>
                                            </div>
                                            <div class='message_status'>
                                                <p>Delivered <small>(".$row['message_sent_succesfully']."/".$row['message_count'].")</small></p>
                                            </div>
                                        </div>
                                        <div class='message_detail'>
                                            <p class ='norm_unseen'>".$row['message_description']."</p>
                                            <p class = 'norm_seen'>".$row['message']."</p>
                                        </div>
                                        <div class='date_sent'>
                                            <div class='conts'>
                                                <p>".date("M-d-Y",strtotime($row['date_sent']))."</p>
                                            </div>
                                            ".$charged."
                                        </div>
                                    </div>";
                }
                $sms_data = json_encode($sms_data);
                // echo $sms_data;
                if ($xs > 0) {
                    $data_to_display.="</div>";
                    $result_title = "<h6>Results</h6>";
                    if (isset($from_date) && isset($to_date)) {
                        $result_title = "<h6>Results from ".date("M-dS-Y",strtotime($from_date))." to ".date("M-dS-Y",strtotime($to_date))."</h6>";
                    }
                    $counters = "<div class='short_detail'>
                                            ".$result_title."
                                            <p>Total Messages sent:  ".$totalMessages." SMS(s) <br> Delivered Messages:  ".$message_delivered." SMS(s) <br>Not delivered:  ".$message_undelivered." SMS(s) <br></p>
                                            <p>Charged units: ".($deduct_charge).".<br>Units to charge :  ".($to_charged_sh - $deduct_charge)." (Ksh ".($to_charged_sh - $deduct_charge).")<br></p>
                                        </div>";
                    echo $counters."<p class='hide' id='sms_data_results'>".$sms_data."</p>";
                }else {
                    echo "<p style='color:gray;font-weight:600;'>No messages found!</p>";
                }
            }
        }
        $conn->close();
        $conn2->close();
    }
    function getTrNo($conn){
        $select = "SELECT `phone_number`,`nat_id` FROM `user_tbl` WHERE `school_code` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$_SESSION['schoolcode']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $data = "";
            while ($row = $result->fetch_assoc()) {
                $data.=$row['phone_number'].",";
            }
            $data = substr($data,0,(strlen($data) - 1));
            return $data;
        }
        return 0;
    }
    function checkPresnt($array, $string){
        if (count($array)>0) {
            for ($i=0; $i < count($array); $i++) { 
                if ($string == $array[$i]) {
                    return 1;
                    break;
                }
            }
        }
        return 0;
    }
    function getApiKeySms($conn){
        $select = "SELECT `sms_api_key` FROM `sms_api`";
        $stmt = $conn->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['sms_api_key'];
            }
        }
        return 0;
    }
    function getPatnerIdSms($conn){
        $select = "SELECT `patner_id` FROM `sms_api`";
        $stmt = $conn->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['patner_id'];
            }
        }
        return 0;
    }
    function getShortCodeSms($conn){
        $select = "SELECT `short_code` FROM `sms_api`";
        $stmt = $conn->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['short_code'];
            }
        }
        return 0;
    }
    function majinaDarasa($data){
        if (strlen($data)>1) {
            return $data;
        }else {
            return "Grade ".$data;
        }
        return $data;
    }
    function getParentsNo($conn2,$arrays_id){
        $select = "SELECT `adm_no`,`parentContacts` FROM `student_data` WHERE `adm_no` != 'alumni'";
        $stmt = $conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = "";
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $presnt = checkPresnt($arrays_id,$row['adm_no']);
                if ($presnt == 0) {
                    $data.=$row['parentContacts'].",";
                }
            }
            $data = substr($data,0,(strlen($data)-1));
        }
        return $data;
    }
    function insertNotifcation_sms($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids){
        $insert = "INSERT INTO `tblnotification`  (`notification_name`,`Notification_content`,`sender_id`,`notification_status`,`notification_reciever_id`,`notification_reciever_auth`) VALUES (?,?,?,?,?,?)";
        $stmt = $conn2->prepare($insert);
        $stmt->bind_param("ssssss",$messageName,$messagecontent,$sender_ids,$notice_stat,$reciever_id,$reciever_auth);
        if($stmt->execute()){
            
        }
    }
    function getStudentData($conn2){
        $select = "SELECT * FROM `student_data` WHERE `stud_class` != '-1' AND `stud_class` != '-2';";
        $stmt = $conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        $student_data = [];
        if ($result) {
            while($row = $result->fetch_assoc()){
                array_push($student_data,$row);
            }
        }
        return $student_data;
    }
    function process_sms($student_data,$message,$adm_no = "0",$conn2,$which_parent){
        $final_message = $message;
        if ($adm_no == "0") {
            return $final_message;
        }
        $term = getTerm($conn2);
        if ($which_parent == "primary") {
            for ($index=0; $index < count($student_data); $index++) { 
                if ($student_data[$index]['adm_no'] == $adm_no) {
                    
                    $final_message = str_replace("{stud_fullname}",ucwords(strtolower($student_data[$index]['first_name']." ".$student_data[$index]['second_name'])),$final_message);
                    $final_message = str_replace("{stud_first_name}",ucwords(strtolower($student_data[$index]['first_name'])),$final_message);
                    $final_message = str_replace("{stud_class}",majinaDarasa($student_data[$index]['stud_class']),$final_message);
                    $dob = date_create($student_data[$index]['D_O_B']);
                    $today = date_create(date("Y-m-d"));
                    $date_diff = date_diff($dob,$today);
                    $date_diff = $date_diff->format("%y Yr(s)");
                    $balance = number_format(getBalance($student_data[$index]['adm_no'],$term,$conn2));
                    $fees_paid = getFeespaidByStudent($student_data[$index]['adm_no'],$conn2);
                    $fees_to_pay = getFeesAsPerTermBoarders($term,$conn2,$student_data[$index]['stud_class'],$student_data[$index]['adm_no']);
                    $final_message = str_replace("{stud_age}",$date_diff,$final_message);
                    $final_message = str_replace("{stud_fees_balance}",$balance,$final_message);
                    $final_message = str_replace("{stud_fees_to_pay}",$fees_to_pay,$final_message);
                    $final_message = str_replace("{stud_fees_paid}",$fees_paid,$final_message);
                    $final_message = str_replace("{stud_noun}",($student_data[$index]['gender'] == "Female" ?"daughter":"son"),$final_message);
                    $final_message = str_replace("{par_fullname}",ucwords(strtolower($student_data[$index]['parentName'])),$final_message);
                    $final_message = str_replace("{par_first_name}",ucwords(strtolower(explode(" ",$student_data[$index]['parentName'])[0])),$final_message);
                    $final_message = str_replace("{title_1}",(((strtolower($student_data[$index]['parent_relation']) == "guardian") ? "":"check") == "check") ? (strtolower($student_data[$index]['parent_relation']) == "father" ? "Mr" : "Mrs"):"",$final_message);
                    $final_message = str_replace("{title_2}",(((strtolower($student_data[$index]['parent_relation']) == "guardian") ? "":"check") == "check") ? (strtolower($student_data[$index]['parent_relation']) == "father" ? "Sir" : "Madam"):"",$final_message);
                    $today = date("D dS M, Y");
                    $final_message = str_replace("{today}",$today,$final_message);
                }
            }
        }else {
            for ($index=0; $index < count($student_data); $index++) { 
                if ($student_data[$index]['adm_no'] == $adm_no) {
                    
                    $final_message = str_replace("{stud_fullname}",ucwords(strtolower($student_data[$index]['first_name']." ".$student_data[$index]['second_name'])),$final_message);
                    $final_message = str_replace("{stud_first_name}",ucwords(strtolower($student_data[$index]['first_name'])),$final_message);
                    $final_message = str_replace("{stud_class}",majinaDarasa($student_data[$index]['stud_class']),$final_message);
                    $dob = date_create($student_data[$index]['D_O_B']);
                    $today = date_create(date("Y-m-d"));
                    $date_diff = date_diff($dob,$today);
                    $date_diff = $date_diff->format("%y Yr(s)");
                    $balance = number_format(getBalance($student_data[$index]['adm_no'],$term,$conn2));
                    $fees_paid = getFeespaidByStudent($student_data[$index]['adm_no'],$conn2);
                    $fees_to_pay = getFeesAsPerTermBoarders($term,$conn2,$student_data[$index]['stud_class'],$student_data[$index]['adm_no']);
                    $final_message = str_replace("{stud_age}",$date_diff,$final_message);
                    $final_message = str_replace("{stud_fees_balance}",$balance,$final_message);
                    $final_message = str_replace("{stud_fees_to_pay}",$fees_to_pay,$final_message);
                    $final_message = str_replace("{stud_fees_paid}",$fees_paid,$final_message);
                    $final_message = str_replace("{stud_noun}",($student_data[$index]['gender'] == "Female" ?"daughter":"son"),$final_message);
                    $final_message = str_replace("{par_fullname}",ucwords(strtolower($student_data[$index]['parent_name2'])),$final_message);
                    $final_message = str_replace("{par_first_name}",ucwords(strtolower(explode(" ",$student_data[$index]['parent_name2'])[0])),$final_message);
                    $final_message = str_replace("{title_1}",(((strtolower($student_data[$index]['parent_relation2']) == "guardian") ? "":"check") == "check") ? (strtolower($student_data[$index]['parent_relation2']) == "father" ? "Mr" : "Mrs"):"",$final_message);
                    $final_message = str_replace("{title_2}",(((strtolower($student_data[$index]['parent_relation2']) == "guardian") ? "":"check") == "check") ? (strtolower($student_data[$index]['parent_relation2']) == "father" ? "Sir" : "Madam"):"",$final_message);
                    $today = date("D dS M, Y");
                    $final_message = str_replace("{today}",$today,$final_message);
                }
            }
        }
        return $final_message;
    }
?>