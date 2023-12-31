<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require("../../assets/encrypt/functions.php");
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['log'])){
            $username = $_GET['username'];
            $_SESSION['unames'] = $username;
            include ("../../connections/conn1.php");
            $select = "SELECT `fullname` , `school_code`, `gender` ,`auth`,`user_id` ,`deleted` ,`activated` FROM `user_tbl` WHERE `username` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $stmt->store_result();
            $rnum = $stmt->num_rows;
            if($rnum>0){
                $stmt->execute();
                $results = $stmt->get_result();
                if($results){
                    $data="";
                    if ($rows=$results->fetch_assoc()) {
                        $deleted = $rows['deleted'];
                        $activated = $rows['activated'];
                        if ($deleted==0 && $activated == 1) {
                            $usernames = $rows['fullname'];
                            $schcode = $rows['school_code'];
                            $userauth = $rows['auth'];
                            $checkcoded = checkCode($schcode,$conn);
                            if ($checkcoded) {
                                $allowed = allowedIn($userauth,$conn,$schcode);
                                if($allowed){
                                    $_SESSION['username'] = $usernames;
                                    $_SESSION['schcode'] = $schcode;
                                    $_SESSION['authority'] = $userauth;
                                    $_SESSION['gender'] = $rows['gender'];
                                    $_SESSION['userids'] = $rows['user_id'];
                                    $select = "SELECT `school_name`,`po_box`,`box_code`,`school_motto`,`school_admin_name`, `sch_message_name` , `school_mail` , `school_contact` ,`sch_mission`,`database_name`,`sch_vision`, `county`,`country`,`ct_cg` from `school_information` where `school_code` = ?";
                                    $stmt->close();
                                    $stmt = $conn->prepare($select);
                                    $stmt->bind_param("s",$schcode);
                                    $stmt->execute();
                                    $stmt->store_result();
                                    $rnums = $stmt->num_rows;
                                    if($rnums>0){
                                        $stmt->execute();
                                        $results = $stmt->get_result();
                                        if($results){
                                            $data = "";
                                            if($row = $results->fetch_assoc()){
                                                $snames=" ".$row['school_name'];
                                                $smotto =" ".$row['school_motto'];
                                                $schmission=" ".$row['sch_mission'];
                                                $dbnames ="".$row['database_name'];
                                                $schvission =" ".$row['sch_vision'];
                                                $school_mail = $row['school_mail'];
                                                $school_contact = $row['school_contact'];
                                                $sch_mgs_name = $row['sch_message_name'];
                                                $admin_name = $row['school_admin_name'];
                                                $po_box = $row['po_box'];
                                                $box_code = $row['box_code'];
                                                $sch_country = $row['country'];
                                                $sch_county = $row['county'];
                                                $ct_cg = $row['ct_cg'];
                                            }
                                            $_SESSION['ct_cg'] = $ct_cg;
                                            $_SESSION['sch_countrys'] = $sch_country;
                                            $_SESSION['sch_countys'] = $sch_county;
                                            $_SESSION['schname'] = $snames;
                                            $_SESSION['smotto'] = $smotto;
                                            $_SESSION['schmission'] = $schmission;
                                            $_SESSION['dbname'] = $dbnames;
                                            $_SESSION['schvission'] = $schvission;
                                            $_SESSION['school_contact'] = $school_contact;
                                            $_SESSION['school_mail'] = $school_mail;
                                            $_SESSION['sch_mgs_name'] = $sch_mgs_name;
                                            $_SESSION['admin_name'] = $admin_name;
                                            $_SESSION['po_boxs'] = $po_box;
                                            $_SESSION['box_codes'] = $box_code;
                                            if ($userauth == 5) {
                                                $dbname = $_SESSION['dbname'];
                                                $hostname = 'localhost';
                                                $dbusername ='root';
                                                // $dbpassword = '2000hILARY';
                                                $dbpassword = '';
                                                if (isset($dbname)) {
                                                    $conn2 = new mysqli($hostname,$dbusername,$dbpassword,$dbname);
                                                    if(mysqli_connect_error()){
                                                        echo "<p style='color:red;'>Connection was lost.</p>";
                                                        //die("Connect Error ( ".mysqli_connect_errno()." ) ".mysqli_connect_error());
                                                    }else{
                                                        
                                                    }
                                                }
                                                //get the class the class teacher is assigned
                                                $select = "SELECT `class_assigned` FROM `class_teacher_tbl` WHERE `class_teacher_id` = ?";
                                                $stmt = $conn2->prepare($select);
                                                $stmt->bind_param("s",$_SESSION['userids']);
                                                $stmt->execute();
                                                $results = $stmt->get_result();
                                                if ($results) {
                                                    if ($row = $results->fetch_assoc()) {
                                                        $_SESSION['class_taughts'] = $row['class_assigned'];
                                                    }
                                                }
                                            }
                                            exit();
                                        }else {
                                            echo "<p>An error occured!</p>";
                                        }
                                    }else{
                                        echo "<p class='data' style='color:rgb(121, 19, 19);'>Access denied!!<br>Contact your administrator to be allowed back in</p>";
                                    }
                                }else {
                                    echo "<p style='color:red;font-size:13px;font-weight:500;'>Access denied!<br>You cannot be allowed in at this time.<br>Try again <br>".getActiveHours($_SESSION['schcode'],$conn)."</p>";
                                }
                            }else {
                                echo "<p style='color:red;font-size:13px;font-weight:500;'>Access denied!<br>Your school isn`t active right now.<br>Try again later<br></p>";
                            }
                        }else {
                            echo "<p class='data' style='color:rgb(121, 19, 19);'>Access denied!!<br>Contact your administrator to be allowed back in</p>";
                        }
                    }
                }else{
                    echo "<p>An error occured!</p>";
                }
                
            }else{
                echo "<p class='data' style='color:rgb(121, 19, 19);'>Invalid username!</p>";
            }
        }elseif (isset($_GET['password'])) {
            include_once("../../assets/encrypt/encrypt.php");
            $passwords = encryptCode( $_GET['password']);
            $username = $_GET['usernames'];
            include ("../../connections/conn1.php");
            $select = "SELECT `fullname` , `school_code`, `gender` ,`auth` FROM `user_tbl` WHERE `username` = ? and `password` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$username,$passwords);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if($rnums>0){
                $data = "<p style = 'color:green;'>Correct credentials <br>Access granted as:";
                $authority = $_SESSION['authority'];
                if($authority==0){
                    $data.="<br> admin</p>";
                }elseif ($authority==1) {
                    $data.="<br> Headteacher</p>";
                }elseif ($authority ==2) {
                    $data.="<br> Teacher</p>";
                }elseif ($authority == 3) {
                    $data.="<br> Deputy principal</p>";
                }elseif ($authority == 4) {
                    $data.="<br> Staff</p>";
                }elseif ($authority == 6) {
                    $data.="<br> Student</p>";
                }elseif ($authority == 5) {
                    $data.="<br> Class Teacher</p>";
                }else {
                    $data.=$authority;
                }
                echo $data;
            }else {
                echo "<p style = 'color:red;'>Inorrect credentials <br>Access denied</p>";
            }
            $stmt->close();
            $conn->close();
        }elseif (isset($_GET['getSchoolInformation'])) {
            echo $_SESSION['schoolcode']."|".$_SESSION['schoolname']."|".$_SESSION['schoolmotto']."|".$_SESSION['schoolmission']."|".$_SESSION['databasename']."|".$_SESSION['schoolvission']."|".$_SESSION['school_contacts']."|".$_SESSION['school_mails']."|".$_SESSION['school_message_name']."|".$_SESSION['administrator_name']."|".$_SESSION['po_boxs']."|".$_SESSION['box_codes']."|".$_SESSION['sch_countrys']."|".$_SESSION['sch_countys'];
        }elseif (isset($_GET['update_school_information'])) {
            include ("../../connections/conn1.php");
            $school_name = $_GET['school_name'];
            $school_motto = $_GET['school_motto'];
            $school_mail = $_GET['administrator_email'];
            $school_message = $_GET['school_message_name'];
            $school_admin = $_GET['administrator_name'];
            $school_admin_contact = $_GET['administrator_contacts'];
            $school_code = $_GET['school_codes'];
            $school_vission = $_GET['school_vission'];
            $postalcode = $_GET['postalcode'];
            $sch_box_no = $_GET['sch_box_no'];
            $sch_country = $_GET['sch_country'];
            $sch_county = $_GET['sch_county'];
            $update = "UPDATE `school_information` SET `school_name` = ?, `sch_message_name` = ?,`school_motto` = ?, `school_admin_name` =?, `school_contact` = ?, `school_mail` = ?,`sch_vision` = ?, `po_box` = ?,`box_code` = ?, `county` = ?, `country` = ? WHERE `school_code` = ?";
            //$update = "UPDATE `school_information` SET `school_name` = ?, `sch_message_name`=?, `school_admin_name` =?, `school_motto` = ?, `school_mail` = ?,`school_mail` = ? , `sch_vision` = ?, `po_box` = ?,`box_code` = ?, `county` = ?,`country` = ? WHERE `school_code` = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("ssssssssssss",$school_name,$school_message,$school_motto,$school_admin,$school_admin_contact,$school_mail,$school_vission,$sch_box_no,$postalcode,$sch_county,$sch_country,$_SESSION['schoolcode']);
            if($stmt->execute()){
                echo "<p class='green_notice fa-sm'>Update has been done sucessfully<br>The changes will take effect next time you login!</p>";
            }else {
                echo "<p class='red_notice fa-xs'>An error has occured during update!</p>";
            }
            $stmt->close();
            $conn->close();
        }elseif (isset($_GET['get_my_information'])) {
            include ("../../connections/conn1.php");
            $user_id = $_SESSION['userids'];
            $select = "SELECT `fullname`,`dob`,`school_code`,`phone_number`,`gender`,`address`,`nat_id`,`tsc_no`,`username`,`auth`,`email` FROM `user_tbl` WHERE `user_id` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$user_id);
            $stmt->execute();
            $results = $stmt->get_result();
            if ($results) {
                if ($row = $results->fetch_assoc()) {
                        $authority = $_SESSION['auth'];
                        $data ="<p style = 'margin-top:10px;'>Your Role: ";
                        $class = '0';
                        $classasigned = '0';
                        if($authority==0){
                            $data.="<b>admin</b></p>";
                        }elseif ($authority==1) {
                            $data.="<b> Headteacher</b>";
                            $data.="<br>".getSubjectsAndClassTaught($user_id)."</p>";
                        }elseif ($authority ==2) {
                            $data.="<b> Teacher</b>";
                            $data.="<br>".getSubjectsAndClassTaught($user_id)."</p>";
                        }elseif ($authority == 3) {
                            $data.="<b> Deputy principal</b>";
                            $data.="<br>".getSubjectsAndClassTaught($user_id)."</p>";
                        }elseif ($authority == 4) {
                            $data.="<b> Staff</b>";
                            $data.="<br>".getSubjectsAndClassTaught($user_id)."</p>";
                        }elseif ($authority == 5) {
                            $data.="<b> Class teacher</b><br>";
                            $data.="Your assigned class: ".getClassTaught($user_id)."<br>".getSubjectsAndClassTaught($user_id)."</p>";
                        }
                    echo $data.="<span class='hide' id='my_information'>".$row['fullname']."|".$row['dob']."|".$row['school_code']."|".$row['phone_number']."|".$row['gender']."|".$row['address']."|".$row['nat_id']."|".$row['tsc_no']."|".$row['username']."|".$row['auth']."|".$row['email']."</span>";
                }
            }
            $stmt->close();
            $conn->close();
        }elseif (isset($_GET['change_my_information'])) {
            include ("../../connections/conn1.php");
            $user_id = $_SESSION['userids'];
            $update = "UPDATE `user_tbl` SET `fullname` = ?, `dob` = ?, `phone_number` = ? , `gender` = ?, `address` = ?, `nat_id` = ?, `tsc_no` = ?, `username` = ?, `email` = ? WHERE `user_id` = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("ssssssssss",$_GET['my_name'],$_GET['my_dob'],$_GET['my_phone'],$_GET['my_gender'],$_GET['my_address'],$_GET['my_nat_id'],$_GET['my_tsc_code'],$_GET['my_username'],$_GET['my_mail'],$user_id);
            if($stmt->execute()){
                echo "<p style='color:green;font-size:13px;font-weight:600;'>Update has been done sucessfully<br>The changes will take effect next time you login!</p>";
            }else {
                echo "<p style='color:red;font-size:13px;font-weight:600;'>An error has occured during update!</p>";
            }
            $stmt->close();
            $conn->close();
        }elseif (isset($_GET['update_password'])) {
            $old_pass = $_GET['old_pass'];
            $newpass = $_GET['newpass'];
            $user_id = $_SESSION['userids'];
            include_once("../../assets/encrypt/encrypt.php");
            $old_pass = encryptCode($old_pass);
            //check id the password is correct
            include ("../../connections/conn1.php");
            $select = "SELECT * FROM `user_tbl` WHERE `user_id` = ? AND `password` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$user_id,$old_pass);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                //update the old with the new password
                $update = "UPDATE `user_tbl` SET `password` = ? WHERE `user_id` = ?";
                $stmt = $conn->prepare($update);
                $newpass = encryptCode($newpass);
                $stmt->bind_param("ss",$newpass,$user_id);
                if($stmt->execute()){
                    echo "<p style='color:green;font-size:13px;font-weight:600;'>Password Changed successfully!<br>Use it next time you login</p>";
                }else {
                    echo "<p style='color:red;font-size:13px;font-weight:600;'>An error has occured during updating<br>Try again later!</p>";
                }
            }else {
                echo "<p style='color:red;font-size:13px;font-weight:600;'>Your old password is in-correct</p>";
            }
        }
    }elseif($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['name'])) {
            include ("../../connections/conn1.php");
            include ("../../connections/conn2.php");
            // get the student information
            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $phone_number = $_POST['phone_number'];
            unset($_SESSION['success']);
            unset($_SESSION['error']);
            // email settings
            $sender_name = "Customer Inquiries!";
            $email_host_addr = "mail.privateemail.com";
            $email_username = "mail@ladybirdsmis.com";
            $email_password = "2000Hilary";
            $tester_mail = "ladybirdsmis@gmail.com";

            // try sending an email
            try {
                $mail = new PHPMailer(true);
        
                $mail->isSMTP();
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                // $mail->Host = 'smtp.gmail.com';
                $mail->Host = $email_host_addr;
                $mail->SMTPAuth = true;
                // $mail->Username = "hilaryme45@gmail.com";
                // $mail->Password = "cmksnyxqmcgtncxw";
                $mail->Username = $email_username;
                $mail->Password = $email_password;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port = 587;
                
                
                $mail->setFrom($email_username,$sender_name);
                $mail->addAddress($tester_mail);
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body = "<b>Name: </b>".$name."<br><b>Phone number : </b>".$phone_number."<br><b>Email: </b>".$email."<br>".$message;
        
                $mail->send();
                $_SESSION['success'] = "<p class='text-success'>We have recieved your request we will review it and get back to you in a ASAP!</p>";
                redirect("../../#contact");
                
            } catch (Exception $th) {
                // echo "<p class='text-danger p-1 border border-danger'>Error : ". $mail->ErrorInfo."</p>";
                $_SESSION['error'] = "<p class='text-success'>Error : ". $mail->ErrorInfo."!</p>";
            }
        }else{
            echo "<p class='text-danger border border-danger'>The Email address has not been set up properly, Delete the current setting and redo the process again!</p>";
        }
    }
    function redirect($links){
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: '.$links);
    }
    function getClassTaught($user_id){
        include ("../../connections/conn2.php");
        $select = "SELECT `class_assigned` FROM `class_teacher_tbl` WHERE `class_teacher_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$user_id);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results) {
            if ($row = $results->fetch_assoc()) {
                return "<b>".className($row['class_assigned'])."</b>";
            }
        }
        return "Not Assigned";
        $stmt->close();
        $conn2->close();
    }
    function getActiveHours($school_code,$conn){
        $select = "SELECT `from_time` , to_time FROM `school_information` WHERE `school_code` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$school_code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return "From ".$row['from_time']." hrs to ".$row['to_time']." hrs.";
            }
        }
        return ".";
    }
    function className($data){
        $datas = "Grade ".$data;
        if (strlen($data)>1) {
            $datas = $data;
        }
        return $datas;
    }
    function getSubjectsAndClassTaught($user_id){
        include ("../../connections/conn2.php");
        $use_ids = $user_id;
        $user_id = "%(".$user_id.":%";
        $select = "SELECT `subject_name`,`teachers_id` FROM `table_subject` WHERE `teachers_id` like ? AND  `sub_activated` = 1";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$user_id);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results) {
            $data_to_display = "<strong >Subject and Classes you teach:</strong><table style='margin:0;margin-left:5px;'><tr><th>No</th><th>Subject Name</th><th>Class Taught</th></tr>";
            $xs = 0;
            while ($row = $results->fetch_assoc()) {
                $xs++;
                $data_to_display.="<tr><td>".$xs."</td><td>".$row['subject_name']."</td>";
                $split_class = explode("|",$row['teachers_id']);
                $data_to_display.="<td>";
                $class_list = "";
                if (count($split_class) > 0) {
                    for ($ind=0; $ind < count($split_class); $ind++) { 
                        $split_data = explode(":",rBkts($split_class[$ind]));
                        if (trim($split_data[0]) == trim($use_ids)) {
                            $class_list.=className($split_data[1]).",";
                        }
                    }
                    $class_list= substr($class_list,0, strlen($class_list)-1);
                }
                $data_to_display.="".$class_list."</td></tr>";
            }
            $data_to_display.="</table><br>If the above information is incorrect contact your administrator to change";
            if ($xs>0) {
                return $data_to_display;
            }
        }
        $stmt->close();
        $conn2->close();
        return "<p style='color:green;font-weight:600;'>You teach no subject!<br>Contact your administrator to assign you a class to teach!</p>";
    }
    function rBkts($string){
        if (strlen($string)>1) {
            return substr($string,1,strlen($string)-2);
        }else {
            return $string;
        }
    }
    function allowedIn($userauth,$conn,$schcode){
        if (($userauth == 1 || $userauth == 0)) {
            return true;
        }else {
            $date = date("H:i:s",strtotime("3 hour"));
            $select = "SELECT `from_time`, `to_time` FROM `school_information` WHERE `from_time` <= ? AND `to_time` >= ? AND `school_code` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("sss",$date,$date,$schcode);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums>0) {
                return true;
            }else {
                $stmt->execute();
                $results = $stmt->get_result();
                if ($results) {
                    if ($row = $results->fetch_assoc()) {
                        $_SESSION['from_times'] = $row['from_time'];
                        $_SESSION['to_time'] = $row['to_time'];
                        echo "<p>Your active hours for login is from ".$row['from_time']." to ".$row['to_time']."</p>";
                    }
                }
            }
        }
        return false;
    }
    function checkCode($schcode,$conn){
        $select = "SELECT * FROM `school_information` WHERE `school_code` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$schcode);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if ($rnum > 0) {
            return true;
        }else {
            return false;
        }
    }
?>
