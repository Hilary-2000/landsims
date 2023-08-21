<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        include("../../connections/conn2.php");
        if(isset($_GET['admit'])){
           $suname = $_GET['surname'];
           $fname = $_GET['fname'];
           $sname = $_GET['sname'];
           $dob = $_GET['dob'];
           $gender = $_GET['gender'];
           $classenrol = $_GET['enrolment'];
           $parentname = $_GET['parentname'];
           $parentcontact = $_GET['parentconts'];
           $parentrelation = $_GET['parentrela'];

           $parentname2 = $_GET['parentname2'];
           $parentcontact2 = $_GET['parentconts2'];
           $parentrelation2 = $_GET['parentrela2'];
           $pmail2 = $_GET['pemail2'];

           if (strlen($parentname2) < 1) {
               $parentname2 = "none";
           }
           if (strlen($parentcontact2) < 1) {
               $parentcontact2 = "none";
           }
           if (strlen($parentrelation2) < 1) {
               $parentrelation2 = "none";
           }
           if (strlen($pmail2) < 1) {
               $pmail2 = "none";
           }

           $admno = $_GET['admnos'];
           $upis = $_GET['upis'];
           $bcno = 0;
                if(isset($_GET['bcno'])){
                    $bcno = $_GET['bcno'];
                }
                    $parentemail = 'none';
                if(isset($_GET['pemail'])){
                    $parentemail = $_GET['pemail'];
                }
                
                    $address = 0;
                if(isset($_GET['address'])){
                    $address = $_GET['address'];
                }
                $parent_accupation1 = $_GET['parent_accupation1'];
                $parent_accupation2 = $_GET['parent_accupation2'];

                $doa = date("Y-m-d",strtotime("3 hour"));
                $INSERT = "INSERT INTO `student_data`  (`surname`,`adm_no`,`first_name`,`second_name`,`student_upi`,`D_O_B`,`gender`,`stud_class`,`D_O_A`,`parentName`,`parentContacts`,`parent_relation`,`parent_email`,`parent_name2`,`parent_contact2`,`parent_relation2`,`parent_email2`,`address`,`BCNo`,`primary_parent_occupation`,`secondary_parent_occupation`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn2->prepare($INSERT);
                $stmt->bind_param("sssssssssssssssssssss",$suname,$admno,$fname,$sname,$upis,$dob,$gender,$classenrol,$doa,$parentname,$parentcontact,$parentrelation,$parentemail,$parentname2,$parentcontact2,$parentrelation2,$pmail2,$address,$bcno,$parent_accupation1,$parent_accupation2);
                if($stmt->execute()){
                    $data = "<p style ='color:green;font-size:12px;'>".$fname." ".$sname." has been admitted successfully<br>Use their admission number to search their information</p>";
                    $stmt->close();
                    $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no` FROM `student_data` order by `ids` DESC LIMIT 1";
                    $stmt = $conn2->prepare($select);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $admissionNumber = 0;
                    if($result){
                        if($row=$result->fetch_assoc()){
                            $admissionNumber = $row['adm_no'];
                            $name = $row['first_name']." ".$row['second_name'];
                        }
                        //insert the notification to the database 
                        $notice_stat = 0;
                        $reciever_id = "all";
                        $reciever_auth = 1;
                        $messageName = "Admission of <b>".$fname." ".$sname."</b> in class: <b>".$classenrol."</b> was successfull";
                        $messagecontent = "<b>".$fname." ".$sname."</b> has been successfully admitted to class: ".$classenrol."";
                        $sender_ids = "Administration System";
                        insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
                        $classtrid = getClassTeacher($conn2,$classenrol);
                        if ($classtrid != "Null") {
                            //insert the notification to the database 
                            $notice_stat = 0;
                            $reciever_id = $classtrid;
                            $reciever_auth = 5;
                            $messageName = "Admission of <b>".$fname." ".$sname."</b> in your class was successfull";
                            $messagecontent = "<b>".$fname." ".$sname."</b> has been successfully admitted to class: <b>".$classenrol."</b>";
                            insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
                        }
                        $data.= "<input type='text' id='admnohold' value=".$admissionNumber." hidden> <input type='text' id='namehold' value='".$name."' hidden>";
                        echo $data;
                    }else {
                        echo "Search for the latest students to see their admission number";
                    }
                }else{
                    echo "<p style ='color:red;font-size:12px;'>Student data not submitted<br>There seem to be an error please try again later</p>";
                }
                $stmt->close();
                $conn2->close();
        }elseif (isset($_GET['checkbcno'])) {
            $bcno = $_GET['checkbcno'];
            $select = "SELECT `BCNo` FROM `student_data` WHERE BCNo = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$bcno);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result){
                    if($row=$result->fetch_assoc()){
                        $bcn = $row['BCNo'];
                        if($bcn==$bcno){
                            echo "<p style='color:red;'>The birth certificate number entered is present<p>";
                        }else {
                            echo "<p style='red'><p>";
                        }
                    }else {
                        echo "<p style='red'><p>";
                    }
                }else {
                    echo "<p style='red'><p>";
                }
            }else {
                echo "<p style='red'><p>";
            }
            $stmt->close();
            $conn2->close();
            
        }elseif (isset($_GET['completeadmit'])) {
            $disabled = $_GET['disabled'];
            $describe = $_GET['description'];
            $paymode = $_GET['paymode'];
            $payamount = $_GET['payamount'];
            $paycode = $_GET['paycode'];
            $boarded = $_GET['boarded'];
            $admno = $_GET['admno'];
            $paymentfor = "admission fees";
            $admissionessentials = $_GET['admissionessentials'];

            $medical_historys = $_GET['medical_history'];
            $source_of_funding_datas = $_GET['source_of_funding_data'];
            $previous_schools = $_GET['previous_schools'];
            $clubs_n_sports = $_GET['clubs_n_sports'];
            // echo $previous_schools;

            //checking for the admission number if its present
            $select = "SELECT * from `student_data` where `adm_no` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$admno);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            // echo $rnums;
            if($rnums>0){
                // 
                // $admno,
                $update = "UPDATE `student_data` SET `disabled` = ? , `boarding` = ?, `disable_describe` = ?, `admissionessentials` = ? ,`prev_sch_attended` = ? , `medical_history` = ?, `source_funding` = ?, `clubs_id` = ? WHERE `adm_no` = ?";
                $stmt = $conn2->prepare($update);
                // echo $update;
                $stmt->bind_param("sssssssss",$disabled,$boarded,$describe,$admissionessentials,$previous_schools,$medical_historys,$source_of_funding_datas,$clubs_n_sports,$admno);
                if($stmt->execute()){
                    // echo $_GET['fees_paid']; 
                    if ($_GET['fees_paid'] == "Yes") {
                        //go ahead and store the student payment information
                        $inserts = "INSERT INTO `finance` (`stud_admin`,`time_of_transaction`,`date_of_transaction`,`transaction_code`,`amount`,`balance`,`payment_for`,`payBy`,`mode_of_pay`) VALUES(?,?,?,?,?,?,?,?,?)";
                        $time = date("H:i:s",strtotime("3 hour"));
                        $date = date("Y-m-d",strtotime("3 hour"));
                        $balance=0;
                        $paidby = $_SESSION['username'];
                        $stmt = $conn2->prepare($inserts);
                        $stmt->bind_param("sssssssss",$admno,$time,$date,$paycode,$payamount,$balance,$paymentfor,$paidby,$paymode);
                        if($stmt->execute()){
                            echo "<p style= 'color:green; font-size:12px;'>Registration was completed successfuly!</p>";
                        }else{
                            echo "<p style= 'color:green; font-size:12px;'>The registration process was inturupted<br>Try again!</p>";
                        }
                    }else {
                        echo "<p style= 'color:green; font-size:12px;'>Registration was completed successfuly!</p>";
                    }
                }else {
                    echo "<p style= 'color:red; font-size:12px;'>Completion wasn`t successfull<br>Try again later!</p>";
                }
            }else {
                echo "<p style= 'color:red; font-size:12px;'>Student admission is not present!</p>";
            }
            $stmt->close();
            $conn2->close();
            
        }elseif (isset($_GET['getStudentCount'])) {
            $count = "SELECT COUNT(activated) as 'Total' FROM `student_data` WHERE `activated` = 1 and `deleted` =0";
            $stmt = $conn2->prepare($count);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                if($row = $result->fetch_assoc()){
                    $counts = $row['Total'];
                    echo  "<p>".$counts." student(s)</p>";
                }
            }
            $stmt->close();
            $conn2->close();
        }elseif (isset($_GET['studentscounttoday'])) {
            $date = date("Y-m-d",strtotime("3 hour"));
            $count = "SELECT COUNT(activated) as 'Total' FROM `student_data` WHERE `activated` = 1 and `deleted` =0 and D_O_A = ?";
            $stmt = $conn2->prepare($count);
            $stmt->bind_param("s",$date);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                if($row = $result->fetch_assoc()){
                    $counts = $row['Total'];
                    echo  "<p>".$counts." student(s)</p>";
                }
            }
            $stmt->close();
            $conn2->close();
        }elseif (isset($_GET['getessentials'])) {
            $select = "SELECT `valued` from `settings` WHERE `sett` = 'admissionessentials'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $data = "";
            $result = $stmt->get_result();
            if($result){
                if($row=$result->fetch_assoc()){
                    $data=$row['valued'];
                }
                
                $datasplit = explode(",",$data);
                $elemenum = count($datasplit);
                $echodata="<p style='color:rgb(36, 36, 36);font-size:12px;'>Select below.</p>";
                if($elemenum>0){
                    for ($xs=0; $xs < $elemenum; $xs++) { 
                        $echodata.="<div style='width:70%;display:flex;justify-content: space-between;position:relative;' class='conts'>";
                        $echodata.="<label style='font-size:12px;'  for='elements".($xs+1)."'>".$datasplit[$xs]."</label>";
                        $echodata.="<input type='checkbox' class='elementsadm' name='' value='".$datasplit[$xs]."' id='elements".($xs+1)."'>";
                        $echodata.="</div>";
                    }
                }else {
                    $echodata.="No addmission essentials";
                }
                echo $echodata;
            }else {
                
            }
        }elseif (isset($_GET['find'])) {
            if(isset($_GET['bynametype'])){
                $name = "%".$_GET['bynametype']."%";
                $select = "SELECT  `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` FROM `student_data` WHERE ( CONCAT(`first_name`,' ',`second_name`,' ',`surname`) LIKE ? OR (`first_name` like ? or `surname` LIKE ? or `second_name` like ?) )and `deleted` = 0 and `activated` =1 LIMIT 20";
                // $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE (`first_name` like ? or `surname` LIKE ? or `second_name` like ?) ";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("ssss",$name,$name,$name,$name);
                $stmt->execute();
                $result = $stmt->get_result();
                $searh = "Student name = <span style='color:brown;'>\"".$_GET['bynametype']."\"</span>";
                createStudentn4($conn2,$result,$searh);
            }elseif (isset($_GET['usingadmno'])) {
                $admno = $_GET['usingadmno'];
                $select = "SELECT * FROM `student_data` WHERE `adm_no` = ? AND deleted=0 and activated=1 LIMIT 20";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$admno);
                $stmt->execute();
                $msg="";
                $result = $stmt->get_result();
                $data ="";
                if($result){
                    if($row=$result->fetch_assoc()){
                        include_once("../finance/financial.php");
                        $data.=$row['surname']."^";
                        $data.=$row['first_name']."^";
                        $data.=$row['second_name']."^";
                        $data.=$row['index_no']."^";
                        $data.=$row['D_O_B']."^";
                        $data.=$row['gender']."^";
                        $data.=$row['stud_class']."^";
                        $data.=$row['adm_no']."^";
                        $data.=$row['D_O_A']."^";
                        $data.=$row['parentName']."^";
                        $data.=$row['parentContacts']."^";
                        $data.=$row['parent_relation']."^";
                        $data.=$row['parent_email']."^";
                        $data.=$row['address']."^";
                        $data.=$row['BCNo']."^";
                        $data.=$row['disabled']."^";
                        $data.=$row['parent_name2']."^";
                        $data.=$row['parent_contact2']."^";
                        $data.=$row['parent_relation2']."^";
                        $data.=$row['parent_email2']."^";
			            $data.=$row['disable_describe']."^";
                        $data.=$row['boarding']."^";
                        $data.=ucwords(strtolower($row['admissionessentials']))."^";
                        $data.=$row['medical_history']."^";
                        $data.=$row['prev_sch_attended']."^";
                        $data.=$row['source_funding']."^";
                        $data.=$row['primary_parent_occupation']."^";
                        $data.=$row['secondary_parent_occupation']."^";
                        $term = getTerm();
                        $data.="Kes ".number_format(getFeespaidByStudent($row['adm_no'],$conn2))."^";
                        $data.="Kes ".number_format(lastACADyrBal($row['adm_no'],$conn2))."^";
                        $data.="Kes ".number_format(getFeesAsPerTermBoarders($term,$conn2,$row['stud_class'],$row['adm_no']))."^";
                        $data.="Kes ".number_format(getBalance($row['adm_no'],$term,$conn2))."^";
                        $data.="Kes ".number_format(total_fees_paid($row['adm_no'],$conn2))."^";
                        $data.=$term."^";
                        $data.=(isTransport($conn2,$row['adm_no'])?"Yes ".getRouteEnrolled($conn2,$row['adm_no']):"No")."^";
                        $data.=(isBoarding($row['adm_no'],$conn2)?"Yes":"No")."^";
                        $data.=$row['clubs_id'];
                    }else{
                        $msg = "<p style='display:none;'>".$data."</p>";
                    }
                }else {
                    $msg = "<p>erorr</p>";
                }
                echo $data;
            }elseif (isset($_GET['admnoincomplete'])) {
                $admin = "%".$_GET['admnoincomplete']."%";
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE `adm_no` like ? and `deleted` = 0 and activated =1 ";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$admin);
                $stmt->execute();
                $result = $stmt->get_result();
                $searh = "Admission no = <span style='color:brown;'>\"".$_GET['admnoincomplete']."\"</span>";
                createStudentn4($conn2,$result,$searh);

            }elseif (isset($_GET['classelected'])) {
                $classenroled = $_GET['classelected'];
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE  `stud_class` = ? and `deleted` = 0 and activated =1 LIMIT 20";
                $stmt=$conn2->prepare($select);
                $stmt->bind_param("s",$classenroled);
                $stmt->execute();
                $result=$stmt->get_result();
                $searh = " Class selected = <span style='color:brown;'>\"".classNameAdms($_GET['classelected'])."\"</span>";
                if($_GET['classelected'] == "-1"){
                    $searh = "<span style='color:brown;'>\"Alumni\"</span>";
                }
                createStudentn4($conn2,$result,$searh);//creates table
            }elseif (isset($_GET['comname'])) {
                $select = "SELECT `surname` , `first_name` ,`second_name` ,`adm_no`,`gender`,`stud_class`,`BCNo` FROM `student_data` where concat(`surname`,' ',`first_name`,' ',`second_name`) = ? or concat(`surname`,' ',`second_name`,' ',`first_name`) =?  OR concat(`surname`,' ',`first_name`) = ?  OR concat(`surname`,' ',second_name) = ?  OR surname = ?  OR concat(`first_name`,' ',`surname`,' ',`second_name`) = ? or concat(`first_name`,' ',`second_name`,' ',`surname`) =?  OR concat(`first_name`,' ',`surname`) = ?  OR concat(`first_name`,' ',second_name) = ?  OR first_name = ?  OR concat(`second_name`,' ',`surname`,' ',`first_name`) = ? or concat(`second_name`,' ',`first_name`,' ',`surname`) =?  OR concat(`second_name`,' ',`surname`) = ?  OR concat(`second_name`,' ', first_name) = ?  OR second_name = ? or (`first_name` like ? or `surname` LIKE ? or second_name like ?) LIMIT 20 ";
                $name = $_GET['comname'];
               $stmt = $conn2->prepare($select);
               $stmt->bind_param("ssssssssssssssssss",$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name,$name);
               if($stmt->execute()){
                    $result = $stmt->get_result();
                    $searh = "Student name = <span style='color:brown;'>\"".$_GET['comname']."\"</span>";
                    createStudentn4($conn2,$result,$searh);
                }else {
                   echo "<p>Not Executed!</p>";
                }
            }
            elseif (isset($_GET['comadm'])) {
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE (`adm_no` = ? or `adm_no` like ?) and `deleted` = 0 and activated =1 LIMIT 20";
                $comadm = "%".$_GET['comadm']."%";
                $comadim = $_GET['comadm'];
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("ss",$comadim,$comadm);
                $stmt->execute();
                $result = $stmt->get_result();
                $searh = "Admission no =  <span style='color:brown;'>\"".$_GET['comadm']."\"</span>";
                createStudentn4($conn2,$result,$searh);
            }
            elseif (isset($_GET['combcno'])) {
                $combcno = $_GET['combcno'];
                $compbcno = "%".$_GET['combcno']."%";
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE (`BCNo` = ? or `BCNo` like ?) and `deleted` = 0 and activated =1 LIMIT 20";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("ss",$combcno,$compbcno);
                $stmt->execute();
                $result = $stmt->get_result();
                $searh = "Birth certificate no containing <span style='color:brown;'>\"".$_GET['combcno']."\"</span>";
                createStudentn4($conn2,$result,$searh);
            }
            elseif (isset($_GET['bybcntype'])) {
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE `BCNo` like ? and `deleted` = 0 and activated =1 LIMIT 20";
                $bcno = "%".$_GET['bybcntype']."%";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$bcno);
                $stmt->execute();
                $result = $stmt->get_result();
                $searh = "Birth certificate no containing <span style='color:brown;'>\"".$_GET['bybcntype']."\"</span>";
                createStudentn4($conn2,$result,$searh);
            }elseif (isset($_GET['classes'])) {
                $classenroled = $_GET['classes'];
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE  `stud_class` = ? and `deleted` = 0 and activated =1 LIMIT 20";
                $stmt=$conn2->prepare($select);
                $stmt->bind_param("s",$classenroled);
                $stmt->execute();
                $result=$stmt->get_result();
                $searh = "Class = <span style='color:brown;'>\"".classNameAdms($_GET['classes'])."\"</span>";
                if($_GET['classes'] == "-1"){
                    $searh = "<span style='color:brown;'>\"Alumni\"</span>";
                }
                createStudentn4($conn2,$result,$searh);//creates table
            }elseif (isset($_GET['allstudents'])) {
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data`";
                $stmt = $conn2->prepare($select);
                $stmt->execute();
                $res = $stmt->get_result();
                if($res){
                    $tablein4 = "<div class='tableme'><table class='table table-striped align-items-center '><tr><th>No.</th><th>Class</th><th><i class='fa fa-male'></i> Male</th><th><i class='fa fa-female'></i> Female</th><th><i class='fa fa-male'></i> + <i class='fa fa-female'></i> Total</th><th>Action</th></tr>";
                    $classes = getClasses($conn2);
                    $classholder = array();
                    $classholdermale = array();
                    $classholderfemale = array();
                    array_push($classes,"-1","-2");
                    if (count($classes)>0) {
                        for ($i=0; $i < count($classes); $i++) { 
                            $counted = 0;
                            array_push($classholder,$counted);
                            array_push($classholdermale,$counted);
                            array_push($classholderfemale,$counted);
                        }
                    }
                    $males=0;
                    $female = 0;
                    while ($row=$res->fetch_assoc()) {
                        for ($i=0; $i < count($classes); ++$i) {
                            if ($classes[$i] == trim($row['stud_class'])) {
                                $classholder[$i]+=1;
                                if ($row['gender']=='Female') {
                                    $classholderfemale[$i]+=1;
                                    $female++;
                                }
                                if ($row['gender']=='Male') {
                                    $classholdermale[$i]+=1;
                                    $males++;
                                }
                                break;
                            }
                        }
                    }
                    $totaled = 0;
                    for ($i=0; $i < count($classes); $i++) {
                        $totaled+=$classholder[$i];
                        $daros = $classes[$i];
                        if($classes[$i] == "-1"){
                            $daros = "Alumni";
                        }
                        if($classes[$i] == "-2"){
                            $daros = "Transfered";
                        }
                        if (strlen($daros)==1){
                            $daros = "Grade ".$classes[$i];
                        }
                        $tablein4.="<tr><td>".($i+1)."</td><td style='font-size:13px;font-weight:bold;'>".$daros."</td><td>".$classholdermale[$i]." Student(s)</td><td>".$classholderfemale[$i]." Student(s)</td><td>".$classholder[$i]." Student(s)</td><td>"."<span class='link viewclass' style='font-size:12px;' id='".$classes[$i]."'><i class='fa fa-eye'></i> View</span>"."</td></tr>";
                    }
                    $tablein4.="</table></div>";
                    $table_2 = "<div class = 'table_holders'><table class='align-items-center'>
                                <tr><th>Gender</th><th>Total</th></tr>
                                <tr><td><i class='fa fa-male'></i> - Male</td><td>".$males."</td></tr>
                                <tr><td><i class='fa fa-female'></i> - Female</td><td>".$female."</td></tr>
                                <tr><td><b>Total</b></td><td><b>".$totaled."</b></td></tr>
                                </table></div>";
                    $datas = "<span class='text-dark text-lg'>Displaying all students recognized by the system</span><br><spans style='text-align:center;'><u>Gender count table</u> ".$table_2." <br> </span>";
                    echo $datas." <p><u>Student count table</u></p>".$tablein4;
                }else {
                    
                }
            }elseif (isset($_GET['todayreg'])) {
                $date = date("Y-m-d",strtotime("3 hour"));
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE `D_O_A` = ? and `deleted` = 0 and activated =1";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$date);
                $stmt->execute();
                $result = $stmt->get_result();
                $searh = "Students Registered = <span style='color:brown;'>".date("M - dS - Y",strtotime($date))."</span>";
                createStudentn4($conn2,$result,$searh);
            }
        }elseif (isset($_GET['delete_staff'])) {
            include("../../connections/conn1.php");
            $staff_ids = $_GET['staff_ids'];
            $select = "SELECT * FROM user_tbl WHERE `user_id` = '".$staff_ids."'";
            $stmt = $conn->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $fullname = $row['fullname'];
                }
            }
            $select = "DELETE FROM `user_tbl` WHERE `user_id` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$staff_ids);
            if($stmt->execute()){
                echo "<p class='text-success'>Staff data deleted successfully!</p>";
                $messageName = "Staff has been deleted";
                $messagecontent = ucwords(strtolower($fullname))." has been deleted on ".date("dS M Y")." by ".$_SESSION['username'].".";
                $notice_stat = 0;
                $reciever_id = "all";
                $reciever_auth = 1;
                $sender_ids = "Administration system";
                insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
            }else{
                echo "<p class='text-success'>An error occured during update!</p>";
            }
        }elseif (isset($_GET['updatestudinfor'])) {
            $class = $_GET['class'];
            $index = $_GET['index'];
            $bcnos = $_GET['bcnos'];
            $yearOfStudy = studentYOS($conn2,$_GET['adminnumber']);
            $oldYear = withoutLatest($conn2,$_GET['adminnumber']);
            $newYOS = explode(":",$yearOfStudy)[0].":".$class;
            if (strlen($oldYear) > 0) {
                $newYOS = $oldYear."|".explode(":",$yearOfStudy)[0].":".$class;
            }else{
                $newYOS = "";
            }
            // echo $newYOS;
            if ($bcnos == "N/A") {
                $bcnos = 0;
            }
            if ($index == "N/A") {
                $index = 0;
            }
            $dob = $_GET['dob'];
            $genders = $_GET['genders'];
            $disabled = $_GET['disabled'];
            $describe = $_GET['describe'];
            $address = $_GET['address'];
            $pnamed = $_GET['pnamed'];
            $pcontacts = $_GET['pcontacts'];
            $paddress = $_GET['paddress'];
            $pemail = $_GET['pemail'];
            $prelation = $_GET['prelation'];
            $adminno = $_GET['adminnumber'];
            $snamed = $_GET['snamed'];
            $fnamed = $_GET['fnamed'];
            $lnamed = $_GET['lnamed'];
            // &parentname2="+parname2+"&parentcontact="+parconts2+"&parentrelation="+parrelation2+"&pemails="+pemail2
            $parentname2 = $_GET['parentname2'];
            $parentcontact = $_GET['parentcontact'];
            $parentrelation = $_GET['parentrelation'];
            $pemails = $_GET['pemails'];
            $occupation1 = $_GET['occupation1'];
            $occupation2 = $_GET['occupation2'];
            $medical_history = $_GET['medical_history'];
            $clubs_in_sporters = $_GET['clubs_in_sporters'];
            $previous_schools = $_GET['previous_schools'];

            // echo $previous_schools;
            $update = "UPDATE `student_data` SET `year_of_study` = ?,`stud_class` = ?, `BCNo`= ?,`index_no` = ?,`gender` = ?, `disabled` = ? , `disable_describe` = ? , `address` = ? ,`parentName` = ?,`parentContacts` = ?,`parent_relation` = ?,`parent_email` = ?,`parent_name2` = ?,`parent_contact2` = ?, `parent_relation2` = ?, `parent_email2` = ?, `first_name` = ? ,`surname` = ? ,`second_name` = ? ,`primary_parent_occupation` = ?, `secondary_parent_occupation` = ?, `medical_history` = ?, `clubs_id` = ?, `prev_sch_attended` = ? WHERE `adm_no`=?";
            $stmt = $conn2->prepare($update);
            $stmt->bind_param("sssssssssssssssssssssssss",$newYOS,$class,$bcnos,$index,$genders,$disabled,$describe,$address,$pnamed,$pcontacts,$prelation,$pemail,$parentname2,$parentcontact,$parentrelation,$pemails,$fnamed,$snamed,$lnamed,$occupation1,$occupation2,$medical_history,$clubs_in_sporters,$previous_schools,$adminno);
            if($stmt->execute()){
                echo "<p style='color:green;font-size:12px;'>Student  data updated successfully!</p>";
            }else{
                echo "<p style='color:red;font-size:12px;'>Error occured while updating<br>Try restarting your the system!</p>";
            }
        }elseif (isset($_GET['getclassinformation'])) {
            $class = $_GET['daro'];
            $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` WHERE  `stud_class` = ? and `deleted` = 0 and activated =1";
            $stmt=$conn2->prepare($select);
            $stmt->bind_param("s",$class);
            $stmt->execute();
            $result=$stmt->get_result();
            createStudentclass($result,$class);
        }elseif (isset($_GET['add_club'])) {
            // check if there are other clubnames
            // if the usernames are present add the new array to the list
            $select = "SELECT * FROM `settings` WHERE `sett` = 'clubs/sports_house'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $clubs_sports = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $clubs_sports = $row['valued'];
                }
            }
            if (strlen($clubs_sports) > 0) {
                // if the clubs are present change it to json and add the new data
                // echo $clubs_sports;
                $club_data = json_decode($clubs_sports);
                $ids = "0";
                for ($indexes=0; $indexes < count($club_data); $indexes++) { 
                    if (($indexes+1) == count($club_data)) {
                        $ids = $club_data[$indexes]->id;
                    }
                }
                $ids+=1;
                $new_clubs = array("id" => $ids,"Name" => $_GET['club_name']);
                array_push($club_data,$new_clubs);
                $clubs = json_encode($club_data);

                // echo $clubs;
                // update clubs
                $update = "UPDATE `settings` SET `valued` = '".$clubs."' WHERE `sett` = 'clubs/sports_house'";
                $stmt = $conn2->prepare($update);
                if($stmt->execute()){
                    echo "<p class='text-success'>The Sports House / Clubs has been successfully added!</p>";
                }else{
                    echo "<p class='text-danger'>The process has not been completed successfully please contact your administrator!!</p>";
                }
            }else {
                $clubs = [];
                $new_clubs = array("id" => "1","Name" => $_GET['club_name']);
                array_push($clubs,$new_clubs);
                // insert data
                $clubs = json_encode($clubs);
                $insert = "INSERT INTO `settings` (`sett`,`valued`) VALUES (?,?)";
                $stmt = $conn2->prepare($insert);
                $sett = "clubs/sports_house";
                $stmt->bind_param("ss",$sett,$clubs);
                if($stmt->execute()){
                    echo "<p class='text-success'>The Sports House / CLubs has been successfully added!</p>";
                }else{
                    echo "<p class='text-danger'>The process has not been completed successfully please contact your administrator!!</p>";
                }
            }
        }elseif (isset($_GET['getClubHouses'])) {
            $select = "SELECT * FROM `settings` WHERE `sett` = 'clubs/sports_house'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $clubs_sports = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $clubs_sports = $row['valued'];
                }
            }
            // check if the clubs are present
            if (strlen($clubs_sports) > 0) {
                // decode it to json data
                $clubs_data = json_decode($clubs_sports);
                $data_to_display = "<table class='table'><tr><th>No.</th><th>Sports House / Clubs</th><th>Options</th></tr>";
                for ($indexed=0; $indexed < count($clubs_data); $indexed++) { 
                    $data_to_display.="<tr><td>".($indexed+1)."</td><td id='club_named".$clubs_data[$indexed]->id."'>".$clubs_data[$indexed]->Name."</td><td><span class='link edit_clubs' id='edit_clubs".$clubs_data[$indexed]->id."' ><i class='fa fa-pen'></i> Edit</span> <span class='link delete_clubs' id='delete_clubs".$clubs_data[$indexed]->id."'><i class='fa fa-trash'></i> Delete</span></td></tr>";
                }
                $data_to_display.="</table>";
                echo $data_to_display;
            }else {
                "<p class = 'text-danger'>There are no clubs at the momment!</p>";
            }
        }elseif (isset($_GET['delete_clubs'])) {
            $select = "SELECT * FROM `settings` WHERE `sett` = 'clubs/sports_house'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $clubs_sports = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $clubs_sports = $row['valued'];
                }
            }
            // check if the clubs are present
            if (strlen($clubs_sports) > 0) {
                $ids = $_GET['ided'];
                $club_data = json_decode($clubs_sports);
                $clubs_data = [];
                $count = 0;
                for ($indexes=0; $indexes < count($club_data); $indexes++) { 
                    if ($club_data[$indexes]->id != $ids) {
                        $new_clubs = array("id" => $club_data[$indexes]->id,"Name" => $club_data[$indexes]->Name);
                        array_push($clubs_data,$new_clubs);
                        $count++;
                    }
                }
                $club_dt = ($count>0) ? json_encode($clubs_data):"";
                $update = "UPDATE `settings` SET `valued` = '".$club_dt."' WHERE `sett` = 'clubs/sports_house'";
                $stmt = $conn2->prepare($update);
                if($stmt->execute()){
                    echo "<p class='text-success'>The Sports House / Clubs has been successfully deleted!</p>";
                }else{
                    echo "<p class='text-danger'>The process has not been completed successfully please contact your administrator!!</p>";
                }
            }else {
                "<p class = 'text-danger'>There are no clubs at the momment!</p>";
            }
        }elseif (isset($_GET['getmyclubs'])) {
            $select = "SELECT * FROM `settings` WHERE `sett` = 'clubs/sports_house'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $clubs_sports = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $clubs_sports = $row['valued'];
                }
            }
            if (strlen($clubs_sports) > 0) {
                $club_in_data = json_decode($clubs_sports);
                $data_to_display = "<select name='source_of_funding' class='border border-dark text-xxs form-control bg-light w-50' id='select_clubs_sports' class='form-control'><option value='' hidden>Select an option</option>";
                for ($ind=0; $ind < count($club_in_data); $ind++) { 
                    $data_to_display.="<option value='".$club_in_data[$ind]->id."'>".$club_in_data[$ind]->Name."</option>";
                }
                $data_to_display.="</select>";
                echo $data_to_display;
            }else {
                $data_to_display = "<select name='source_of_funding' class='border border-dark text-xxs form-control bg-light w-50' id='select_clubs_sports' class='form-control'><option value='' hidden>Select an option</option></select>";
                echo $data_to_display;
            }
        }elseif (isset($_GET['getmyclubs2'])) {
            $select = "SELECT * FROM `settings` WHERE `sett` = 'clubs/sports_house'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $clubs_sports = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $clubs_sports = $row['valued'];
                }
            }
            if (strlen($clubs_sports) > 0) {
                $club_in_data = json_decode($clubs_sports);
                $data_to_display = "<select name='' class='border border-dark text-xxs form-control bg-light w-100' id='clubs_in_sporters' class='form-control'><option value='' id='select_clubs_sports_def' hidden>Select an option</option>";
                for ($ind=0; $ind < count($club_in_data); $ind++) { 
                    $data_to_display.="<option class='clubs_in_sporter' value='".$club_in_data[$ind]->id."'>".$club_in_data[$ind]->Name."</option>";
                }
                $data_to_display.="</select>";
                echo $data_to_display;
            }else {
                $data_to_display = "<select name='' class='border border-dark text-xxs form-control bg-light w-100' id='clubs_in_sporters' class='form-control'><option value='' id='select_clubs_sports_def' hidden>Select an option</option></select>";
                echo $data_to_display;
            }
        }elseif (isset($_GET['edit_clubs'])) {
            $select = "SELECT * FROM `settings` WHERE `sett` = 'clubs/sports_house'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $clubs_sports = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $clubs_sports = $row['valued'];
                }
            }
            // check if the clubs are present
            if (strlen($clubs_sports) > 0) {
                $club_data = json_decode($clubs_sports);
                $name = $_GET['club_name'];
                $id = $_GET['club_id'];
                for ($indexed=0; $indexed < count($club_data); $indexed++) { 
                    if ($id == $club_data[$indexed]->id) {
                        $club_data[$indexed]->Name = $name;
                        break;
                    }
                }
                $club_data = json_encode($club_data);
                $update = "UPDATE `settings` SET `valued` = '".$club_data."' WHERE `sett` = 'clubs/sports_house'";
                $stmt = $conn2->prepare($update);
                if($stmt->execute()){
                    echo "<p class='text-success'>The Sports House / Clubs has been successfully Updated!</p>";
                }else{
                    echo "<p class='text-danger'>The process has not been completed successfully please contact your administrator!!</p>";
                }
            }else {
                "<p class = 'text-danger'>There are no clubs at the momment!</p>";
            }
        }
        elseif (isset($_GET['insertattendance'])) {
            $data = $_GET['insertattendance'];
            $datasplit = explode(",",$data);
            $name = $datasplit[0];
            $daro = $datasplit[1];
            /*****check if class register already called** */
            $select = "SELECT * FROM `attendancetable` WHERE `class`=? AND `date` = ? ";
            $stmt = $conn2->prepare($select);
            $date = date("Y-m-d",strtotime($_GET['calldate']));
            $stmt->bind_param("ss",$daro,$date);
            $stmt->execute();
            $stmt->store_result();
            $rnums=0;
            $rnums = $stmt->num_rows;
            /**********end**** */
            if($rnums==0){
                $insert = "INSERT INTO `attendancetable` (`admission_no`,`date`,`signedby`,`class`) VALUES (?,?,?,?)";
                $stmt = $conn2->prepare($insert);
                $counter = 2;
                for ($i=2; $i < count($datasplit) ; $i++) { 
                    $stmt->bind_param("ssss",$datasplit[$i],$date,$name,$daro);
                    $stmt->execute();
                    $counter++;
                }
                if($counter==count($datasplit)){
                    echo "<p style='color:green;'>Register successfully called for ".date("D dS M Y",strtotime($date))."!</p>";
                }
            }else {
                $delete = "DELETE FROM `attendancetable` WHERE `class` = ? AND `date` = ?";
                $stmt= $conn2->prepare($delete);
                $stmt->bind_param("ss",$daro,$date);
                $stmt->execute();
                // proceed and insert
                $insert = "INSERT INTO `attendancetable` (`admission_no`,`date`,`signedby`,`class`) VALUES (?,?,?,?)";
                $stmt = $conn2->prepare($insert);
                $counter = 2;
                for ($i=2; $i < count($datasplit) ; $i++) { 
                    $stmt->bind_param("ssss",$datasplit[$i],$date,$name,$daro);
                    $stmt->execute();
                    $counter++;
                }
                if($counter==count($datasplit)){
                    echo "<p style='color:green;'>Register successfully called for ".date("D dS M Y",strtotime($date))."!</p>";
                }
                echo "<p style='color:red;'>Register was already called!</p>";
            }
        }elseif (isset($_GET['class'])) {
            $class = $_GET['class'];
            $date = $_GET['dates'];
            if($date=="today"){
                $date=date("Y-m-d",strtotime("3 hour"));
            }
            $datas = classNameAdms($class);
            $dated = date_create($date);
            $dated = date_format($dated,"Y-m-d");
            echo "<p style='font-size:12px;text-align:center;margin-top:5px;'>Displaying <span style='color:brown;font-weight:600;'>".$datas."</span> attendance on : <span style='color:brown;font-weight:600;'>".date("l dS \of M Y",strtotime($dated))."</span></p>";
            $select = "SELECT `adm_no` FROM `student_data` WHERE `stud_class` = ? AND `deleted`=0 AND activated=1";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$class);
            $stmt->execute();
            $result = $stmt->get_result();
            $datas = "";
            $datanew;
            if($result){
                while ($row = $result->fetch_assoc()){
                    $datas.="".$row['adm_no'].",";
                }
                $datanew = explode(",",substr($datas,0,(strlen($datas)-1)));
            }
            //retrieve data of the class from the database
            $select = "SELECT `student_data`.`surname` AS 'surname' ,`student_data`.`first_name` AS 'first_name' ,`student_data`.`second_name` AS 'second_name' ,`student_data`.`adm_no` AS 'adm_no' , `student_data`.`gender` AS 'gender' ,`student_data`.`stud_class` AS 'stud_class' ,`student_data`.`BCNo` AS 'BCNo' from `student_data` JOIN `attendancetable` ON `student_data`.`adm_no` = `attendancetable`.`admission_no` where `attendancetable`.`class` = ? and `attendancetable`.`date` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("ss",$class,$date);
            $stmt->execute();
            $results = $stmt->get_result();
            $tata = createTable($results,$datanew);
            $stmt->close();
            if(count($tata)>0){
                $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data` where `adm_no` = ? and `deleted` = 0 AND `activated` = 1";
                $unattendedtable = "";
                $stmt = $conn2->prepare($select);
                $absentno = 0;
                //Unattendace table
                $unattendedtable="<h6 style='font-size:15px;text-align:center;margin-top:20px;'>Absent list</h6>";
                $unattendedtable.="<div class='tableme'><table class='output1' >";
                $unattendedtable.="<tr><th>No</th>";
                $unattendedtable.="<th>Student Name</th>";
                $unattendedtable.="<th>Adm no.</th>";
                $unattendedtable.="<th>Gender</th>";
                $unattendedtable.="<th>Class</th>";
                $unattendedtable.="<th>Status</th></tr>";
                for ($i=0; $i < count($tata); $i++) {
                    $admno = $tata[$i];
                    $stmt->bind_param("s",$admno);
                    $stmt->execute();
                    $res = $stmt->get_result();      
                    if($res){
                        while ($rows = $res->fetch_assoc()){
                            $unattendedtable.="<tr><td>".($i+1)."</td>";
                            $unattendedtable.="<td>".ucfirst($rows['first_name'])." ".ucfirst($rows['second_name'])."</td>";
                            $unattendedtable.="<td>".$rows['adm_no']."</td>";
                            $unattendedtable.="<td>".$rows['gender']."</td>";
                            $unattendedtable.="<td>".classNameAdms($rows['stud_class'])."</td>";
                            $unattendedtable.="<td>"."Absent"."</td></tr>"; 
                            $absentno++;
                        }
                    }
                }

                $unattendedtable.="</table></div>";
                if($absentno>0){
                    echo $unattendedtable;
                }else {
                    echo "<p style='margin-top:20px;text-align:center;font-size:12px;font-weight:600;color: rgb(23, 72, 73);'>Roll call not taken!</p>";
                }

            }else {
                echo "<p style='text-align:center;margin-top:20px;font-size:12px;font-weight:600;color: rgb(23, 72, 73);'>All students are present!</p>";
            }
        }elseif (isset($_GET['findphone'])) {
            $phonenumber = $_GET['findphone'];
            include("../../connections/conn1.php");
            $conn2->close();
            $select = "SELECT * FROM `user_tbl` where `phone_number` = ? and `school_code` = ? and deleted = 0 and activated=1";
            $schoolcode;
            if(isset($_SESSION['schoolcode'])){
                $schoolcode = $_SESSION['schoolcode'];
            }else{
                $schoolcode = '';
            }
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$phonenumber,$schoolcode);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if($rnums>0){
                echo  "<p style='color:red;font-size:12px;'>The phone number entered is present</p>";
            }else{
                echo  "<p></p>";
            }
            
        }elseif (isset($_GET['findidpass'])) {
            $natid = $_GET['findidpass'];
            include("../../connections/conn1.php");
            $conn2->close();
            $select = "SELECT * FROM `user_tbl` where `nat_id` = ? and `school_code` = ? and deleted = 0 and activated=1";
            $schoolcode;
            if(isset($_SESSION['schoolcode'])){
                $schoolcode = $_SESSION['schoolcode'];
            }else{
                $schoolcode = '';
            }
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$natid,$schoolcode);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if($rnums>0){
                echo  "<p style='color:red;font-size:12px;'>The id / passport number entered is present</p>";
            }else{
                echo  "<p></p>";
            }
        }elseif (isset($_GET['findtscno'])) {
            $tscnos = $_GET['findtscno'];
            include("../../connections/conn1.php");
            $conn2->close();
            $select = "SELECT * FROM `user_tbl` where `tsc_no` = ? and `school_code` = ? and deleted = 0 and activated=1";
            $schoolcode;
            if(isset($_SESSION['schoolcode'])){
                $schoolcode = $_SESSION['schoolcode'];
            }else{
                $schoolcode = '';
            }
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$tscnos,$schoolcode);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if($rnums>0){
                echo  "<p style='color:red;font-size:12px;'>The TSC number entered is present</p>";
            }else{
                echo  "<p></p>";
            }
        }elseif (isset($_GET['findemail'])) {
            $emails = $_GET['findemail'];
            include("../../connections/conn1.php");
            $conn2->close();
            $select = "SELECT * FROM `user_tbl` where `email` = ? and `school_code` = ? and deleted = 0 and activated=1";
            $schoolcode;
            if(isset($_SESSION['schoolcode'])){
                $schoolcode = $_SESSION['schoolcode'];
            }else{
                $schoolcode = '';
            }
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$emails,$schoolcode);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if($rnums>0){
                echo  "<p style='color:red;font-size:12px;'>The email entered is present</p>";
            }else{
                echo  "<p></p>";
            }
        }elseif (isset($_GET['insertstaff'])) {
            $fullname = $_GET['fullnames'];
            $dobo = $_GET['dobos'];
            $schoolcodes = $_SESSION['schoolcode'];
            $phonenumber = $_GET['phonenumbers'];
            $gender = $_GET['genders'];
            $address = $_GET['address'];
            $natids = $_GET['idnumber'];
            $tscno = $_GET['tscnumber'];
            include("../../assets/encrypt/encrypt.php");
            include("../../connections/conn1.php");
            $password = encryptCode($_GET['password']);
            $email = $_GET['emails'];
            $username = $_GET['username'];
            $authority = $_GET['authority'];
            $nhif_number = $_GET['nhif_number'];
            $nssf_number = $_GET['nssf_number'];
            $delete = 0;
            $activated = 1;
            if ($authority == "6") {
                $delete = 1;
                $activated = 0;
            }


            $insert = "INSERT INTO `user_tbl` (`fullname`,`dob`,`school_code`,`phone_number`,`gender`,`auth`,`address`,`nat_id`,`tsc_no`,`username`,`password`,`email`,`activated`,`nssf_number`,`nhif_number`,`deleted`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt=$conn->prepare($insert);
            $stmt->bind_param("ssssssssssssssss",$fullname,$dobo,$schoolcodes,$phonenumber,$gender,$authority,$address,$natids,$tscno,$username,$password,$email,$activated,$nssf_number,$nhif_number,$delete);
            if($stmt->execute()){
                //administrator notification
                    $messageName = "Registration of <b>".$fullname."</b> as a new staff was successfull";
                    $messagecontent = "Registration of ".$fullname." as <b>".getAuthority($authority)."</b> has been done successfully<br>The user is to use their username and password you assigned them to login";
                    $notice_stat = 0;
                    $reciever_id = "all";
                    $reciever_auth = 1;
                    $sender_ids = "Administration system";
                    insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
                    ///staff notification
                    $messageName = "Hello <b>".$fullname."</b>. Welcome!";
                    $messagecontent = "Hello <b>".$fullname."</b>, Welcome to <b>".$_SESSION['schoolname']." SMIS</b>. <br>You are assigned <b>".getAuthority($authority)."</b> by your administrator.<br>Use the menu on your left to navigate the system and the home button on the top to view your dashboard.";
                    $notice_stat = 0;
                    //latest id
                    $staff_id = latestStaffId();
                    if ($staff_id > 0) {
                        $reciever_id = $staff_id;
                        $reciever_auth = $authority;
                        insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
                    }
                    echo "<p style='color:green;'>"."Registration was completed successfull!!"."</p>";
            }else {
                echo "<p style='color:red;'>"."An error occured during registration!"."</p>";
            }
        }elseif (isset($_GET['getavalablestaff'])) {
            $select = "SELECT `fullname` ,`phone_number`,`gender`,`nat_id`,`tsc_no`,`auth`,`activated`,`user_id` FROM `user_tbl` where `school_code` = ? AND `user_id` != ?";
            $schoolcodes = $_SESSION['schoolcode'];
            $userid = $_SESSION['userids'];
            include("../../connections/conn1.php");
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$schoolcodes,$userid);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                $xs =0;
                $data="<h6 style='font-size:17px;text-align:center;font-weight:550;font-family:'Rockwell';'>My Staff List</h6>";
                $data.="<p style='display:none;' id='errorsviewing'>Pop</p>";
                $data.="<div class='container'><table class='table output1' >";
                $data.="<tr><th>No.</th>";
                $data.="<th>Fullname</th>";
                $data.="<th>Authority</th>";
                $data.="<th>Gender</th>";
                $data.="<th>National id</th>";
                $data.="<th>Activated</th>";
                $data.="<th>Option</th></tr>";
                $xs2=0;
                $number = 1;
                while ($rowed = $result->fetch_assoc()) {
                    $data.="<tr><td>".$number."</td><td>".ucwords(strtolower($rowed['fullname']))."</td>";
                    if(isset($rowed['auth'])){
                        $auth = $rowed['auth'];
                        if($auth=='0'){
                            $data.="<td>"."Administrator"."</td>";
                        }elseif ($auth=='1') {
                            $data.="<td>"."Headteacher/Principal"."</td>";
                        }elseif ($auth=='2') {
                            $data.="<td>"."Teacher"."</td>";
                        }elseif ($auth=='3') {
                            $data.="<td>"."Deputy principal"."</td>";
                        }elseif ($auth=='4') {
                            $data.="<td>"."Staff"."</td>";
                        }elseif ($auth=='5') {
                            $data.="<td>"."Class teacher"."</td>";
                        }elseif ($auth=='6') {
                            $data.="<td>"."School Driver"."</td>";
                        }else {
                            $data.="<td style='color:blue;'>".ucwords(strtolower($auth))."</td>";
                        }
                    }else {
                        $data.="<td>"."N/A"."</td>";
                    }
                    
                    $data.="<td>".$rowed['gender']."</td>";
                    $data.="<td>".$rowed['nat_id']."</td>";
                    if (isset($rowed['activated'])) {
                        $activated = $rowed['activated'];
                        if($activated=='1'){
                            $data.="<td>"."Active"."</td>";
                        }else {
                            $data.="<td style='color:red;'>"."Not active"."</td>";
                        }
                    }
                    
                    $my_user_ids = $rowed['user_id'];
                    
                    $number++;
                    $data.="<td>"."<p class='link viewtr' style='font-size:12px;' id='".$my_user_ids."'><i class='fa fa-eye'></i> View</p>"."</td></tr>";
                }
                $data.="</table></div>";
                echo $data;
            }
        }elseif (isset($_GET['staffdata'])) {
            $id = $_GET['staffdata'];
            include("../../connections/conn1.php");
            $select = 'SELECT * FROM `user_tbl` WHERE `user_id`=?';
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $results = $stmt->get_result();
            if($results){
                $data = "";
                while ($rows = $results->fetch_assoc()) {
                    $data.=$rows['fullname']."^";
                    $data.=$rows['dob']."^";
                    $data.=$rows['school_code']."^";
                    $data.=$rows['phone_number']."^";
                    $data.=$rows['gender']."^";
                    $data.=$rows['address']."^";
                    $data.=$rows['nat_id']."^";
                    $data.=$rows['tsc_no']."^";
                    $data.=$rows['username']."^";
                    $data.=$rows['deleted']."^";
                    $data.=$rows['activated']."^";
                    $data.=$rows['auth']."^";
                    $data.=$rows['email']."^";
                    $data.=$rows['user_id']."^";
                    $data.=$rows['nssf_number']."^";
                    $data.=$rows['nhif_number'];
                }
                echo $data;
            }
        }elseif (isset($_GET['updatestaff'])) {
            $fullname = $_GET['fullnames'];
            $dob = $_GET['dob'];
            $natids = $_GET['natids'];
            $phonenumber = $_GET['phonenumber'];
            $address = $_GET['address'];
            $emails = $_GET['emails'];
            $tscno = $_GET['tscno'];
            $username = $_GET['username'];
            $genders = $_GET['genders'];
            $activated = $_GET['activated'];
            $authorities = $_GET['authorities'];
            $staffid = $_GET['staffid'];
            $deleted = $_GET['deleted'];
            $nssf_numbers = $_GET['nssf_numbers'];
            $nhif_numbers = $_GET['nhif_numbers'];
            include("../../connections/conn1.php");

            $update = "UPDATE `user_tbl` SET `fullname` = ?,`dob` = ?,`phone_number` = ?,`gender` =?,`address` = ?,`nat_id`=?,`tsc_no`=?,`username` =?,`deleted`=?,`auth`=?,`email`=?,`activated` =?, `nssf_number` = ?, `nhif_number` = ? WHERE `user_id` = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param('sssssssssssssss',$fullname,$dob,$phonenumber,$genders,$address,$natids,$tscno,$username,$deleted,$authorities,$emails,$activated,$nssf_numbers,$nhif_numbers,$staffid);
            if($stmt->execute()){
                if ($authorities != "5") {
                    $delete = "DELETE FROM `class_teacher_tbl` WHERE `class_teacher_id` = ?";
                    $stmt = $conn2->prepare($delete);
                    $stmt->bind_param("s",$staffid);
                    if($stmt->execute()){
                        echo "<p style='color:green;'>Staff information updated successfully!</p>";
                    }else {
                        echo "<p style='color:red;'>Error occured during updating!</p>";
                    }
                }else {
                    echo "<p style='color:green;'>Staff information updated successfully!</p>";
                }
            }else {
                echo "<p style='color:red;'>Error occured during updating!</p>";
            }
        }elseif (isset($_GET['findnationalid'])) {
            $nationalid = $_GET['findnationalid'];
            $userids = $_GET['userids'];
            $select = "SELECT * FROM `user_tbl` WHERE `nat_id` = ? and NOT `user_id` = ? ";
            include("../../connections/conn1.php");
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$nationalid,$userids);
            $stmt->execute();
            $stmt->store_result();
            $snums = $stmt->num_rows;
            if($snums>0){
                echo "<p style='color:red;'><small>The id or passport number entered is already used!</small></p>";
            }else {
                echo "<p></p>";
            }
        }elseif (isset($_GET['findphonenumberd'])) {
            $phonenumber = $_GET['findphonenumberd'];
            $userid = $_GET['userids'];
            $select = "SELECT * FROM `user_tbl` WHERE `phone_number` = ? and NOT `user_id` = ? ";
            include("../../connections/conn1.php");
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$phonenumber,$userid);
            $stmt->execute();
            $stmt->store_result();
            $snums = $stmt->num_rows;
            if($snums>0){
                echo "<p style='color:red;'><small>The phone number entered is already used!</small></p>";
            }else {
                echo "<p></p>";
            }
        }elseif (isset($_GET['findstafsemails'])) {
            $emails = $_GET['findstafsemails'];
            $userid = $_GET['userids'];
            $select = "SELECT * FROM `user_tbl` WHERE `email` = ? and NOT `user_id` = ? ";
            include("../../connections/conn1.php");
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$emails,$userid);
            $stmt->execute();
            $stmt->store_result();
            $snums = $stmt->num_rows;
            if($snums>0){
                echo "<p style='color:red;'><small>The email entered is already used!</small></p>";
            }else {
                echo "<p></p>";
            }
        }elseif (isset($_GET['findusername'])) {
            $emails = $_GET['findusername'];
            $userid = $_GET['userids'];
            $select = "SELECT * FROM `user_tbl` WHERE  `username` = ? and NOT `user_id` = ? ";
            include("../../connections/conn1.php");
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$emails,$userid);
            $stmt->execute();
            $stmt->store_result();
            $snums = $stmt->num_rows;
            if($snums>0){
                echo "<p style='color:red;'><small>The username entered is already used!</small></p>";
            }else {
                echo "<p></p>";
            }
        }elseif (isset($_GET['studentspresenttoday'])) {
            $date = date("Y-m-d",strtotime("3 hour"));
            $select = "SELECT COUNT(id) as 'Totals' FROM `attendancetable` WHERE `date` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$date);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                if($rows = $result->fetch_assoc()){
                    echo $rows['Totals']." Student(s)";
                }
            }
        }elseif (isset($_GET['activeuser'])) {
            $userid = $_GET['userid'];
            $insert = "INSERT INTO `logs` (`login_time`,`active_time`,`date`,`user_id`) VALUES (?,?,?,?)";
            $update = "UPDATE `logs` SET `active_time` = ? WHERE `user_id`=? AND `date`=?";
            $select = "SELECT * FROM `logs` WHERE `date` = ? and `user_id`= ? ";
            //check if there is a record for today
            //if present update the time, if not update
            $smt = $conn2->prepare($select);
            $date = date("Y-m-d",strtotime("3 hour"));
            $smt->bind_param("ss",$date,$userid);
            $smt->execute();
            $smt->store_result();
            $rnums = $smt->num_rows;
            if($rnums>0){
                $smt->close();
                $smt = $conn2->prepare($update);
                $time = date("H:i:s",strtotime("3 hour"));
                $smt->bind_param("sss",$time,$userid,$date);
                $smt->execute();
                echo  "TIME = ".$time;
                $smt->close();
                $conn2->close();
            }else {
                $smt->close();
                $smt = $conn2->prepare($insert);
                $time = date("H:i:s",strtotime("3 hour"));
                $smt->bind_param("ssss",$time,$time,$date,$userid);
                $smt->execute();
                echo  "TIME = ".$time;
                $smt->close();
                $conn2->close();
            }
        }elseif (isset($_GET['checkactive'])) {
            $select = "SELECT COUNT(user_id) AS 'totals' FROM `logs` where `date`= ? and `active_time` >= ?";
            $stmt = $conn2->prepare($select);
            $date = date("Y-m-d",strtotime("3 hour"));
            $time = date("H:i:s",strtotime("3598 seconds"));
            $stmt->bind_param("ss",$date,$time);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                if($row=$result->fetch_assoc()){
                    echo $row['totals']." User(s)";
                }
            }
            $stmt->close();
            $conn2->close();
        }elseif (isset($_GET['totaluserspresent'])) {
            $select = "SELECT COUNT(fullname) AS 'Total' FROM `user_tbl` where `school_code` = ?";
            include("../../connections/conn1.php");
            $stmt = $conn->prepare($select);
            $schoolcodes = $_SESSION['schoolcode'];
            $stmt->bind_param("s",$schoolcodes);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                if($row=$result->fetch_assoc()){
                    echo $row['Total']." user(s)";
                }
            }
        }elseif (isset($_GET['schoolfeesrecieved'])) {
            $select = "SELECT sum(`amount`) AS 'Amount' FROM `finance` WHERE date_of_transaction = ?";
            include("../../comma.php");
            $stmt = $conn2->prepare($select);
            $date = date("Y-m-d",strtotime("3 hour"));
            $stmt->bind_param("s",$date);
            $stmt->execute();
            $res = $stmt->get_result();
            $total_all = "Ksh 0";
            if($res){
                if ($rowed = $res->fetch_assoc()) {
                    if (isset($rowed['Amount'])) {
                        $total_all = "Ksh ".comma($rowed['Amount']);   
                    }
                }
            }
            echo $total_all;
        }elseif (isset($_GET['updatingpassword'])) {
            $password = $_GET['updatingpassword'];
            $userid = $_GET['usersids'];
            include("../../connections/conn1.php");
            include("../../assets/encrypt/encrypt.php");
            $update = 'UPDATE `user_tbl` SET `password` = ? WHERE `user_id` = ?';
            $stmt = $conn->prepare($update);
            $password = encryptCode($password);
            $stmt->bind_param("ss",$password,$userid);
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Password update was successfull!</p>";
            }else {
                echo "<p style='color:red;'>Password update wasn`t successfull!</p>";
            }
        }elseif (isset($_GET['get_CLassteacher'])) {
            $select = "SELECT `class_teacher_id`,`class_assigned`,`active` FROM `class_teacher_tbl`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            include("../../connections/conn1.php");
            if ($result) {
                $table_information = "<div class='tableme'><table>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Class Assigned</th>
                                            <th>Option</th>
                                        </tr>";
                                        $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    //get teacher name
                    $xs++;
                    $tr_name = getTeacherName($conn,$row['class_teacher_id']);
                    $daros = $row['class_assigned'];
                    if (strlen($daros)==1){
                        $daros = "Class ".$row['class_assigned'];
                    }
                    $table_information.="<tr>
                                            <td>".$xs.". </td>
                                            <td id= 'ccN".$row['class_teacher_id']."'>".$tr_name."</td>
                                            <td id= 'ccD".$row['class_teacher_id']."'>".$daros."</td>
                                            <td><p style='margin:1px;font-size:12px;' class='change_classteacher link' id='cc".$row['class_teacher_id']."'><i class='fa fa-pen'></i> Edit</p></td>
                                        </tr>";
                }
                $table_information.="</table></div>";
                if ($xs > 0) {
                    echo $table_information;
                }else {
                    echo "<div class='displaydata'>
                            <img class='' src='images/error.png'>
                            <p class='' >No records found! </p>
                        </div>";
                }
            }
        }elseif (isset($_GET['get_available_teacher'])) {
            //get the teachers with classes
            $select = "SELECT `class_teacher_id` FROM `class_teacher_tbl`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $tr_with_class = "";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $tr_with_class.=$row['class_teacher_id'].",";
                }
                $split_p_tr = [];
                if (strlen($tr_with_class) > 0) {
                    //remove comma
                    $tr_with_class = substr($tr_with_class,0,strlen($tr_with_class)-1);
                    $split_p_tr = explode(",",$tr_with_class);
                }
                include("../../connections/conn1.php");
                //get the class teachers
                $select = "SELECT `user_id` FROM `user_tbl` WHERE `school_code` = ? AND `auth` = 5";
                $schoolcode = $_SESSION['schoolcode'];
                $stmt = $conn->prepare($select);
                $stmt->bind_param("s",$schoolcode);
                $stmt->execute();
                $result = $stmt->get_result();
                $tr_class = "";
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $tr_class.=$row['user_id'].",";
                    }
                }
                if (strlen($tr_class) > 0) {
                    //remove comma
                    $tr_class = substr($tr_class,0,strlen($tr_class)-1);
                }
                //of all the teachers dont include those who are not present
                $newstring = "";
                $split_tr = explode(",",$tr_class);
                for ($xd=0; $xd < count($split_tr); $xd++) { 
                    $present = checkPresnt($split_p_tr,$split_tr[$xd]);
                    if ($present == 0) {
                        $newstring.=$split_tr[$xd].",";
                    }
                }
                $tr_with_out_class = [];
                if (strlen($newstring) > 0) {
                    //remove comma
                    $newstring = substr($newstring,0,strlen($newstring)-1);
                    $tr_with_out_class = explode(",",$newstring);
                }
                
                //completed teacher list who are class teachers
                if (count($tr_with_out_class) > 0) {
                    $datatoshow="<div class ='classlist2' style='height:100px;overflow:auto;' name='selectsubs' id=''>";
                    for ($index=0; $index < count($tr_with_out_class); $index++) { 
                        $trnames = getTeacherName($conn,$tr_with_out_class[$index]);
                        $datatoshow.="<div class = 'checkboxholder' style='margin:10px 0;padding:0px 0px;'>
                                            <label style='margin-right:5px;cursor:pointer;font-size:12px;' for='data".$tr_with_out_class[$index]."' id=''>".($index+1).". ".$trnames."</label>
                                            <input class='check_subjects hide' type='checkbox' value='".$trnames."' name='' id='data".$tr_with_out_class[$index]."'>
                                        </div>";
                    }
                    $datatoshow.="</div>";
                    echo $datatoshow;
                }else {
                    echo "<p class='green_notice' >No teacher records found! </p>";
                }
                
            }
        }elseif (isset($_GET['get_Class_available'])) {
            $select = "SELECT `class_assigned` FROM `class_teacher_tbl`";
            $stmt=$conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $class_assigned = "";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $class_assigned.=$row['class_assigned'].",";
                }
                $class_with_tr = [];
                if(strlen($class_assigned) > 0){
                    $class_assigned = substr($class_assigned,0,strlen($class_assigned)-1);
                    $class_with_tr = explode(",",$class_assigned);
                }
                //found array of classes with teachers

                //find array of all classes that are not present
                $select = "SELECT `valued` FROM `settings` WHERE `id` = 2";
                $stmt = $conn2->prepare($select);
                $stmt->execute();
                $result = $stmt->get_result();
                $class_list = "";
                $class_lists = [];
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        $class_list = $row['valued'];
                    }
                    if (strlen($class_list) > 0) {
                        $class_lists = explode(",",$class_list);
                    }
                }
                $new_list = "";
                if (count($class_with_tr) > 0) {
                    for ($ind=0; $ind < count($class_lists); $ind++) { 
                        $present = checkPresnt($class_with_tr,$class_lists[$ind]);
                        if ($present == 0) {
                            $new_list.=$class_lists[$ind].",";
                        }
                    }
                    $new_list = substr($new_list,0,strlen($new_list)-1);
                }else {
                    //display the classlist
                    $new_list = $class_list;
                }
                $classlist_display = explode(",",$new_list);
                $data_to_display = "<div class ='classlist2' style='height:100px;overflow:auto;' name='selectsubs' id=''>";
                $xs = 0;
                if (strlen($new_list) > 0){
                    for ($ind=0; $ind < count($classlist_display); $ind++) { 
                        $xs++;
                        $daros = $classlist_display[$ind];
                        if (strlen($daros)==1){
                            $daros = "Class ".$classlist_display[$ind];
                        }
                        $data_to_display.="<div class = 'checkboxholder' style='margin:10px 0;padding:0px 0px;'>
                            <label style='margin-right:5px;cursor:pointer;font-size:12px;' for='cl_ass".$classlist_display[$ind]."'>".$daros."</label>
                            <input class='check_class' type='checkbox' value='".$classlist_display[$ind]."' name='' id='cl_ass".$classlist_display[$ind]."'>
                        </div>";
                    }
                    $data_to_display.="</div>";
                }
                if ($xs>0) {
                    echo $data_to_display;
                }else {
                    $data_to_display = "<div class ='classlist' style='height:100px;overflow:auto;' name='selectsubs' id='selectsubs'>";
                    $data_to_display.="<div class = 'checkboxholder' style='margin:10px 0;padding:0px 0px;'>";
                    $data_to_display.="<label style='margin-right:5px;cursor:pointer;font-size:13px;' for='abc'>No Classes present</label>";
                    $data_to_display.="</div>";
                    $data_to_display.="</div>";
                    echo $data_to_display;
                }
            }
        }elseif (isset($_GET['add_classteacher'])) {
            $class = $_GET['clas_s'];
            $teacher_ids = $_GET['teacher_ids'];
            $insert = "INSERT INTO class_teacher_tbl (class_teacher_id,class_assigned,active) VALUES (?,?,?)";
            $active = 1;
            $stmt = $conn2->prepare($insert);
            $stmt->bind_param("sss",$teacher_ids,$class,$active);
            if($stmt->execute()){
                echo "<p style='color:green;font-size:12px;'>Class teacher assigned successfully!</p>";
            }else {
                echo "<p style='color:red;font-size:12px;'>An error occured!<br>Please try again later!</p>";
            }
        }elseif (isset($_GET['teacher_unassign_id'])) {
            $tr_id = $_GET['teacher_unassign_id'];
            $delete = "DELETE FROM `class_teacher_tbl` WHERE `class_teacher_id` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$tr_id);
            if($stmt->execute()){
                echo "<p style='color:green;font-size:12px;'>Unassignement was successfull</p>";
            }else {
                echo "<p style='color:red;font-size:12px;'>An error has occured.<br>Please try again later!</p>";
            }
        }elseif (isset($_GET['get_teacher_for_subject'])) {
            //get the teachers with classes
            $select = "SELECT `class_teacher_id` FROM `class_teacher_tbl`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $tr_with_class = "";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $tr_with_class.=$row['class_teacher_id'].",";
                }
                $split_p_tr = [];
                if (strlen($tr_with_class) > 0) {
                    //remove comma
                    $tr_with_class = substr($tr_with_class,0,strlen($tr_with_class)-1);
                    $split_p_tr = explode(",",$tr_with_class);
                }
                include("../../connections/conn1.php");
                //get the class teachers
                $select = "SELECT `user_id` FROM `user_tbl` WHERE `school_code` = ? AND `auth` = 5";
                $schoolcode = $_SESSION['schoolcode'];
                $stmt = $conn->prepare($select);
                $stmt->bind_param("s",$schoolcode);
                $stmt->execute();
                $result = $stmt->get_result();
                $tr_class = "";
                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        $tr_class.=$row['user_id'].",";
                    }
                }
                if (strlen($tr_class) > 0) {
                    //remove comma
                    $tr_class = substr($tr_class,0,strlen($tr_class)-1);
                }
                //of all the teachers dont include those who are not present
                $newstring = "";
                $split_tr = explode(",",$tr_class);
                for ($xd=0; $xd < count($split_tr); $xd++) { 
                    $present = checkPresnt($split_p_tr,$split_tr[$xd]);
                    if ($present == 0) {
                        $newstring.=$split_tr[$xd].",";
                    }
                }
                $tr_with_out_class = [];
                if (strlen($newstring) > 0) {
                    //remove comma
                    $newstring = substr($newstring,0,strlen($newstring)-1);
                    $tr_with_out_class = explode(",",$newstring);
                }
                
                //completed teacher list who are class teachers
                if (count($tr_with_out_class) > 0) {
                    $datatoshow="<div class ='classlist2' style='height:100px;overflow:auto;' name='selectsubs' id=''>";
                    for ($index=0; $index < count($tr_with_out_class); $index++) { 
                        $trnames = getTeacherName($conn,$tr_with_out_class[$index]);
                        $datatoshow.="<div class = 'checkboxholder' style='margin:10px 0;padding:0px 0px;'>
                                            <label style='margin-right:5px;cursor:pointer;font-size:12px;' for='tr_subs".$tr_with_out_class[$index]."' id=''>".($index+1).". ".$trnames."</label>
                                            <input class='check_teachers_subjects ' type='checkbox' value='".$trnames."' name='' id='tr_subs".$tr_with_out_class[$index]."'>
                                        </div>";
                    }
                    $datatoshow.="</div>";
                    echo $datatoshow;
                }else {
                    echo "<div class='displaydata'>
                            <img class='' src='images/error.png'>
                            <p class='' >No class teachers found! </p>
                        </div>";
                }
                
            }
        }elseif (isset($_GET['replace_tr_id'])) {
            $replace_tr = $_GET['replace_tr_id'];
            $existing_id = $_GET['existing_id'];
            $select = "UPDATE `class_teacher_tbl` SET `class_teacher_id` = ? WHERE `class_teacher_id` = ?";
            $smt = $conn2->prepare($select);
            $smt->bind_param("ss",$replace_tr,$existing_id);
            if($smt->execute()){
                echo "<p style='color:green;font-size:12px;'>Update was done successfully!</p>";
            }else {
                echo "<p style='color:red;font-size:12px;'>An error has occured!<br>Please try again later!</p>";
            }
        }elseif (isset($_GET['getclass'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $select_class_id = $_GET['select_class_id'];
            $value_prefix = $_GET['value_prefix'];
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $class = trim($row['valued']);
                    $class_explode = explode(",",$class);
                    $counter = 0;
                    $string_to_display = "<select class='form-control w-100' name='".$select_class_id."' id='".$select_class_id."'> <option value='' hidden>Select..</option>";
                    $string_to_display.="<option  id='".$value_prefix."-2' value='-2'>Transfered</option>";
                    $string_to_display.="<option  id='".$value_prefix."-1' value='-1'>Alumni</option>";
                    for ($xs=count($class_explode)-1; $xs >= 0; $xs--) { 
                        $counter++;
                        if (strlen($value_prefix) > 0) {
                            $string_to_display.="<option id='".$value_prefix.$class_explode[$xs]."' value='".$class_explode[$xs]."'>".myClassName($class_explode[$xs])."</option>";
                        }else {
                            $string_to_display.="<option value='".$class_explode[$xs]."'>".myClassName($class_explode[$xs])."</option>";
                        }
                    }
                    $string_to_display.="</select>";
                    if ($counter > 1) {
                        echo $string_to_display;
                    }else {
                        echo "<p class='red_notice'>No classes to choose<br>Contact your administrator to rectify the issue!</p>";
                    }
                }
            }
        }elseif (isset($_GET['getmyClassList'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "";
                if ($row = $result->fetch_assoc()) {
                    $class_list = trim($row['valued']);
                    if (strlen($class_list) > 0) {
                        //split the classes with a comma
                        $class_listed = explode(",",$class_list);

                        if (count($class_listed) > 0) {
                            $data_to_display.="<table style='margin:10;margin-left:30px;'><tr><th>No.</th>
                                                            <th>Class</th>
                                                            <th>Options</th>
                                                        </tr>";
                            $xs = 0;
                            for ($xc=0; $xc < count($class_listed); $xc++) { 
                                $xs++;
                                $data_to_display.="<tr>
                                                    <td>".$xs.". </td>
                                                    <td id='cll".$class_listed[$xc]."'>".myClassName($class_listed[$xc])."</td>
                                                    <td><p class='link remove_class' = id='clm".$class_listed[$xc]."' style='font-size:12px; color:brown;'><i class='fa fa-trash'></i></p></td>
                                                    </tr>";
                            }
                            $data_to_display.="</table>";
                        }else {
                            $data_to_display.="<p class='red_notice'>No classes to display!</p>";
                        }
                    }else {
                        $data_to_display.="<p class='red_notice'>No classes to display!</p>";
                    }
                }
                echo $data_to_display;
            }
        }elseif (isset($_GET['loginHours'])) {
            include("../../connections/conn1.php");
            $select = "SELECT `from_time`, `to_time` FROM `school_information` WHERE `school_code` = ? ";
            $stmt=$conn->prepare($select);
            $stmt->bind_param("s",$_SESSION['schoolcode']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    if (strlen($row['from_time']) > 0) {
                        echo $row['from_time']."|".$row['to_time'];
                    }else {
                        echo "";
                    }
                }
            }
        }elseif (isset($_GET['academicCalender'])) {
            $select = "SELECT `term`,`start_time` , `end_time` ,`closing_date` FROM  `academic_calendar`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<div class='table_holders'><table>
                                        <tr>
                                            <th>No. </th>
                                            <th>Term</th>
                                            <th>Opening day</th>
                                            <th>Closing date:</th>
                                            <th>Ending date</th>
                                        </tr>";
                                        $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $data_to_display.="<tr>
                                        <td>".$xs.".</td>
                                        <td>".$row['term']."</td>
                                        <td>".date("M-d-Y",strtotime($row['start_time']))."</td>
                                        <td>".date("M-d-Y",strtotime($row['closing_date']))."</td>
                                        <td>".date("M-d-Y",strtotime($row['end_time']))."</td>
                                    </tr>";
                }
                $data_to_display.="</table></div>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='green_notice'>No academic calender!</p>";
                }
            }
        }elseif (isset($_GET['get_adm_essential'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'admissionessentials'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $valued = $row['valued'];
                    $data_to_display = "";
                    if (strlen($valued) > 0) {
                        $data_to_display.="<table>
                                            <tr>
                                                <th>No. </th>
                                                <th>Admission item</th>
                                                <th>Delete</th>
                                            </tr>";
                        $split_val = explode(",",$valued);
                        $xs = 0;
                        for ($dc=0; $dc < count($split_val); $dc++) {
                            $xs++;
                            $data_to_display.="<tr>
                                                <td>".$xs.". </td>
                                                <td>".$split_val[$dc]."</td>
                                                <td><p class='link adms_essent' id='vals".$split_val[$dc]."' style='color:brown;font-size:12px;'><i class='fa fa-trash'></i></p></td>
                                            </tr>";
                        }
                        $data_to_display.="</table>";
                    }else {
                        $data_to_display.="<p class='red_notice'>No admission essentials present!</p>";
                    }
                }
            }
            echo $data_to_display;
        }elseif (isset($_GET['add_class'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $old_string_class = $row['valued'];
                    if(strlen($old_string_class) < 1){
                        $old_string_class.=$_GET['add_class'];
                    }else {
                        $old_string_class.=",".$_GET['add_class'];
                    }
                    $update = "UPDATE `settings` SET `valued` = ? WHERE `sett` = 'class'";
                    $stmt = $conn2->prepare($update);
                    $stmt->bind_param("s",$old_string_class);
                    if($stmt->execute()){
                        echo "<p class='green_notice'>Class has been added succesfully!</p>";
                    }else {
                        echo "<p class='red_notice'>An error has occured!</p>";
                    }
                }
            }
        }elseif (isset($_GET['remove_class'])) {
            $class_remove = $_GET['remove_class'];
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $class_list = $row['valued'];
                    if (strlen($class_list) > 0) {
                        $class_explode = explode(",",$class_list);
                        $new_list = "";
                        for ($ind=0; $ind < count($class_explode); $ind++) { 
                            if ($class_explode[$ind] == $class_remove) {

                            }else {
                                $new_list.=$class_explode[$ind].",";
                            }
                        }
                        $new_list = substr($new_list,0,strlen($new_list) - 1);
                        $update = "UPDATE `settings` set `valued` = ? WHERE `sett` = 'class'";
                        $stmt = $conn2->prepare($update);
                        $stmt->bind_param("s",$new_list);
                        if($stmt->execute()){
                            echo "<p class='green_notice'>".myClassName($class_remove)." removed successfully</p>";
                        }else {
                            echo "<p class='red_notice'>An error occured during deleting..<br>Please try again later!</p>";
                        }
                    }
                }
            }
        }elseif (isset($_GET['change_active_hours'])) {
            include("../../connections/conn1.php");
            $from = $_GET['from'];
            $to = $_GET['to'];
            $update = "UPDATE `school_information` SET `from_time` = ?, `to_time` = ? WHERE `school_code` = ?";
            $stmt = $conn->prepare($update);
            $stmt->bind_param("sss",$from,$to,$_SESSION['schoolcode']);
            if($stmt->execute()){
                $date_from = date_create($from);
                $date_to = date_create($to);
                $difference = date_diff($date_from,$date_to);
                echo $difference->format("Active login period is successfully set to <span class='green_notice'>%H hours %i mins per day</span>");
            }else {
                echo "<p class='red_notice'>An error occured during update!</p>";
            }
            $stmt->close();
            $conn->close();
        }elseif (isset($_GET['update_sch_cal'])) {
            $term_one_start = $_GET['term_one_start'];
            $term_one_close = $_GET['term_one_close'];
            $term_one_end = $_GET['term_one_end'];
            $term_two_start = $_GET['term_two_start'];
            $term_two_close = $_GET['term_two_close'];
            $term_two_end = $_GET['term_two_end'];
            $term_three_start = $_GET['term_three_start'];
            $term_three_close = $_GET['term_three_close'];
            $term_three_end = $_GET['term_three_end'];
            $update = "UPDATE `academic_calendar` SET `start_time` = ? , `end_time` = ? , `closing_date` = ? WHERE `id` = ?";
            $stmt = $conn2->prepare($update);
            //term one
            $term = 1;
            $stmt->bind_param("ssss",$term_one_start,$term_one_end,$term_one_close,$term);
            $stmt->execute();
            //term two
            $term = 2;
            $stmt->bind_param("ssss",$term_two_start,$term_two_end,$term_two_close,$term);
            $stmt->execute();
            //term three
            $term = 3;
            $stmt->bind_param("ssss",$term_three_start,$term_three_end,$term_three_close,$term);
            $stmt->execute();
        }elseif (isset($_GET['add_admission_ess'])) {
            $component = $_GET['component'];
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'admissionessentials'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $admission_components = $row['valued'];
                    if (strlen($admission_components) > 0) {
                        $admission_components.=",".$component;
                    }else {
                        $admission_components.=$component;
                    }
                    $update = "UPDATE `settings` SET `valued` = ? WHERE `sett` = 'admissionessentials'";
                    $stmt = $conn2->prepare($update);
                    $stmt->bind_param("s",$admission_components);
                    $stmt->execute();
                }
            }
        }elseif (isset($_GET['remove_components'])) {
            $component_name = $_GET['component_rem'];
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'admissionessentials'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $comps = $row['valued'];
                    if (strlen($comps) > 0) {
                        $split_comps = explode(",",$comps);
                        $new_list = "";
                        for ($xsd=0; $xsd < count($split_comps); $xsd++) { 
                            if ($split_comps[$xsd] == $component_name) {
                            }else {
                                $new_list.=$split_comps[$xsd].",";
                            }
                        }
                        $new_list = substr($new_list,0,strlen($new_list)-1);
                        $update = "UPDATE `settings` SET `valued` = ? WHERE `sett` = 'admissionessentials'";
                        $stmt = $conn2->prepare($update);
                        $stmt->bind_param("s",$new_list);
                        $stmt->execute();
                    }
                }
            }
        }elseif (isset($_GET['usernames_value'])) {
            include("../../connections/conn1.php");
            $usernames_value = $_GET['usernames_value'];
            $select = "SELECT * FROM `user_tbl` WHERE `username` = ? AND `user_id` != ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("ss",$usernames_value,$_SESSION['userids']);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                echo "<p class='red_notice'>The username is already used!</p>";
            }
            $stmt->close();
            $conn->close();
        }elseif (isset($_GET['transfered_students'])) {
            // get the total number of transfered students
            $select = "SELECT COUNT(*) AS 'Total' FROM `student_data` WHERE `stud_class` = '-2';";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    echo $row['Total']." Transfered Student(s)";
                }else {
                    echo "0 Transfered Student(s)";
                }
            }else {
                echo "0 Transfered Student(s)";
            }
        }elseif (isset($_GET['alumnis_number'])) {
            // get the total number of transfered students
            $select = "SELECT COUNT(*) AS 'Total' FROM `student_data` WHERE `stud_class` = '-1';";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    echo $row['Total']." Alumni(s)";
                }else {
                    echo "0 Alumni(s)";
                }
            }else {
                echo "0 Alumni(s)";
            }
        }
        elseif (isset($_GET['get_loggers'])) {
            include("../../connections/conn1.php");
            $get_loggers = $_GET['get_loggers'];
            $select = "SELECT `id` , `login_time`,`active_time`,`date`,`user_id` FROM `logs` WHERE `date` = ?";
            $date = date("Y-m-d",strtotime("3 hour"));
            $time = date("H:i:s",strtotime("59 minutes"));
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$date);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<h6>Active logs for Today (<u>".date("M-dS-Y",strtotime($date))."</u>)</h6><table style='margin-left:10px;'>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Time Login</th>
                                        <th>Last time Active</th>
                                        <th>Status</th>
                                    </tr>";
                                    $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $time = date("H:i:s",strtotime("3 hour"));
                    $time1 = date_create($time);
                    $time2 = date_create($row['active_time']);
                    $time3 = date_diff($time2,$time1);
                    $timeval = $time3->format("%s");
                    $status = "<td>In-Active</td>";
                    $hour = $time3->format("%h");
                    $min = $time3->format("%i");
                    if ($timeval <= 2) {
                        if ($hour < 1) {
                            if ($min < 1) {
                                $status = "<td class='bg_green'>Active</td>";                                
                            }
                        }
                    }
                    $data_to_display.="<tr>
                                        <td>".$xs.".</td>
                                        <td>".getTeacherName($conn,$row['user_id'])."</td>
                                        <td>".$row['login_time']."</td>
                                        <td>".$row['active_time']."</td>
                                        ".$status."
                                    </tr>";
                }
                $data_to_display.="</table>";
                if ($xs > 0) {
                    echo $data_to_display;
                }
            }
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['date_logs'])) {
            include("../../connections/conn1.php");
            $select = "SELECT `id` , `login_time`,`active_time`,`date`,`user_id` FROM `logs` WHERE `date` = ?";
            $date = $_GET['date_logs'];
            $time = date("H:i:s",strtotime("59 minutes"));
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$date);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<h6>Logs for (<u>".date("l M-dS-Y",strtotime($date))."</u>)</h6><table style='margin-left:10px;'>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Time Login</th>
                                        <th>Last time Active</th>
                                        <th>Date</th>
                                    </tr>";
                                    $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $time = date("H:i:s",strtotime("3 hour"));
                    $time1 = date_create($time);
                    $time2 = date_create($row['active_time']);
                    $time3 = date_diff($time2,$time1);
                    $timeval = $time3->format("%s");
                    $data_to_display.="<tr>
                                        <td>".$xs.".</td>
                                        <td>".getTeacherName($conn,$row['user_id'])."</td>
                                        <td>".$row['login_time']."</td>
                                        <td>".$row['active_time']."</td>
                                        <td>".date("M-d-Y",strtotime($date))."</td>
                                    </tr>";
                }
                $data_to_display.="</table>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No logs present on : ".date("M-d-Y",strtotime($date))."</p>";
                }
            }
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['change_dp_local'])) {
            include("../../connections/conn1.php");
            $new_locale = $_SESSION['imagepath1'];
            $update = "UPDATE `user_tbl` SET `profile_loc` = ? WHERE `user_id` = ?";
            $stmt = $conn->prepare($update);
            $imagepath = $_SESSION['imagepath1'];
            $myids = $_SESSION['userids'];
            $stmt->bind_param("ss",$imagepath,$myids);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['getImages_dp'])) {
            include("../../connections/conn1.php");
            $select = "SELECT `profile_loc` FROM `user_tbl` WHERE `user_id` = ?";
            $stmt = $conn->prepare($select);
            $myids = $_SESSION['userids'];
            $stmt->bind_param("s",$myids);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                if ($row = $result->fetch_assoc()) {
                    echo $row['profile_loc'];
                }
            }
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['change_dp_school'])) {
            include("../../connections/conn1.php");
            $update = "UPDATE `school_information` SET `school_profile_image` = ? WHERE `school_code` = ?";
            $stmt = $conn->prepare($update);
            $path = $_SESSION['imagepath2'];
            $stmt->bind_param("ss",$path,$_SESSION['schoolcode']);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['bring_me_sch_dp'])) {
            include("../../connections/conn1.php");
            $select = "SELECT `school_profile_image` FROM `school_information` WHERE `school_code` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$_SESSION['schoolcode']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    echo $row['school_profile_image'];
                }
            }
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['number_of_me_studnets'])) {
            $class_taught = getClassTaught($conn2);
            if ($class_taught != "Null") {
                //get the total number of students
                $select = "SELECT COUNT(*) AS 'Total' FROM `student_data` WHERE `stud_class` = ?";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$class_taught);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        echo myClassName($class_taught).":<br> ".$row['Total']." student(s)";
                    }else {
                        echo "Err";
                    }
                }else {
                    echo "Err";
                }
            }else {
                echo "<p class='red_notice'>Class not assigned!</p>";
            }
        }elseif (isset($_GET['reg_today_my_class'])) {
            $class_taught = getClassTaught($conn2);
            if ($class_taught != "Null") {
                $select = "SELECT COUNT(*) AS 'Total' FROM `student_data` WHERE `stud_class` = ? AND `D_O_A` = ?";
                $stmt = $conn2->prepare($select);
                $date = date("Y-m-d",strtotime("3 hour"));
                $stmt->bind_param("ss",$class_taught,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        echo myClassName($class_taught).":<br> ".$row['Total']." student(s)";
                    }else {
                        echo "Err";
                    }
                }else {
                    echo "Err";
                }
            }else {
                echo "<p class='red_notice'>Class not assigned!</p>";
            }
        }elseif (isset($_GET['today_attendance'])) {
            $class_taught = getClassTaught($conn2);
            if ($class_taught != "Null"){
                $select = "SELECT COUNT(*) AS 'Total' FROM `attendancetable` WHERE `class` = ? AND `date` = ?";
                $stmt = $conn2->prepare($select);
                $date = date("Y-m-d",strtotime("3 hour"));
                $stmt->bind_param("ss",$class_taught,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        echo myClassName($class_taught).":<br>".$row['Total']." student(s)";
                    }else {
                        echo "Err";
                    }
                }else {
                    echo "Err";
                }
            }else {
                echo "<p class='red_notice'>Class not assigned!</p>";
            }
        }elseif (isset($_GET['absent_students'])) {
            $class_taught = getClassTaught($conn2);
            if ($class_taught != "Null"){
                $select = "SELECT COUNT(*) AS 'Total' FROM `attendancetable` WHERE `class` = ? AND `date` = ?";
                $stmt = $conn2->prepare($select);
                $date = date("Y-m-d",strtotime("3 hour"));
                $stmt->bind_param("ss",$class_taught,$date);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        $total1 = $row['Total'];
                        $select = "SELECT COUNT(*) AS 'Totals' FROM `student_data` WHERE `stud_class` = ?";
                        $stmt = $conn2->prepare($select);
                        $stmt->bind_param("s",$class_taught);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result) {
                            if ($row = $result->fetch_assoc()) {
                                $total2 = $row['Totals'];
                                $total3 = $total2-$total1;
                                echo myClassName($class_taught).":<br>".$total3." student(s)";
                            }
                        }else {
                            echo "Err";
                        }
                    }else {
                        echo "Err";
                    }
                }else {
                    echo "Err";
                }
            }else {
                echo "<p class='red_notice'>Class not assigned!</p>";
            }
        }elseif (isset($_GET['feedback_message'])) {
            include("../../connections/conn1.php");
            $feedback_message = $_GET['feedback_message'];
            $insert = "INSERT INTO `user_feedback` (`from_id`,`feedback`,`deleted`) VALUES (?,?,?)";
            $stmt = $conn->prepare($insert);
            $deleted = 0;
            $userids = $_SESSION['userids'];
            $stmt->bind_param("sss",$userids,$feedback_message,$deleted);
            if($stmt->execute()){
                $authers = getAuthority1($conn,$userids);
                if ($authers == "Null") {
                    $authers = "all";
                }
                //insert the notification to the database 
                $notice_stat = 0;
                $reciever_id = $userids;
                $reciever_auth = $authers;
                $messageName = "Thanks for the feedback!";
                $messagecontent = "We really value your feedback, we`ll review it and use it to make your experience better as we go.<br><b>Thank you!</b>";
                $sender_ids = "Ladybird SMIS";
                insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids);
                echo "<p class='green_notice'>Feedback sent successfully!</p>";
            }else {
                echo "<p class='red_notice'>An error has occured<br> Please try again later!</p>";
            }
            $stmt->close();
            $conn->close();
            $conn2->close();
        }elseif (isset($_GET['get_attendance_school'])) {
            $class_list = getClasses($conn2);
            $select = "SELECT COUNT(`admission_no`) AS 'Total' FROM `attendancetable` WHERE `class` = ? AND `date` = ?";
            $stmt = $conn2->prepare($select);
            $data_to_display = "<h6>School`s students attendance on <span class='text-primary'>(".date("D M-d-Y",strtotime($_GET['dated'])).")</span></h6><table class=''>
                                <tr>
                                    <th>No.</th>
                                    <th>Class</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>option</th>
                                </tr>";
                                $xs = 0;
                                $total_present = 0;
                                $total_absent = 0;
            for ($index=0; $index < count($class_list); $index++) { 
                $xs++;
                $stmt->bind_param("ss",$class_list[$index],$_GET['dated']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        $present_total = $row['Total'];
                        $class_pop = getClassCount($conn2,$class_list[$index]);
                        $absent_no = $class_pop - $present_total;
                        $total_absent+=$absent_no;
                        $total_present+=$present_total;
                        $bgs = "color:green;";
                        if ($absent_no > 0) {
                            $bgs = "color:red;";
                        }
                        $data_to_display.="<tr>
                                            <td>".$xs.".</td>
                                            <td>".myClassName($class_list[$index])."</td>
                                            <td>".$present_total." Student(s)</td>
                                            <td style='".$bgs."'>".$absent_no." Student(s)</td>
                                            <td><p class='link view_stud_attendance' style='font-size:12px;' id='".$class_list[$index]."'><i class='fa fa-eye'></i> View</p></td>
                                        </tr>";
                    }
                }
            }
            $data_to_display.="<tr><td></td><td>Total</td><td>".$total_present." Student(s)</td><td>".$total_absent." Student(s)</td></tr></table>";
            echo $data_to_display;
        }elseif (isset($_GET['allowct'])) {
            include("../../connections/conn1.php");
            $select = "SELECT `ct_cg` FROM `school_information` WHERE `school_code` = ?";
            $stmt = $conn->prepare($select);
            $schoolcode = $_SESSION['schoolcode'];
            $stmt->bind_param("s",$schoolcode);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    echo $row['ct_cg'];
                }
            }
        }elseif (isset($_GET['update_ct'])) {
            include("../../connections/conn1.php");
            $ct_cg_value = $_GET['ct_cg_value'];
            $update = "UPDATE `school_information` SET `ct_cg` = ? WHERE `school_information`.`school_code` = ?";
            $stmt = $conn->prepare($update);
            $schoolcode = $_SESSION['schoolcode'];
            $stmt->bind_param("ss",$ct_cg_value,$schoolcode);
            if ($stmt->execute()) {
                echo "<p class='green_notice'>Data updated successfully!</p>";
            }else {
                echo "<p class='red_notice'>Error occured during update!</p>";
            }
        }elseif (isset($_GET['generate_adm_auto'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'lastadmgen';";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $admno = $row['valued'];
                    echo checkAdmUsed($conn2,$admno);
                }
            }
        }elseif (isset($_GET['genmanuall'])) {
            $select = "SELECT * FROM `student_data` WHERE `adm_no` = ?";
            $stmt = $conn2->prepare($select);
            $admno = $_GET['admno'];
            $stmt->bind_param("s",$admno);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                echo "<p>The admission number is already used!</p>";
            }else {
                echo "";
            }
        }elseif (isset($_GET['getWholeSchool'])) {
            $select = "SELECT `surname`,`first_name`,`second_name`,`adm_no`,`gender`,`stud_class`,`BCNo` from `student_data`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $res = $stmt->get_result();
            if($res){
                $tablein4 = "<div class='tableme'><table class='table table-striped align-items-center '><tr><th>No.</th><th>Class</th><th><i class='fa fa-male'></i> Male</th><th><i class='fa fa-female'></i> Female</th><th><i class='fa fa-male'></i> + <i class='fa fa-female'></i> Total</th><th>Action</th></tr>";
                $classes = getClasses($conn2);
                $classholder = array();
                $classholdermale = array();
                $classholderfemale = array();
                if (count($classes)>0) {
                    for ($i=0; $i < count($classes); $i++) { 
                        $counted = 0;
                        array_push($classholder,$counted);
                        array_push($classholdermale,$counted);
                        array_push($classholderfemale,$counted);
                    }
                }
                $males=0;
                $female = 0;
                while ($row=$res->fetch_assoc()) {
                    for ($i=0; $i < count($classes); ++$i) {
                        if ($classes[$i] == trim($row['stud_class'])) {
                            $classholder[$i]+=1;
                            if ($row['gender']=='Female') {
                                $classholderfemale[$i]+=1;
                                $female++;
                            }
                            if ($row['gender']=='Male') {
                                $classholdermale[$i]+=1;
                                $males++;
                            }
                            break;
                        }
                    }
                }
                $totaled = 0;
                for ($i=0; $i < count($classes); $i++) {
                    $totaled+=$classholder[$i];
                    $daros = $classes[$i];
                    if (strlen($daros)==1){
                        $daros = "Class ".$classes[$i];
                    }
                    $tablein4.="<tr><td>".($i+1)."</td><td style='font-size:13px;font-weight:bold;'>".$daros."</td><td>".$classholdermale[$i]." Student(s)</td><td>".$classholderfemale[$i]." Student(s)</td><td>".$classholder[$i]." Student(s)</td><td>"."<span class='link promoteclass' style='font-size:12px;' id='pm".$classes[$i]."'><i class='fa fa-arrow-up'></i> Promote Class</span>"."</td></tr>";
                }
                $tablein4.="</table></div>";
                $table_2 = "<div class = 'table_holders'><table class='align-items-center'>
                            <tr><th>Gender</th><th>Total</th></tr>
                            <tr><td><i class='fa fa-male'></i> - Male</td><td>".$males."</td></tr>
                            <tr><td><i class='fa fa-female'></i> - Female</td><td>".$female."</td></tr>
                            <tr><td><b>Total</b></td><td><b>".$totaled."</b></td></tr>
                            </table></div>";
                $datas = "<h6 class='text-center w-100'>Displaying all students recognized by the system</h6><br><span style='text-align:center;'><u>Gender count table</u> ".$table_2." <br> </span>";
                echo $datas." <p><u>Student count table</u></p>".$tablein4;
            }else {
                
            }
        }elseif (isset($_GET['getclassData'])) {
            $className = $_GET['classname'];
            $academicYear = "%".getAcadYear($conn2).":".$className;
            $select = "SELECT `surname`,`first_name`,`second_name`,`gender`,`D_O_A`,`stud_class`,`adm_no`,`year_of_study` FROM `student_data` WHERE `stud_class` = ? AND  `year_of_study` NOT LIKE ?;";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("ss",$className,$academicYear);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result){
                $data_to_display = "<input type='hidden' id='theClass' value='".$className."'><button class='btn btn-secondary btn-sm my-2' id='goBack3'><i class='fas fa-arrow-left'></i> Back</button><table class='table'><tr><th>No.</th><th>Fullnames</th><th>Date Of Admissions</th><th>Student Class</th><th>Gender</th><th>Select All <input type='checkbox' id='promoSelect'></th></tr>";
                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    $data_to_display.="<tr><td>".$counter."</td><td>".$row['surname']." ".$row['first_name']." ".$row['second_name']."</td>";
                    $data_to_display.="<td>".$row['D_O_A']."</td>";
                    $data_to_display.="<td>".$row['stud_class']."</td>";
                    $data_to_display.="<td>".$row['gender']."</td>";
                    $data_to_display.="<td>"."<input type='checkbox' class='promotionCheck' id='promo".$row['adm_no']."'>"."</td></tr>";
                    $counter++;
                }
                if ($counter > 1) {
                    $data_to_display.="</table><button class='btn btn-secondary btn-sm my-2' id='promoteStudents'><i class='fas fa-arrow-up'></i> Promote Selected students</button><div class='container'><span id='errHandler44'></span></div>";
                    echo $data_to_display;
                }else {
                    echo "<button class='btn btn-secondary btn-sm my-2' id='goBack3'><i class='fas fa-arrow-left'></i> Back</button><br><span class='text-danger'>No students to be promoted at the moment in class :".$className."</span>";
                }
            }
        }elseif (isset($_GET['promote'])) {
            // get the class to know where to promote the student next
            $studClass = $_GET['classselected'];
            $unselected = explode(",",$_GET['unselected']);
            $selectedStd = explode(",",$_GET['selectedStd']);
            //get the class list
            $classList = getTheClass($conn2);
            $classIndex = 0;
            for ($index=0; $index < count($classList); $index++) { 
                $classIndex++;
                if($studClass == $classList[$index]){
                    break;
                }
            }
            $nextClass = -1; // the negative one means that the student is an alumni
            if ($classIndex != count($classList)) {
                $nextClass = $classList[$classIndex];
            }
            // here we update the student data |class|academic year
            // echo "prev class ".$studClass." next class ".$nextClass." next academic year ".getAcadYear($conn2);

            // parameters
            $academicYear = getAcadYear($conn2);

            // update the class
            $updated = 0;
            for ($i=0; $i < count($selectedStd); $i++) { 
                $academicYearStud = studCurrentAcadYear($conn2,$selectedStd[$i])."|".$academicYear.":".$nextClass;
                $update = "UPDATE `student_data` SET `stud_class` = ?, `year_of_study` = ? WHERE `adm_no` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("sss",$nextClass,$academicYearStud,$selectedStd[$i]);
                if($stmt->execute()){
                    $updated++;
                }
                // echo $academicYearStud;
            }
            for ($i=0; $i < count($unselected); $i++) {
                $academicYearStud = studCurrentAcadYear($conn2,$unselected[$i])."|".$academicYear.":".$studClass;
                $update = "UPDATE `student_data` SET `stud_class` = ?, `year_of_study` = ? WHERE `adm_no` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("sss",$studClass,$academicYearStud,$unselected[$i]);
                if($stmt->execute()){
                    // $updated++;
                }
            }
            if ($updated == count($selectedStd)) {
                echo "<p class='text-success'>".$updated." student(s) successfully promoted to ".$nextClass."</p>";
            }else{
                echo "<p class='text-danger'>An error occured during update!</p>";
            }
        }elseif (isset($_GET['enroll_boarding_this'])) {
            $admno = $_GET['enroll_boarding_this'];
            $update = "UPDATE `student_data` SET `boarding` = 'enroll' WHERE `adm_no` = ?";
            $stmt = $conn2->prepare($update);
            $stmt->bind_param("s",$admno);
            if($stmt->execute()){
                echo "<p class='text-success'>Student has been successfully enrolled for boarding. Proceed to the boarding section to assign the student his/her dormitory!</p>";
            }else {
                echo "<p class='text-danger'>An error has occured. Please try again later!</p>";
            }
        }elseif (isset($_GET['unenroll_boarding_this'])) {
            $admno = $_GET['unenroll_boarding_this'];
            // delete the student from the dormitory
            $delete = "DELETE FROM `boarding_list` WHERE `student_id` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$admno);
            $stmt->execute();
            $update = "UPDATE `student_data` SET `boarding` = 'none', `boarding` = 'none' WHERE `adm_no` = ?";
            $stmt = $conn2->prepare($update);
            $stmt->bind_param("s",$admno);
            if($stmt->execute()){
                echo "<p class='text-success'>Student has been successfully unenrolled from boarding!</p>";
            }else {
                echo "<p class='text-danger'>An error has occured. Please try again later!</p>";
            }
        }
        

    }elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../../connections/conn1.php");
        include("../../connections/conn2.php");
        // DELETE THE STUDENT
        if (isset($_POST['delete_student'])) {
            $std_id = $_POST['delete_student'];
            $delete = "DELETE FROM `student_data` WHERE `adm_no` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$std_id);
            if($stmt->execute()){
                echo "<p class='text-success'>You have succesffully deleted this student.</p>";
            }else {
                echo "<p class='text-danger'>An error occured while trying to delete the student. Try again later</p>";
            }
        }elseif(isset($_POST['add_route'])){
            $select = "SELECT * FROM `van_routes` ORDER BY route_id DESC";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $route_id = 1;
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $route_id = ($row['route_id']*1) + 1;
                }
            }
            $insert = "INSERT INTO `van_routes` (`route_id`,`route_name`,`route_price`,`route_areas`) VALUES (?,?,?,?)";
            $route_name = $_POST['route_name'];
            $route_price = $_POST['route_price'];
            $route_area_coverage = $_POST['route_area_coverage'];
            $stmt=$conn2->prepare($insert);
            $stmt->bind_param("ssss",$route_id,$route_name,$route_price,$route_area_coverage);
            if($stmt->execute()){
                echo "<p class='text-success'>Route added successfully!</p>";
            }else {
                echo "<p class='text-danger'>Route was not added.Please try again!</p>";
            }
        }elseif (isset($_POST['get_routes'])) {
            $select = "SELECT * FROM `van_routes`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $data_to_display.=$row['route_id']."^".$row['route_name']."^".$row['route_price']."^".$row['route_areas']."^".$row['route_status']."|";
                }
                $data_to_display = substr($data_to_display,0,(strlen($data_to_display)-1));
            }
            echo $data_to_display;
        }elseif (isset($_POST['getroute_infor'])) {
            $getroute_infor = $_POST['getroute_infor'];
            $select = "SELECT * FROM `van_routes` WHERE `route_id` = ?;";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$getroute_infor);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $data_to_display.=$row['route_id']."^".$row['route_name']."^".$row['route_price']."^".$row['route_areas']."^".$row['route_vans']."^".$row['route_status'];
                }
            }
            echo $data_to_display;
        }elseif (isset($_POST['update_routes'])) {
            $routes_names = $_POST['routes_names'];
            $routes_price = $_POST['routes_price'];
            $routes_areas = $_POST['routes_areas'];
            $route_ids = $_POST['route_ids'];
            $route_prev_price = $_POST['route_prev_price'];
            if ($route_prev_price == $routes_price) {
                $update = "UPDATE `van_routes` SET `route_name` = ?, `route_price` = ?, `route_areas` = ? WHERE `route_id` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("ssss",$routes_names,$routes_price,$routes_areas,$route_ids);
                if($stmt->execute()){
                    // get the result
                    echo "<p class='text-success'>Route updated successfully!</p>";
                }else {
                    // get the error
                    echo "<p class='text-danger'>Route was not updated.Please try again!</p>";
                }
            }else{
                $update = "UPDATE `van_routes` SET `route_name` = ?, `route_price` = ?, `route_areas` = ?, `route_date_change` = ?, `route_prev_price` = ? WHERE `route_id` = ?";
                $stmt = $conn2->prepare($update);
                $date = date("Y-m-d");
                $stmt->bind_param("ssssss",$routes_names,$routes_price,$routes_areas,$date,$route_prev_price,$route_ids);
                if($stmt->execute()){
                    // get the result
                    echo "<p class='text-success'>Route updated successfully!</p>";
                }else {
                    // get the error
                    echo "<p class='text-danger'>Route was not updated.Please try again!</p>";
                }
            }
        }elseif (isset($_POST['delete_route'])) {
            $r_id = $_POST['delete_route'];
            $delete = "DELETE FROM `van_routes` WHERE `route_id` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$r_id);
            if($stmt->execute()){
                $update = "UPDATE `school_vans` SET `route_id` = '' WHERE `route_id` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("s",$r_id);
                $stmt->execute();
                echo "<p class='text-success'>Route deleted successfully!</p>";
            }else {
                echo "<p class='text-danger'>An error occured during operation.Please try again later!</p>";
            }
        }elseif (isset($_POST['save_van'])) {
            $bus_name = $_POST['bus_name'];
            $van_regno = $_POST['van_regno'];
            $van_model = $_POST['van_model'];
            $van_seater_size = $_POST['van_seater_size'];
            $insurance_date = $_POST['insurance_date'] ? $_POST['insurance_date']:"";
            $service_date = $_POST['service_date'] ? $_POST['service_date']:"";
            $routed_lists = $_POST['routed_lists'] ? $_POST['routed_lists']:"";
            $van_driver = $_POST['van_driver'] ? $_POST['van_driver']:"";
            // get the latest bus route
            $select = "SELECT * FROM `school_vans` ORDER BY `van_id` DESC LIMIT 1;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $van_id = 1;
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $van_id = ($row['van_id']*1)+1;
                }
            }
            $insert = "INSERT INTO `school_vans` (`van_id`,`van_name`,`van_reg_no`,`model_name`,`van_seater_size`,`route_id`,`insurance_expiration`,`next_service_date`,`driver_name`) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $conn2->prepare($insert);
            $stmt->bind_param("sssssssss",$van_id,$bus_name,$van_regno,$van_model,$van_seater_size,$routed_lists,$insurance_date,$service_date,$van_driver);
            if($stmt->execute()){
                echo "<p class='text-success'>Van added successfully!</p>";
            }else{
                echo "<p class='text-danger'>An error occured during operation.Please try again later!</p>";
            }
        }elseif (isset($_POST['get_vans'])) {
            $select = "SELECT * FROM `school_vans`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                while($row = $result->fetch_assoc()){
                    $driver_id = $row['driver_name'];
                    $driverName = getNameAdm($driver_id,$conn);
                    $data_to_display.=$row['van_id']."^".$row['van_name']."^".$row['van_reg_no']."^".$row['model_name']."^".$row['van_seater_size']."^".$row['route_id']."^".$row['insurance_expiration']."^".$row['next_service_date']."^".$driverName."|";
                }
                $data_to_display = substr($data_to_display,0,(strlen($data_to_display)-1));
            }
            echo $data_to_display;
        }elseif(isset($_POST['van_infor'])){
            $van_id = $_POST['van_infor'];
            $select = "SELECT * FROM `school_vans` WHERE `van_id` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$van_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $driver_name = getNameAdm($row['driver_name'],$conn);
                    $route_name = getRoute($row['route_id'],$conn2);
                    $data_to_display.=$row['van_id']."|".$row['van_name']."|".$row['van_reg_no']."|".$row['model_name']."|".$row['van_seater_size']."|".$route_name."|".$row['insurance_expiration']."|".$row['next_service_date']."|".$driver_name;
                }
            }
            echo $data_to_display;
        }elseif (isset($_POST['update_van'])) {
            $van_name = $_POST['van_name'];
            $van_regno = $_POST['van_regno'];
            $van_model = $_POST['van_model'];
            $van_seater_size = $_POST['van_seater_size'];
            $insurance_date = $_POST['insurance_date'];
            $service_date = $_POST['service_date'];
            $van_id = $_POST['van_id'];
            $van_driver = ($_POST['van_driver'] != "Null") ? $_POST['van_driver'] : "";
            $van_route = ($_POST['van_route'] != "Null") ? $_POST['van_route']: "";
            if($_POST['van_driver'] == "Null" && $_POST['van_route'] != "Null"){
                echo "Null driver";
                $update = "UPDATE `school_vans` SET `van_name` = ?, `van_reg_no` = ?, `model_name` = ?, `van_seater_size` = ?, `route_id` = ?, `insurance_expiration` = ?, `next_service_date` = ? WHERE `van_id` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("ssssssss",$van_name,$van_regno,$van_model,$van_seater_size,$van_route,$insurance_date,$service_date,$van_id);
                if($stmt->execute()){
                    echo "<p class='text-success'>Van updates done successfully!</p>";
                }else{
                    echo "<p class='text-danger'>Van updates failed due to an error occurance. Please try again late!</p>";
                }
            }elseif ($_POST['van_driver'] == "Null" && $_POST['van_route'] != "Null") {
                $update = "UPDATE `school_vans` SET `van_name` = ?, `van_reg_no` = ?, `model_name` = ?, `van_seater_size` = ?, `insurance_expiration` = ?, `next_service_date` = ?, `driver_name` = ? WHERE `van_id` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("ssssssss",$van_name,$van_regno,$van_model,$van_seater_size,$insurance_date,$service_date,$van_driver,$van_id);
                if($stmt->execute()){
                    echo "<p class='text-success'>Van updates done successfully!</p>";
                }else{
                    echo "<p class='text-danger'>Van updates failed due to an error occurance. Please try again late!</p>";
                }
            }elseif ($_POST['van_driver'] == "Null" && $_POST['van_route'] == "Null") {
                $update = "UPDATE `school_vans` SET `van_name` = ?, `van_reg_no` = ?, `model_name` = ?, `van_seater_size` = ?, `insurance_expiration` = ?, `next_service_date` = ? WHERE `van_id` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("sssssss",$van_name,$van_regno,$van_model,$van_seater_size,$insurance_date,$service_date,$van_id);
                if($stmt->execute()){
                    echo "<p class='text-success'>Van updates done successfully!</p>";
                }else{
                    echo "<p class='text-danger'>Van updates failed due to an error occurance. Please try again late!</p>";
                }
            }else{
                $update = "UPDATE `school_vans` SET `van_name` = ?, `van_reg_no` = ?, `model_name` = ?, `van_seater_size` = ?, `route_id` = ?, `insurance_expiration` = ?, `next_service_date` = ?, `driver_name` = ? WHERE `van_id` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("sssssssss",$van_name,$van_regno,$van_model,$van_seater_size,$van_route,$insurance_date,$service_date,$van_driver,$van_id);
                if($stmt->execute()){
                    echo "<p class='text-success'>Van updates done successfully!</p>";
                }else{
                    echo "<p class='text-danger'>Van updates failed due to an error occurance. Please try again late!</p>";
                }
            }
        }elseif (isset($_POST['delete_van'])) {
            $van_id = $_POST['delete_van'];
            $delete = "DELETE FROM `school_vans` WHERE `van_id` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$van_id);
            if($stmt->execute()){
                echo "<p class='text-success'>Van deleted done successfully!</p>";
            }else{
                echo "<p class='text-danger'>Van updates failed due to an error occurance. Please try again late!</p>";
            }
        }elseif (isset($_POST['get_std_enroll_trans'])) {
            $get_std_enroll_trans = $_POST['get_std_enroll_trans'];
            // get the student if they are already enrolled in the transport system
            $select = "SELECT * FROM `transport_enrolled_students` WHERE `student_id` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$get_std_enroll_trans);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                echo "-1";
            }else{
                $select = "SELECT * FROM `student_data` WHERE `adm_no` = ? AND `stud_class` != '-1';";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$get_std_enroll_trans);
                $stmt->execute();
                $result = $stmt->get_result();
                $data_to_display = "";
                if ($result) {
                    if($row = $result->fetch_assoc()){
                        $classname = myClassName($row['stud_class']);
                        $data_to_display.=$row['surname']." ".$row['first_name']." ".$row['second_name']."|".$row['address']."|".$classname;
                    }
                }
                echo $data_to_display;
            }
        }elseif(isset($_POST['enroll_students'])){
            $student_id = $_POST['student_id'];
            $route_id = $_POST['route_id'];
            $stoppage = $_POST['stoppage'];
            $date = date("Y-m-d");
            $status = "1";
            
            $insert = "INSERT INTO `transport_enrolled_students` (`student_id`,`route_id`,`stoppage`,`date_of_reg`,`status`) VALUES (?,?,?,?,?)";
            $stmt = $conn2->prepare($insert);
            $stmt->bind_param("sssss",$student_id,$route_id,$stoppage,$date,$status);
            // echo $insert;
            if($stmt->execute()){
                echo "<p class='text-success'>You have successfully enrolled the student in transport system!</p>";
            }else{
                echo "<p class='text-danger'>An error occured, Please try again later!</p>";
            }
        }elseif (isset($_POST['getStudents_enrolled'])) {
            $select = "SELECT * FROM `transport_enrolled_students`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                while($row = $result->fetch_assoc()){
                    $std_name = ucwords(strtolower(getNamestd($row['student_id'],$conn2)));
                    $route_name = ucwords(strtolower(getRoute($row['route_id'],$conn2)));
                    $data_to_display.=$row['id']."^".$std_name." (".$row['student_id'].")"."^".$route_name."^".ucwords(strtolower($row['stoppage']))."^".$row['date_of_reg']."|";
                }
                $data_to_display = substr($data_to_display,0,(strlen($data_to_display)-1));
            }
            echo $data_to_display;
        }elseif (isset($_POST['get_statistics'])) {
            $select = "SELECT COUNT(*) AS 'Total' FROM `transport_enrolled_students`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $enrolled_count = 0;
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $enrolled_count = $row['Total'];
                }
            }
            $select = "SELECT COUNT(*) AS 'Total' FROM `school_vans`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $van_count = 0;
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $van_count = $row['Total'];
                }
            }
            $select = "SELECT COUNT(*) AS 'Total' FROM `van_routes`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $route_count = 0;
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $route_count = $row['Total'];
                }
            }
            echo $enrolled_count."|".$van_count."|".$route_count;
        }elseif (isset($_POST['student_data'])) {
            $std_id = $_POST['student_data'];
            $select = "SELECT * FROM `transport_enrolled_students` WHERE `id` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$std_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $stud_name = getNamestd($row['student_id'],$conn2);
                    $getclassname = getmyClassName($row['student_id'],$conn2);
                    $route_id = getRoute($row['route_id'],$conn2);
                    $data_to_display.=$stud_name."|".$route_id."|".$row['stoppage']."|".$row['date_of_reg']."|".$row['id']."|".$getclassname."|".$row['student_id'];
                }
            }
            echo $data_to_display;
        }elseif (isset($_POST['update_student_trans'])) {
            $data_id = $_POST['data_id'];
            $route_id = $_POST['route_id'];
            $stud_stoppage_trans = $_POST['stud_stoppage_trans'];
            $update = "UPDATE `transport_enrolled_students` SET `stoppage` = ?,`route_id` = ? WHERE `id` = ?";
            $stmt = $conn2->prepare($update);
            $stmt->bind_param("sss",$stud_stoppage_trans,$route_id,$data_id);
            if($stmt->execute()){
                echo "<p class='text-success'>Student data updated successfully!</p>";
            }else{
                echo "<p class='text-danger'>An error has occured!</p>";
            }
        }elseif(isset($_POST['deregister_stud'])){
            $deregister_stud = $_POST['deregister_stud'];
            $delete = "DELETE FROM `transport_enrolled_students` WHERE `id` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$deregister_stud);
            if($stmt->execute()){
                echo "<p class='text-success'>You have successfully unenrolled the student from the transport system!</p>";
            }else{
                echo "<p class='text-danger'>An error occured.Please try again later!</p>";
            }
        }elseif (isset($_POST['set_report_button'])) {
            // get if the report button is set
            $roles = "";
            $select = "SELECT * FROM `settings` WHERE `sett` = 'user_roles'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $roles = $row['valued'];
                $new_roled = json_decode($roles);
                // loop through the roles
                for ($index=0; $index < count($new_roled); $index++) { 
                    $role_decode = $new_roled[$index]->roles;
                    // echo $roles;
                    $present = false;
                    for ($i=0; $i < count($role_decode); $i++) { 
                        $btn = $role_decode[$i];
                        if ($btn->name == "my_reports") {
                            $present = !$present;
                            break;
                        }
                    }
                    if (!$present) {
                        echo "not present";
                        $my_reports_role = array("name" => "my_reports","Status" => "no");
                        array_push($role_decode,$my_reports_role);
                        $new_roled[$index]->roles = $role_decode;
                        $updeted_role = json_encode($new_roled);
                        $update = "UPDATE `settings` SET `valued` = '$updeted_role' WHERE `sett` = 'user_roles'";
                        $stmt = $conn2->prepare($update);
                        $stmt->execute();
                    }
                }
            }
        }elseif (isset($_POST['getmystudents'])) {
            $getmystudents = $_POST['getmystudents'];
            $select = "SELECT * FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $classes = $row['valued'];
                $my_class = explode(",",$classes);
                $data_to_display = "<select class='form-control' name='".$getmystudents."' id='".$getmystudents."'><option value='' hidden>Select an option</option>";
                for ($index=0; $index < count($my_class); $index++) { 
                    $data_to_display.="<option value='".$my_class[$index]."' >".myClassName($my_class[$index])."</option>";
                }
                $data_to_display.="<option value='all' >All Students</option>";
                $data_to_display.="</select>";
                echo $data_to_display;
            }else{
                echo "<p>No classes to display!</p>";
            }
        }elseif (isset($_POST['get_me_staff'])) {
            $select = "SELECT * FROM `user_tbl` WHERE `school_code` = ?";
            $stmt = $conn->prepare($select);
            $stmt->bind_param("s",$_SESSION['schcode']);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "<p class='color:red;'>No staff present in your school</p>";
            if ($result) {
                $data_to_display = "<select name='mystaff_lists_select' id='mystaff_lists_select' class='form-control'><option value='' hidden>Select Staff</option><option value='-1'><b>All Staff</b></option>";
                while ($row = $result->fetch_assoc()) {
                    $data_to_display.="<option value='".$row['user_id']."'>".ucwords(strtolower($row['fullname']))."</option>";
                }
                $data_to_display.="</select>";
            }
            echo $data_to_display;
        }
    }
    function getNameAdm($userid,$conn){
        $select = "SELECT * FROM `user_tbl` WHERE `user_id` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fullname = "Null";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $fullname = $row['fullname'];
            }
        }
        return $fullname;
    }
    function getNamestd($userid,$conn){
        $select = "SELECT * FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $fullname = "Null";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $fullname = $row['first_name']." ".$row['second_name']." ".$row['surname'];
            }
        }
        return $fullname;
    }
    function getmyClassName($userid,$conn){
        $select = "SELECT * FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $classname = "Null";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $classname = myClassName($row['stud_class']);
            }
        }
        return $classname;
    }
    function getRoute($route_id,$conn){
        $select = "SELECT * FROM `van_routes` WHERE `route_id` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$route_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $route_name = "Null";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $route_name = $row['route_name'];
            }
        }
        return $route_name;
    }
    function getTheClass($conn2){
        $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class';";
        $stmt = $conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                // get the class list
                $valued = $row['valued'];
                // split the string to aray
                $classes = explode(",",$valued);
                return $classes;
            }
        }
    }
    function studCurrentAcadYear($conn2,$studid){
        $select = "SELECT `year_of_study` FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$studid);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            if($row = $result->fetch_assoc()){
                $yearOfStudy = $row['year_of_study'];
                return $yearOfStudy;
            }
        }
   }
    function getAcadYear($conn2){
        $select = "SELECT `academic_year` FROM `academic_calendar` LIMIT 1;";
        $stmt = $conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        $academic_year = date("Y");
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                // get the result
                $academic_year = $row['academic_year'];
            }
        }
        return $academic_year;
    }
    function checkAdmUsed($conn2,$admno){
        $select = "SELECT * FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        for(;;){
            $stmt->bind_param("s",$admno);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                $admno++;
            }else {
                return $admno;
            }
        }
    }
    function getClassCount($conn2,$classes){
        $select = "SELECT COUNT(*) AS 'Total' FROM `student_data` WHERE `stud_class` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$classes);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['Total'];
            }
        }
        return 0;
    }
    function getClassTaught($conn2){
        $select = "SELECT `class_assigned` FROM `class_teacher_tbl` WHERE `class_teacher_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$_SESSION['userids']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['class_assigned'];
            }
        }
        return "Null";
    }
    function myClassName($data){
        if($data == "-i"){
            return "Alumni";
        }
        if (strlen($data)>1) {
            return $data;
        }else {
            return "Grade ".$data;
        }
        return $data;
    }
    function getAuthority1($conn,$userid){
        $select = "SELECT `auth` FROM `user_tbl` WHERE `user_id` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$userid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['auth'];
            }
        }
        return "Null";
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
    function getTeacherName($conn,$tr_id){
        $schoolcode = $_SESSION['schoolcode'];
        $select = "SELECT `fullname`, `gender` FROM `user_tbl` WHERE `school_code` = ? AND `user_id` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("ss",$schoolcode,$tr_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if ($row['gender'] == "F") { 
                    return "Mrs. ".ucfirst($row['fullname']);
                }elseif($row['gender'] == "M") {
                    return "Mr. ".ucfirst($row['fullname']);
                }
            }
        }
        return "Null";
    }

    function splitSpace($data){
        return explode(" ",$data)[1];
    }
    function getClasses($conn2){
        $select = "SELECT `sett`,`valued` FROM `settings` WHERE `sett` = 'class'";
        $stmt = $conn2->prepare($select);
        $stmt->execute();
        $res = $stmt->get_result();
        $classes = array();
        if ($res) {
            if($row = $res->fetch_assoc()) {
                $cows = $row['valued'];
                $classes = explode(",",$cows);
            }
        }
        if (count($classes)>0) {
            return $classes;
        }else {
            return $classes;
        }
    }
    function checkIfCallRegister($class){
        include("../../connections/conn2.php");
        $select = "SELECT * FROM `attendancetable` WHERE `class`=? AND `date` = ? ";
        $stmt = $conn2->prepare($select);
        $date = date("Y-m-d",strtotime("3 hour"));
        $stmt->bind_param("ss",$class,$date);
        $stmt->execute();
        $stmt->store_result();
        $rnums = $stmt->num_rows;
        $stmt->close();
        $conn2->close();
        if($rnums>0){
            return true;
        }else{
            return false;
        }
        return false;
    }
    function createStudentn4($conn2,$result,$searchinfor){
        if($result){
            $xs =0;
            $data="<h6 style='font-size:17px;text-align:center;font-weight:500;'>Results for ".$searchinfor."</h6>";
            $data.="<div class='tableme'><table class='table' >";
            $data.="<tr><th>No.</th>";
            $data.="<th>Student Name</th>";
            //$data.="<th>Middle Name</th>";
            $data.="<th>Adm no.</th>";
            //$data.="<th>BC no.</th>";
            $data.="<th>Gender</th>";
            $data.="<th>Amount Paid</th>";
            $data.="<th>Balance</th>";
            $data.="<th>Class</th>";
            $data.="<th>Option</th></tr>";
            include("../finance/financial.php");
            while($row=$result->fetch_assoc()){
                $xs++;
                $data.="<tr><td>".($xs)."</td>";
                $data.="<td>".ucwords(strtolower($row['first_name']." ".$row['second_name']))."</td>";
                //$data.="<td>".$row['second_name']."</td>";
                $data.="<td>".$row['adm_no']."</td>";
                //$data.="<td>".$row['BCNo']."</td>";
                $data.="<td>".$row['gender']."</td>";
                $classes = classNameAdms($row['stud_class']);
                $fees_paid = getFeespaidByStudentAdm($row['adm_no']);
                $balance = getBalanceAdm($row['adm_no'],getTerm(),$conn2);
                $data.="<td>Kes ".number_format($fees_paid)."</td>";
                $data.="<td>Kes ".number_format($balance)."</td>";
                $data.="<td>".$classes."</td>";
                $data.="<td>"."<p style='display:flex;'><span style='font-size:12px;' class='link view_students' id='view".$row['adm_no']."'><i class='fa fa-eye'></i> View </span>"."</td></tr>";
            }
            $data.="</table></div>";
            if($xs>0){
                echo $data;
            }else{
                echo "<p style='font-size:15px;color:red;'>No results for:<br> <b>".$searchinfor."</b>..</p>";
            }
        }else{
            echo "<p style='font-size:15px;'>No results..</p>";
        }
    }
    function createStudentclass($result,$class){
        $daros = classNameAdms($class);
        $date_used = $_GET['date_used'];
        if($result){
            $xs =0;
            $data="<h6 style='font-size:17px;text-align:center;margin-bottom:5px;'><u>Check attendance for ".$daros." Members.</u></h6>";
            $data.="<p>Tick the checkbox "."<input type='checkbox' checked readonly>"." if present or leave blank "."<input type='checkbox' readonly>"." when absent, then <strong>Submit</strong></p>";
            $data.="<p id ='tablein'></p>";
            $data.="<div class='tableme'><table >";
            $data.="<tr><th>No</th>";
            $data.="<th>Student name</th>";
            $data.="<th>Adm no.</th>";
            $data.="<th>Gender</th>";
            $data.="<th>Class</th>";
            $data.="<th>Present</th></tr>";
            while($row = $result->fetch_assoc()){
                $xs++;
                $data.="<tr><td>".$xs."</td>";
                $data.="<td><label for='".$row['adm_no']."'>".ucwords(strtolower($row['first_name']." ".$row['second_name']))."</label></td>";
                $data.="<td>".$row['adm_no']."</td>";
                $data.="<td>".$row['gender']."</td>";
                $data.="<td>".classNameAdms($row['stud_class'])."</td>";
                $data.="<td>"."<input type='checkbox' class='present' id='".$row['adm_no']."'>"."</td></tr>";
            }
            $data.="</table></div>";
            $data.="<span class='text-danger'>Always confirm the date before submitting!</span>";
            if($xs>0){
                echo $data;
            }else {
                echo "<p style='font-size:15px;color:red;'>No students present in ".$daros.".</p>";
            }
        }else{
            echo "<p style='font-size:15px;'>No results after results..</p>";
        }
    }
    function createTable($results,$arrays){
        //Attendace table
        $attendedtable="<h6 style='font-size:15px;text-align:center;margin-top:10px;'>Present list</h6>";
        $attendedtable.="<div class='tableme' style = 'border-bottom:1px dashed gray;' ><table class='output1' >";
        $attendedtable.="<tr><th>No</th>";
        $attendedtable.="<th>Student Name</th>";
        $attendedtable.="<th>Adm no.</th>";
        $attendedtable.="<th>Gender</th>";
        $attendedtable.="<th>Class</th>";
        $attendedtable.="<th>Status</th></tr>";
        
        $xs = 0;
        if($results){
            while ($rows = $results->fetch_assoc()) {
                $arrays = checkadmissionno($rows['adm_no'],$arrays);
                $xs++;
                $attendedtable.="<tr><td>".$xs."</p></td>";
                $attendedtable.="<td>".ucfirst($rows['first_name'])." ".ucfirst($rows['second_name'])."</p></td>";
                $attendedtable.="<td>".$rows['adm_no']."</p></td>";
                $attendedtable.="<td>".$rows['gender']."</p></td>";
                $attendedtable.="<td>".$rows['stud_class']."</p></td>";
                $attendedtable.="<td>"."Present"."</p></td></tr>";
            }
        }
        $attendedtable.="</table></div>";
        if($xs>0){
            echo "<p>".$attendedtable."</p>";
        }else {
            echo "<p style='text-align:center;margin-top:20px;font-size:12px;font-weight:600;color:red;'>No students present!</p><hr>";            
        }

        return $arrays;
    }
    function checkadmissionno($check,$arrays){

        for ($i=0; $i < count($arrays); $i++) { 
            if ($arrays[$i]==$check){
                unset($arrays[$i]);
                return array_values($arrays);
                break;
            }
        }
        return $arrays;
    }
    function getClassTeacher($conn2,$classname){
        $select = "SELECT `class_teacher_id` FROM `class_teacher_tbl` WHERE `class_assigned` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$classname);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['class_teacher_id'];
            }
        }
        return "Null";
    }
    function insertNotice($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_ids){
        $insert = "INSERT INTO `tblnotification`  (`notification_name`,`Notification_content`,`sender_id`,`notification_status`,`notification_reciever_id`,`notification_reciever_auth`) VALUES (?,?,?,?,?,?)";
        $stmt = $conn2->prepare($insert);
        $stmt->bind_param("ssssss",$messageName,$messagecontent,$sender_ids,$notice_stat,$reciever_id,$reciever_auth);
        $stmt->execute();
    }
    function getAuthority($auth){
        $data = "";
        if($auth=='0'){
            $data = "Administrator";
        }elseif ($auth=='1') {
            $data = "Headteacher/Principal";
        }elseif ($auth=='2') {
            $data = "Teacher";
        }elseif ($auth=='3') {
            $data = "Deputy principal";
        }elseif ($auth=='4') {
            $data = "Staff";
        }elseif ($auth=='5') {
            $data = "Class teacher";
        }elseif ($auth=='6') {
            $data = "School Driver";
        }else {
            $data = $auth;
        }
        return $data;
    }
    function latestStaffId(){
        include("../../connections/conn1.php");
        $select = "SELECT `user_id` FROM `user_tbl` WHERE `school_code` = ? ORDER BY `user_id` DESC LIMIT 1";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$_SESSION['schoolcode']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['user_id'];
            }
        }
        return 0;
        $stmt->close();
        $conn->close();
    }
    function getRouteEnrolled($conn2,$admno){
        $select = "SELECT * FROM `transport_enrolled_students` WHERE `student_id` = '".$admno."'";
        $stmt = $conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        $route_name = "Null";
        $route_price = "Kes 0";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $route_id = $row['route_id'];
                $select = "SELECT * FROM `van_routes` WHERE `route_id` = '".$route_id."'";
                $stmt = $conn2->prepare($select);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($rowd = $result->fetch_assoc()) {
                        $route_name = ucwords(strtolower($rowd['route_name']));
                        $route_price = "Kes ".number_format($rowd['route_price']);
                    }
                }
            }
        }
        return "<b>".$route_name."</b> @ <b>".$route_price."</b> Per Term";
    }
    function studentYOS($conn2,$admno){
        $select = "SELECT `year_of_study` FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $yearOfStudy = explode("|",$row['year_of_study']);
                // explode the data to get the latest year of study 
                $year = $yearOfStudy[(count($yearOfStudy)-1)];
                return $year;
            }
        }
    }
    function withoutLatest($conn2,$admno){
        $select = "SELECT `year_of_study` FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $yearOfStudy = explode("|",$row['year_of_study']);
                // explode the data to get the latest year of study 
                $YOS = "";
                for ($i=0; $i < (count($yearOfStudy)-1); $i++) { 
                    $YOS.=$yearOfStudy[$i]."|";
                }
                $YOS = substr($YOS,0,(strlen($YOS)-1));
                return $YOS;
            }
        }
    }
    function classNameAdms($data){
        if ($data == "-1") {
            return "Alumni";
        }
        if ($data == "-2") {
            return "Transfered";
        }
        $datas = "Grade ".$data;
        if (strlen($data)>1) {
            $datas = $data;
        }
        return $datas;
    }
?>
