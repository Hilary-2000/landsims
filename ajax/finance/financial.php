<?php
    // session_start();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SERVER['REQUEST_METHOD'] =='GET') {
        include("../../connections/conn1.php");
        include("../../connections/conn2.php");
        include("../../comma.php");
        if (isset($_GET['payfordetails'])) {
            $class = "";
            if (isset($_GET['class_use'])) {
                $class = "%|".$_GET['class_use']."|%";
                if ($_GET['class_use'] == "-1") {
                    $select = "<select class='payments_options' id='payfor'><option value='' hidden>Select option..</option>";
                    $select.="<option value='balance'>Balance</option>";
                    $select.="</select>";
                    echo $select;
                }else{
                    $select = "SELECT `expenses` FROM `fees_structure` WHERE `activated` = 1 and `classes` like ?";
                    $stmt = $conn2->prepare($select);
                    $stmt->bind_param("s",$class);
                    $stmt->execute();
                    $results = $stmt->get_result();
                    $select = "<p style='color:green;'>There is no payment option set by the administrator</p>";
                    if($results){
                        $select = "<select class='payments_options' id='payfor'><option value='' hidden>Select option..</option>";
                        $xs = 0;
                        $pup = array();
                        while ($row = $results->fetch_assoc()) {
                            $xs++;
                            $in = 0;
                            //first check if the array is present
                            for ($i=0; $i < count($pup); $i++) { 
                                if($pup[$i]== $row['expenses']){
                                    $in=1;
                                }
                            }
                            if ($in==0) {
                                array_push($pup,$row['expenses']);
                                $select.="<option value='".$row['expenses']."'>".$row['expenses']."</option>";
                            }
                        }
                        $select.="</select>";
                        if($xs>0){
                            echo $select;
                        }else {
                            echo "<p style='color:green;'>There is no payment option set by the administrator</p>";
                        }
                    }else {
                        echo "<p style='color:green;'>There is no payment option set by the administrator</p>";
                    }
                }
            }else {
                echo "<p style='color:green;'>Display a student with their admission number to display their available votehead!</p>";
            }
        }elseif (isset($_GET['findadmno'])) {
            $admnos = $_GET['findadmno'];
            $admnopresent = checkadmno($admnos);
            if ($admnopresent==1) {
                $last_paying = getLastTimePaying($conn2,$admnos);
                $names = getName($admnos);
                $term = getTermV2($conn2);
                $classes = explode("^",$names)[1];
                $added_fees = checkFeesChange($term,$conn2,$classes,$last_paying);
                $transport_change = changeTransport($conn2,$admnos);
                $fees_change = "";
                if (strlen($added_fees) > 0) {
                    $fees_change = "<hr><span class='text-primary'>We have noticed fees structure has been changed below are the changes:".$added_fees."</span><br>";
                }
                if (strlen($transport_change) > 0) {
                    $fees_change.=$transport_change."<br>";
                }
                $name = explode("^",$names)[0];
                $date = date("Y-m-d",strtotime("3 hour"));
                $times = date("H:i:s",strtotime("3 hour"));
                $balance = getBalance($admnos,$term,$conn2);
                $select = "SELECT `stud_admin` , `transaction_id`, `status`, `transaction_code`, `mode_of_pay` , (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  `date_of_transaction` , `time_of_transaction` , `amount` , `balance`, `payment_for` FROM `finance` WHERE `stud_admin` = ? ORDER BY `transaction_id` DESC LIMIT 5 ";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$admnos);
                $stmt->execute();
                $results = $stmt->get_result();
                $date = date("l dS \of M Y",strtotime($date));
                if($results){
                    $xss =0;
                    $boarding = "";
                    if (isBoarding($admnos,$conn2)) {
                        $boarding = "<span class='green_notice'> -(boarder)- </span>";
                    }
                    $transporter = "";
                    if (isTransport($conn2,$admnos)) {
                        $transporter = "<span class='green_notice'> -(Transport)- </span>";
                    }
                    $daro_ss = getName($admnos);
                    $getclass = explode("^",$daro_ss)[1];
                    // when we move to a new term we will want to add the new term fees
                    $date_term_began = date("Ymd",strtotime(getTermStart($conn2,$term)));
                    $last_paid_time  = date("Ymd",strtotime(getLastTimePaying($conn2,$admnos)));
                    $term_report = "";
                    if ($date_term_began > $last_paid_time) {
                        $current_term = getFeesTerm($term,$conn2,$getclass,$admnos);
                        $term_report = "<hr><span class='text-primary'><b>".ucwords(strtolower($name))."</b> made their last payments on ".date("dS M Y",strtotime($last_paid_time)).". The payments was made before ".$term." started, as a result Fees of Kes ".number_format($current_term)." for term  ".$term."  will be added to the existing balance so the new balance will be <b>Kes ".number_format($balance)."</b></span>";
                        // echo $term_report;
                        $fees_change .= $term_report;
                    }
                    $headings= strlen($fees_change)>5 ?"<h6 class='text-center'>Notice</h6>":"";
                    $balancecalc = calculatedBalanceReport($admnos,$term,$conn2);
                    $fees_paid = getFeespaidByStudent($admnos,$conn2);
                    $fees_to_pay = getFeesAsPerTermBoarders($term,$conn2,$getclass,$admnos);
                    $last_academic_balance = lastACADyrBal($admnos,$conn2);
                    $tableinformation1 = "<p style='text-align:center;margin-bottom:10px;'>Displaying results for <strong class='student_names' id='std_names'>".$name."</strong>".$boarding." ".$transporter."<br> Student id: <strong id = 'students_id_ddds'>".$admnos."</strong><br>Student Class : ".className($getclass)."</p>";
                    $tableinformation1.="<p style='margin:10px 0;' >As at <b>".$times."</b> on <b>".$date."</b> <br>Term: <b>".$term."</b><br><span style='color:gray;' ><b>Total Fees Paid this Term : Kes ".number_format($fees_paid)."</b><br><span style='color:gray;' ><b>Last academic year balance : Kes ".number_format($last_academic_balance)."</b><br><span style='color:gray;' ><b>Total fees to be paid as per <b>".$term."</b>: ".$fees_to_pay."</b></span><br><span style='color:gray;'><b>System calculated balance: Ksh</b> ".$balancecalc.".</span>".$headings.$fees_change."<hr><strong>Current Balance is: Ksh <span id='closed_balance'  class='queried' title='click to change the student balance'>".$balance."</span></strong><input type='text' value='".$admnos."'  id='presented' hidden></p>";
                    $tableinformation1.="<p class='red_notice fa-sm hide' id='read_note'>Changing of the student balance is not encouraged, its to be done only when the student is newly registered to the system or there is change in the fees structure</p><br>";
                    $tableinformation1.="<div class='hide' id='fee_balance_new'><input type='number' id='new_bala_ces' placeholder='Enter New Balance'> <div class='acc_rej'><p class = 'redAcc' id='accBalance'>✔</p><p class='greenRej' id='rejectBalances' >✖</p></div></div>";
                    $tableinformation ="<p>- Below are the last 5 transactions recorded or less<br>- Find all the transaction made by the student by clicking the <b>Manage transaction</b> button at the menu.</p><p id='reversehandler'></p><p style = 'font-weight:550;font-size:17px;text-align:center;'><u>Finance table</u></p>";
                    $tableinformation.="<p class = 'hide class_studs_in'>".explode("^",$names)[1]."</p>";
                    $tableinformation .= "<div class='tableme'><table class='table'><tr>
                                        <th>No.</th>
                                        <th>Paid Amount</th>
                                        <th>D.O.P</th>
                                        <th>T.O.P</th>
                                        <th>Balance</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                        </tr>
                                        ";
                                        $transaction_code = "";
                                        $modeofpay = "";
                                        $amount_recieved = "0";
                    while ($row = $results->fetch_assoc()) {
                        $statuses = $row['status'];
                        if($statuses == "0"){
                            if ($xss == 0) {
                                $transaction_code = $row['transaction_code'];
                                $modeofpay = $row['mode_of_pay'];
                                $amount_recieved = $row['amount'];
                            }
                            $xss++;
                            $tableinformation.="<tr><td>".$xss."</td>";
                            $tableinformation.="<td id='reverse_amount".$row['transaction_id']."'>".comma($row['amount'])."</td>";
                            $tableinformation.="<td>".$row['date_of_transaction']."</td>";
                            $tableinformation.="<td>".$row['time_of_transaction']."</td>";
                            $tableinformation.="<td>".comma($row['balance'])."</td>";
                            $tableinformation.="<td>".$row['payment_for']."</td>";
                            $status = "<p>confirmed</p>";
                            if($row['date_of_transaction'] == date('Y-m-d',strtotime("3 hour")) && $row['time_of_transaction'] > date("H:i:s",strtotime("30 minutes")) ){
                                if ($row['mode_of_pay'] != "mpesa" && $statuses != "1") {
                                    $status = "<button class='reverse' style='margin:0 auto;' id='".$row['transaction_id']."'>reverse</button>";
                                }elseif ($statuses == "1") {
                                    $status = "<p class='text-danger'>Reversed</p>";
                                }
                            }
                            $tableinformation.="<td>".$status."</td></tr>";
                        }
                    }
                    $tableinformation.="</table></div>";
                    $tableinformation.="<p class= 'hide' id='transaction_code'>".$transaction_code."</p><p class = 'hide' id ='mode_use_pay'>".$modeofpay."</p><p class='hide' id = 'amount_recieved'>".$amount_recieved."</p><p style='margin-top:10px;'>Note: <br> <small>D.O.P = Date of Payment <br>T.O.P = Time of Payment</small></p>";
                    echo $tableinformation1;
                    if($xss>0){
                        echo $tableinformation;
                    }else {
                        echo "<p class = 'hide class_studs_in'>".explode("^",$names)[1]."</p><p>No records found!.</p>";
                    }
                }else {
                    echo "<p style='color:red;'>An error occured!</p>";
                }
            }else {
                echo "<p style='color:red;'>Admission number entered is invalid!</p>";
            }

        }elseif (isset($_GET['insertpayments'])) {
            include("../../sms_apis/sms.php");
            $studadmin = $_GET['stuadmin'];
            $time = date("H:i:s", strtotime("3 hour"));
            $date = date("Y-m-d",strtotime("3 hour"));
            $trancode = $_GET['transcode'];
            $amount = $_GET['amount'];
            $term = getTerm();
            $payfor = $_GET['payfor'];
            $balance = $_GET['balances'];
            //$balance = getBalance($studadmin,$term,$conn2);
            $newbalance = $balance-$amount;
            //CHECK IF ITS PROVISIONAL FOR IT TO DEDUCT THE AMOUNT
            $classd = explode("^",getClass($studadmin))[1];
            $isprov = isProvisional($payfor,$conn2,$classd);
            if ($isprov == "true") {
                $newbalance = $balance;
            }
            // check if the last year academic balance is reduced and reduce it
            $last_academic_balance = lastACADyrBal($studadmin,$conn2);
            if ($last_academic_balance > 0) {
                // echo $amount." ".$last_academic_balance." ".$newbalance;
                if ($amount > $last_academic_balance) {
                    // clear it to zero
                    $new_bal = 0;
                    // deduct whats left and update the remeaining
                    $select = "SELECT * FROM `finance` WHERE `stud_admin` = ? AND `date_of_transaction` < ? ORDER BY `transaction_id` DESC LIMIT 1;";
                    $stmt = $conn2->prepare($select);
                    $beginyear = getAcademicStart($conn2);
                    $stmt->bind_param("ss",$studadmin,$beginyear);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result) {
                        if ($row = $result->fetch_assoc()) {
                            if (isset($row['balance'])) {
                                $transaction_id = $row['transaction_id'];
                                $update = "UPDATE `finance` SET `balance` = '$new_bal' WHERE `transaction_id` = '$transaction_id'";
                                $stmt = $conn2->prepare($update);
                                $stmt->execute();
                            }
                        }
                    }
                }else {
                    // deduct whats left and update the remeaining
                    $new_bal = $last_academic_balance - $amount;
                    $select = "SELECT * FROM `finance` WHERE `stud_admin` = ? AND `date_of_transaction` < ? ORDER BY `transaction_id` DESC LIMIT 1;";
                    $stmt = $conn2->prepare($select);
                    $beginyear = getAcademicStart($conn2);
                    $stmt->bind_param("ss",$studadmin,$beginyear);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result) {
                        if ($row = $result->fetch_assoc()) {
                            if (isset($row['balance'])) {
                                $transaction_id = $row['transaction_id'];
                                $update = "UPDATE `finance` SET `balance` = '$new_bal' WHERE `transaction_id` = '$transaction_id'";
                                $stmt = $conn2->prepare($update);
                                $stmt->execute();
                            }
                        }
                    }
                }
            }
            $payby = $_GET['paidby'];
            $modeofpay = $_GET['modeofpay'];
            $insert = "INSERT INTO `finance` (`stud_admin`,`time_of_transaction`,`date_of_transaction`,`transaction_code`,`amount`,`balance`,`payment_for`,`payBy`,`mode_of_pay`) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $conn2->prepare($insert);
            $stmt->bind_param("sssssssss",$studadmin,$time,$date,$trancode,$amount,$newbalance,$payfor,$payby,$modeofpay);
            if($stmt->execute()){
                $student_name = getName1($studadmin);
                //administrator notification
                    $messageName = "Confirmed payment for ".$student_name."";
                    $messagecontent = "Confirmed Ksh ".comma($amount)." has been recieved from ".$student_name." Adm No: ".$studadmin." for <b>".$payfor."</b>, on ".date("M-d-Y",strtotime($date))." at ".$time." hrs.<br>The payment mode used was <b>".$modeofpay."</b>";
                    $notice_stat = "0";
                    $reciever_id = "all";
                    $reciever_auth = "1";
                    $sender_id = "Payment system";
                    insertNotifcation($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_id);
                    
                    //send sms
                    $send_sms = $_GET['send_sms'];
                    if (isset($send_sms)) {
                        $phone_number = getPhoneNumber($conn2,$studadmin);
                        if ($phone_number != 0) {
                            if ($send_sms == "first_parent") {
                                $phone_number = explode(",",$phone_number)[0];
                            }else if ($send_sms == "second_parent") {
                                $phone_number = explode(",",$phone_number)[1];
                            }elseif ($send_sms == "both_parent") {
                                $phone_number = $phone_number;
                            }else {
                                $phone_number = "";
                            }
                            $message = "Confirmed Kes ".comma($amount)." has been successfully paid for ".$student_name.", New fee balance is Kes ".comma($newbalance)." as at ".date("H:i:s",strtotime("3 hour"))." on ".date("d-M-Y",strtotime("3 hour")).".";
                            // echo $message;
                            $api_key = getApiKey($conn2);
                            //check if the school has its own api keys
                            $school = 1;
                            if ($api_key == 0) {
                                $school = 0;
                                $api_key = getApiKey($conn);
                            }
                            //echo $api_key;
                            if ($api_key !== 0) {
                                    if ($school == 0) {
                                        $partnerID = getPatnerId($conn);
                                        $shortcodes = getShortCode($conn);
                                    }else {
                                        $partnerID = getPatnerId($conn2);
                                        $shortcodes = getShortCode($conn2);
                                    }
                                //send sms
                                $response = sendSmsToClient($phone_number,$message,$api_key,$partnerID,$shortcodes);
                                $decoded = json_decode($response);
                                if (isset($decoded->{'message'})) {
                                    // echo $decoded->{'message'};
                                }elseif (isset($decoded->{'response-description'})) {
                                    // echo $decoded->{'response-description'};
                                }
                                //recorded the sms information to the sms server
                                $message_type = "Multicast";
                                $message_count = count(explode(",",$phone_number));
                                $recipient_no = $phone_number;
                                $text_message = $message;
                                $message_desc = strlen($message) > 45 ? substr($message,0,45)."..." : $message;
                                $date = date("Y-m-d", strtotime("3 hour"));
                                $select = "INSERT INTO `sms_table` (`message_count`,`date_sent`,`message_sent_succesfully`,`message_undelivered`,`message_type`,`sender_no`,`message_description`,`message`) VALUES ('$message_count','$date','$message_count','$message_count','$message_type','$recipient_no','$message_desc','$text_message')";
                                $stmt = $conn2->prepare($select);
                                // echo $select;
                                $stmt->execute();
                                // echo "Inserted successfull!";
                                // }else{
                                //     echo "Inserted not successfull!";
                                // }
                            }else {
                                echo "<p class='red_notice'>Activate your sms account!</p>";
                            }
                        }else {
                            echo "Invalid parents phone number!";
                        }
                        //end of sms
                    }
                echo "<p style='color:green;font-size:13px;'>Transaction completed successfully!</p>";
            }else{
                echo "<p style='color:red;font-size:13px;'>An error has occured!</p>";
            }


            // if the mpesa transaction change the transaction to assigned
            if (isset($_GET['mpesa_id'])) {
                $update = "UPDATE `mpesa_transactions` SET `std_adm` = ?, `transaction_status` = '1' WHERE `transaction_id` = ?";
                $stuadmin = $_GET['stuadmin'];
                $mpesa_id = $_GET['mpesa_id'];
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("ss",$stuadmin,$mpesa_id);
                $stmt->execute();
            }
        }elseif (isset($_GET['findtransactions'])) {
            $period = $_GET['period'];
            $students = $_GET['studentstype'];
            $today = date("Y-m-d",strtotime("3 hour"));
            $time = date("H:i:s",strtotime("3 hour"));
            $startdate = '';
            $enddate;
            $dates;
            if($period =="today"){
                $startdate = date("Y-m-d",strtotime("3 hour"));
                $dates = "<p>Displaying results of <b>".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
            }elseif($period =="last2days"){
                $startdate = date("Y-m-d",strtotime("-24 hours"));
                $enddate = date("Y-m-d",strtotime("-48 hours"));
                $dates = "<p>Displaying results as from <b>".date("l dS \of M Y",strtotime("-48 hours"))." </b>to <b>".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
            }elseif($period =="last5days"){
                $startdate = date("Y-m-d",strtotime("-96 hours"));
                $enddate = date("Y-m-d",strtotime("-120 hours"));
                $dates = "<p>Displaying results as from <b>".date("l dS \of M Y",strtotime("-120 hours"))."</b> to<b> ".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
            }elseif($period =="lastoneweek"){
                $startdate = date("Y-m-d",strtotime("-144 hours"));
                $enddate = date("Y-m-d",strtotime("-168 hours"));
                $dates = "<p>Displaying results as from <b>".date("l dS \of M Y",strtotime("-168 hours"))."</b> to<b> ".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
            }
            $select1 = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction BETWEEN ? and ? OR (date_of_transaction = ? and `time_of_transaction` > ?) ORDER BY `transaction_id` DESC";
            $select2 = "SELECT `stud_admin` , `mode_of_pay`,(SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction = ? ORDER BY `transaction_id` DESC ";
            $stmt;
            if(!isset($enddate)){
                $stmt = $conn2->prepare($select2);
                $stmt->bind_param("s",$today);
                $stmt->execute();
                $resulted = $stmt->get_result();
            }else {
                $stmt = $conn2->prepare($select1);
                $stmt->bind_param("ssss",$startdate,$today,$enddate,$time);
                $stmt->execute();
                $resulted = $stmt->get_result();
            }
            //create the table
            $table = createtablefinance($resulted);
            $table3 = createTotal2($stmt);
            $data1 = "<div class='tablecarriers'>".createTotal($stmt).$table3."</div>";
            //add the selection of caharts or table
            $selections = "<div class='selectoptions' id='solace'>
                                <div class='view_opt'>
                                    <p>View:</p>
                                </div>
                                <div class='avail_view_options'>
                                    <div class='selected_Option' id='tabular'>
                                        <p>Table</p>
                                    </div>
                                    <div class='tables'  id='chartlike'>
                                        <p>Chart</p>
                                    </div>
                                </div>
                            </div><p id='noticeHold' style='text-align:center;' class='red_notice hide'>Some values may not appear on the chart because they are equivalent to \"0\"<br>View their values at the table view</p>";
            $data = $dates."<br>".$selections."<br>".$data1." ".$table;
            echo $data;
        }elseif (isset($_GET['findtransbtndates'])) {
            $startperiod = $_GET['startfrom'];
            $endperiod = $_GET['endperiod'];
            $time = date("H:i:s",strtotime("3 hour"));
            $dates;$dated;
            $stmt;
            if ($startperiod!=$endperiod) {
                if ($startperiod<$endperiod) {

                    $date=date_create($startperiod);
                    date_add($date,date_interval_create_from_date_string("1 day"));
                    $dates = date_format($date,"Y-m-d");
                    $select = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction BETWEEN ? and ? OR (date_of_transaction = ? and `time_of_transaction` > ?) ORDER BY `transaction_id` DESC";
                    $stmt = $conn2->prepare($select);
                    $stmt->bind_param("ssss",$dates,$endperiod,$startperiod,$time);
                    $stmt->execute();
                    $dated = "<p>Displaying results as from <b>".date("l dS \of M Y",strtotime($startperiod))."</b> to<b> ".date("l dS \of M Y",strtotime($endperiod))."</b></p>";
                    

                }elseif ($startperiod>$endperiod) {

                    $date=date_create($endperiod);
                    date_add($date,date_interval_create_from_date_string("1 day"));
                    $dates = date_format($date,"Y-m-d");
                    $select = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction BETWEEN ? and ? OR (date_of_transaction = ? and `time_of_transaction` > ?) ORDER BY `transaction_id` DESC";
                    $stmt = $conn2->prepare($select);
                    $stmt->bind_param("ssss",$dates,$startperiod,$endperiod,$time);
                    $stmt->execute();
                    $dated = "<p>Displaying results as from <b>".date("l dS \of M Y",strtotime($endperiod))."</b> to<b> ".date("l dS \of M Y",strtotime($startperiod))."</b></p>";
                    
                }
            }else {
                $select = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction = ? ORDER BY `transaction_id` DESC";
                $stmt = $conn2->prepare($select);
                $stmt->bind_param("s",$startperiod);
                $stmt->execute();
                $dated = "<p>Displaying results of <b>".date("l dS \of M Y",strtotime($endperiod))."</b>";

            }
            //create the table
            $resulted = $stmt->get_result();
            $table = createtablefinance($resulted);
            $table3 = createTotal2($stmt);
            $data1 = "<div class='tablecarriers'>".createTotal($stmt).$table3."</div>";
            //add the selection of caharts or table
            $selections = "<div class='selectoptions' id='solace'>
                                <div class='view_opt'>
                                    <p>View:</p>
                                </div>
                                <div class='avail_view_options'>
                                    <div class='selected_Option' id='tabular'>
                                        <p>Table</p>
                                    </div>
                                    <div class='tables'  id='chartlike'>
                                        <p>Chart</p>
                                    </div>
                                </div>
                            </div><p id='noticeHold' style='text-align:center;' class='red_notice hide'>Some values may not appear on the chart because they are equivalent to \"0\"<br>View their values at the table view</p>";
            $data = $dated."<br>".$selections."<br>".$data1." ".$table;
            echo $data;
        }elseif (isset($_GET['findtransbtndatesandadmno'])) {
            $startperiod = $_GET['startfrom'];
            $endperiod = $_GET['endperiod'];
            $admno = $_GET['admnos'];
            $time = date("H:i:s",strtotime("3 hour"));
            $dates;$dated;
            $name = getName($admno);
            $stmt;
            if($name!="null"){
                $name = explode("^",$name)[0];
                if ($startperiod!=$endperiod) {
                    if ($startperiod<$endperiod) {

                        $date=date_create($startperiod);
                        date_add($date,date_interval_create_from_date_string("1 day"));
                        $dates = date_format($date,"Y-m-d");
                        $select = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE (date_of_transaction BETWEEN ? and ?  OR (date_of_transaction = ? and `time_of_transaction` > ?)) AND `stud_admin` = ? ORDER BY `transaction_id` DESC";
                        $stmt = $conn2->prepare($select);
                        $stmt->bind_param("sssss",$dates,$endperiod,$startperiod,$time,$admno);
                        $stmt->execute();
                        $dated = "<p>Displaying results of <b>'".$name."'</b>.<br>As from <b>".date("l dS \of M Y",strtotime($startperiod))."</b> to<b> ".date("l dS \of M Y",strtotime($endperiod))."</b></p>";
                        

                    }elseif ($startperiod>$endperiod) {

                        $date=date_create($endperiod);
                        date_add($date,date_interval_create_from_date_string("1 day"));
                        $dates = date_format($date,"Y-m-d");
                        $select = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE (date_of_transaction BETWEEN ? and ? OR (date_of_transaction = ? and `time_of_transaction` > ?))  AND `stud_admin` = ?  ORDER BY `transaction_id` DESC";
                        $stmt = $conn2->prepare($select);
                        $stmt->bind_param("sssss",$dates,$startperiod,$endperiod,$time,$admno);
                        $stmt->execute();
                        $dated = "<p>Displaying results of <b>'".$name."'</b>.<br> As from <b>".date("l dS \of M Y",strtotime($endperiod))."</b> to<b> ".date("l dS \of M Y",strtotime($startperiod))."</b></p>";
                        
                    }
                }else {
                    $select = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction = ? AND `stud_admin` = ? ORDER BY `transaction_id` DESC";
                    $stmt = $conn2->prepare($select);
                    $stmt->bind_param("ss",$startperiod,$admno);
                    $stmt->execute();
                    $dated = "<p>Displaying results of of <b>'".$name."'</b>.<br>On <b>".date("l dS \of M Y",strtotime($endperiod))."</b>";

                }
                //create the table
                $resulted = $stmt->get_result();
                $table = createtablefinance($resulted);
                $table3 = createTotal2($stmt);
                $term = getTerm();
                $feespaid = getFeespaidByStudent($admno,$conn2);
                $balance = getBalance($admno,$term,$conn2);
                $data1 = "<p>Amount paid this academic year: <strong>Ksh ".comma($feespaid)." </strong></p><p>Balance as of ".$term.":<strong> Ksh ".comma($balance)." </strong></p><br><div class='tablecarriers'>".createTotal($stmt).$table3."</div>";
                //add the selection of caharts or table
                $selections = "<div class='selectoptions' id='solace'>
                                    <div class='view_opt'>
                                        <p>View:</p>
                                    </div>
                                    <div class='avail_view_options'>
                                        <div class='selected_Option' id='tabular'>
                                            <p>Table</p>
                                        </div>
                                        <div class='tables'  id='chartlike'>
                                            <p>Chart</p>
                                        </div>
                                    </div>
                                </div><p id='noticeHold' style='text-align:center;' class='red_notice hide'>Some values may not appear on the chart because they are equivalent to \"0\"<br>View their values at the table view</p>";
                $data = $dated."<br>".$selections."<br>".$data1." ".$table;
                echo $data;
            }else {
                echo "<p style='color:red;'>Invalid admission number!</p>";
            }
        }elseif (isset($_GET['findtransbtncontsdatesandadmno'])) {
            $period = $_GET['period'];
            $adminno = $_GET['admnos'];
            $today = date("Y-m-d",strtotime("3 hour"));
            $time = date("H:i:s",strtotime("3 hour"));
            $startdate = '';
            $enddate;
            $dates;
            $name = getName($adminno);
            if($name!="null"){
                $name = explode("^",$name)[0];
                if($period =="today"){
                    $startdate = date("Y-m-d",strtotime("3 hour"));
                    $dates = "<p>Displaying results of <b>".$name."</b><br> <b>".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
                }elseif($period =="last2days"){
                    $startdate = date("Y-m-d",strtotime("-24 hours"));
                    $enddate = date("Y-m-d",strtotime("-48 hours"));
                    $dates = "<p>Displaying results of <b>".$name."</b><br> As from <b>".date("l dS \of M Y",strtotime("-48 hours"))." </b>to <b>".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
                }elseif($period =="last5days"){
                    $startdate = date("Y-m-d",strtotime("-96 hours"));
                    $enddate = date("Y-m-d",strtotime("-120 hours"));
                    $dates = "<p>Displaying results of <b>".$name."</b><br> As from <b>".date("l dS \of M Y",strtotime("-120 hours"))."</b> to<b> ".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
                }elseif($period =="lastoneweek"){
                    $startdate = date("Y-m-d",strtotime("-144 hours"));
                    $enddate = date("Y-m-d",strtotime("-168 hours"));
                    $dates = "<p>Displaying results of <b>".$name."</b><br> As from <b>".date("l dS \of M Y",strtotime("-168 hours"))."</b> to<b> ".date("l dS \of M Y",strtotime("3 hour"))."</b></p>";
                }
                $select1 = "SELECT `stud_admin` , `mode_of_pay`, (SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE (date_of_transaction BETWEEN ? and ? OR (date_of_transaction = ? and `time_of_transaction` > ?)) AND `stud_admin` = ?  ORDER BY `transaction_id` DESC";
                $select2 = "SELECT `stud_admin` , `mode_of_pay`,(SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE date_of_transaction = ? AND `stud_admin` = ?  ORDER BY `transaction_id` DESC ";
                $stmt;
                if(!isset($enddate)){
                    $stmt = $conn2->prepare($select2);
                    $stmt->bind_param("ss",$today,$adminno);
                    $stmt->execute();
                    $resulted = $stmt->get_result();
                }else {
                    $stmt = $conn2->prepare($select1);
                    $stmt->bind_param("sssss",$startdate,$today,$enddate,$time,$adminno);
                    $stmt->execute();
                    $resulted = $stmt->get_result();
                }
                //create the table
                $table = createtablefinance($resulted);
                $table3 = createTotal2($stmt);
                $term = getTerm();
                $feespaid = getFeespaidByStudent($adminno,$conn2);
                $balance = getBalance($adminno,$term,$conn2);
                $data1 = "<p>Amount paid this academic year: <strong>Ksh ".comma($feespaid)." </strong></p><p>Balance as of ".$term.":<strong> Ksh ".comma($balance)." </strong></p><br><div class='tablecarriers'>".createTotal($stmt).$table3."</div>";
                //add the selection of caharts or table
                $selections = "<div class='selectoptions' id='solace'>
                                    <div class='view_opt'>
                                        <p>View:</p>
                                    </div>
                                    <div class='avail_view_options'>
                                        <div class='selected_Option' id='tabular'>
                                            <p>Table</p>
                                        </div>
                                        <div class='tables'  id='chartlike'>
                                            <p>Chart</p>
                                        </div>
                                    </div>
                                </div><p id='noticeHold' style='text-align:center;' class='red_notice hide'>Some values may not appear on the chart because they are equivalent to \"0\"<br>View their values at the table view</p>";
                $data = $dates."<br>".$selections."<br>".$data1." ".$table;
                echo $data;
            }else {
                echo "<p style='color:red;'>Invalid admission number!</p>";
            }
        }elseif (isset($_GET['findtransindates'])) {
            $class = $_GET['class'];
            $students = studentInclass($class,$conn2);
            $classd = $class;
            $term = getTerm();
            $feespaidbyc = getFeesAsPerTerm($term,$conn2,$class);
            $classd = className($class);
            if (count($students)>0) {
                $tablein4 = "<p style='text-align:center;'><span style='font-size:20px;font-weight:500;'><u>Displaying results for ".$classd."</u></span><br>By term <b>".$term."</b> they are to pay Ksh <b>".comma($feespaidbyc)."</b> each. ";
                if (getBoardingFees($conn2,$class) > 0) {
                    $tablein4.="<b>AND</b> if boarding <b>".comma(getBoardingFees($conn2,$class))."</b> is added to their fees.<br> Boarders name are preceeded with <span style='color:green;font-size:12px;font-weight:600;'> -b</span> for easy identification.";
                }
                $tablein4.="<p style='text-align:center;' >Scroll down to find the <b>print fees reminder</b> button and print fee reminders</p>";
                $tablein4.= "</p><p id='pleasewait23' style='color:green;text-align:center;' >Preparing please wait...</p><div class='tableme'><table class='table'><tr><th>No.</th><th>Name</th><th>Adm no.</th><th>Paid amounts</th><th>Balance</th><th>Options</th><th title='select to print fees reminder'>Print Fee reminder</th></tr>";
                $total = 0;
                $totbal = 0;
                for ($i=0; $i < count($students); $i++) { 
                    $data = explode("^",$students[$i]);
                    $feespaid = getFeespaidByStudent($data[1],$conn2);
                    $balance = getBalance($data[1],$term,$conn2);
                    $balancetxt;
                    if ($balance==0) {
                        $balancetxt="<p style='color:green;font-size: 13px;font-weight:100;'>Cleared!</p>";
                    }else {
                        $balancetxt="Ksh ".comma($balance)."";
                    }
                    $total+=$feespaid;
                    $totbal+=$balance;
                    $tablein4.="<tr><td>".($i+1)."</td>"."<td>".$data[0];
                    if (isBoarding($data[1],$conn2)) {
                        $tablein4.="<span style='color:green;font-size:12px;font-weight:600;'> -b</span>";
                    }
                    $tablein4.="</td><td>".$data[1]."</td><td style='color:green; font-size:12px;font-weight:600;'>Ksh ".comma($feespaid)."</td><td style='color:rgb(71,0, 26);font-size:13px;font-weight:600;'>".$balancetxt."</td><td>"."<button class='finbtns' id='finbtn".$data[1]."'>More..</button>"."</td><td ><input style='align-items:center;margin:auto;cursor:pointer;' type='checkbox' class='sutid' id='sutid".$data[1]."'></td></tr>";
                }
                $tablein4.="<tr><td style='border:none;'></td><td style='border:none;'></td><td><b>Total</b></td><td style='color:green; font-size:13px;' ><b>Ksh ".comma($total)."</b></td><td style='color:rgb(71,0, 26); font-size:13px;' ><b>Ksh ".comma($totbal)."</b></td><td style='border:none;'></td></tr></table></div>";
                $tablein4.="<div class='conts'><p>- At this window you can print fee reminder for each student.</p><p>- Select on the last column the ones you want to print fee reminders for.</p>";
                $tablein4.="<p>- After selecting click the button below to print fee reminders</p><br><br>";
                $tablein4.="<label style='font-weight:600;font-size:13px;cursor:pointer;' for='date_picker'>Select deadline for payment <br></label>
                            <input type='date' id='date_picker' min = '".date("Y-m-d",strtotime('3 hour'))."' style='max-width:150px;'><br><p id='reminder_err'></p><br>";
                $tablein4.="<button type='button' id='print_reminders'>Print fees reminders</button></div>";

                echo $tablein4;
            }else {
                echo "<p style='color:red;'>There are no members in ".className($class)."</p>";
            }
        }elseif (isset($_GET['find_transaction_with_code'])) {
            $transaction_code = $_GET['find_transaction_with_code'];
            $select2 = "SELECT `stud_admin` , `mode_of_pay`,(SELECT(concat(`first_name`,' ',`second_name`)) FROM `student_data` WHERE `adm_no` = `stud_admin`) AS 'Name' ,  date_of_transaction , time_of_transaction , `amount` , balance, payment_for  FROM `finance` WHERE `transaction_code` = ?  ORDER BY `transaction_id` DESC ";
            $stmt = $conn2->prepare($select2);
            $stmt->bind_param("s",$transaction_code);
            $stmt->execute();
            $resulted = $stmt->get_result();
            if ($resulted) {
                //create the table
                $table = createtablefinance($resulted);
                $table3 = createTotal2($stmt);
                $data1 = "<div class='tablecarriers'>".createTotal($stmt).$table3."</div>";
                //add the selection of caharts or table
                $selections = "<div class='selectoptions' id='solace'>
                                    <div class='view_opt'>
                                        <p>View:</p>
                                    </div>
                                    <div class='avail_view_options'>
                                        <div class='selected_Option' id='tabular'>
                                            <p>Table</p>
                                        </div>
                                        <div class='tables'  id='chartlike'>
                                            <p>Chart</p>
                                        </div>
                                    </div>
                                </div><p id='noticeHold' style='text-align:center;' class='red_notice hide'>Some values may not appear on the chart because they are equivalent to \"0\"<br>View their values at the table view</p>";
                $data = $selections."<br>".$data1." ".$table;
                echo $data;
                
            }
        }
        elseif (isset($_GET['transactionid'])) {
            $transactionid = $_GET['transactionid'];
            $amount_reverse = $_GET['amount_reverse'];
            $select = "SELECT * FROM `finance` WHERE `transaction_id` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$transactionid);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                     $stud_admin = $row['stud_admin'];
                     $transaction_id = $row['transaction_id'];
                     $amount = $row['amount'];
                     $amount2 = $row['amount'];
                     $balance = $row['balance'];
                     $balance2 = $row['balance'];
                     $payment_for = $row['payment_for'];
                     $payBy = $row['payBy'];
                     $mode_of_pay = $row['mode_of_pay'];
                     $status = $row['status'];
                     $idsd = $row['idsd'];
                     $amount_paid = getFeespaidByStudent($stud_admin,$conn2);
                     $lastacad = lastACADyrBal($stud_admin,$conn2);
                     $daro = getName($stud_admin);
                    //  get to know if the payment is provissional or not
                    $classd = explode("^",getClass($stud_admin))[1];
                    $isprov = isProvisional($payment_for,$conn2,$classd);
                    if($isprov != "true"){
                        // get the balance do not add
                        $balance = $balance+$amount;
                    }
                    // insert a new record showing the amount was reversed
                    $insert = "INSERT INTO `finance` (`stud_admin`,`time_of_transaction`,`date_of_transaction`,`transaction_code`,`amount`,`balance`,`payment_for`,`payBy`,`mode_of_pay`,`status`) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $conn2->prepare($insert);
                    $time = date("H:i:s",strtotime("3 hours"));
                    $dates = date("Y-m-d",strtotime("3 hours"));
                    $transaction_code = "reverse";
                    $amount = "-".$amount;
                    $status = "1";
                    $stmt->bind_param("ssssssssss",$stud_admin,$time,$dates,$transaction_code,$amount,$balance,$transaction_code,$payBy,$transaction_code,$status);
                    $stmt->execute();

                    // update the current transaction data status to reveresed
                    $update = "UPDATE `finance` SET `status` = '1' WHERE `transaction_id` = ?";
                    $stmt = $conn2->prepare($update);
                    $stmt->bind_param("s",$transactionid);
                    if($stmt->execute()){
                        $students_id_ddds = $stud_admin;
                        $student_name = getName1($students_id_ddds);
                        $messageName = "Reversal of payment for ".$student_name."";
                        $messagecontent = "Reversal of Ksh ".$amount_reverse." for ".$student_name." Adm No: ".$students_id_ddds." has been done successfully on ".date("M-d-Y",strtotime("3 hour"))." at ".date("H:i:s")." hrs";
                        $notice_stat = "0";
                        $reciever_id = "all";
                        $reciever_auth = "1";
                        $sender_id = "Payment system";
                        insertNotifcation($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_id);
                        // check if the last academic balance is above zero or the paid amount and the balance is greater than the required payment
                        $term = getTermV2($conn2);
                        $balance = $balance2;
                        $getclass = explode("^",$daro);
                        $dach = $getclass[1];
                        $feestopay = getFeesAsPerTermBoarders($term,$conn2,$dach,$students_id_ddds);
                        // echo $balance." ".$lastacad." ".$amount_paid." ".$feestopay."<br>";
                        if ($feestopay < ($balance+$amount_paid)) {
                            // if the balance and the amount paid is greater than the fees to pay 
                            // that means that there was a last academic balance
                            // get the amount paid that academic year
                            $last_acad_bal = ($balance+$amount_paid) - $feestopay;
                            if ($amount2 < $last_acad_bal) {
                                // clear it to zero
                                $new_bal = $amount2+$lastacad;
                                // echo $new_bal." ".$amount2." UP";
                                // deduct whats left and update the remeaining
                                $select = "SELECT * FROM `finance` WHERE `stud_admin` = ? AND `date_of_transaction` < ? ORDER BY `transaction_id` DESC LIMIT 1;";
                                $stmt = $conn2->prepare($select);
                                $beginyear = getAcademicStart($conn2);
                                $stmt->bind_param("ss",$students_id_ddds,$beginyear);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result) {
                                    if ($row = $result->fetch_assoc()) {
                                        if (isset($row['balance'])) {
                                            $transaction_id = $row['transaction_id'];
                                            $update = "UPDATE `finance` SET `balance` = '$new_bal' WHERE `transaction_id` = '$transaction_id'";
                                            $stmt = $conn2->prepare($update);
                                            $stmt->execute();
                                        }
                                    }
                                }
                            }else {
                                // if the amount2 reversed is greater than the last academic balance
                                // take fees to pay minus balance to get how much was paid to the current academic year
                                $newbalance = $amount2 - ($feestopay - $balance);
                                // echo $amount2." ".$newbalance." ".$feestopay." ".$balance."DOWN";
                                // deduct whats left and update the remeaining
                                $select = "SELECT * FROM `finance` WHERE `stud_admin` = ? AND `date_of_transaction` < ? ORDER BY `transaction_id` DESC LIMIT 1;";
                                $stmt = $conn2->prepare($select);
                                $beginyear = getAcademicStart($conn2);
                                $stmt->bind_param("ss",$students_id_ddds,$beginyear);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result) {
                                    if ($row = $result->fetch_assoc()) {
                                        if (isset($row['balance'])) {
                                            $transaction_id = $row['transaction_id'];
                                            $update = "UPDATE `finance` SET `balance` = '$newbalance' WHERE `transaction_id` = '$transaction_id'";
                                            $stmt = $conn2->prepare($update);
                                            $stmt->execute();
                                        }
                                    }
                                }
                            }
                        }
                        echo "<p style='color:green;'>Reverse was successfull</p>";
                    }else {
                        echo "<p style='color:red;'>Reverse was not successfull</p>";
                    }
                }
            }
            // $students_id_ddds = $_GET['students_id_ddds'];
            // $delete = "DELETE FROM `finance` WHERE `transaction_id` = ?";
            // $stmt = $conn2->prepare($delete);
            // $stmt->bind_param("i",$transactionid);
            
        }elseif (isset($_GET['feesstructurefind'])) {
            $class = $_GET['class'];
            $select = "SELECT `expenses`,`roles` ,`TERM_1`,`TERM_2`,`TERM_3`,`classes`,`activated`,`ids` FROM fees_structure WHERE `classes` LIKE ?";
            $daros = "%|".$class."|%";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$daros);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res) {
                $dat = "Class ".$class;
                if (strlen($class)>1) {
                    $dat=$class;
                }
                $table = "<h6 style='text-align:center;'>Fees structure for <span id='class_display_fees'>".$dat."</span> </h6>";
                $table.="<div class='tableme'><table class='table'>";
                $table.="<tr>
                        <th>Votehead</th>
                        <th>TERM ONE</th>
                        <th>TERM TWO</th>
                        <th>TERM THREE</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>";
                        $total1 =0;
                        $total2 =0;
                        $total3 =0;
                while ($row = $res->fetch_assoc()) {
                    $table.="<tr><td class='vote_heads' id = 'expense_name".$row['ids']."'>".$row['expenses']."</td>";
                    $table.="<td class = 't-one' id = 't_one".$row['ids']."'>".$row['TERM_1']."</td>";
                    $table.="<td class = 't-two' id = 't_two".$row['ids']."'>".$row['TERM_2']."</td>";
                    $table.="<td class = 't-three' id = 't_three".$row['ids']."'>".$row['TERM_3']."</td>";
                    $total1+=$row['TERM_1'];
                    $total2+=$row['TERM_2'];
                    $total3+=$row['TERM_3'];
                    $roles = $row['roles'];
                    $table.="<td class='roles_in'>".$roles."</td>";
                    $button = "<p class='link edit_feeser' style='margin:0 auto;font-size:11px;' id='eed".$row['ids']."'><i class='fa fa-pen'></i></p>";
                    $button2 = "<p class='link removef_ee' style='margin:0 auto;font-size:11px;' id='remover".$row['ids']."'><i class='fa fa-trash'></i></p>";
                    $table.="<p class='hide' id='proles".$row['ids']."'>".$row['roles']."</p>";
                    $table.="<td>".$button."</td><td>".$button2."</td></tr>";
                }
                $table.="<tr><td><b>Total</b></td><td>Ksh ".$total1."</td><td>Ksh ".$total2."</td><td>Ksh ".$total3."</td></tr><tr><td><b>Grand total </b></td><td>Ksh ".($total1+$total2+$total3)."</td></tr></table></div>";
                echo $table;
            }
        }elseif (isset($_GET['m_pesa_code'])) {
            $mpesa_code = $_GET['m_pesa_code'];
            $select = "SELECT `transaction_code` FROM finance WHERE `transaction_code` = ? AND `mode_of_pay` = 'mpesa' ";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$mpesa_code);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                echo "<p style='font-size:12px;color:red;'>Transaction code already used!</p>";
            }else {
                echo "";
            }
        }elseif (isset($_GET['bank_codes'])) {
            $mpesa_code = $_GET['bank_codes'];
            $select = "SELECT `transaction_code` FROM finance WHERE `transaction_code` = ? AND `mode_of_pay` = 'bank' ";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$mpesa_code);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                echo "<p style='font-size:12px;color:red;'>Transaction code already used!</p>";
            }else {
                echo "";
            }
        }elseif (isset($_GET['get_fee_reminders'])) {
            $class_to_remind = $_GET['get_fee_reminders'];
            $deadline = $_GET['deadline'];
            $date = date_create($deadline);
            $date = date_format($date,"Y-m-d");
            $date = date("D dS M Y",strtotime($date));
            $split_students = explode(",",$class_to_remind);
            $data_to_display = "";
            $xfg = 0;
            for ($xc=0; $xc < count($split_students); $xc++) {
                $xfg++;
                $reminder = getBalance($split_students[$xc],getTerm(),$conn2);
                //create the string to move
                $name_class = explode("^",getName($split_students[$xc]));
                $data_to_display.="<div class='printable_page'>
                    <div class='page_titles'>
                        <h2>".$_SESSION['schoolname']."</h2>
                        <p>P.O BOX ".$_SESSION['po_boxs']." - ".$_SESSION['box_codes']." (".$_SESSION['sch_countys'].")</p>
                        <h4> Motto:".$_SESSION['schoolmotto']."</h4>
                    </div>
                    <div class='student_data'>
                        <p><strong>Student Name:</strong> ".$name_class[0]."</p>
                        <p><strong>Student Id:</strong> ".$split_students[$xc]."</p>
                        <p><strong>Student Class: </strong>".className($name_class[1])."</p>
                    </div>
                    <div class='message_remider'>
                        <p>Dear Parent, <br>You are kindly reminded to clear your fee arrears of Kes <strong>".comma($reminder)."</strong> by <strong>".$date."</strong> .</p><br>
                        <p> <strong> Yours Failthfully <br>Headteacher, <br> ". $_SESSION['schoolname']."</strong></p>
                    </div>
                </div>";
            }
            if ($xfg > 0) {
                echo $data_to_display;
            }else {
                echo "<div class='displaydata'>
                            <img class='' src='images/error.png'>
                            <p class='' >No students to display! </p>
                        </div>";
            }
        }elseif (isset($_GET['send_message'])) {
            include("../../sms.php");
            $phone_number = $_GET['to'];
            $err = 0;
            if (strlen($phone_number) == 10 || strlen($phone_number) == 9) {
                $phone_number = substr($phone_number,1,10);
            }elseif (strlen($phone_number) == 12) {
                $phone_number = substr($phone_number,4,13);
            }else {
                echo "<p style='color:green;font-size:13px;font-weight:600;margin-top:10px;'>Invalid phone number</p>";
                $err++;
            }
            if ($err == 0) {
                //sendMessage($country_code,$phone_number);
                $school_code = "SchoolSMS";
                $message = "This is a test message!<br> Hilary!";
                // $invalid = sendSmsToClient($phone_number,$message,$school_code);
                // echo $invalid;
            }
        }elseif (isset($_GET['get_class_add_expense'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $classlist = $row['valued'];
                    $exp_class = explode(",",$classlist);
                    if (count($exp_class) > 0) {
                        $data_to_display = "<div class='classlist'>";
                        $xs = 0;
                        for ($ind=count($exp_class)-1; $ind >=0; $ind--) { 
                            $xs++;
                            $data_to_display.="<div class = 'checkboxholder' style='margin:10px 0;padding:0px 0px;'>
                                                    <label style='margin-right:5px;cursor:pointer;font-size:12px;' for='cl_ass".$exp_class[$ind]."'>".className($exp_class[$ind])."</label>
                                                    <input class='add_expense_check' type='checkbox' name='cl_ass".$xs."' id='cl_ass".$exp_class[$ind]."'>
                                                </div>";
                        }
                        $data_to_display.="</div>";
                        if ($xs>0) {
                            echo $data_to_display;
                        }else {
                            echo "<p class = 'red_notice'>No classes present!</p>";
                        }
                    }
                }
            }
        }elseif (isset($_GET['add_expense'])) {
            $insert = "INSERT INTO `fees_structure` (`expenses`,`TERM_1`,`TERM_2`,`TERM_3`,`classes`,`activated`,`roles`,`date_changed`,`term_1_old`,`term_2_old`,`term_3_old`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn2->prepare($insert);
            $activated = 1;
            $date_changed = date("Y-m-d",strtotime("3 hour"));
            $stmt->bind_param("sssssssssss",$_GET['expense_name'],$_GET['term_one'],$_GET['term_two'],$_GET['term_three'],$_GET['class_lists'],$activated,$_GET['roles'],$date_changed,$_GET['term_one'],$_GET['term_two'],$_GET['term_three']);
            if($stmt->execute()){
                echo  "<p class = 'green_notice'>Votehead inserted successfully!</p>";
            }else {
                echo  "<p class = 'red_notice'>Votehead not inserted!</p>";
            }
        }elseif (isset($_GET['delete_fee'])) {
            $fees_id = $_GET['delete_fee'];
            $delete = "DELETE FROM `fees_structure` WHERE `ids` = ?";
            $stmt = $conn2->prepare($delete);
            $stmt->bind_param("s",$fees_id);
            if($stmt->execute()){
                echo  "<p class = 'green_notice'>Deleted successfully!</p>";
            }else {
                echo  "<p class = 'red_notice'>Action was not successfull!</p>";
            }
        }elseif (isset($_GET['getclasslist2'])) {
            $select = "SELECT `valued` FROM `settings` WHERE `sett` = 'class'";
            $fees_id = $_GET['fees_id'];
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $classlist = $row['valued'];
                    $exp_class = explode(",",$classlist);
                    if (count($exp_class) > 0) {
                        $data_to_display = "<div class='classlist'>";
                        $xs = 0;
                        for ($ind=count($exp_class)-1; $ind >=0; $ind--) { 
                            $xs++;
                            $data_to_display.="<div class = 'checkboxholder' style='margin:10px 0;padding:0px 0px;'>
                                                    <label style='margin-right:5px;cursor:pointer;font-size:12px;' for='cla_sse_d".$exp_class[$ind]."'>".className($exp_class[$ind])."</label>
                                                    <input class='update_expense_check' type='checkbox' name='cla_sse_d".$xs."' id='cla_sse_d".$exp_class[$ind]."'>
                                                </div>";
                        }
                        $data_to_display.="</div><p id='class_fees_ass' class='hide'>".getClassAssignFee($fees_id,$conn2)."</p>";
                        if ($xs>0) {
                            echo $data_to_display;
                        }else {
                            echo "<p class = 'red_notice'>No classes present!</p>";
                        }
                    }
                }
            }
        }elseif (isset($_GET['update_fees_information'])) {
            $expensename = $_GET['fees_name'];
            $old_expense_name = $_GET['old_names'];
            $t_one = $_GET['t_one'];
            $t_two = $_GET['t_two'];
            $t_three = $_GET['t_three'];
            $fee_ids = $_GET['fee_ids'];
            $class_list = $_GET['class_list'];
            $roles = $_GET['roles'];
            // get the previous fees structures for the entity
            $select = "SELECT `TERM_1`,`TERM_2`,`TERM_3` FROM `fees_structure` WHERE `ids` = ?;";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$fee_ids);
            $stmt->execute();
            $result = $stmt->get_result();
            $term_1_old = "0";
            $term_2_old = "0";
            $term_3_old = "0";
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $term_1_old = $row['TERM_1'];
                    $term_2_old = $row['TERM_2'];
                    $term_3_old = $row['TERM_3'];
                }
            }

            $update = "UPDATE `fees_structure` SET `expenses` = ?,`TERM_1` = ? , `TERM_2` = ?, `TERM_3` = ?, `classes` = ?, `roles` = ? , `date_changed` = ? ,`term_1_old` = ? , `term_2_old` = ?, `term_3_old` = ? WHERE `ids` = ?";
            $stmt = $conn2->prepare($update);
            $date_changed = date("Y-m-d",strtotime("3 hours"));
            $stmt->bind_param("sssssssssss",$expensename,$t_one,$t_two,$t_three,$class_list,$roles,$date_changed,$term_1_old,$term_2_old,$term_3_old,$fee_ids);
            $execute = $stmt->execute();
            if ($execute) {
                $update = "UPDATE `finance` SET `payment_for` = ? WHERE `payment_for` = ?";
                $stmt = $conn2->prepare($update);
                $stmt->bind_param("ss",$expensename,$old_expense_name);
                $stmt->execute();
                echo "<p class = 'green_notice'>Update done successfully!</p>";
            }else {
                echo "<p class = 'red_notice'>An error occured during update!</p>";
            }
        }elseif (isset($_GET['check_expense_name'])) {
            $check_expense_name = $_GET['check_expense_name'];
            $select = "SELECT * FROM `fees_structure` WHERE `expenses` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$check_expense_name);
            $stmt->execute();
            $stmt->store_result();
            $rnums = $stmt->num_rows;
            if ($rnums > 0) {
                echo "<p class='red_notice'>The votehead name is already used!<br>Try using amother name</p>";
            }else {
                echo "";
            }
        }elseif (isset($_GET['addExpenses'])) {
            $exp_name = $_GET['exp_name'];
            $exp_cat = $_GET['expensecat'];
            $exp_quant = $_GET['quantity'];
            $exp_unit = $_GET['unitcost'];
            $exp_totcost = $_GET['total'];
            $unit_name = $_GET['unit_name'];
            $date = date("Y-m-d",strtotime("3 hour"));
            $time = date("H:i:s",strtotime("3 hour"));
            $insert = "INSERT INTO `expenses` (`expid`,`exp_name`,`exp_category`,`unit_name`,`exp_quantity`,`exp_unit_cost`,`exp_amount`,`expense_date`,`exp_time`,`exp_active`)VALUES (null,?,?,?,?,?,?,?,?,0)";
            $stmt = $conn2->prepare($insert);
            $stmt->bind_param("ssssssss",$exp_name,$exp_cat,$unit_name,$exp_quant,$exp_unit,$exp_totcost,$date,$time);
            if($stmt->execute()){
                echo "<p class='green_notice'>Expense uploaded successfully!<span id='uploaded'></span></p>";
            }else {
                echo "<p class='red_notice'>Error occured during upload!</p>";
            }

        }elseif (isset($_GET['todays_expemse'])) {
            // $select = "SELECT `exp_name`,`exp_category`,`unit_name`,`exp_quantity`,`exp_unit_cost`,`exp_amount`,`expense_date`,`exp_time` FROM `expenses` WHERE `expense_date` = ?";
            $select = "SELECT `exp_name`,`exp_category`,`unit_name`,`exp_quantity`,`exp_unit_cost`,`exp_amount`,`expense_date`,`exp_time` FROM `expenses` ORDER BY `expid` DESC";
            $stmt = $conn2->prepare($select);
            $date = date("Y-m-d",strtotime("3 hour"));
            // $stmt->bind_param("s",$date);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $json_2 = "<p class='hide' id='expenses_data_json'>[";
                $data_to_display = "<div class='conts'>
                                    <h6 style='text-align:center;font-size:14px;'><u>Expenses Table</u></h6>
                                </div>
                                <div class='table_holders'>
                                    <table  class='table'>
                                        <tr>
                                            <th>No.</th>
                                            <th>Expense Name</th>
                                            <th>Expense Category</th>
                                            <th>Units</th>
                                            <th>Unit Price</th>
                                            <th>Total Amount</th>
                                        </tr>";
                                        $xs = 0;
                                        $total_pay = 0;
                while($rows = $result->fetch_assoc()){
                    $xs++;
                    $data_to_display.="<tr>
                                        <td>".$xs."</td>
                                        <td>".$rows['exp_name']."</td>
                                        <td>".$rows['exp_category']."</td>
                                        <td>".$rows['exp_quantity']." ".$rows['unit_name']."</td>
                                        <td>Ksh ".$rows['exp_unit_cost']."</td>
                                        <td><b>Ksh ".$rows['exp_amount']."</b></td>
                                    </tr>";
                                    $total_pay+=$rows['exp_amount'];
                    $json_2.="{\"exp_name\":\"".ucwords(strtolower($rows['exp_name']))."\",\"exp_category\":\"".ucwords(strtolower($rows['exp_category']))."\",\"exp_quantity\":".$rows['exp_quantity'].",\"exp_unit_cost\":".$rows['exp_unit_cost'].",\"exp_amount\":".$rows['exp_amount'].",\"expense_date\":\"".date("dS M Y",strtotime($rows['expense_date']))."\",\"exp_time\":\"".$rows['exp_time']."\",\"unit_name\":\"".ucwords(strtolower($rows['unit_name']))."\"},";
                }
                $data_to_display.="<tr><td></td><td></td><td></td><td></td><td>Total</td><td>Ksh ".$total_pay."</td></tr>";
                $data_to_display.="</table></div>";
                $json_2 = substr($json_2,0,(strlen($json_2)-1));
                $json_2.="]</p>";
                if ($xs > 0) {
                    // echo $data_to_display.$json_2;
                    echo $json_2;
                }else {
                    echo "<p class='green_notice' style='text-align:center;'>No expenses recorded today!</p>";
                }
                //get current year
                $startdate = date("Y-m",strtotime("3 hour"))."-01";
                $enddate = date("Y-m",strtotime("3 hour"))."-31";
                $select = "SELECT `exp_category`, sum(`exp_amount`) as 'Total', COUNT(`exp_category`) AS 'Record' FROM `expenses`  GROUP BY `exp_category`;";
                // $select = "SELECT `exp_category`, sum(`exp_amount`) as 'Total', COUNT(`exp_category`) AS 'Record' FROM `expenses` WHERE `expense_date` BETWEEN ? AND ? GROUP BY `exp_category`;";
                $stmt = $conn2->prepare($select);
                // $stmt->bind_param("ss",$startdate,$enddate);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    $xs = 0;
                    $data_to_display = "<div class='modepayChartHolder' style='width:400px;height:400px;margin:auto;'><canvas id='expense-charted-in' width = '200px' height='200px'></canvas></div><h5 style='text-align:center;' id='title-charts2'>Expenses Categories</h5><table  class='table'>
                                        <tr>
                                            <th>No.</th>
                                            <th>Expense Category</th>
                                            <th>Amount</th>
                                            <th>Record(s)</th>
                                        </tr>";
                                        $myjson = "{";
                    while ($row = $result->fetch_assoc()) {
                        $xs++;
                        $data_to_display.="<tr>
                                            <td>".$xs." .</td>
                                            <td>".$row['exp_category']."</td>
                                            <td>Kes ".comma($row['Total'])."</td>
                                            <td>".$row['Record']."</td>
                                        </tr>";
                        $myjson.="\"".$row['exp_category']."\":\"".$row['Total']."\",";
                    }
                    $myjson = substr($myjson,0,strlen($myjson)-1);
                    $myjson.="}";
                    $data_to_display.="</table><p class='hide' id='table_values2'>$myjson</p>";
                    if ($xs > 0) {
                        echo $data_to_display;
                    }else {
                        echo "<p class='red_notice'>No records found for ".date("M - Y",strtotime($startdate))." !</p>";
                    }
                }
            }
        }elseif (isset($_GET['date_display'])) {
            $select = "SELECT `exp_name`,`exp_category`,`unit_name`,`exp_quantity`,`exp_unit_cost`,`exp_amount`,`expense_date`,`exp_time` FROM `expenses` WHERE `expense_date` = ?";
            $stmt = $conn2->prepare($select);
            $date = $_GET['date_display'];
            $stmt->bind_param("s",$date);
            $stmt->execute();
            $dating = date("l dS M Y",strtotime($date));
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<div class='conts'>
                                    <h6 style='text-align:center;font-size:12px;'><u>".$dating." expenses</u></h6>
                                </div>
                                <div class='table_holders'>
                                    <table  class='table'>
                                        <tr>
                                            <th>No.</th>
                                            <th>Expense Name</th>
                                            <th>Expense Category</th>
                                            <th>Units</th>
                                            <th>Unit Price</th>
                                            <th>Total Amount</th>
                                        </tr>";
                                        $xs = 0;
                                        $total_pay = 0;
                while($rows = $result->fetch_assoc()){
                    $xs++;
                    $data_to_display.="<tr>
                                        <td>".$xs."</td>
                                        <td>".$rows['exp_name']."</td>
                                        <td>".$rows['exp_category']."</td>
                                        <td>".$rows['exp_quantity']." ".$rows['unit_name']."</td>
                                        <td>Ksh ".$rows['exp_unit_cost']."</td>
                                        <td><b>Ksh ".$rows['exp_amount']."</b></td>
                                    </tr>";
                                    $total_pay+=$rows['exp_amount'];
                }
                $data_to_display.="<tr><td></td><td></td><td></td><td>Total</td><td>Ksh ".$total_pay."</td></tr>";
                $data_to_display.="</table></div>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No expenses recorded on the selected date!</p>";
                }
            }
        }elseif (isset($_GET['incomestatement'])) {
            //get the time periods between terms
            $term_arrays = getTermPeriods($conn2);
            //get the income based on the period above
            $term_income = getTermIncome($term_arrays,$conn2);
            //get the expenses per term
            $term_expense = getExpenses($term_arrays,$conn2);
            //get all the expenses names
            $all_expenses = getALlExpenseNames($term_expense);
            //get taxes
            $all_taxes = getTaxes($term_arrays,$conn2);
            //term periods 
            $term_per = getTermPeriod($conn2);
            //get the current term period
            $years = date("Y");
            $month_periods  = getPeriods($years,$conn2);
            //create the table now
            //1. start with the table header
            $data_to_display = "<div class='financial_statements'>
                                <div class='finace_headers'>
                                    <div class='conts'><p style='text-align:left;'>Date Generated: ".date("l dS M Y",strtotime("3 hour"))."</p></div>
                                    ".
                                    // <div class='financial_year'><h6>Financial Year <select name='fin_year' id='fin_year'>
                                    //     <option value='2021'>2021</option>
                                    //     <option value='2020'>2020</option>
                                    //     <option value='2019'>2019</option>
                                    //     <option value='2018'>2018</option>
                                    // </select></h6></div>
                                    "<div class='titles '>
                                        <h2 class='fs-16px'>Financial Statements</h2>
                                        <div class='t1'>
                                            <h6 class='fs-12px'>Term One (<small>".date("M-d-Y",strtotime($term_per[0]))." - ".date("M-d-Y",strtotime($term_per[1]))."</small>)</h6>
                                        </div>
                                        <div class='t2'>
                                            <h6 class='fs-12px'>Term two (<small>".date("M-d-Y",strtotime($term_per[2]))." - ".date("M-d-Y",strtotime($term_per[3]))."</small>)</h6>
                                        </div>
                                        <div class='t3'>
                                            <h6 class='fs-12px'>Term Three (<small>".date("M-d-Y",strtotime($term_per[4]))." - ".date("M-d-Y",strtotime($term_per[5]))."</small>)</h6>
                                        </div>
                                    </div>
                                </div>";
            $data_to_display.="<div class='finance_header'>
                <div class='conts'>
                    <h2 class='title_statements fs-16px bg-cadet'>Income Statement</h2>
                </div>
            </div>";
            //the income statement start by displaying the primary Income
            $data_to_display.="<div class='finance_header'>
                                    <p class='title_name'>Primary Income</p>
                                </div>";
            $data_to_display.="<div class='finance_body'>
                                    <p class='name_title'>Operating revenue</p>";
            for ($indes=0; $indes < count($term_income); $indes++) {
                $data_to_display.="<div class='t1'>
                                    <p>Ksh ".comma($term_income[$indes])."</p>
                                </div>";
            }
            $data_to_display.="</div>";
            //end of primary income and start of secondary income even though there is nothing at the moment
            $data_to_display.="<div class='finance_body'>
                                <p class='name_title'>Other Income</p>
                                <div class='t1'>
                                    <p>Ksh 0</p>
                                </div>
                                <div class='t2'>
                                    <p>Ksh 0</p>
                                </div>
                                <div class='t3'>
                                    <p>Ksh 0</p>
                                </div>
                            </div>";
            //total the income
            $data_to_display.="<div class='finance_body_total'>
                                    <p class='name_title'>Total Income</p>";
            for ($indes=0; $indes < count($term_income); $indes++) {
                $data_to_display.="<div class='t1'>
                                    <p>Ksh ".comma($term_income[$indes])."</p>
                                </div>";
            }
            $data_to_display.= "</div>";

            //ENTER THE EXPENSES SECTION
            $data_to_display.="<div class='finance_header'>
                                <p class='title_name'>Expenses</p>
                            </div>";
            //create an array with all the expense array list
            $expenses_val = [];
            for ($index=0; $index <= count($all_expenses); $index++) { 
                if ($index == count($all_expenses)) {
                    $expenses_val["Salaries"] = [];
                    break;
                }else {
                    $expenses_val[$all_expenses[$index]] = [];
                }
            }

            //get values per the period given
            $totalExpenses = [];
            for ($index=0; $index < count($term_expense); $index++) {
                //echo "term ".($index+1)." Size is ".count($term_expense[$index])."<br>";
                $total = 0;
                for ($index1=0; $index1 < count($all_expenses); $index1++) {
                    if (checkPresent($term_expense[$index],$all_expenses[$index1])) {
                        $my_val = getValues($term_expense[$index],$all_expenses[$index1]);
                        //echo "- ".$all_expenses[$index1]." = ".$my_val."<br>";
                        array_push($expenses_val[$all_expenses[$index1]],$my_val);
                        $total+=($my_val*1);
                    }else {
                        //echo "- ".$all_expenses[$index1]." = 0<br>";
                        array_push($expenses_val[$all_expenses[$index1]],0);
                    }
                }
                array_push($totalExpenses,$total);
            }
            

            //add a category called salaries and this includes all the salaries the institution distributes
            $salaries = getSalaryExp($conn2,$term_arrays);
            //ADD THE SALARIES ARRAY TO THE GROUP
            array_push($all_expenses,"Salaries");
            array_push($expenses_val["Salaries"],$salaries[0],$salaries[1],$salaries[2]);
            //add the salaries value to the total value
            for ($intex=0; $intex < count($totalExpenses); $intex++) { 
                $totalExpenses[$intex]+=$salaries[$intex];
            }


            for ($indexes=0; $indexes < count($all_expenses); $indexes++) { 
                $data_to_display.="<div class='finance_body'>
                                        <p class='name_title'>".$all_expenses[$indexes]."</p>
                                        <div class='t1'>
                                            <p>Ksh ".comma($expenses_val[$all_expenses[$indexes]][0])."</p>
                                        </div>
                                        <div class='t2'>
                                            <p>Ksh ".comma($expenses_val[$all_expenses[$indexes]][1])."</p>
                                        </div>
                                        <div class='t3'>
                                            <p>Ksh ".comma($expenses_val[$all_expenses[$indexes]][2])."</p>
                                        </div>
                                    </div>";
            }
            //TOTAL ALL THE EXPENSES
            $data_to_display.="<div class='finance_body_total'>
                                    <p class='name_title'>Total Expenses</p>
                                    <div class='t1'>
                                        <p>Ksh ".comma($totalExpenses[0])."</p>
                                    </div>
                                    <div class='t2'>
                                        <p>Ksh ".comma($totalExpenses[1])."</p>
                                    </div>
                                    <div class='t3'>
                                        <p>Ksh ".comma($totalExpenses[2])."</p>
                                    </div>
                                </div>";
            //CALCULATE EARNINGS BEFORE TAXES
            //deduct term expenses from term income
            $before_taxes = [];
            for ($index=0; $index < count($term_income); $index++) { 
                $befo_taxes = $term_income[$index] - $totalExpenses[$index];
                array_push($before_taxes,$befo_taxes);
            }
            $data_to_display.= "<div class='finance_body'>
                                    <p class='name_title'>Earning before Tax</p>
                                    <div class='t1'>
                                        <p>Ksh ".comma($before_taxes[0])."</p>
                                    </div>
                                    <div class='t2'>
                                        <p>Ksh ".comma($before_taxes[1])."</p>
                                    </div>
                                    <div class='t3'>
                                        <p>Ksh ".comma($before_taxes[2])."</p>
                                    </div>
                                </div>";
            
            
            //GET THE TAXES
            $data_to_display.="<div class='finance_header'>
                                <p class='title_name'>Taxes</p>
                            </div>";

            $data_to_display.="<div class='finance_body'>
                                <p class='name_title'>Taxes</p>
                                <div class='t1'>
                                    <p>Ksh ".comma($all_taxes[0])."</p>
                                </div>
                                <div class='t2'>
                                    <p>Ksh ".comma($all_taxes[1])."</p>
                                </div>
                                <div class='t3'>
                                    <p>Ksh ".comma($all_taxes[2])."</p>
                                </div>
                            </div>";
            //GET THE NET INCOME
            //net income = income before tax - taxes
            $net_income = [];
            for ($index=0; $index < count($all_taxes); $index++) { 
                $netincome = $before_taxes[$index] - $all_taxes[$index];
                array_push($net_income,$netincome);
            }
            $data_to_display.="<div class='finance_body_total'>
                                    <p class='name_title'>Net Income</p>
                                    <div class='t1'>
                                        <p>Ksh ".comma($net_income[0])."</p>
                                    </div>
                                    <div class='t2'>
                                        <p>Ksh ".comma($net_income[1])."</p>
                                    </div>
                                    <div class='t3'>
                                        <p>Ksh ".comma($net_income[2])."</p>
                                    </div>
                                </div>";
            
            $data_to_display.= "</div>";
            echo $data_to_display;

        }elseif (isset($_GET['mystaff'])) {
            $select = "SELECT `fullname`,`user_id` FROM `user_tbl` WHERE `payroll` = 'disabled' AND `school_code` = ?;";
            $stmt = $conn->prepare($select);
            $school_code = $_SESSION['schoolcode'];
            $stmt->bind_param("s",$school_code);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "<p class='red_notice'>No staff present to enroll!</p>";
            if ($result) {
                $data_to_display = "<select class='form-control' name='staff_l' id='staff_l'>
                                        <option value='' hidden>Select staff</option>";
                                        $xs =0;
                while ($row = $result->fetch_assoc()) {
                    $data_to_display.="<option value='".$row['user_id']."'>".$row['fullname']."</option>";
                    $xs++;
                }
                $data_to_display.="</select>";
            }
            echo $data_to_display;
        }elseif (isset($_GET['enroll_payroll'])) {
            $insert = "INSERT INTO `payroll_information` (`staff_id`,`current_balance`,`current_balance_monNyear`,`salary_amount`,`effect_month`,`salary_breakdown`) VALUES (?,?,?,?,?,?)";
            $staff_id = $_GET['staff_id'];
            $salary_amount = $_GET['salary_amount'];
            $effect_year = $_GET['effect_year'];
            $balance = $_GET['balance'];
            $effect_month = $_GET['effect_month'];
            $salary_breakdown = $_GET['salary_breakdown'];
            $monYear = $effect_month.":".$effect_year;
            $present = checkEnrolled($conn2,$staff_id);
            if (!$present) {
                $stmt = $conn2->prepare($insert);
                $stmt->bind_param("ssssss",$staff_id,$balance,$monYear,$salary_amount,$monYear,$salary_breakdown);
                if($stmt->execute()){
                    $update = "UPDATE `user_tbl` SET `payroll` = 'enabled' WHERE `user_id` = ?";
                    $stmt = $conn->prepare($update);
                    $stmt->bind_param("s",$staff_id);
                    if($stmt->execute()){
                        echo "<p class='green_notice'>Staff information uploaded successfully!</p>";
                    }else {
                        echo "<p class='red_notice'>An error occured during update!</p>";
                    }
                }else {
                    echo "<p class='red_notice'>An error occured during update!</p>";
                }
            }else {
                echo "<p class='red_notice'>The user is already enrolled!</p>";
            }
        }elseif (isset($_GET['getEnrolled'])) {
            $select = "SELECT `staff_id`,`payroll_id`,`current_balance`,`current_balance_monNyear`,`salary_amount`,`effect_month` FROM `payroll_information`";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "<table class='table'>
                                    <tr>
                                        <th>No.</th>
                                        <th>Staff Name</th>
                                        <th>Balance</th>
                                        <th>Last Paid</th>
                                        <th>Salary Amount</th>
                                        <th>Options</th>
                                    </tr>";
                                    $xs = 0;
                while ($row = $result->fetch_assoc()) {
                    //get the last one on the list for year and time
                    $xs++;
                    $balance_for = explode(",",$row['current_balance_monNyear']);
                    $month_N_Year = explode(":",$balance_for[(count($balance_for)-1)]);
                    //GET THE LAST ONE ON SALARIES
                    $salary_amount = explode(",",$row['salary_amount']);
                    $curr_salary = $salary_amount[(count($salary_amount)-1)];
                    //
                    $data_to_display.="<tr>
                                            <td>".$xs.". </td>
                                            <td id='namd".$row['staff_id']."'>".getStaffName($conn,$row['staff_id'])."</td>
                                            <td id='salo_balance".$row['staff_id']."'>Kes ".comma($row['current_balance'])."</td><span class='hide' id='salo".$row['staff_id']."'>".$curr_salary."</span>
                                            <td id='lastpay".$row['staff_id']."'>".$month_N_Year[0]." ".$month_N_Year[1]."</td>
                                            <td id='montly_sal".$row['staff_id']."'>Kes ".comma($curr_salary)."</td>
                                            <td '><span  class='edit_salary link'  id = 'stf".$row['staff_id']."' style='font-size:12px;'> <i class='fa fa-pen'></i> Edit</span> / <span class='link view_salos_pay' style='font-size:12px;'  id='viw".$row['staff_id']."'>  <i class='fa fa-eye'></i> View</span> / <span class='link pay_staff_salo' style='font-size:12px';  id='lipa".$row['staff_id']."'>  <i class='fa fa-coins'></i> Pay</span></td>
                                        </tr>";
                }
                $data_to_display.="</table>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<div class='conts' style='margin:auto;width:250px;display:flex;flex-direction:column;align-items:center;'><p class='green_notice' style='text-align:center;'>There are no staff enrolled in the payroll system currently!<br><p class='block_btn enroll_pays' id='enroll_staff_btn'><i class=' fa fa-plus'></i> Enroll staff</p></p>";
                }
            }else {
                echo "<p class='red_notice' style='text-align:center;'>There are no staff enrolled in the payroll system currently!</p>";
            }
        }elseif (isset($_GET['change_salo'])) {
            $id = $_GET['id'];
            $new_amnt = $_GET['new_amnt'];
            $select = "SELECT `salary_amount`,`effect_month` FROM `payroll_information` WHERE `staff_id` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    $str = $row['salary_amount'];
                    $old_period = $row['effect_month'];
                    $mon = date("M",strtotime("3 hour"));
                    $year = date("Y",strtotime("3 hour"));
                    $new_period = $old_period.",".$mon.":".$year;
                    $new_sal = $str.",".$new_amnt;
                    $update = "UPDATE `payroll_information` set `salary_amount` = ?, `effect_month` = ?, `salary_breakdown` = ? WHERE `staff_id` = ?";
                    $stmt = $conn2->prepare($update);
                    $salo_breakdown = $_GET['salo_breakdown'];
                    $stmt->bind_param("ssss",$new_sal,$new_period,$salo_breakdown,$id);
                    if($stmt->execute()){
                        echo "<p class='green_notice'>Update was done successfully!</p>";
                    }else {
                        echo "<p class='red_notice'>An error occured!</p>";
                    }
                }else {
                    echo "<p class='red_notice'>An error occured!</p>";
                }
            }else {
                echo "<p class='red_notice'>An error occured!</p>";
            }
        }elseif (isset($_GET['unenroll_user'])) {
            $update = "DELETE FROM `payroll_information` WHERE `staff_id` = ?";
            $userids = $_GET['userids'];
            $stmt = $conn2->prepare($update);
            $stmt->bind_param("s",$userids);
            if($stmt->execute()){
                $update = "UPDATE `user_tbl` SET `payroll` = 'disabled' WHERE `user_id` = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("s",$userids);
                if($stmt->execute()){
                    echo "<p class='green_notice'>The staff has been successfully un-enrolled!</p>";
                    
                }else {
                    echo "<p class='green_notice'>An error has occured!</p>";
                }
            }else {
                echo "<p class='green_notice'>An error has occured!</p>";
            }
        }elseif (isset($_GET['checkBalance'])) {
            $id = $_GET['ids'];
            $tot = salaryBalanceToBePaid($id,$conn2);
            echo "Kes ".comma($tot);
        }elseif (isset($_GET['salary_details'])) {
            $salary_details = $_GET['salary_details'];
            $select = "SELECT * FROM `payroll_information` WHERE `staff_id` = ?";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$salary_details);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                if($row = $result->fetch_assoc()){
                    $data_to_display = $row['salary_breakdown'];
                }
            }
            echo $data_to_display;
        }
        elseif (isset($_GET['pay_staff'])) {
            //values from the users
            $staff_id = $_GET['staff_id'];
            $mode_of_pay = $_GET['mode_of_pay'];
            $transactioncode = $_GET['transactioncode'];
            $amount = $_GET['amount'];
            $amount_recieved = $amount;
            $staffname = getStaffName($conn,$staff_id);

            //GET THE TOTAL BALANCE
            $data = getTotalBalance($staff_id,$conn2);
            // $total_salo_balance = 0;
            // $$total_salo_balance = getTotalSalaryBalance($data);


            //get the difference in time from the last time paid to today
            $dates = explode(":",$data[1]);
            $dated = date("Y-m",strtotime($dates[1]."-".$dates[0]."-01"));
            //echo $dated;
            $year = date("Y",strtotime("3 hour"));
            $month = date("m",strtotime("3 hour"));
            $today = date("Y-m",strtotime($year."-".$month."-01"));
            //echo $today;
            //difference in months
            $lastdate = date_create($dated);
            $todaydate = date_create($today);
            $date_diff = date_diff($lastdate,$todaydate);
            $months_back = $date_diff->format("%R%m");

            //fill the data to be found in the table
            $last_paid_time = $data[1];
            $salo_balance = $data[0];
            $salary_bal = $data[0];
            $xs = 0;
            if ($salo_balance>$amount) {
                $salo_balance = $data[0] - $amount;
            }elseif ($salo_balance == $amount) {

                //get the salry index - this is where the current payment stands
                $salary_index = getSalaryIndex($data[1],$data[2],$data[3]);
                //we need to get the amount has been paid until what month
                $payplan = getPayPlan($data[1],$salary_index,$data[2],$data[3]);
                $current_salo = 0;
                for ($indexes=0; $indexes < count($payplan); $indexes++) { 
                    $split_data = explode(":",$payplan[$indexes]);
                    if ($split_data[1] > 1) {
                        $current_salo = $split_data[0];
                        break;
                    }
                }
                if ($current_salo == 0) {
                    $current_salo = getCurrentSalo($data[2]);
                }
                $salo_balance = $current_salo;
                $xs++;
            }else {
                //get the salry index - this is where the current payment stands
                $salary_index = getSalaryIndex($data[1],$data[2],$data[3]);
                //we need to get the amount has been paid until what month
                $payplan = getPayPlan($data[1],$salary_index,$data[2],$data[3]);
                //get the number of months the payment has been done
                $amount-=$salo_balance;
                for ($index=0; $index < count($payplan); $index++) {
                    $string_data = explode(":",$payplan[$index]);
                    $salary = $string_data[0];
                    $times = $string_data[1];
                    for ($index1=0; $index1 < $times; $index1++) {
                        //for the first month deduct the salary balance
                        if ($amount == 0) {
                            $salo_balance = $salary;
                            break;
                        }
                        if ($salary > $amount) {
                            $salo_balance = $salary - $amount;
                            if ($xs <= 0) {
                                $xs++;
                            }
                            break;
                        }
                        //sawa
                        if ($index == 0 && $index1 == 0) {
                            $xs++;
                            continue;
                        }else {
                            $amount-=$salary;
                        }
                        $xs++;
                    }
                }
            }
            $data_to_display = "<p>";
            //if the months gone are equal to the number of months present
            $next_pay_month = $dated;
            if ($xs == $months_back && $salo_balance == $salary_bal) {
                $dated = date("Y-m-d",strtotime("3 hour"));
                if ($amount == 0 ) {
                    //get the balance
                    $salo_balance = 0;
                    //get the months
                    $xs = 1;
                    $next_pay_month = addMonthTOdate($dated,$xs);
                    $data_to_display.="No arrears.<br>Next payments for <b>".$staffname."</b> will be done on <b>".date("M-Y",strtotime($next_pay_month))."</b> of Kes <b>".comma(getCurrentSalo($data[2]))."</b>";
                }else {
                    $current_salo = getCurrentSalo($data[2]);
                    $remain = $amount%$current_salo;
                    $monthsgone = intdiv($amount,$current_salo);
                    $salo_balance = $current_salo - $remain;
                    if ($remain > 0) {
                        $next_pay_month = addMonthTOdate($dated,$monthsgone);
                    }else {
                        $next_pay_month = addMonthTOdate($dated,$monthsgone);
                    }
                    $data_to_display.="<b>".$staffname."</b> will recieve an advance Payment of <b>Kes ".comma($amount)."</b><br>The amount will be equally distributed untill <b>".date("M-Y",strtotime($next_pay_month))."</b> and a balance of <b>Kes ".comma($salo_balance)."</b> will remain.";
                }
            }elseif ($xs <= $months_back) {
                if ($xs == 0) {
                    //echo "<br>You owe the staff ".$salo_balance." for ".$next_pay_month." paid him";
                    $data_to_display.="Salary arrears for <b>".$staffname."</b> is<br> : Kes <b>".comma($salo_balance)."</b> for <b>".date("M-Y",strtotime($next_pay_month))."</b>.";
                }else {
                    $next_pay_month = addMonthTOdate($dated,$xs);
                    //echo "<br>You owe the staff ksh ".$salo_balance." and its ".$next_pay_month." from last paid";
                    $data_to_display.="Salary arrears for <b>".$staffname."</b> is <br>: Kes <b>".comma($salo_balance)."</b> for <b>".date("M-Y",strtotime($next_pay_month))."</b>.";
                }
            }
            /**
             * what is needed
             * salary balance done
             * next pay month
             */
            $data_to_display."</p>";
            echo $data_to_display;
            $months = date("M",strtotime($next_pay_month));
            $yrs = date("Y",strtotime($next_pay_month));
            $next_pay = $months.":".$yrs;
            $update = "UPDATE `payroll_information` SET `current_balance` = ?,`current_balance_monNyear` = ? WHERE `staff_id` = ?";
            $stmt = $conn2->prepare($update);
            $stmt->bind_param("sss",$salo_balance,$next_pay,$staff_id);
            if($stmt->execute()){
                //insert the payments
                $insert = "INSERT INTO `salary_payment` (`staff_paid`,`amount_paid`,`mode_of_payment`,`payment_code`,`date_paid`,`time_paid`) VALUES (?,?,?,?,?,?)";
                $stmt = $conn2->prepare($insert);
                $dates = date("Y-m-d",strtotime("3 hour"));
                $time = date("H:i:s",strtotime("3 hour"));
                $stmt->bind_param("ssssss",$staff_id,$amount_recieved,$mode_of_pay,$transactioncode,$dates,$time);
                if($stmt->execute()){
                    echo "<p class='green_notice'>Payments successfully done</p>";
                }else {
                    echo "<p class='red_notice'>An error has occured!<br>Try again later!</p>";
                }
            }else {
                echo "<p class='red_notice'>An error has occured!<br>Try again later!</p>";
            }
        }elseif (isset($_GET['get_expenses'])) {
            $years = $_GET['years'];
            $months = $_GET['months'];
            $startdate = date("Y-m-d",strtotime($years."-".$months."-01"));
            $enddate = date("Y-m-d",strtotime($years."-".$months."-31"));
            $select = "SELECT `exp_category`, sum(`exp_amount`) as 'Total', COUNT(`exp_category`) AS 'Record' FROM `expenses` WHERE `expense_date` BETWEEN ? AND ? GROUP BY `exp_category`;";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("ss",$startdate,$enddate);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $xs = 0;
                $data_to_display = "<hr><div class='modepayChartHolder' style='width:400px;height:400px;margin:auto;'><canvas id='expense-charts-in' width = '200px' height='200px'></canvas></div><h2 style='text-align:center;' id='title-charts'>Expenses for ".date("M-Y",strtotime($startdate))."</h2><table class='table'>
                                    <tr>
                                        <th>No.</th>
                                        <th>Expense Category</th>
                                        <th>Amount</th>
                                        <th>Record(s)</th>
                                    </tr>";
                                    $myjson = "{";
                while ($row = $result->fetch_assoc()) {
                    $xs++;
                    $data_to_display.="<tr>
                                        <td>".$xs." .</td>
                                        <td>".$row['exp_category']."</td>
                                        <td>Kes ".comma($row['Total'])."</td>
                                        <td>".$row['Record']."</td>
                                    </tr>";
                    $myjson.="\"".$row['exp_category']."\":\"".$row['Total']."\",";
                }
                $myjson = substr($myjson,0,strlen($myjson)-1);
                $myjson.="}";
                $data_to_display.="</table><p class='hide' id='table_values'>$myjson</p>";
                if ($xs > 0) {
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No records found for ".date("M - Y",strtotime($startdate))." !</p>";
                }
            }
        }elseif (isset($_GET['view_salo_history'])) {
            $staff_id = $_GET['staff_id'];
            $curr_year = $_GET['curr_year'];
            //get all the amount the staff has been paid as salo
            $total_salo = getTotalSalo($conn2,$staff_id);
            //get the first month staff was paid
            $firstpay_record = getFirstPayDate($conn2,$staff_id);
            $current_bal = getCurrentBalTime($conn2,$staff_id);
            $lasttimepaid = explode(",",$current_bal);
            $times = explode(":",$firstpay_record);
            $firstpay_dated = date("Y-m-d",strtotime("01-".$times[0]."-".$times[1]));
            // echo $firstpay_dated;
            //create the years date array
            $date_array = [];
            for ($index=0; $index < 12; $index++) { 
                $month = "0".($index+1);
                if ($index+1 > 9) {
                    $month = ($index+1);
                }
                $date = $curr_year."-".$month."-01";
                array_push($date_array,$date);
            }

            // $times[0];
            $first_pay_amount = getFirstPaymentAmount($conn2,$staff_id);
            // echo $first_pay_amount;
            $salaries = [];//get the salary for the months with this salary array
            //loop through time and get the salary for each month
            for ($index=0; $index < count($date_array); $index++) { 
                //if the first month the staff was paid is greater than the date the salary is unknown and no cash is paid
                $date_record = date("Y-m-d",strtotime($date_array[$index]));
                if ($date_record >= $firstpay_dated) {
                    $salares = getSalary($date_record,$conn2,$staff_id,$first_pay_amount);
                    array_push($salaries,$salares);
                }else {
                    array_push($salaries,"0");
                }
            }
            $payment_history = [];
            //get the current month its been paid
            $sikus = explode(":",$lasttimepaid[0]);

            $lastmonthpaid = date("Y-m-d",strtotime("01-".$sikus[0]."-".$sikus[1]));
            //go into date array and get the payments as they are
            $total_paid = 0;
            $last_pay_amount = 0;
            $last_salary_index = 11;
            $first_salary_index = 13;
            $months_present = [];
            for ($index=0; $index < count($salaries); $index++) { 
                //if the date is between the first time paid and the last
                $balance = 0;
                if ($date_array[$index] >   $firstpay_dated) {
                    if ( $date_array[$index] < $lastmonthpaid) {
                        $total_paid+=($salaries[$index]*1);
                        if (!checkIN($months_present,$index)) {
                            array_push($months_present,$index);
                        }
                    }
                }
                if ($date_array[$index] == $lastmonthpaid) {
                    $last_salary_index = $index;
                    if (!checkIN($months_present,$index)) {
                        array_push($months_present,$index);
                    }
                    // echo $first_salary_index;
                }
                if ($date_array[$index] == $firstpay_dated) {
                    $first_salary_index = $index;
                    if (!checkIN($months_present,$index)) {
                        array_push($months_present,$index);
                    }
                }
            }
            // echo $date_array[$last_salary_index];
            //get the amount paid on the last month
            $last_balance = $salaries[$last_salary_index] - $lasttimepaid[1];
            if ($last_salary_index == 11) {
                if($lastmonthpaid != $date_array[$last_salary_index]){
                    // $lasttimepaid[1] = getSalary($lastmonthpaid,$conn2,$staff_id);
                }
            }
            // echo $lasttimepaid[1]." last";
            if ($total_salo > 0) {
                if ($first_salary_index == $last_salary_index) {
                    //if ($salaries[$last_salary_index] > $total_salo) {
                        $balance = $lasttimepaid[1];
                        $last_pay_amount = $total_salo;
                    // }else {
                    //     echo $total_paid;
                    // }
                }else {
                    $balance = $salaries[$last_salary_index]-$lasttimepaid[1];
                    $total_paid+=$balance;
                    $last_pay_amount = $balance;
                    //get the amount paid on the first month
                    $total_paid+=$first_pay_amount;
                }
            }

            $monthly_salary_breakdown = getPaymentBreakdown($conn2,$staff_id,$first_pay_amount,$firstpay_record);
            // var_dump($monthly_salary_breakdown);
            // echo $first_pay_amount." first pay ";
            //GET THE PAYMENT DETAILS
            $select = "SELECT `pay_id`,`staff_paid`,`amount_paid`,`mode_of_payment`,`payment_code`,`date_paid`,`time_paid` FROM `salary_payment` WHERE `staff_paid` = ? ORDER BY `pay_id` DESC;";
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$staff_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $count_total = 0;
            $details = [];
            $mode_of_payment = [];
            $amount_paid = [];
            $payment_code = [];
            $date_paid = [];
            $time_paid = [];
            if ($result) {
                while($row = $result->fetch_assoc()){
                    if ($count_total >= $total_salo) {
                        break;
                    }
                    $count_total += ($row['amount_paid']*1);
                    array_push($amount_paid,$row['amount_paid']);
                    array_push($mode_of_payment,$row['mode_of_payment']);
                    array_push($payment_code,$row['payment_code']);
                    array_push($date_paid,$row['date_paid']);
                    array_push($time_paid,$row['time_paid']);
                }
            }
            array_push($details,$amount_paid,$mode_of_payment,$payment_code,$date_paid,$time_paid);
            //go through the data and deduct the amount from the last amount
            $details_fin = [];
            $payments_list = [];
            //last payment
            $middle_amounts = 0;
            //echo $last_pay_amount;
            //get the amount paid in every month
            if (count($details[0]) > 0) {
                $next_month_amount = 0;
                $starting_index = 0;
                for ($index=count($salaries); $index > 0; $index--) {
                    $ind = $index - 1;
                    if (checkIN($months_present,$ind)) {
                        //store the salary as an integer
                        $my_salo = $salaries[$ind];
                        //know if its the last or the first month
                        if ($first_salary_index != $last_salary_index) {
                            // echo "<p> Paid ".$last_pay_amount." ".$ind."</p>";
                            $my_salo = $last_pay_amount;
                            if ($last_salary_index == $ind) {
                                if ($last_salary_index == 11) {
                                    if($lastmonthpaid != $date_array[$last_salary_index]){
                                        // echo "<p> Paid  ".$last_pay_amount." ".$ind."</p>";
                                        $last_pay_amount = getSalary($lastmonthpaid,$conn2,$staff_id);
                                        $my_salo = $last_pay_amount;
                                    }
                                }
                                //for the last month get the amount paid deduct it from the payments plan
                            }
    
                            //know how much was paid on the first salary
                            if ($first_salary_index == $ind) {
                                // echo "<p> Paid ".$first_pay_amount."</p>";
                                $my_salo = $first_pay_amount;
                            } 
                        }else {
                            if ($last_salary_index == $ind) {
                                // echo "<p> Paid ".$last_pay_amount."</p>";
                                $my_salo = $last_pay_amount+$lasttimepaid[1];
                                if ($last_salary_index == 11) {
                                    if($lastmonthpaid != $date_array[$last_salary_index]){
                                        // echo "<p> Paid 2 ".$last_pay_amount." ".$ind."</p>";
                                        $last_pay_amount = getSalary($lastmonthpaid,$conn2,$staff_id);
                                        $my_salo = $last_pay_amount;
                                    }
                                }
                                //for the last month get the amount paid deduct it from the payments plan
                            }
                        }
                        // check if my salo is the first month
                        $curr_date = date("Y-m-d", strtotime("01-".($index)."-".$curr_year));
                        if ($curr_date == $firstpay_dated) {
                            $my_salo = $first_pay_amount;
                        }
                        $myname = $my_salo;
                        $counted = 0;
                        //after getting the respective salary start deducting the amounts where neccesary
                        for ($index3=$starting_index; $index3 < count($details[0]); $index3++) {
                            $index2 = $index3;
                            // echo "<p>".$index2." My next month ".$next_month_amount." My salo ".$my_salo." ".$counted."</p>"."";
                            $counted++;
                            if ($my_salo == 0) {
                                break;
                            }
                            if ($next_month_amount > 0) {
                                if ($my_salo > $next_month_amount) {
                                    $my_salo-=$next_month_amount;
                                    $stringdata = "<p>-Kes ".comma($next_month_amount)." ".payMode($details[1][$index2])."  (".date("d-M-Y",strtotime($details[3][$index2])).") </p>";
                                    array_push($payments_list,$stringdata);
                                    $next_month_amount = 0;
                                    continue;
                                }elseif ($my_salo <= $next_month_amount) {
                                    $remain_salo = $next_month_amount-$my_salo;
                                    $next_month_amount = $remain_salo;
                                    $starting_index = $index2;
                                    $stringdata = "<p>-Kes ".comma($my_salo)." ".payMode($details[1][$index2])." (".date("d-M-Y",strtotime($details[3][$index2])).") </p>";
                                    array_push($payments_list,$stringdata);
                                    $my_salo = 0;
                                    break;
                                }
                            }
                            if ($next_month_amount == 0) {
                                if ($my_salo > $details[0][$index2]) {
                                    $my_salo-=$details[0][$index2];
                                    $stringdata = "<p>-Kes ".comma($details[0][$index2])." ".payMode($details[1][$index2])." (".date("d-M-Y",strtotime($details[3][$index2])).") </p>";
                                    array_push($payments_list,$stringdata);
                                    $next_month_amount = 0;
                                    continue;
                                }elseif ($my_salo <= $details[0][$index2]) {
                                    $remain_salo = $details[0][$index2]-$my_salo;
                                    $next_month_amount = $remain_salo;
                                    $starting_index = $index2;
                                    $stringdata = "<p>-Kes ".comma($my_salo)." ".payMode($details[1][$index2])." (".date("d-M-Y",strtotime($details[3][$index2])).") </p>";
                                    array_push($payments_list,$stringdata);
                                    $my_salo = 0;
                                    break;
                                }
                            }
                        }
                    }
                    array_push($details_fin,$payments_list);
                    $payments_list = [];
                }
                $counted = count($details_fin);
                //echo "<p class='red_notice'>$counted</p>";
            }

            //if the current year is less than the given year we display the else code
            if ($times[1] <= $curr_year) {
                //get the first time the staff was paid
                if ($total_salo > 0) {
                    $data_to_display = "";
                    $data_to_display.="
                    <div class='conts' style='margin:10px 0;'>
                        <p class='embold'>Staff name: <span class='color_brown'>".getStaffName($conn,$staff_id)."</span></p>
                        <p class='embold'>Year : <span class='color_brown'>$curr_year</span></p>
                        <p class='embold'>Total salary paid: <span class='color_brown'>Kes ".comma($total_salo)."</span></p>
                    </div><div class='my_salo-flexbox'>";
                    //rearrange the data
                    $details_fin2 = [];
                    for ($index = count($details_fin); $index > 0; $index--) {
                        $intd = $index-1;
                        array_push($details_fin2,$details_fin[$intd]);
                    }
                    //display the information now
                    for ($index=0; $index < count($salaries); $index++) {
                        $dating = "01-".($index+1)."-".$curr_year;
                        $array_key = date("M - Y",strtotime($dating));
                        $fund_details = "";
                        $this_salary = isset($monthly_salary_breakdown[$array_key]) ? $monthly_salary_breakdown[$array_key]:[0];

                        // MAKE UPDATES HERE SO THAT IT MAY SHOW THE PAYMENT BREAKDOWN
                        // var_dump($this_salary[0] > 0);
                        if($this_salary[0] > 1){
                            for ($indx=0; $indx < count($this_salary); $indx++) {
                                $fund_details .= $this_salary[$indx];
                            }
                            // $fund_details = $this_salary[0];
                        }else{
                            $fund_details = "<p class='green_notice'> No records found!</p>";
                        }
                        $balance = 0;
                        $amount_paid = $salaries[$index];
                        if ($first_salary_index == $last_salary_index) {
                            $amount_paid = $last_pay_amount;
                            $balance = $lasttimepaid[1];
                            if (count($details_fin2[$index]) <= 0) {
                                $amount_paid = 0;
                                $balance = 0;
                            }
                        }else {
                            if ($first_salary_index == $index) {
                                $amount_paid = $first_pay_amount;
                                $salaries[$index] = $amount_paid;
                            }
                            if (count($details_fin2[$index]) <= 0) {
                                $amount_paid = 0;
                            }
                            if ($last_salary_index == $index) {
                                $amount_paid = $last_pay_amount;
                                $balance = $salaries[$index] - $amount_paid;
                            }
                        }
                        // echo "Amount already paid ".$amount_paid." Balance ".$balance."<br>";
                        $data_to_display.="
                                    <div class='year_card'>
                                        <div class='margin-bottom-5px width_100per bordered_bottom'>
                                            <p class='embold'>Month: <span class='color_brown'>".date("M - Y",strtotime($dating))."</span></p>
                                        </div>
                                        <div class='salary-amount bordered_bottom'>
                                            <p class='embold'>Salary : <span class='color_brown'> Kes ".comma($salaries[$index])."</span></p>
                                        </div>
                                        <div class='payments-details'>".$fund_details."</div>
                                        <div class='total_payments'>
                                            <p class='embold'>Total paid: <span class='color_brown'> Kes ".comma($amount_paid)."</span></p>
                                            <p class='embold'>Balance : <span class='color_brown'>Kes ".comma($balance)."</span></p>
                                        </div>
                                    </div>
                        ";
                    }
                    $data_to_display.="</div>";
                    echo $data_to_display;
                }else {
                    echo "<p class='red_notice'>No records found for this year for ".getStaffName($conn,$staff_id)."</p>";
                }
            }else {
                echo "<p class='red_notice'>No records found because the staff first payment was recorded in ".$firstpay_record." and the current selected year is ".$curr_year.".</p>";
            }
        }elseif (isset($_GET['mpesaTransaction'])) {
            $select = "SELECT `transaction_id`,`mpesa_id`,`amount`,`std_adm`,`transaction_time`,`short_code`,`payment_number`,`fullname`,`transaction_status` FROM `mpesa_transactions` ORDER BY transaction_id DESC;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $data_to_display = "";
                while ($row = $result->fetch_assoc()) {
                    $paymentDate = $row['transaction_time'];
                    $year = substr($paymentDate, 0, 4);
                    $month = substr($paymentDate, 4, 2);
                    $day = substr($paymentDate, 6, 2);
                    $hour = substr($paymentDate, 8, 2);
                    $min = substr($paymentDate, 10, 2);
                    $sec = substr($paymentDate, 12, 2);
                    $d = mktime($hour, $min, $sec, $month, $day, $year);
                    $transactionDate =  date("D-dS-M-Y  h.i.s A", $d);
                    $data_to_display.=$row['mpesa_id'].":".$row['amount'].":".getName1($row['std_adm'])." (".$row['std_adm']."):".$transactionDate.":".$row['short_code'].":".$row['payment_number'].":".$row['fullname'].":".$row['transaction_status'].":".$row['transaction_id']."|";
                }
                $data_to_display = substr($data_to_display,0,(strlen($data_to_display)-1));
                echo $data_to_display;
            }
        }elseif (isset($_GET['mpesa_transaction_id'])) {
            $select = "SELECT `transaction_id`,`mpesa_id`,`amount`,`std_adm`,`transaction_time`,`short_code`,`payment_number`,`fullname`,`transaction_status` FROM `mpesa_transactions` WHERE `transaction_id` = ?";
            $mpesa_transaction_id = $_GET['mpesa_transaction_id'];
            $stmt = $conn2->prepare($select);
            $stmt->bind_param("s",$mpesa_transaction_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                if ($row = $result->fetch_assoc()) {
                    // panga the user data
                    $paymentDate = $row['transaction_time'];
                    $year = substr($paymentDate, 0, 4);
                    $month = substr($paymentDate, 4, 2);
                    $day = substr($paymentDate, 6, 2);
                    $hour = substr($paymentDate, 8, 2);
                    $min = substr($paymentDate, 10, 2);
                    $sec = substr($paymentDate, 12, 2);
                    $d = mktime($hour, $min, $sec, $month, $day, $year);
                    $transactionDate =  date("D-dS-M-Y  h.i.s A", $d);
                    $mpesa_data =$row['transaction_id'].":".$row['mpesa_id'].":".$row['amount'].":".$row['std_adm'].":".$transactionDate.":".$row['short_code'].":".$row['payment_number'].":".$row['fullname'].":".$row['transaction_status'];
                    echo $mpesa_data;
                }
            }
        }elseif (isset($_GET['getstudentdetails'])) {
            // get the students data
            $select = "SELECT * FROM `student_data` WHERE `deleted` = 0;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $data_to_display = "";
            if ($result) {
                while($row = $result->fetch_assoc()){
                    $first_name = $row['first_name'];
                    $second_name = $row['second_name'];
                    $surname = $row['surname'];
                    $stud_class = $row['stud_class'];
                    $adm_no = $row['adm_no'];
                    $data_to_display.=$first_name.":".$second_name.":".$surname.":".$adm_no.":".className($stud_class)."|";
                }
                $data_to_display = substr($data_to_display,0,(strlen($data_to_display)-1));
            }
            echo $data_to_display;
        }elseif (isset($_GET['getdrivers'])) {
            // get the user ids that have been used in the school van section
            $select = "SELECT `driver_name` FROM `school_vans`;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $driver_ids = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    array_push($driver_ids,$row['driver_name']);
                }
            }
            // var_dump($driver_ids);
            $select = "SELECT * FROM `user_tbl` WHERE `auth` = 6 AND `school_code` = ?";
            $stmt = $conn->prepare($select);
            $school_code = $_SESSION['schoolcode'];
            $stmt->bind_param("s",$school_code);
            $stmt->execute();
            $result = $stmt->get_result();
            $driver_list = "<select name='van_driver' id='van_driver' class='form-control'><option value='' hidden>Select a driver.</option>";
            $driver_count = 0;
            if($result){
                while ($row = $result->fetch_assoc()) {
                    $present = 0;
                    for ($i=0; $i < count($driver_ids); $i++) { 
                        if (trim($driver_ids[$i]) == trim($row['user_id'])) {
                            $present = 1;
                            break;
                        }
                    }
                    if ($present == 0) {
                        $driver_list.= "<option value = '".$row['user_id']."' >".$row['fullname'].".</option>";
                        $driver_count++;
                    }
                }
            }
            $driver_list .= "</select>";
            if ($driver_count != 0) {
                echo $driver_list;
            }else {
                echo "<p class='text-danger text-xxs'>No drivers present in the school at the moment!</p>";
            }
        }elseif (isset($_GET['getdrivers_update'])) {
            // get the user ids that have been used in the school van section
            $select = "SELECT `driver_name` FROM `school_vans`;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $driver_ids = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    array_push($driver_ids,$row['driver_name']);
                }
            }
            // var_dump($driver_ids);
            $select = "SELECT * FROM `user_tbl` WHERE `auth` = 6 AND `school_code` = ?";
            $stmt = $conn->prepare($select);
            $school_code = $_SESSION['schoolcode'];
            $stmt->bind_param("s",$school_code);
            $stmt->execute();
            $result = $stmt->get_result();
            $driver_list = "<select style='width:100%;' name='van_driver' id='van_driver_up' class='form-control'><option value='' hidden>Select a driver.</option>";
            $driver_count = 0;
            if($result){
                while ($row = $result->fetch_assoc()) {
                    $present = 0;
                    for ($i=0; $i < count($driver_ids); $i++) { 
                        if (trim($driver_ids[$i]) == trim($row['user_id'])) {
                            $present = 1;
                            break;
                        }
                    }
                    if ($present == 0) {
                        $driver_list.= "<option value = '".$row['user_id']."' >".$row['fullname'].".</option>";
                        $driver_count++;
                    }
                }
            }
            $driver_list .= "</select>";
            if ($driver_count != 0) {
                echo $driver_list;
            }else {
                echo "<p class='text-danger text-xxs'>No drivers present in the school at the moment!</p>";
            }
        }
        elseif (isset($_GET['getRoutes'])) {
            $select = "SELECT * FROM `van_routes`;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $route_counts = 0;
            $route_list = "<select style='width:100%;' name='routed_lists' id='routed_lists' class='form-control'><option value='' hidden>Select a Route.</option>";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $route_list.= "<option value = '".$row['route_id']."' > ".$row['route_name'].".</option>";
                    $route_counts++;
                }
            }
            $route_list .= "</select>";
            if ($route_counts > 0) {
                echo $route_list;
            }else {
                echo "<p  class='text-danger text-xxs'>No routes registered in the school at the moment. Register routes in order to proceed!</p>";
            }
        }
        elseif (isset($_GET['getRoutes_update'])) {
            $select = "SELECT * FROM `van_routes`;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $route_counts = 0;
            $route_list = "<select name='routed_lists' style='width:100%;' id='routed_lists_inside' class='form-control'><option value='' hidden>Select a Route.</option>";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $route_list.= "<option value = '".$row['route_id']."' > ".$row['route_name'].".</option>";
                    $route_counts++;
                }
            }
            $route_list .= "</select>";
            if ($route_counts > 0) {
                echo $route_list;
            }else {
                echo "<p class='text-danger text-xxs'>No routes registered in the school at the moment. Register routes in order to proceed!</p>";
            }
        }elseif(isset($_GET['getRoutes_enroll_trans'])){
            $select = "SELECT * FROM `van_routes`;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $route_counts = 0;
            $route_list = "<select name='routed_lists' id='enroll_studs_routes' style='width:100%;' class='form-control'><option value='' hidden>Select a Route.</option>";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $route_list.= "<option value = '".$row['route_id']."' > ".$row['route_name']." (Kes ".$row['route_price'].").</option>";
                    $route_counts++;
                }
            }
            $route_list .= "</select>";
            if ($route_counts > 0) {
                echo $route_list;
            }else {
                echo "<p class='text-danger text-xxs'>No routes registered in the school at the moment. Register routes in order to proceed!</p>";
            }
        }elseif(isset($_GET['getroute_view_information'])){
            $select = "SELECT * FROM `van_routes`;";
            $stmt = $conn2->prepare($select);
            $stmt->execute();
            $result = $stmt->get_result();
            $route_counts = 0;
            $route_list = "<select name='routed_lists' id='update_studs_routes' style='width:100%;' class='form-control'><option value='' hidden>Select a Route.</option>";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $route_list.= "<option value = '".$row['route_id']."' > ".$row['route_name']." (Kes ".$row['route_price'].").</option>";
                    $route_counts++;
                }
            }
            $route_list .= "</select>";
            if ($route_counts > 0) {
                echo $route_list;
            }else {
                echo "<p class='text-danger text-xxs'>No routes registered in the school at the moment. Register routes in order to proceed!</p>";
            }
        }

        //CLOSE ALL CONNECTION
        // if ($conn2) {
        //     $conn2->close();
        // }
        // if ($conn) {
        //     $conn->close();
        // }
    }
    function getSalaryExp($conn2,$term_period){
        $select = "SELECT SUM(`amount_paid`) AS 'Total' FROM `salary_payment` WHERE `date_paid` BETWEEN ? AND ?;";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$term_period[0],$term_period[1]);
        $stmt->execute();
        $result = $stmt->get_result();
        $salaries = [];
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if (isset($row['Total'])) {
                    array_push($salaries,$row['Total']);
                }else {
                    array_push($salaries,"0");
                }
            }
        }
        $stmt->bind_param("ss",$term_period[2],$term_period[3]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if (isset($row['Total'])) {
                    array_push($salaries,$row['Total']);
                }else {
                    array_push($salaries,"0");
                }
            }
        }
        $stmt->bind_param("ss",$term_period[4],$term_period[5]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if (isset($row['Total'])) {
                    array_push($salaries,$row['Total']);
                }else {
                    array_push($salaries,"0");
                }
            }
        }
        return $salaries;
    }

    function payMode($value){
        if ($value == "bank") {
            return "<span class='green_notice'>-b</span>";
        }elseif ($value == "cash") {
            return "<span class='green_notice'>-c</span>";
        }elseif ($value == "m-pesa") {
            return "<span class='green_notice'>-m</span>";
        }else {
            return "<span class='green_notice'>-u</span>";
        }
    }
    function checkIN($array,$element){
        if (count($array) > 0) {
            for ($index=0; $index < count($array); $index++) { 
                if ($array[$index] == $element) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    function getSalary($dates,$conn2,$staff_id,$first_salary = -1){
        $first_pay = getFirstPayDate($conn2,$staff_id);
        $select = "SELECT `effect_month`, `salary_amount` FROM `payroll_information` WHERE `staff_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $times = "";
        $salary = "";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $times = $row['effect_month'];
                $salary = $row['salary_amount'];
            }
        }
        $f_date = explode(":",$first_pay);
        $f_d_date = date("Y-m-d",strtotime("01-".$f_date[0]."-".$f_date[1]));
        if ($f_d_date == $dates && $first_salary != -1) {
            // echo $first_salary." ".$f_d_date;
            return $first_salary;
        }
        if (isset($times) && strlen($times) > 0) {
            $time_divide = explode(",",$times);
            if (count($time_divide) == 1) {
                return $salary;
            }elseif (count($time_divide) > 1) {
                $exploded_salo = explode(",",$salary);
                for ($index=0; $index < count($time_divide); $index++) {
                    $epl_time = explode(":",$time_divide[$index]);
                    if ($index+1 < count($time_divide)) {
                        $nextMonth = explode(":",$time_divide[$index+1]);
                    }else {
                        $count = count($exploded_salo);
                        return $exploded_salo[$count-1];
                        break;
                    }
                    $date_now = date("Y-m-d",strtotime("01-".$epl_time[0]."-".$epl_time[1]));
                    $next_mon = date("Y-m-d",strtotime("01-".$nextMonth[0]."-".$nextMonth[1]));
                    if ($dates >=$date_now && $dates<$next_mon) {
                        return $exploded_salo[$index];
                        break;
                    }
                }
            }
        }else {
            return 0;
        }
    }

    function getCurrentBalTime($conn2,$staff_id){
        $select = "SELECT `current_balance_monNyear`,`current_balance` FROM `payroll_information` WHERE `staff_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data_return = "";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $data_return = "0,0";
                if (isset($row['current_balance_monNyear'])) {
                    $data_return = $row['current_balance_monNyear'].",".$row['current_balance'];
                }
            }else {
                $data_return = 0;
            }
        }
        return $data_return;
    }

    function getFirstPayDate($conn2,$staff_id){
        $select = "SELECT `effect_month` FROM `payroll_information` WHERE `staff_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $first_month = "";
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $first_month = $row['effect_month'];
            }
        }
        if (strlen($first_month) > 0) {
            $divide_mon = explode(",",$first_month);
            $first_month = $divide_mon[0];
        }
        return $first_month;
    }

    function getTotalSalo($conn2,$staff_id){
        $select = "SELECT SUM(`amount_paid`) AS 'Total' FROM `salary_payment` WHERE `staff_paid` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $total_salo = 0;
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if (isset($row['Total'])) {
                    $total_salo = $row['Total'];
                }else {
                    $total_salo = 0;
                }
            }
        }
        return $total_salo;
    }

    function salaryBalanceToBePaid($id,$conn2){
        $data = getTotalBalance($id,$conn2);
        $tot = getTotalSalaryBalance($data);
        return $tot;
    }
    function addMonthTOdate($date,$months){
        $dated = date_create($date);
        $times = $months." months";
        date_add($dated, date_interval_create_from_date_string($times));
        return date_format($dated, 'Y-m-d');
    }

    function getCurrentSalo($data){
        $mysalo = explode(",",$data);
        $counted = count($mysalo);
        $current_salo = $mysalo[$counted-1];
        return $current_salo;
    }
    function getBalanceOfAdvancement($salary,$exceed){
        $remainder = $exceed%$salary;
        return $remainder;
    }

    function getTotalSalaryBalance($data){
        //check where the last balance falls into what salary category
        // array_push($data,$row['current_balance'],$row['current_balance_monNyear'],$row['salary_amount'],$row['effect_month']);
        // date=0 = current balance amount for the single month
        // date=1 = where the current balance is at (month and year)
        // date=2 = salary amount, what he is to be paid monthly
        // date=3 = when the payment of the client was first recorded
        if (count($data) > 0) {
            $salary_evo = $data[3];
            $salary_index = getSalaryIndex($data[1],$data[2],$salary_evo);
            //get how manytime its going to be paid
            $payPlan = getPayPlan($data[1],$salary_index,$data[2],$data[3]);
            //after getting plan calculate the balance
            $sum_total = 0;
            for ($payind=0; $payind < count($payPlan); $payind++) { 
                $salo_times = explode(":",$payPlan[$payind]);
                $product=($salo_times[1]*$salo_times[0]);
                $sum_total+=$product;
            }
            //split salary
            $salarysplit = explode(",",$data[2]);
            $salarytodeduct = $salarysplit[$salary_index];
            //deduct the salary amount from the total and add the last balance
            $salary_total = ($sum_total-$salarytodeduct) + ($data[0] * 1);

            return $salary_total;
        }
        return 0;
    }

    function getPayPlan($last_paid,$salary_index,$salary_list,$effect_month){
        $salary_arr = explode(",",$salary_list);
        $lastpay = explode(":",$last_paid);
        $last_paids = date("Y-m-d",strtotime("01-".$lastpay[0]."-".$lastpay[1]));
        //split the months to arrays
        $salo_evo_per = explode(",",$effect_month);
        $nextMonth = $last_paids;
        $payPlan = [];
        for ($index=$salary_index; $index < count($salo_evo_per); $index++) {
            //take the last time he was paid and add one month to it
            //if there is a next month
            if ($index+1 < count($salo_evo_per)) {
                //count the number of months to that month
                $last_pay1 = explode(":",$salo_evo_per[$index+1]);
                $last_paider = date("Y-m-d",strtotime("01-".$last_pay1[0]."-".$last_pay1[1]));
                //echo "<br>".$salary_arr[$index];
                //go to the nexmonth
                //if the next month is not greater or equal to today or the next month
                $xs=0;
                for(;;){
                    //echo $nextMonth."<br>";
                    if ($nextMonth < $last_paider) {
                        //echo "<br>".$xs." ".$nextMonth." > to ".$last_paider;
                        //echo $nextMonth;
                        $xs++;
                    }else {
                        break;
                    }
                    $no = 1;
                    $nextMonth = addMonths($no,$nextMonth);
                }
                $string = $salary_arr[$index].":".$xs;
                array_push($payPlan,$string);
            }else{
                $create_date = date("Y-m",strtotime("3 hour"));
                $newDate = $create_date."-01";
                $last_paider = $newDate;
                //echo "<br>".$salary_arr[$index];
                //go to the nexmonth
                //if the next month is not greater or equal to today or the next month
                $xs=0;
                for(;;){
                    //echo $nextMonth."<br>";
                    if ($nextMonth < $last_paider) {
                        //echo "<br>".$xs." ".$nextMonth." > to ".$last_paider;
                        //echo $nextMonth;
                        $xs++;
                    }else {
                        break;
                    }
                    $no = 1;
                    $nextMonth = addMonths($no,$nextMonth);
                }
                $string = $salary_arr[$index].":".$xs;
                array_push($payPlan,$string);
            }
        }
        //echo $salary_arr[$salary_index];
        return $payPlan;
    }
    function addMonths($mon,$month){
        $nt_mon = date_create($month);
        $no_of_mons = $mon." Months";
        $nxt_mon = date_add($nt_mon, date_interval_create_from_date_string($no_of_mons));
        $nextMonth = date_format($nxt_mon, 'Y-m-d');
        return $nextMonth;
    }


    function getSalaryIndex($last_paid,$curr_salo,$salary_evo){
        if (strlen($salary_evo) > 0) {
            //explode the salary evolve to different time frames
            $salo_evo_arr = explode(",",$salary_evo);
            for ($index=0; $index < count($salo_evo_arr); $index++) { 
                $salary = explode(":",$salo_evo_arr[$index]);
                $date = date("Y-m-d",strtotime("01-".$salary[0]."-".$salary[1]));
                $last_pay = explode(":",$last_paid);
                $lastpay = date("Y-m-d",strtotime("01-".$last_pay[0]."-".$last_pay[1]));
                if ($lastpay >= $date) {
                    return $index;
                    break;
                }
            }
        }
    }
    function getTotalBalance($id,$conn2){
        $select = "SELECT `current_balance`,`current_balance_monNyear`,`salary_amount`,`effect_month` FROM `payroll_information` WHERE `staff_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                array_push($data,$row['current_balance'],$row['current_balance_monNyear'],$row['salary_amount'],$row['effect_month']);
            }
        }
        return $data;
    }
    function getStaffName($conn,$id){
        $select = "SELECT `fullname`,`gender` FROM `user_tbl` WHERE `user_id` = ?";
        $stmt = $conn->prepare($select);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $prefix = "Mrs. ";
                if ($row['gender'] == "M") {
                    $prefix = "Mr. ";
                }
                $name = $prefix.$row['fullname'];
                return $name;
            }
        }
        return "Null";
    }
    function checkEnrolled($conn2,$id){
        $select = "SELECT * FROM `payroll_information` WHERE `staff_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $stmt->store_result();
        $rnums = $stmt->num_rows;
        if ($rnums > 0) {
            return true;
        }
        return false;
    }
    function getTermPeriod($conn2){
        // $select = "SELECT `start_time`,`end_time` FROM `academic_calendar` WHERE 
        //             (YEAR(`end_time`) >= ? AND `term` = 'TERM_1') 
        //             OR (YEAR(`end_time`) >= ? AND `term` = 'TERM_2') 
        //             OR (YEAR(`end_time`) >= ? AND `term` = 'TERM_3');";
        $select = "SELECT `start_time`,`end_time` FROM `academic_calendar` WHERE 
                    (`term` = 'TERM_1') 
                    OR (`term` = 'TERM_2') 
                    OR (`term` = 'TERM_3');";
        $stmt = $conn2->prepare($select);
        $date = date("Y",strtotime("3 hour"));
        // $stmt->bind_param("sss",$date,$date,$date);
        $stmt->execute();
        $result = $stmt->get_result();
        $dates = [];
        if ($result) {
            while($row = $result->fetch_assoc()){
                array_push($dates,$row['start_time'],$row['end_time']);
            }
        }
        //echo count($dates);
        return $dates;
    }

    function getLastTimePaying($conn2,$stud_id){
        $select = "SELECT * FROM `finance` WHERE `stud_admin` = ? ORDER BY `transaction_id` DESC LIMIT 1";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$stud_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['date_of_transaction'];
            }
        }
        return date("Y-m-d",strtotime("3 hours"));
    }
    function getPeriods($years,$conn2){
        $select = "";
    }

    function checkPresent($array,$string){
        if (count($array) > 0) {
            for ($index=0; $index < count($array); $index++) { 
                $my_str = $array[$index];
                if (strlen($my_str) > 0) {
                    $my_str_split = explode(":",$my_str);
                    if ($my_str_split[0] == $string) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
    function getValues($array,$string){
        if (count($array) > 0) {
            for ($index=0; $index < count($array); $index++) { 
                $my_str = $array[$index];
                if (strlen($my_str) > 0) {
                    $my_str_split = explode(":",$my_str);
                    if ($my_str_split[0] == $string) {
                        return $my_str_split[1];
                    }
                }
            }
        }
        return "0";
    }
    function getALlExpenseNames($term_expense){
        //its a multilevel array
        $allitems = [];
        for ($index1=0; $index1 < count($term_expense); $index1++) { 
            for ($index2=0; $index2 < count($term_expense[$index1]); $index2++) { 
                $object = $term_expense[$index1][$index2];
                //array_push($allitems,$object);
                //split the text
                if (strlen($object) > 0) {
                    $stringExp = explode(":",$object);
                    if (!isPresent($allitems,$stringExp[0])) {
                        array_push($allitems,$stringExp[0]);
                    }
                }
            }
        }
        return $allitems;
    }
    function isPresent($array,$string){
        if (count($array) > 0 ) {
            for ($indexes=0; $indexes <count($array) ; $indexes++) { 
                if ($string == $array[$indexes]) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
    function getTaxes($arrayPeriod,$conn2){
        $select = "SELECT `exp_category` as 'Expense', sum(`exp_amount`) AS 'Total' FROM `expenses` WHERE `expense_date` BETWEEN ? and ?   AND `exp_category` = 'taxes'  GROUP BY `Expense`";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$arrayPeriod[0],$arrayPeriod[1]);
        $stmt->execute();
        $termExp = [];
        $result = $stmt->get_result();
        $taxes = 0;
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $taxes = $row['Total'];
            }
        }
        array_push($termExp,$taxes);
        //second term
        $taxes = 0;
        $stmt->bind_param("ss",$arrayPeriod[2],$arrayPeriod[3]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $taxes = $row['Total'];
            }
        }
        array_push($termExp,$taxes);
        //third term
        $taxes = 0;
        $stmt->bind_param("ss",$arrayPeriod[4],$arrayPeriod[5]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $taxes = $row['Total'];
            }
        }
        array_push($termExp,$taxes);
        //echo $arrayPeriod[4]." - ".$arrayPeriod[5];

        return $termExp;
    }

    function getExpenses($arrayPeriod,$conn2){
        $select = "SELECT `exp_category` as 'Expense', sum(`exp_amount`) AS 'Total' FROM `expenses` WHERE `expense_date` BETWEEN ? and ?   AND `exp_category` != 'taxes'  GROUP BY `Expense`";
        $termExp = [];
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$arrayPeriod[0],$arrayPeriod[1]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $termPexp1 = [];
            while ($row = $result->fetch_assoc()) {
                array_push($termPexp1,$row['Expense'].":".$row['Total']);
            }
            array_push($termExp,$termPexp1);
        }
        //second term
        $stmt->bind_param("ss",$arrayPeriod[2],$arrayPeriod[3]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $termPexp1 = [];
            while ($row = $result->fetch_assoc()) {
                array_push($termPexp1,$row['Expense'].":".$row['Total']);
            }
            array_push($termExp,$termPexp1);
        }
        //third term
        $stmt->bind_param("ss",$arrayPeriod[4],$arrayPeriod[5]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $termPexp1 = [];
            while ($row = $result->fetch_assoc()) {
                array_push($termPexp1,$row['Expense'].":".$row['Total']);
            }
            array_push($termExp,$termPexp1);
        }
        return $termExp;
    }
    function getTermIncome($arrayPeriod,$conn2){
        $term_pay = [];
        $select = "SELECT sum(`amount`)  AS 'Total' FROM `finance` WHERE `date_of_transaction` BETWEEN ? AND ?";
        $stmt = $conn2->prepare($select);
        $stmt ->bind_param("ss",$arrayPeriod[0],$arrayPeriod[1]);
        $stmt->execute();
        $result = $stmt->get_result();
        $err = 0;
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $total = $row['Total'];
                if ($total >= 0 || $total != null) {
                    array_push($term_pay,$row['Total']);
                }else {
                    $err++;
                    array_push($term_pay,0);
                }
            }else {
                array_push($term_pay,"0");
            }
        }else {
            array_push($term_pay,"0");
        }
        $stmt ->bind_param("ss",$arrayPeriod[2],$arrayPeriod[3]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $total = $row['Total'];
                if ($total >= 0 || $total != null) {
                    array_push($term_pay,$row['Total']);
                }else {
                    array_push($term_pay,0);
                    $err++;
                }
            }else {
                array_push($term_pay,"0");
            }
        }else {
            array_push($term_pay,"0");
        }
        $stmt ->bind_param("ss",$arrayPeriod[4],$arrayPeriod[5]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $total = $row['Total'];
                if ($total >= 0 || $total != null) {
                    array_push($term_pay,$row['Total']);
                }else {
                    $err++;
                    array_push($term_pay,0);
                }
            }else {
                array_push($term_pay,"0");
            }
        }else {
            array_push($term_pay,"0");
        }
        if ($err == 3) {
            echo "<p class='red_notice'>Edit your school academic calender first before generating your financial statement</p>";
        }
        return $term_pay;
    }
    function getTermPeriods($conn2){
        $date = date("Y",strtotime("3 hour"));
        // $select = "SELECT  `term`,`start_time`,`end_time`,`closing_date` FROM `academic_calendar` WHERE 
        // (YEAR(`end_time`) >= ? AND `term` = 'TERM_1') 
        // OR (YEAR(`end_time`) >= ? AND `term` = 'TERM_2') 
        // OR (YEAR(`end_time`) >= ? AND `term` = 'TERM_3');";
        $select = "SELECT  `term`,`start_time`,`end_time`,`closing_date` FROM `academic_calendar` WHERE 
        (`term` = 'TERM_1') 
        OR (`term` = 'TERM_2') 
        OR (`term` = 'TERM_3');";
        $stmt = $conn2->prepare($select);
        // $stmt->bind_param("sss",$date,$date,$date);
        $stmt->execute();
        $period = [];
        $result = $stmt->get_result();
        if ($result) {
            while($row = $result->fetch_assoc()){
                array_push($period,$row['start_time'],$row['end_time']);
            }
        }
        return $period;
    }
    function getClassAssignFee($fees_id,$conn2){
        $select = "SELECT `classes` FROM `fees_structure` WHERE `ids` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$fees_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $classlist = $row['classes'];
                $cl_ist = explode(",",$classlist);
                $newlist = "";
                for ($ind=0; $ind < count($cl_ist); $ind++) {
                    $newlist.=rBkts($cl_ist[$ind]).",";
                }
                $newlist = substr($newlist,0,strlen($newlist)-1);
                return $newlist;
            }
        }
    }
    function rBkts($string){
        $string = trim($string);
        if (strlen($string)>1) {
            return substr($string,1,strlen($string)-2);
        }else {
            return $string;
        }
    }
    function className($data){
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

    function createtablefinance($results){
        $tableinformation ="<hr><h6 style='text-align:center;font-weight:600;'>Transaction Detals Results</h6>";
        $tableinformation .= "<div class='tableme' id='fin_tables'><table  class='table'><tr>
                            <th>No.</th>
                            <th>Adm no</th>
                            <th>Paid Amount</th>
                            <th>D.O.P</th>
                            <th>T.O.P</th>
                            <th>M.O.P</th>
                            <th>Purpose</th></tr>
                            ";
        if ($results) {
            $transaction_data = "[";
            $xss =0;
            while ($row = $results->fetch_assoc()) {
                if ($row['amount']) {
                    $xss++;
                    $tableinformation.="<tr><td>".$xss."</td>";
                    $tableinformation.="<td>".$row['stud_admin']."</td>";
                    $tableinformation.="<td>".comma($row['amount'])."</td>";
                    $tableinformation.="<td>".$row['date_of_transaction']."</td>";
                    $tableinformation.="<td>".$row['time_of_transaction']."</td>";
                    $tableinformation.="<td>".$row['mode_of_pay']."</td>";
                    $tableinformation.="<td>".$row['payment_for']."</td></tr>";
                    $trans_date = date("dS M Y H:i:s A",strtotime($row['date_of_transaction']."".$row['time_of_transaction']));
                    $trans_date_sort = date("YmdHis",strtotime($row['date_of_transaction']."".$row['time_of_transaction']));
                    $student_name = getName1($row['stud_admin']);
                    $transaction_data.="{\"stud_admin\":\"".$row['stud_admin']."\",\"amount\":\"".comma($row['amount'])."\",\"date_of_transaction\":\"".$trans_date."\",\"student_name\":\"".$student_name."\",\"mode_of_pay\":\"".$row['mode_of_pay']."\",\"payment_for\":\"".$row['payment_for']."\",\"amount_sort\":".$row['amount'].",\"trans_date_sort\":".$trans_date_sort."},";
                }
            }
            $transaction_data = substr($transaction_data,0,-1)."]";
            $tableinformation.="</table></div>";
            $tableinformation.="<p style='margin-top:10px;'>HINT: <br> <small>D.O.P = Date of Payment <br>T.O.P = Time of Payment <br>M.O.P = Mode of Payment</small></p>";
            
            if ($xss>0) {
                return "<p class='hide' id='fees_data'>".$transaction_data."</p>";
            }else {
                return "<p class='hide' id='fees_data'></p>";
                return "<div class='displaydata'>
                            <img class='' src='images/error.png'>
                            <p class='' >No records found! </p>
                        </div>" ;
            }
        }else {
            return "<p class='hide' id='fees_data'></p>";
            return "Null";
        }
    }
    function createTotal($stmt){
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results) {
            $table1 = "<div id='my_purpose_table2' ><p>Sorted by mode of pay:</p><div  class='hide' id='purpChartHolder'><canvas id='purpChart' width = '300px' height='300px'></canvas></div><br><table id='mode_table'>";
            $table1.="<tr><th>Mode of pay</th>";
            $table1.="<th>Amount in (ksh)</th></tr>";
            $mpesa =0;
            $cash = 0;
            $bank = 0;
            $reverse = 0;
            $total = 0;
            while ($row = $results->fetch_assoc()) {
                if ($row['mode_of_pay']=='cash') {
                    $cash+=$row['amount'];
                }elseif ($row['mode_of_pay']=='bank') {
                    $bank+=$row['amount'];
                }elseif ($row['mode_of_pay']=='mpesa') {
                    $mpesa+=$row['amount'];
                }elseif ($row['mode_of_pay']=='reverse') {
                    $reverse+=$row['amount'];
                }
            }
            $total = $mpesa+$cash+$bank+$reverse;
            $table1.="<tr><td>M-Pesa</td><td>".comma($mpesa)."</td></tr>";
            $table1.="<tr><td>Cash</td><td>".comma($cash)."</td></tr>";
            $table1.="<tr><td>Bank</td><td>".comma($bank)."</td></tr>";
            $table1.="<tr><td>Reverse</td><td>".comma($reverse)."</td></tr>";
            $table1.="<tr><td><b>Total</b></td><td>".comma($total)."</td></tr>";
            $table1.="</table></div>";
            $table1.="<p id='purpose_values_in' class = 'hide' >{\"MPesa\":".$mpesa.",\"Cash\":".$cash.",\"Bank\":".$bank.",\"reverse\":".$reverse."}</p>";
            if($total>0){
                return $table1;
            }
        }else {
            return "";
        }
    }
    function createTotal2($stmt){
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results) {
            $mpesa =0;
            $cash = 0;
            $bank = 0;
            $total = 0;
            $purposes = getModesOfPay();
            $purpose1= array();
            //create arrays depending on the size of the array and initialize with value 0
            for($d =0;$d<count($purposes);$d++){
                array_push($purpose1,$purposes[$d].($d+1));
                $purpose1[$d] = 0;
            }
            //on instance of the array be found present the amount is assigned to the respective array
            $totals=0;
            while ($row = $results->fetch_assoc()) {
                for ($i=0; $i < count($purposes); $i++) {
                    if (trim($purposes[$i]) == trim($row['payment_for'])) {
                        $purpose1[$i]+=$row['amount'];
                        $totals+=$row['amount'];
                        break;
                    }
                }
            }
            $table1 = "<div  id='my_purpose_table1'><p>Sorted by purpose of pay:</p><div  class='hide' id='modepayChartHolder'><canvas id='modeChart' width = '300px' height='300px'></canvas></div><br><table id='purp_table'>";
            $table1.="<tr><th>Purpose of pay</th>";
            $table1.="<th>Amount in (ksh)</th></tr>";
            $total = $mpesa+$cash+$bank;
            $jsonData = "";
            for ($i=0; $i < count($purpose1); $i++) { 
                $table1.="<tr><td>".$purposes[$i]."</td><td>".comma($purpose1[$i])."</td></tr>";
                $jsonData.="\"".$purposes[$i]."\":\"".$purpose1[$i]."\",";
            }
            $table1.="<tr><td><b>Total</b></td><td>".comma($totals)."</td></tr>";
            $table1.="</table></div>";
            if (strlen($jsonData) > 0) {
                $jsonData = substr($jsonData,0,(strlen($jsonData) - 1));
                $jsonData = "{".$jsonData."}";
            }
            $table1.="<p class='hide' id='modepay_jsondata'>".$jsonData."</p>";
            if ($totals>0) {
                return $table1;
            }else {
                return "";
            }
        }else {
            return "";
        }
    }
    function getModesOfPay(){
        include("../../connections/conn2.php");
        $selected = "SELECT `payment_for`, sum(`amount`) AS 'Total' FROM `finance` GROUP BY `payment_for`;";
        $stmt = $conn2->prepare($selected);
        $stmt->execute();
        $purposeofpay = array("admission fees");
        $res = $stmt->get_result();
        if ($res) {    
            while ($row = $res->fetch_assoc()) {
                $present = 0;
                for ($i=0; $i < count($purposeofpay); $i++) { 
                    if ($purposeofpay[$i]==$row['payment_for']) {
                        $present=1;
                    }
                }
                if ($present==0) {
                    array_push($purposeofpay,$row['payment_for']);
                }
            }
            return $purposeofpay;
        }
    }
    function checkadmno($admno){
        include("../../connections/conn2.php");
        $select = "SELECT * FROM `student_data` WHERE `adm_no` = ? LIMIT 1";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $stmt->store_result();
        $rnums = $stmt->num_rows;
        if($rnums>0){
            return 1;
        }else {
            return 0;
        }
        $stmt->close();
        $conn2->close();
    }
    function getName($admno){
        include("../../connections/conn2.php");
        $select = "SELECT concat(`first_name`,' ',`second_name`) AS `Names`, `stud_class` FROM `student_data` where `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            $xs =0;
            $name = '';
            while ($row=$results->fetch_assoc()) {
                $xs++;
                $name = $row['Names']."^".$row['stud_class'];
            }
            if($xs!=0){
                return $name;
            }else{
                return "null";
            }
        }else {
            return "null";
        }
        
        $stmt->close();
        $conn2->close();
    }
    function getNameReport($admno,$conn2){
        // include_once("../../sims/ajax/finance/financial.php");
        $select = "SELECT concat(`first_name`,' ',`second_name`) AS `Names`, `stud_class` FROM `student_data` where `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            $xs =0;
            $name = '';
            while ($row=$results->fetch_assoc()) {
                $xs++;
                $name = $row['Names']."^".$row['stud_class'];
            }
            if($xs!=0){
                return $name;
            }else{
                return "null";
            }
        }else {
            return "null";
        }
        
        $stmt->close();
        // $conn2->close();
    }
    function getClass($admno){
        include("../../connections/conn2.php");
        $select = "SELECT concat(`first_name`,' ',`second_name`) AS `Names`, `stud_class` FROM `student_data` where `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            $xs =0;
            $name = '';
            while ($row=$results->fetch_assoc()) {
                $xs++;
                $name = $row['Names']."^".$row['stud_class'];
            }
            if($xs!=0){
                return $name;
            }else{
                return "null";
            }
        }else {
            return "null";
        }
        
        $stmt->close();
        $conn2->close();
    }
    function getClassV2reports($admno,$conn2){
        // include_once("../../sims/ajax/connections/conn2.php");
        $select = "SELECT concat(`first_name`,' ',`second_name`) AS `Names`, `stud_class` FROM `student_data` where `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            $xs =0;
            $name = '';
            while ($row=$results->fetch_assoc()) {
                $xs++;
                $name = $row['Names']."^".$row['stud_class'];
            }
            if($xs!=0){
                return $name;
            }else{
                return "null";
            }
        }else {
            return "null";
        }
        
        // $stmt->close();
        // $conn2->close();
    }
    function studentInclass($class,$conn2){
        $select = "SELECT concat(`first_name`,' ',`second_name`) AS 'Names',`adm_no` FROM `student_data` WHERE `stud_class` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$class);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $datas = $row['Names']."^".$row['adm_no'];
                array_push($students,$datas);
            }
        }
        return $students;
    }
    function getTerm(){
        $date = date("Y-m-d",strtotime("3 hour"));
        $select = "SELECT `term` FROM `academic_calendar` WHERE `end_time` > ? AND `start_time` < ?";
        include("../../connections/conn2.php");
        $stmt= $conn2->prepare($select);
        $stmt->bind_param("ss",$date,$date);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            if ($rowed = $results->fetch_assoc()) {
              $term = $rowed['term'];
              return $term;
            }else {
              return "TERM_1";
            }
        }else {
            return "TERM_1";
          }
        
        $stmt->close();
        $conn2->close();
    }
    function getTermV2($conn2){
        $date = date("Y-m-d",strtotime("3 hour"));
        $select = "SELECT `term` FROM `academic_calendar` WHERE `end_time` > ? AND `start_time` < ?";
        // include("../../connections/conn2.php");
        $stmt= $conn2->prepare($select);
        $stmt->bind_param("ss",$date,$date);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            if ($rowed = $results->fetch_assoc()) {
              $term = $rowed['term'];
              return $term;
            }else {
              return "TERM_1";
            }
        }else {
            return "TERM_1";
          }
        
        $stmt->close();
        $conn2->close();
    }
    function checkNewlyBoard($admno,$conn2){
        $select = "SELECT * FROM `boarding_list` WHERE `date_of_enrollment` > ?  and `student_id` = ?";
        $stmt = $conn2->prepare($select);
        $date = date("Y-m-d", strtotime("-719 hour"));
        $stmt->bind_param("ss",$date,$admno);
        $stmt->execute();
        $stmt->store_result();
        $rnums = $stmt->num_rows;
        if ($rnums > 0) {
            return true;
        }else {
            return false;
        }
    }
    function getBalance($admno,$term,$conn2){
        //get the fee balance from the latest transaction record if not found then calculate how much the students is to pay
        $lastbal = lastBalance($admno,$conn2);
        // get the student is enrolled in the transport system
        $is_trans = isTransport($conn2,$admno);
        $check_recent_boarding = checkNewlyBoard($admno,$conn2);
        // get the fees payment per term for the transport system
        $transport_payment = 0;
        if($is_trans == 1){
            // $transport_payment = transportBalance($conn2,$admno);
        }
        // check if the student has made any payments before the term started
        $date_term_began = date("Ymd",strtotime(getTermStart($conn2,$term)));
        $last_paid_time  = date("Ymd",strtotime(getLastTimePaying($conn2,$admno)));
        // add next term balance
        $current_term = 0;
        if ($date_term_began > $last_paid_time) {
            $daro_ss = getName($admno);
            $getclass = explode("^",$daro_ss)[1];
            $current_term = getFeesTerm($term,$conn2,$getclass,$admno);
            // echo $current_term;
        }
        if ($lastbal > 0 && !$check_recent_boarding) {
            return $lastbal + $transport_payment + $current_term;
        }else {
            $balance = calculatedBalanceReport($admno,$term,$conn2);
            return $balance + $transport_payment;
        }
    }
    function getBalanceReports($admno,$term,$conn2){
        // echo $term;
        //get the fee balance from the latest transaction record if not found then calculate how much the students is to pay
        $lastbal = lastBalance($admno,$conn2);
        // get the student is enrolled in the transport system
        $is_trans = isTransport($conn2,$admno);
        $check_recent_boarding = checkNewlyBoard($admno,$conn2);
        // get the fees payment per term for the transport system
        $transport_payment = 0;
        if($is_trans == 1){
            // $transport_payment = transportBalance($conn2,$admno);
        }
        // check if the student has made any payments before the term started
        $date_term_began = date("Ymd",strtotime(getTermStart($conn2,$term)));
        $last_paid_time  = date("Ymd",strtotime(getLastTimePaying($conn2,$admno)));
        // add next term balance
        $current_term = 0;
        if ($date_term_began > $last_paid_time) {
            $daro_ss = getNameReport($admno,$conn2);
            $getclass = explode("^",$daro_ss)[1];
            $current_term = getFeesTerm($term,$conn2,$getclass,$admno);
            // echo $current_term;
        }
        if ($lastbal > 0 && !$check_recent_boarding) {
            return $lastbal + $transport_payment+$current_term;
        }else {
            $balance = calculatedBalanceReport($admno,$term,$conn2);
            return $balance + $transport_payment;
        }
    }
    function getBalanceAdm($admno,$term){
        include("../../connections/conn2.php");
        //get the fee balance from the latest transaction record if not found then calculate how much the students is to pay
        $lastbal = lastBalance($admno,$conn2);
        // get the student is enrolled in the transport system
        $is_trans = isTransport($conn2,$admno);
        $check_recent_boarding = checkNewlyBoard($admno,$conn2);
        // get the fees payment per term for the transport system
        $transport_payment = 0;
        if($is_trans == 1){
            // $transport_payment = transportBalance($conn2,$admno);
        }
        if ($lastbal > 0 && !$check_recent_boarding) {
            return $lastbal + $transport_payment;
        }else {
            $balance = calculatedBalanceReport($admno,$term,$conn2);
            return $balance + $transport_payment; 
        }
    }
    function isTransport($conn2,$admno){
        $select = "SELECT * FROM `transport_enrolled_students` WHERE `student_id` = ?;";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if ($rnum > 0) {
            return true;
        }
        return false;
    }
    // get the student payment of transport per term if joined the same term the payment is taken for the only term
    function transportBalance($conn2,$admno,$termed = "null"){
        $select = "SELECT * FROM `transport_enrolled_students` WHERE `student_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $result = $stmt->get_result();
        // get the date joined
        // get the amount of the student route
        if ($result) {
            if($row = $result->fetch_assoc()){
                $route_id = $row['route_id'];
                $date_of_reg = $row['date_of_reg'];
                $route_val = routeAmount($conn2,$route_id,$date_of_reg);
                // echo $route_val;
                if ($termed != "null") {
                    // echo $route_val;
                    if ($termed == "TERM_1") {
                        // echo $route_price;
                        return ($route_val/1);
                    }else if($termed == "TERM_2"){
                        return ($route_val/2);
                    }else if($termed == "TERM_3"){
                        return ($route_val/3);
                    }
                    return 0;
                }
                return $route_val;
                // get the amount the students is supposed to pay depending on the dae of registration and term they in
            }
        }
        return 0;
    }
    // get route amount
    function routeAmount($conn2,$route_id,$date_of_reg){
        $select = "SELECT * FROM `van_routes` WHERE `route_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$route_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $route_price = 0;
        if ($result) {
            if($row = $result->fetch_assoc()){
                $route_price = $row['route_price'];
            }
        }
        // get the date of registration is in what term
        $select = "SELECT * FROM `academic_calendar` WHERE `start_time` <= ? AND `closing_date` >= ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$date_of_reg,$date_of_reg);
        $stmt->execute();
        $result = $stmt->get_result();
        $term = getTermV2($conn2);
        if ($result) {
            if($row = $result->fetch_assoc()){
                $term = $row['term'];
            }
        }
        // echo $term;
        $term = getTermV2($conn2);
        if ($term == "TERM_1") {
            // echo $route_price;
            return ($route_price*1);
        }else if($term == "TERM_2"){
            return ($route_price*2);
        }else if($term == "TERM_3"){
            return ($route_price*3);
        }
        return 0;
    }
    function calculatedBalance($admno,$term,$conn2){
        $daro = getName($admno);
        $getclass = explode("^",$daro);
        $dach = $getclass[1];
        $feestopay = getFeesAsPerTermBoarders($term,$conn2,$dach,$admno);
        $feespaidbystud = getFeespaidByStudent($admno,$conn2);
        $balance = $feestopay - $feespaidbystud;
        
        $balance += lastACADyrBal($admno,$conn2);
        return $balance;
    }
    function calculatedBalanceReport($admno,$term,$conn2){
        $daro = getNameReport($admno,$conn2);
        $getclass = explode("^",$daro);
        $dach = $getclass[1];
        $feestopay = getFeesAsPerTermBoarders($term,$conn2,$dach,$admno);
        $feespaidbystud = getFeespaidByStudent($admno,$conn2);
        $lastbal = lastBalance($admno,$conn2);
        $balance = $lastbal;
        $lastacad = lastACADyrBal($admno,$conn2);
        // echo $lastbal;
        if($lastbal <= 0 && $lastacad <= 0){
            $balance = $feestopay - $feespaidbystud;
        }elseif($lastbal > 0 && $lastacad > 0){
            $balance = $feestopay + $lastacad;
        }elseif ($lastbal <= 0 && $lastacad > 0) {
            $balance = $lastacad;
        }
        // echo lastACADyrBal($admno,$conn2);
        return $balance;
    }
    function lastACADyrBal($admno,$conn2){
        $select = "SELECT `balance` FROM `finance` WHERE `stud_admin` = ? AND `date_of_transaction` < ? ORDER BY `transaction_id` DESC LIMIT 1;";
        $stmt = $conn2->prepare($select);
        $beginyear = getAcademicStart($conn2);
        $stmt->bind_param("ss",$admno,$beginyear);
        $stmt->execute();
        $balance = 0;
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                if (isset($row['balance'])) {
                    $balance = $row['balance'];
                }
            }
        }
        return $balance;
    }
    function lastBalance($admno,$conn2){
        $select = "SELECT `balance` ,`date_of_transaction`FROM `finance` WHERE `stud_admin` = ? ORDER BY `transaction_id` DESC LIMIT 1";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $last_paid = date("YmdHis",strtotime($row['date_of_transaction']));
                $beginyear = date("YmdHis",strtotime(getAcademicStart($conn2)));
                if ($beginyear < $last_paid) {
                    return $row['balance'];
                }
            }
        }
        return 0;
    }
    function getFeesAsPerTerm($term,$conn2,$classes){
        $select = '';
        $class = "%|".$classes."|%";
        if($term == "TERM_1"){
            $select = "SELECT sum(`TERM_1`) AS 'TOTALS' FROM `fees_structure` WHERE `classes` LIKE ? AND `activated` = 1  and not `roles` = 'provisional';";
        }elseif($term == "TERM_2"){
            $select = "SELECT sum(`TERM_1`)+sum(TERM_2) AS 'TOTALS' FROM `fees_structure`  WHERE `classes` LIKE ? AND `activated` = 1  and not `roles` = 'provisional';";
        }elseif($term == "TERM_3"){
            $select = "SELECT sum(`TERM_1`)+sum(TERM_2)+sum(`TERM_3`) AS 'TOTALS' FROM `fees_structure`  WHERE `classes` LIKE ? AND `activated` = 1  and not `roles` = 'provisional';";
        }
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$class);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res){
            if ($row = $res->fetch_assoc()) {
                return strlen($row['TOTALS'])>0 ? $row['TOTALS'] : 0;
            }else{
                return 0;
            }
        }
        return 0;
        $stmt->close();
    }
    function isProvisional($purpose,$conn2,$clas_s){
        $class = "%".$clas_s."%";
        $select = "SELECT `expenses` FROM `fees_structure` WHERE `expenses` = ? AND  `classes` LIKE ? AND `roles` = 'provisional';";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$purpose,$class);
        $stmt->execute();
        $stmt->store_result();
        $rnums = $stmt->num_rows;
        if ($rnums > 0) {
            return "true";
        }else {
            return "false";
        }
    }
    function getFeesAsPerTermBoarders($term,$conn2,$classes,$admno){
        $select = '';
        $class = "%|".$classes."|%";
        if($term == "TERM_1"){
            $select = "SELECT sum(`TERM_1`) AS 'TOTALS' FROM `fees_structure` WHERE `classes` LIKE ? AND `activated` = 1  and `roles` = 'regular';";
        }elseif($term == "TERM_2"){
            $select = "SELECT sum(`TERM_1`)+sum(TERM_2) AS 'TOTALS' FROM `fees_structure`  WHERE `classes` LIKE ? AND `activated` = 1  and `roles` = 'regular';";
        }elseif($term == "TERM_3"){
            $select = "SELECT sum(`TERM_1`)+sum(TERM_2)+sum(`TERM_3`) AS 'TOTALS' FROM `fees_structure`  WHERE `classes` LIKE ? AND `activated` = 1  and `roles` = 'regular';";
        }
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$class);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res){
            if ($row = $res->fetch_assoc()) {
                $fees_to_pay = $row['TOTALS'];
                if (isBoarding($admno,$conn2)) {
                    $boarding_fees = getBoardingFees($conn2,$classes);
                    $fees_to_pay = $fees_to_pay+$boarding_fees;
                }
                // echo isBoarding($admno,$conn2);
                if (isTransport($conn2,$admno)) {
                    $transport = transportBalance($conn2,$admno);
                    $fees_to_pay+=$transport;
                }
                if (strlen($fees_to_pay) < 1) {
                    return 0;
                }
                return $fees_to_pay;
            }else{
                return 0;
            }
        }
        return 0;
        $stmt->close();
    }
    function getFeesTerm($term,$conn2,$classes,$admno){
        $select = '';
        $class = "%|".$classes."|%";
        $select = "SELECT sum(`".$term."`) AS 'TOTALS' FROM `fees_structure` WHERE `classes` LIKE ? AND `activated` = 1  and `roles` = 'regular';";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$class);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res){
            if ($row = $res->fetch_assoc()) {
                $fees_to_pay = $row['TOTALS'];
                if (isBoarding($admno,$conn2)) {
                    $boarding_fees = getBoardingFees($conn2,$classes,$term);
                    $fees_to_pay = $fees_to_pay+$boarding_fees;
                }
                // echo isBoarding($admno,$conn2);
                if (isTransport($conn2,$admno)) {
                    $transport = transportBalance($conn2,$admno,$term);
                    $fees_to_pay+=$transport;
                }
                if (strlen($fees_to_pay) < 1) {
                    return 0;
                }
                return $fees_to_pay;
            }else{
                return 0;
            }
        }
        return 0;
        $stmt->close();
    }
    function checkFeesChange($term,$conn2,$classes,$last_paid_time){
        $select = '';
        $class = "%|".$classes."|%";
        if($term == "TERM_1"){
            $select = "SELECT `expenses`, (SUM(`TERM_1`)) - (SUM(`term_1_old`)) AS 'Increase' FROM `fees_structure`WHERE `classes` LIKE ? AND `activated` = 1  and not `roles` = 'provisional' AND `date_changed` > ?  GROUP BY `expenses`;";
        }elseif($term == "TERM_2"){
            $select = "SELECT `expenses`, (SUM(`TERM_1`)+SUM(`TERM_2`)) - (SUM(`term_1_old`)+SUM(`term_2_old`)) AS 'Increase' FROM `fees_structure`WHERE `classes` LIKE ? AND `activated` = 1  and not `roles` = 'provisional' AND `date_changed` > ?  GROUP BY `expenses`;";
        }elseif($term == "TERM_3"){
            $select = "SELECT `expenses`, (SUM(`TERM_1`)+SUM(`TERM_2`)+SUM(`TERM_3`)) - (SUM(`term_1_old`)+SUM(`term_2_old`)+SUM(`term_3_old`)) AS 'Increase' FROM `fees_structure`WHERE `classes` LIKE ? AND `activated` = 1  and not `roles` = 'provisional' AND `date_changed` > ?  GROUP BY `expenses`;";
        }
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$class,$last_paid_time);
        $stmt->execute();
        $result = $stmt->get_result();
        $data_to_display = "";
        if ($result) {
            $data_to_display.= "<ol  type='1'>";
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                $data_to_display .= "<li>".$row['expenses']." : ".$row['Increase']."</li>";
                $total += ($row['Increase']*1);
            }
            $data_to_display .= "<strong>Total : <span id='increased_fees'>".$total."</span><br></strong>";
            $data_to_display.= "</ol>You are advised to add the total you are shown above to the student`s current fees balance below or Ignore if already changed.||";
            if ($total == 0) {
                $data_to_display = "";
                return $data_to_display;
            }
        }
        return $data_to_display;
    }
    function getFeespaidByStudent($admno,$conn2){
        $select = "SELECT sum(amount) AS 'TOTAL' FROM `finance` where `stud_admin` = ?  AND `date_of_transaction` BETWEEN ? and ? AND `payment_for` != 'admission fees'";
        $stmt = $conn2->prepare($select);
        $beginyear = getAcademicStart($conn2);//start date of the academic year
        $currentdate = date("Y-m-d", strtotime("3 hour"));
        $stmt->bind_param("sss",$admno,$beginyear,$currentdate);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res){
            if($row = $res->fetch_assoc()){
                if (isset($row['TOTAL'])) {
                    $total_pay = $row['TOTAL'];
                    $class = explode("^",getClassV2reports($admno,$conn2))[1];
                    $prov_roles = getProvisionalRole($class,$conn2);
                    $prov_amount = provisionalPays($admno,$conn2,$prov_roles,$beginyear);
                    $total_pay = $total_pay-$prov_amount;
                    return $total_pay;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else {
            return 0;
        }
        return 0;
    }
    function total_fees_paid($admno,$conn2){
        $select = "SELECT sum(amount) AS 'TOTAL' FROM `finance` where `stud_admin` = ?";
        $stmt = $conn2->prepare($select);
        $beginyear = getAcademicStart($conn2);//start date of the academic year
        $currentdate = date("Y-m-d", strtotime("3 hour"));
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res){
            if($row = $res->fetch_assoc()){
                if (isset($row['TOTAL'])) {
                    $total_pay = $row['TOTAL'];
                    return $total_pay;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else {
            return 0;
        }
        return 0;
    }
    function getFeespaidByStudentAdm($admno){
        include("../../connections/conn2.php");
        $select = "SELECT sum(amount) AS 'TOTAL' FROM `finance` where `stud_admin` = ?  AND `date_of_transaction` BETWEEN ? and ? AND `payment_for` != 'admission fees'";
        $stmt = $conn2->prepare($select);
        $beginyear = getAcademicStart($conn2);//start date of the academic year
        $currentdate = date("Y-m-d", strtotime("3 hour"));
        $stmt->bind_param("sss",$admno,$beginyear,$currentdate);
        $stmt->execute();
        $res = $stmt->get_result();
        // $conn2->close();
        if($res){
            if($row = $res->fetch_assoc()){
                if (isset($row['TOTAL'])) {
                    $total_pay = $row['TOTAL'];
                    $class = explode("^",getClassV2reports($admno,$conn2))[1];
                    $prov_roles = getProvisionalRole($class,$conn2);
                    $prov_amount = provisionalPays($admno,$conn2,$prov_roles,$beginyear);
                    $total_pay = $total_pay-$prov_amount;
                    return $total_pay;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else {
            return 0;
        }
        return 0;
    }
    /**
     * The following function returns the total amount paid for the provisional payments
     */
    function provisionalPays($admno,$conn2,$prov_pays,$beginyear){
        $provisional_amount = 0;
        if (count($prov_pays) > 0) {
            for ($i=0; $i < count($prov_pays); $i++) {
                $select = "SELECT sum(amount) AS 'TOTAL' FROM `finance` where `stud_admin` = ?  AND `date_of_transaction` BETWEEN ? and ? AND  `payment_for` = ?;";
                $stmt = $conn2->prepare($select);
                $today = date("Y-m-d",strtotime("3 hour"));
                $stmt->bind_param("ssss",$admno,$beginyear,$today,$prov_pays[$i]);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result) {
                    if ($row = $result->fetch_assoc()) {
                        $provisional_amount = ($row['TOTAL']*1);
                    }
                }
            }
        }
        return $provisional_amount;
    }
    /**
     * @return Arrays of all provisional payments
     */
    function getProvisionalRole($stud_class,$conn2){
        $class = "%|".$stud_class."|%";
        $select = "SELECT `expenses` FROM `fees_structure` WHERE `roles` = 'provisional' AND  `classes` LIKE ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$class);
        $stmt->execute();
        $result = $stmt->get_result();
        $roles = "";
        $roles_arr = [];
        if ($result) {
            while($row = $result->fetch_assoc()){
                $roles.=$row['expenses'].",";
            }
        }
        if (strlen($roles) > 0) {
            $roles = substr($roles,0,(strlen($roles)-1));
            $roles_arr = explode(",",$roles);
        }
        return $roles_arr;
    }
    function getAcademicStart($conn2){
        $select = "SELECT `start_time` FROM `academic_calendar` WHERE `term` = 'TERM_1';";
        $stmt =$conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['start_time'];
            }
        }
        return date('Y')."-01-01";
    }
    function getTermStart($conn2,$term){
        $select = "SELECT `start_time` FROM `academic_calendar` WHERE `term` = '".$term."';";
        $stmt =$conn2->prepare($select);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['start_time'];
            }
        }
        return date('Y')."-01-01";
    }
    function isBoarding($admno,$conn2){
        $select = "SELECT * FROM `boarding_list` WHERE `student_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $stmt->store_result();
        $rnums = $stmt->num_rows;
        if ($rnums > 0) {
            return true;
        }
        return false;
    }
    function getBoardingFees($conn2,$class,$termed = "null"){
        $class = "%|".$class."|%";
        $term = getTermV2($conn2);
        // echo $term;
        $select = "";
        if ($term == "TERM_1" && $termed == "null") {
            $select = "SELECT sum(`TERM_1`) AS 'Total' FROM `fees_structure` WHERE `roles` = 'boarding' AND `activated` = 1 AND `classes` like ?";
        }elseif ($term == "TERM_2" && $termed == "null") {
            $select = "SELECT sum(`TERM_1`)+sum(`TERM_2`) AS 'Total' FROM `fees_structure` WHERE `roles` = 'boarding' AND `activated` = 1 AND `classes` like ?";
        }elseif ($term == "TERM_3" && $termed == "null") {
            $select = "SELECT sum(`TERM_1`)+sum(`TERM_2`)+sum(`TERM_3`) AS 'Total' FROM `fees_structure` WHERE `roles` = 'boarding' AND `activated` = 1 AND `classes` like ?";
        }elseif ($termed != "null") {
            $select = "SELECT sum(`".$termed."`) AS 'Total' FROM `fees_structure` WHERE `roles` = 'boarding' AND `activated` = 1 AND `classes` like ?";
        }
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$class);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['Total'];
            }
        }
        return 0;
    }
    function getName1($admno){
        include("../../connections/conn2.php");
        $select = "SELECT concat(`first_name`,' ',`second_name`) AS `Names` FROM `student_data` where `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $results = $stmt->get_result();
        if($results){
            $xs =0;
            $name = '';
            while ($row=$results->fetch_assoc()) {
                $xs++;
                $name = $row['Names']."";
                break;
            }
            if($xs!=0){
                return $name;
            }else{
                return "null";
            }
        }else {
            return "null";
        }
        
        $stmt->close();
        $conn2->close();
    }
    
    function insertNotifcation($conn2,$messageName,$messagecontent,$notice_stat,$reciever_id,$reciever_auth,$sender_id){
        $insert = "INSERT INTO `tblnotification`  (`notification_name`,`Notification_content`,`sender_id`,`notification_status`,`notification_reciever_id`,`notification_reciever_auth`) VALUES (?,?,?,?,?,?)";
        $stmt = $conn2->prepare($insert);
        $stmt->bind_param("ssssss",$messageName,$messagecontent,$sender_id,$notice_stat,$reciever_id,$reciever_auth);
        $stmt->execute();
    }
    
    function getApiKey($conn){
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
    function getPatnerId($conn){
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
    function getShortCode($conn){
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
    function getPhoneNumber($conn2,$stud_id){
        $select = "SELECT `parentContacts`,`parent_contact2` FROM `student_data` WHERE `adm_no` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$stud_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                return $row['parentContacts'].",".$row['parent_contact2'];
            }
        }
        return 0;
    }
    function changeTransport($conn2,$admno){
        // first check the students date of last payment and check if transport amount has been changed
        $last_paid_time = getLastTimePaying($conn2,$admno);
        // check the date the route was changed or added if it is greater than the date the student last paid
        $select = "SELECT * FROM `transport_enrolled_students` WHERE `student_id` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$admno);
        $stmt->execute();
        $result = $stmt->get_result();
        $route_id = 0;
        if ($result) {
            if ($row = $result->fetch_assoc()) {
                $route_id = $row['route_id'];
            }
        }
        // get the route price change
        $select = "SELECT * FROM `van_routes` WHERE `route_id` = ? AND `route_date_change` >= ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("ss",$route_id,$last_paid_time);
        $stmt->execute();
        $result = $stmt->get_result();
        $route_price = "0";
        $old_price = "0";
        $data_to_display = "";
        if($result){
            if ($row = $result->fetch_assoc()) {
                $route_price = ($row['route_price']*1);
                $old_price = ($row['route_prev_price']*1);
                $data_to_display = "<hr><span class='text-primary'>Route fees seemed to have been changed. It has changed by <b>Ksh ".($route_price-$old_price)."</b>. Please change accordingly</span>.";
            }
        }
        // there will be change in price if there is no result
        return $data_to_display;
    }
    function getFirstPaymentAmount($conn2,$staff_id){
        $total_paid = getTotalSalo($conn2,$staff_id);
        // get the last month balance
        $firstpay_record = getFirstPayDate($conn2,$staff_id);
        $times = explode(":",$firstpay_record);
        $firstpay_dated = date("Y-m-d",strtotime("01-".$times[0]."-".$times[1]));
        // get the current balnce, amount and month
        $curr_balance = getCurrentBalTime($conn2,$staff_id);
        $times = explode(":",explode(",",$curr_balance)[0]);
        $last_date_paid = date("Y-m-d",strtotime("01-".$times[0]."-".$times[1]));
        // echo $last_date_paid;
        // get the first pay as a date
        // loop through the dates untill the last paydate to get 
        // the total amount paid that period and the first payment amount
        $total_salary = 0;
        $overrall_salo = 0;
        $date = addMonths(1,$firstpay_dated);
        // echo $date;
        // if the last paid date is the same as tthe date with the balance the first amount 
        // paid is the balance plus the amount paid
        if ($firstpay_dated == $last_date_paid) {
            $balance = explode(",",$curr_balance);
            return $balance[1] + $total_paid;
        }
        if($date < $last_date_paid){
            for(;;){
                if ($last_date_paid == $date) {
                    break;
                }
                $total_salary+=getSalary($date,$conn2,$staff_id);
                $date = addMonths(1,$date);
            }
        }
        $overrall_salo = 0;
        $overall_date = addMonths(1,$firstpay_dated);
        for(;;){
            if ($last_date_paid < $overall_date) {
                break;
            }
            $overrall_salo+=getSalary($overall_date,$conn2,$staff_id);
            $overall_date = addMonths(1,$overall_date);
        }
        $last_time_salo = getSalary($last_date_paid,$conn2,$staff_id) - explode(",",$curr_balance)[1];
        $total_salary+=$last_time_salo;
        return $total_paid - $total_salary;

        // return 0;
    }
    function getPaymentBreakdown($conn2,$staff_id,$first_pay_amount,$firstpay_dated){
        $select = "SELECT * FROM `salary_payment` WHERE `staff_paid` = ?";
        $stmt = $conn2->prepare($select);
        $stmt->bind_param("s",$staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result) {
            while($row = $result->fetch_assoc()){
                $data2 = [];
                array_push($data2,$row['amount_paid']);
                array_push($data2,$row['mode_of_payment']);
                array_push($data2,$row['payment_code']);
                array_push($data2,$row['date_paid']);
                array_push($data2,$row['time_paid']);
                // final array
                array_push($data,$data2);
            }
        }

        $months_n_salary = [];
        $breakdown = [];
        $salary_rem = 0;
        $amount_rem = 0;
        // break down the payment from the first payment to the last
        $date_explode = explode(":",$firstpay_dated);
        $fdate = date("Y-m-d",strtotime("01-".$date_explode[0]."-".$date_explode[1]));
        for ($index=0; $index < count($data); $index++) { 
            $stringdata = "";
            // first store the salary amount
            $amount_paid = $data[$index][0];
            if ($amount_rem > 0) {
                $amount_paid+=$amount_rem;
            }
            // echo $amount_paid." index ".$index." ".$salary_rem."<br>";
            if ($salary_rem < 1) {
                $salary = getSalary($fdate,$conn2,$staff_id,$first_pay_amount);
                if ($index == 0) {
                    $salary = $first_pay_amount;
                }
            }else{
                $salary = $salary_rem;
            }
            // echo $amount_paid." ".$salary."<br>";
            // start dividing the salary
            if ($salary > $amount_paid) {
                // echo $salary." above ".$amount_paid."<br>";
                // break;
                $salary -= $amount_paid;
                $stringdata = "<p>-Kes ".comma($amount_paid)." ".payMode($data[$index][1])."  (".date("d-M-Y",strtotime($data[$index][3])).") </p>";
                array_push($breakdown,$stringdata);
                $stringdata = "";
                $salary_rem = $salary;
                $amount_paid = 0;
                if (count($data) == $index+1) {
                    $m_date = date("M - Y",strtotime($fdate));
                    $months_n_salary += [$m_date => $breakdown];
                }
                // check if there is any salary other payment value so that you may break or continue
                continue;
            }else {
                // echo $salary;break;
                while($amount_paid >= $salary){
                    // if there is a salary remaining show the amount that remained has been paid of
                    if ($amount_rem > 0) {
                        // $salary-=$amount_rem;
                        $stringdata .= "<p>-Kes ".comma($amount_rem)." ".payMode($data[$index-1][1])."  (".date("d-M-Y",strtotime($data[$index-1][3])).") </p>";
                        // array_push($breakdown,$stringdata);
                    }
                    $amount_paid -= $salary;
                    if ($amount_rem > 0) {
                        $salary-=$amount_rem;
                        $amount_rem = 0;
                    }
                    $stringdata .= "<p>-Kes ".comma($salary)." ".payMode($data[$index][1])."  (".date("d-M-Y",strtotime($data[$index][3])).") </p>";
                    array_push($breakdown,$stringdata);
                    $stringdata = "";
                    $m_date = date("M - Y",strtotime($fdate));
                    $months_n_salary += [$m_date => $breakdown];
                    $breakdown = [];
                    $fdate = addMonths(1,$fdate);
                    if ($salary_rem > 0) {
                        $salary_rem = 0;
                        $fdate = date("Y-m-d",strtotime($fdate));
                    }
                    $salary = getSalary($fdate,$conn2,$staff_id);
                }
                if ($amount_paid > 0) {
                    // echo $amount_paid;
                    $amount_rem = $amount_paid;
                    if (count($data) == ($index+1)) {
                        // echo $amount_rem." ".$salary." rem <br>";
                        $salary -= $amount_rem;
                        $stringdata = "<p>-Kes ".comma($amount_rem)." ".payMode($data[$index][1])."  (".date("d-M-Y",strtotime($data[$index][3])).") </p>";
                        array_push($breakdown,$stringdata);
                        $stringdata = "";
                        $m_date = date("M - Y",strtotime($fdate));
                        $months_n_salary += [$m_date => $breakdown];
                        $breakdown = [];
                    }else {
                        // echo $amount_rem." ".$salary." rem <br>";
                        $salary -= $amount_rem;
                        $stringdata = "<p>-Kes ".comma($amount_rem)." ".payMode($data[$index][1])."  (".date("d-M-Y",strtotime($data[$index][3])).") </p>";
                        array_push($breakdown,$stringdata);
                        $stringdata = "";
                        $m_date = date("M - Y",strtotime($fdate));
                        // $months_n_salary += [$m_date => $breakdown];
                        // $breakdown = [];
                        $amount_rem = 0;
                        // echo $salary." mine<br>";
                    }
                }
            }
        }
        // var_dump($breakdown);
        return $months_n_salary;
    }
?>