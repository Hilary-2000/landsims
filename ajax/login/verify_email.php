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
        if(isset($_GET['code'])){
            include ("../../assets/encrypt/encrypt.php");
            $code = $_GET['code'];
            $username = decryptCode($code);
            include ("../../connections/conn1.php");
            
            // update the school account but first get the user data
            $select = "SELECT * FROM `user_tbl` WHERE `username` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $school_code = $row['school_code'];
                    $update = "UPDATE `school_information` SET `activated` = 1 WHERE `school_code` = ?";
                    $stmtu = $conn->prepare($update);
                    $stmtu->bind_param("s",$school_code);
                    $stmtu->execute();

                    // show message that the account has been verified
                    $_SESSION['success'] = "<p class='text-success'>Your email has been verified successfully! You can now login to your account.</p>";
                    redirect("../../timetable-signup.php");
                    exit();
                }
            }
        }
    }

    // show error message when nothing happens
    $_SESSION['error'] = "<p class='text-danger'>Invalid verification link!</p>";
    redirect("../../timetable-signup.php");
    exit();

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
