cObj("showfeesstructure").onclick = function () {
    if (cObj("daros") != "undefined" && cObj("daros") != null){
        var err = checkBlank("daros");
        if (err==0) {
            var datapass = "?feesstructurefind=true&class="+valObj("daros");
            sendData1("GET","finance/financial.php",datapass,cObj("displayfin"));
            setTimeout(() => {
                var ids = setInterval(() => {
                    if (cObj("loadings").classList.contains("hide")) {
                        var removef_ee = document.getElementsByClassName("removef_ee");
                        //delete the fee
                        for (let index = 0; index < removef_ee.length; index++) {
                            const element = removef_ee[index];
                            element.addEventListener("click",removeFees);
                        }
                        var edit_feeser = document.getElementsByClassName("edit_feeser");
                        for (let index = 0; index < edit_feeser.length; index++) {
                            const element = edit_feeser[index];
                            element.addEventListener("click", editFees);
                        }
                        stopInterval(ids);
                    }
                }, 100);
            }, 1000); 
        }else{
            cObj("displayfin").innerHTML= "<p style='color:red;'>Select class to proceed!</p>";
        }
    }else{
        alert("Its null");
    }
}



function editFees() {
    //get the values from the table
    var fees_id = this.id.substr(3);
    cObj("exp_name1").value = cObj("expense_name"+fees_id).innerText;
    cObj("term_one1").value = cObj("t_one"+fees_id).innerText;
    cObj("term_two1").value = cObj("t_two"+fees_id).innerText;
    cObj("term_three1").value = cObj("t_three"+fees_id).innerText;
    cObj("original_exp_name").innerText = cObj("expense_name"+fees_id).innerText;
    var proles = cObj("proles"+fees_id).innerText;
    cObj(proles+"12").selected = true;
    cObj("fee_id_s").innerText = fees_id;
    //show class list
    var datapass = "?getclasslist2=true&fees_id="+fees_id;
    sendData2("GET","finance/financial.php",datapass,cObj("class_list_fees_update"),cObj("loadings21322"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                var class_fees_ass = cObj("class_fees_ass").innerText.split(",");
                //split class
                var update_expense_check = document.getElementsByClassName("update_expense_check");
                for (let index = 0; index < update_expense_check.length; index++) {
                    const element = update_expense_check[index];
                    var classs = element.id.substr(9);
                    var present = checkPresent(class_fees_ass,classs);
                    if (present == 1) {
                        element.checked = true;
                    }
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
    //show the window
    cObj("add_expense_update").classList.remove("hide");
}
function checkPresent(array,strings) {
    if (array.length>0) {
        for (let index = 0; index < array.length; index++) {
            const element = array[index];
            if (element.trim() == strings.trim()) {
                return 1;
            }
        }
    }
    return 0;
}
function removeFees() {
    var fee_id = this.id.substr(7);
    var expensename  = cObj("expense_name"+fee_id).innerText;
    cObj("expensenamed").innerText = expensename;
    cObj("record_ids").innerText = fee_id;
    cObj("delete_fee_win").classList.remove("hide");
}
cObj("confirm_yes_fees").onclick = function () {
    //get the record id
    var fee_id = cObj("record_ids").innerText;
    var datapass = "?delete_fee="+fee_id;
    sendData1("GET","finance/financial.php",datapass,cObj("removeer_fees"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                cObj("delete_fee_win").classList.add("hide");
                cObj("showfeesstructure").click();
                stopInterval(ids);
            }
        }, 100);
    }, 1000);
}
cObj("confirm_no_fees").onclick = function () {
    cObj("delete_fee_win").classList.add("hide");
}
cObj("modeofpay").onchange = function () {
    var thisvalue = this.value;
    if(thisvalue=="mpesa"){
        cObj("mpesad").classList.remove("hide");
        cObj("banksd").classList.add("hide");
        cObj("cash").classList.add("hide");
        cObj("btns").classList.remove("hide");
    }else if(thisvalue=="cash"){
        cObj("mpesad").classList.add("hide");
        cObj("banksd").classList.add("hide");
        cObj("cash").classList.remove("hide");
        cObj("btns").classList.remove("hide");
    }else if(thisvalue=="bank"){        
        cObj("mpesad").classList.add("hide");
        cObj("banksd").classList.remove("hide");
        cObj("cash").classList.add("hide");
        cObj("btns").classList.remove("hide");
    }
}
cObj("modeofpay").onclick = function () {
    cObj("makepayments").classList.remove("hide");
}
cObj("searchfin1").onclick = function () {
    var err = 0;
    err+=checkBlank("studids");
    if(err==0){
        var datapass = "?findadmno="+valObj("studids");
        sendData1("GET","finance/financial.php" ,datapass,cObj("paymentsresults"));
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("loadings").classList.contains("hide")) {
                    var className = document.getElementsByClassName("reverse");
                    setReverselistener(className);
                    stopInterval(ids);
                    //get the vote head only for that specific class
                    var classes = document.getElementsByClassName("class_studs_in");
                    getVoteHead(classes);
                    if (cObj("closed_balance") != null) {
                        cObj("closed_balance").addEventListener("click",showBalanceInput);
                        cObj("accBalance").addEventListener("click",acceptBalance);
                        cObj("rejectBalances").addEventListener("click",closeAcceptBalance);
                    }
                }
            }, 100);
        }, 1000);
    }else{
        cObj("paymentsresults").innerHTML = "<p style='color:red;'>Enter an admission number to proceed!</p>";
    }
}
function getVoteHead(classname){
    if(classname.length > 0){
        for (let index = 0; index < classname.length; index++) {
            if(index>0){
                break;
            }
            const element = classname[index];
            var myclass = element.innerText;
            voterHeads(myclass);
        }
    }
}
function voterHeads(classin){
    //get the payment details here
    var datapass2 = "?payfordetails=true&class_use="+classin;
    sendData("GET","finance/financial.php",datapass2,cObj("payments"));
}
function setReverselistener(className) {
    if (className.length>0) {
        for (let index = 0; index < className.length; index++) {
            const element = className[index];
            element.addEventListener("click", reverseListener);
        }
    }
}
function reverseListener() {
    var datapass = "?transactionid="+this.id+"&amount_reverse="+cObj("reverse_amount"+this.id).innerText+"&students_id_ddds="+cObj("students_id_ddds").innerText;
    sendData1("GET","finance/financial.php",datapass,cObj("reversehandler"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                cObj("searchfin1").click();
                stopInterval(ids);
            }
        }, 100);
    }, 1000);
}
cObj("makepayments").onclick = function () {
    //first check if the student information has been populated
    
    if(typeof(cObj("presented")) != 'undefined' && cObj("presented") != null){
        grayBorder(cObj("studids"));
        cObj("geterrorpay").innerHTML = "<p style='color:red;font-size:12px;'></p>";
        if(typeof(cObj("payfor")) != 'undefined' && cObj("payfor") != null){
            var errs = checkErrors();
            if (cObj("modeofpay").value == "mpesa") {
                if (cObj("mpesa_code_err").innerText.length > 1) {
                    errs++;
                    redBorder(cObj("mpesacode"));
                }else{
                    grayBorder(cObj("mpesacode"));
                }
            }else if (cObj("modeofpay").value == "bank") {
                if (cObj("bank_code_errs").innerText.length > 1) {
                    errs++;
                    redBorder(cObj("bankcode"));
                }else{
                    grayBorder(cObj("bankcode"));
                }
            }
            if(errs==0){
                cObj("nameofstudents").innerText = cObj("std_names").innerText;
                // display the confirmation window
                cObj("confirmpayments").classList.remove("hide");
            }else{
                cObj("geterrorpay").innerHTML = "<p style='color:red;font-size:12px;'>Check for errors and fill all the fields having red borders</p>";
            }
        }else{
            cObj("geterrorpay").innerHTML = "<p style='color:red;'>Please contact your administrator there might be an issue with the system configuration.</p>"
        }        
    }else{
        redBorder(cObj("studids"));
        cObj("geterrorpay").innerHTML = "<p style='color:red;font-size:12px;'>First check if the student admission number is valid by searching, if its found to be valid proceed and make the payment.</p>"
    }

}

cObj("bankcode").onblur = function () {
    var code = this.value;
    if (code.trim().length > 0) {
        var datapass = "?bank_codes="+code;
        sendData2("GET","finance/financial.php",datapass,cObj("bank_code_errs"),cObj("anonymus"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("anonymus").classList.contains("hide")) {
                    if (cObj("bank_code_errs").innerText.trim().length > 1) {
                        redBorder(this);
                    }else{
                        grayBorder(this);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 100);
    }
}

cObj("confirmyes").onclick = function () {
    // add sms functionality to the payment system
        var trancode = '';
        var amount = 0;
        if (valObj("modeofpay")=='mpesa') {
            trancode = valObj("mpesacode");
            amount = valObj("amount1")
        }else if (valObj("modeofpay")=='cash') {
            trancode = "cash";
            amount = valObj("amount3")
        }else if (valObj("modeofpay")=='bank') {
            trancode = valObj("bankcode");
            amount = valObj("amount2")
        }
        var send_sms = cObj("check-parents-sms").value;
        // send sms to the students parent 
        var datapass = "?insertpayments=true&stuadmin="+valObj("presented")+"&transcode="+trancode+"&amount="+amount+"&payfor="+valObj("payfor")+"&paidby="+valObj("useriddds")+"&modeofpay="+valObj("modeofpay")+"&balances="+cObj("closed_balance").innerText+"&send_sms="+send_sms;
        sendData1("GET","finance/financial.php",datapass,cObj("geterrorpay"));
        var purpose_p = valObj("payfor");
        cObj("confirmpayments").classList.add("hide");
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("geterrorpay").innerText.length>0) {
                    var text = cObj("geterrorpay").innerText.substr(0,11);
                    if(text =="Transaction"){
                        cObj("payforms").reset();
                        cObj("mpesad").classList.add("hide");
                        cObj("banksd").classList.add("hide");
                        cObj("cash").classList.add("hide");
                        cObj("makepayments").classList.add("hide");
                        cObj("studids").value = cObj("students_id_ddds").innerText;
                        cObj("searchfin1").click();
                        setTimeout(() => {
                            var timeout = 0;
                            var idsf = setInterval(() => {
                                timeout++;
                                //after two minutes of slow connection the next process wont be executed
                                if (timeout==1200) {
                                    stopInterval(idsf);                        
                                }
                                if (cObj("loadings").classList.contains("hide")) {
                                    //set the values of the payment reciept
                                    cObj("student_adm_no").innerText = ": "+cObj("students_id_ddds").innerText;
                                    cObj("students_jina").innerText = ": "+cObj("std_names").innerText;
                                    cObj("transaction_codeds").innerText = cObj("transaction_code").innerText;
                                    cObj("mode_of_payment").innerText = cObj("mode_use_pay").innerText;
                                    cObj("cash_recieved").innerText = "Kes "+comma3(cObj("amount_recieved").innerText);
                                    cObj("closing_balance").innerText = "Kes "+comma3(cObj("closed_balance").innerText);
                                    cObj("purpose_in_p").innerText = purpose_p;
                                    cObj("sch_logods").src = cObj("sch_logos").src;
                                    // values to submit for reciept printing
                                    cObj("students_names").value = cObj("std_names").innerText;
                                    cObj("student_admission_no").value = cObj("students_id_ddds").innerText;
                                    cObj("amount_paid_by_student").value = "Kes "+comma3(cObj("amount_recieved").innerText);
                                    cObj("new_student_balance").value = "Kes "+comma3(cObj("closed_balance").innerText);
                                    cObj("mode_of_payments").value = cObj("mode_use_pay").innerText;
                                    cObj("transaction_codes").value = cObj("transaction_code").innerText;
                                    cObj("payments_for").value = purpose_p;

                                    cObj("submit_receipt_printing").click();

                                    // stop the other windows used for reciepts
                                    // hideWindow();
                                    // unselectbtns();
                                    // cObj("printer_page").classList.remove("hide");
                                    stopInterval(idsf);
                                    // console.log("we are here");
                                }
                            }, 100);
                        }, 200);

                        stopInterval(ids);
                    }else{
                    }
                }
                cObj("geterrorpay").innerHTML="<p></p>";
            }, 100);
        }, 200);

}

cObj("mpesacode").onblur = function () {
    var mpesacode = this.value;
    if (mpesacode.trim().length > 0) {
        //send data to the database to check the code if its used
        var datapass = "?m_pesa_code="+this.value.trim();
        sendData2("GET","finance/financial.php",datapass,cObj("mpesa_code_err"),cObj("anonymus"));
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("anonymus").classList.contains("hide")) {
                    if (cObj("mpesa_code_err").innerText.trim().length > 1) {
                        redBorder(this);
                    }else{
                        grayBorder(this);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 100);
    }else{
        cObj("mpesa_code_err").innerHTML = "";
    }
}

cObj("confirmno").onclick = function () {
    cObj("confirmpayments").classList.add("hide");
}

cObj("showprocess1").onclick = function () {
    cObj("procedure").classList.remove("hide");
    cObj("btnshow1").classList.add("hide");
}
cObj("hideprocess1").onclick = function () {
    cObj("procedure").classList.add("hide");
    cObj("btnshow1").classList.remove("hide");
}


function checkErrors() {
    let errors = 0;
    errors+=checkBlank("payfor");
    //check if cash, mpesa or bank is selected
    errors+=checkBlank("modeofpay");
    if(checkBlank("modeofpay")==0){
        if (valObj("modeofpay")=='mpesa') {
            errors+=checkBlank("mpesacode");
            errors+=checkBlank("amount1");
        }else if (valObj("modeofpay")=='cash') {
            errors+=checkBlank("amount3");
        }else if (valObj("modeofpay")=='bank') {
            errors+=checkBlank("bankcode");
            errors+=checkBlank("amount2");
        }
    }

    return errors;
}


cObj("timeopt").onchange = function () {
    if(this.value=="btndates"){
        cObj("btndates").classList.remove("hide");
        cObj("otheropts").classList.remove("hide");
        cObj("classlists").classList.add("hide");
        cObj("trans_code").classList.add("hide");
    }else{
        if (this.value=="clased") {
            cObj("otheropts").classList.add("hide");
            cObj("btndates").classList.add("hide");
            cObj("classlists").classList.remove("hide");
            cObj("trans_code").classList.add("hide");
        }else if (this.value == "transactioncodes") {
            cObj("otheropts").classList.add("hide");
            cObj("btndates").classList.add("hide");
            cObj("classlists").classList.add("hide");
            cObj("trans_code").classList.remove("hide");
        }else{
            cObj("btndates").classList.add("hide");
            cObj("otheropts").classList.remove("hide");
            cObj("classlists").classList.add("hide");
            cObj("trans_code").classList.add("hide");
        }
    }
}

cObj("student_s").onchange = function () {
    if(this.value=="admno"){
        cObj("enteradmno").classList.remove("hide");
    }else{
        cObj("enteradmno").classList.add("hide");
    }
}

cObj("searchtransaction").onclick = function () {
    let errs = checkerrorstrans();
    if (errs==0) {    
        if (cObj("classedd") != null && cObj("classedd") != "undefined") {
            getTransactionId();
        }else{
            getClasses("manage_trans","classedd","");
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        getTransactionId();
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }
    }else{
        cObj("errhandler").innerHTML = "<p style='color:red;'>Select and fill all the options with the red border</p>";
    }
}
function getTransactionId() {
    cObj("errhandler").innerHTML = "<p style='color:red;'></p>";
    var firstselect = cObj("timeopt").value;
    var secondselect = cObj("student_s").value;
    if (cObj("classedd") != "undefined" && cObj("classedd") != null){
        var thirdselect = cObj("classedd").value;
        var datapass = "?";
        if(firstselect!="btndates" && secondselect!="admno" && firstselect!="clased" && firstselect!="transactioncodes"){
            datapass = "?findtransactions=true&period="+firstselect+"&studentstype="+secondselect;
            sendData1("GET","finance/financial.php",datapass,cObj("errhandler"));
            assignEventsDone();
            displayFeesData();
        }else{
            if (firstselect=="btndates" && secondselect!="admno" && firstselect!="clased" && firstselect!="transactioncodes") {
                datapass = "?findtransbtndates=true&startfrom="+valObj("startdate")+"&endperiod="+valObj("enddate");
                sendData1("GET","finance/financial.php",datapass,cObj("errhandler"));
                assignEventsDone();
                displayFeesData();
            }else if (firstselect=="btndates" && secondselect=="admno" && firstselect!="clased" && firstselect!="transactioncodes") {
                datapass = "?findtransbtndatesandadmno=true&startfrom="+valObj("startdate")+"&endperiod="+valObj("enddate")+"&admnos="+valObj("admnno");
                sendData1("GET","finance/financial.php",datapass,cObj("errhandler"));
                assignEventsDone();
                displayFeesData();
            }else if(firstselect!="btndates" && secondselect=="admno" && firstselect!="clased" && firstselect!="transactioncodes"){
                datapass = "?findtransbtncontsdatesandadmno=true&admnos="+valObj("admnno")+"&period="+firstselect;
                sendData1("GET","finance/financial.php",datapass,cObj("errhandler"));
                assignEventsDone();
            }else if(thirdselect.length>0 && firstselect=="clased" && firstselect!="transactioncodes"){
                datapass = "?findtransindates=true&class="+thirdselect;
                sendData1("GET","finance/financial.php",datapass,cObj("errhandler"));
                setTimeout(() => {
                    var timeout = 0;
                    var ids = setInterval(() => {
                        timeout++;
                        //after two minutes of slow connection the next process wont be executed
                        if (timeout==1200) {
                            stopInterval(ids);                        
                        }
                        if (cObj("loadings").classList.contains("hide")) {
                            var obj = document.getElementsByClassName("finbtns");
                            setListener(obj);
                            if (cObj("pleasewait23") != "undefined" && cObj("pleasewait23") != null){
                                cObj("pleasewait23").style.display = 'none';
                            }
                            //set listener for the print remiders button
                            if (cObj("print_reminders") != "undefined" && cObj("print_reminders") != null) {
                                cObj("print_reminders").addEventListener("click", printFeesReminder);
                            }
                            stopInterval(ids);
                        }
                    }, 100);
                }, 200);
                cObj("window_2").classList.add("hide");
            }else if (firstselect == "transactioncodes") {
                datapass = "?find_transaction_with_code="+cObj("transact_code").value;
                sendData1("GET","finance/financial.php",datapass,cObj("errhandler"));
                assignEventsDone();
                displayFeesData();
            }
        }
    }
}
function assignEventsDone() {
    if (cObj("fin_tables") != 'undefined') {
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    cObj("tabular").addEventListener("click",selectTable);
                    cObj("chartlike").addEventListener("click",selectChart);
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }
}
// display data

function displayFeesData() {
    cObj("window_2").classList.remove("hide");
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var fees_data = cObj("fees_data").innerText;
                if (fees_data.length > 10) {
                    var json_data = JSON.parse(fees_data);
                    // create the table
                    getFeesNDisplay(json_data);
                    cObj("search_option_fee").classList.remove("d-none");
                    cObj("tablefooter_fees").classList.remove("invisible");
                }else{
                    cObj("search_option_fee").classList.add("d-none");
                    cObj("transDataReciever_fees").innerHTML = "<p class='sm-text text-danger text-bold text-center'><span style='font-size:40px;'><i class='fas fa-exclamation-triangle'></i></span> <br>Ooops! No results found!</p>";
                    cObj("tablefooter_fees").classList.add("invisible");
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function printFeesReminder() {
    var student_to_send_reminder = document.getElementsByClassName("sutid");
    var student_id = "";
    for (let index = 0; index < student_to_send_reminder.length; index++) {
        const element = student_to_send_reminder[index];
        if (element.checked == true) {
            student_id+=element.id.substr(5)+",";
        }
    }
    student_id = student_id.substr(0,student_id.length-1);
    var err = checkBlank("date_picker");
    //send the data to the database
    if (err == 0) {
        cObj("reminder_err").innerHTML = "";
        if (student_id.length>1) {
            var datapass = "?get_fee_reminders="+student_id+"&deadline="+cObj("date_picker").value;
            sendData1("GET","finance/financial.php",datapass,cObj("print_reminded"));
            setTimeout(() => {
                var ids = setInterval(() => {
                    if (cObj("loadings").classList.contains("hide")) {
                        hideWindow();
                        cObj("fees_reminders").classList.remove("hide");
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else{
            cObj("reminder_err").innerHTML = "<p style='color:red;font-size:12px;font-weight:600;'>Select a student to print reminder!</p>";
        }
    }else{
        cObj("reminder_err").innerHTML = "<p style='color:red;font-size:12px;font-weight:600;'>Give a date from today as the deadline for fees payment!</p>";
    }
}
function stopInterval(id) {
    clearInterval(id);
}
function setListener(obj){
    for (let index = 0; index < obj.length; index++) {
        const element = obj[index];
        element.addEventListener('click' , viewlistener);
    }
};

function viewlistener() {
    var admno = this.id;
    admno = admno.substr(6,admno.length);
    //first change period
    cObj("btnd").selected = true;
    cObj("timeopt").click();
    cObj("spcificstd").selected = true;
    cObj("student_s").click();
    cObj("admnno").value = ""+admno+"";
    //get date today and year
    var year = new Date();
    var mon = year.getMonth()+1;
    var date = year.getDate();
    month = ''+mon;
    dates = ""+date;
    if (mon<10) {
        month = "0"+mon;
    }
    if (date<10) {
        dates = "0"+date;
    }
    cObj("startdate").value = year.getFullYear()+"-01-01";
    cObj("enddate").value = year.getFullYear()+"-"+month+"-"+dates;
    cObj("searchtransaction").click();
}
function checkerrorstrans() {
    let err = 0;
    err+=checkBlank("timeopt");

    if(cObj("timeopt").value != "clased" && cObj("timeopt").value !="transactioncodes" ){
        err+=checkBlank("student_s");
    }

    if(cObj("timeopt").value == "btndates"){
        err+=checkBlank("startdate");
        err+=checkBlank("enddate");
    }
    if(cObj("student_s").value == "admno"){
        err+=checkBlank("admnno");
    }
    if(cObj("timeopt").value == "clased"){
        if (cObj("classedd") != "undefined" && cObj("classedd") != null){
            err+=checkBlank("classedd");
        }else{
            err++;
        }
    }
    if (cObj("timeopt").value == "transactioncodes") {
        err+=checkBlank("transact_code");
    }
    return err;
}
var a;
function printFeesReciept() {
    a = window.open('','','height=500px, width=500px');
    a.document.write("<html><head><link rel='stylesheet' href='/sims/assets/CSS/homepage2.css'></head><body>");
    a.document.write(cObj("fees_reciept").innerHTML);
    a.document.write("</body></html>");
    a.document.close();
    setTimeout(() => {
        a.print();
    }, 2000);
    // cObj("fees_reciept").print();
}
function payWindowclick() {
    cObj("payfeess").click();
    closeWin();
}
function closeWin() {
    if (a != "undefined" && a != null) {
        a.close();
    }
}

var b;
function printFeesReminded() {
    a = window.open('','','height=480px, width=700px');
    a.document.write("<html><head><link rel='stylesheet' href='/sims/assets/CSS/homepage2.css'></head><body>");
    a.document.write(cObj("print_reminded").innerHTML);
    a.document.write("</body></html>");
    a.document.close();
    setTimeout(() => {
        a.print();
    }, 2000);
}
function closeWinB() {
    if (a != "undefined" && a != null) {
        a.close();
    }
    cObj("findtrans").click();
}
//the third window
var c;
function printFeesStructure() {
    c = window.open('','','height=480px, width=700px');
    c.document.write("<html><head><link rel='stylesheet' href='/sims/assets/CSS/homepage2.css'></head><body>");
    c.document.write(cObj("fees_struct-in").innerHTML);
    c.document.write("</body></html>");
    c.document.close();
    setTimeout(() => {
        c.print();
    }, 2000);
}
//close window

function closeWindowPay() {
    cObj("feestruct").click();
    closeWin2();
}
function closeWin2() {
    if (c != "undefined" && c != null) {
        c.close();
    }
}
function sendMessage() {
    var datapass = "?send_message=true&to="+cObj("phone_nos").value+"&message="+cObj("text_message").value
    sendData1("GET","finance/financial.php",datapass,cObj("out_put"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var response = cObj("out_put").innerText
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("close_add_expense21").onclick = function () {
    cObj("add_expense_update").classList.add("hide");
}
cObj("close_add_expense1").onclick = function () {
    cObj("add_expense_update").classList.add("hide");
}
cObj("save_add_expense1").onclick = function () {
    //check for errors
    var err = checkBlank("exp_name1");
    err+=checkBlank("term_one1");
    err+=checkBlank("term_two1");
    err+=checkBlank("term_three1");
    err+=checkBlank("boarders1_regular1");
    if (err == 0) {
        cObj("err_handler_101").innerHTML = "<p class='red_notice'></p>";
        //check if classes are selected
        var classes = document.getElementsByClassName("update_expense_check");
        var checker = 0;
        var class_list = "";
        for (let index = 0; index < classes.length; index++) {
            const element = classes[index];
            if (element.checked == true) {
                checker++;
                class_list+="|"+element.id.substr(9)+"|,";
            }
        }
        if (checker > 0) {
            class_list = class_list.substr(0,class_list.length-1);
            var fee_name = cObj("exp_name1").value
            var term_one1 = cObj("term_one1").value
            var term_two1 = cObj("term_two1").value
            var term_three1 = cObj("term_three1").value
            var fees_id = cObj("fee_id_s").innerText
            var roles = cObj("boarders1_regular1").value;
            var datapass = "?update_fees_information=true&fees_name="+fee_name+"&t_one="+term_one1+"&t_two="+term_two1+"&t_three="+term_three1+"&fee_ids="+fees_id+"&class_list="+class_list+"&old_names="+cObj("original_exp_name").innerText+"&roles="+roles;
            sendData1("GET","finance/financial.php",datapass,cObj("err_handler_101"));
            setTimeout(() => {
                var ids = setInterval(() => {
                    if (cObj("loadings").classList.contains("hide")) {
                        cObj("add_expense_update").classList.add("hide");
                        cObj("showfeesstructure").click();
                        cObj("err_handler_101").innerHTML = "";
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else{
            cObj("err_handler_101").innerHTML = "<p class='red_notice'>Select a class to proceed!</p>";
        }
    }else{
        cObj("err_handler_101").innerHTML = "<p class='red_notice'>Fill all the fields covered with a red border!</p>";
    }
}
cObj("exp_name").onblur = function () {
    //gwt its value
    var expense_name = this.value;
    if (expense_name.length > 0) {
        //check if the name is used
        var datapass = "?check_expense_name="+expense_name;
        sendData2("GET","finance/financial.php",datapass,cObj("expe_err"),cObj("anonymus"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("anonymus").classList.contains("hide")) {
                    //get the if the expe_err has some text in it
                    if (cObj("expe_err").innerText.length > 0) {
                        redBorder(this);
                    }else{
                        grayBorder(this);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }
}
function showBalanceInput() {
    cObj("fee_balance_new").classList.remove("hide");
    cObj("fee_balance_new").classList.add("new_balances");
    cObj("read_note").classList.remove("hide");
}
function acceptBalance() {
    var err = checkBlank("new_bala_ces");
    if (err == 0) {
        var balance = valObj("new_bala_ces");
        cObj("closed_balance").innerText = balance;
        closeAcceptBalance();
        cObj("new_bala_ces").value = "";
    }
}
function closeAcceptBalance() {
    cObj("fee_balance_new").classList.add("hide");
    cObj("fee_balance_new").classList.remove("new_balances");
    cObj("new_bala_ces").value = "";
    cObj("read_note").classList.add("hide");
}

//record an expense
cObj("add_expenseed").addEventListener("click", addExpense);

function addExpense() {
    //check for errors
    var err = checkBlank("exp_named");
    err+=checkBlank("exp_cat");
    err+=checkBlank("exp_quant");
    err+=checkBlank("exp_amnt");
    err+=checkBlank("exp_total_amt");
    if (err == 0) {
        cObj("err_hndler_expenses").innerHTML = "<p class='green_notice'></p>";
        err = 0;
        if (cObj("exp_amnt").value == "0" || cObj("exp_quant").value == "0") {
            redBorder(cObj("exp_amnt"));
            cObj("err_hndler_expenses").innerHTML = "<p class='red_notice'>Amount or Quantity can`t be zero</p>";
            err++;
        }else{
            grayBorder(cObj("exp_amnt"));
            cObj("err_hndler_expenses").innerHTML = "<p class='green_notice'></p>";
        }
        if (err == 0) {
            var datapass = "?addExpenses=true&exp_name="+cObj("exp_named").value+"&expensecat="+cObj("exp_cat").value+"&quantity="+cObj("exp_quant").value+"&unitcost="+cObj("exp_amnt").value+"&total="+cObj("exp_total_amt").value+"&unit_name="+cObj("unit_name").value;
            sendData1("GET","finance/financial.php",datapass,cObj("err_hndler_expenses"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        //get the if the expe_err has some text in it
                        if (cObj("uploaded") != null) {
                            cObj("exp_named").value = "";
                            cObj("exp_quant").value = "0";
                            cObj("exp_amnt").value = "0";
                            cObj("exp_total_amt").value = "0";
                            cObj("main_sele").selected = true;
                            cObj("unit_name").value = "";
                            displayTodaysExpense();
                        }
                        setTimeout(() => {
                            cObj("err_hndler_expenses").innerHTML = "";
                        }, 3000);
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }
    }else{
        cObj("err_hndler_expenses").innerHTML = "<p class='red_notice'>Please fill all the blank fields</p>";
    }
}
cObj("exp_quant").addEventListener("change",changeValue);
cObj("exp_quant").addEventListener("keyup",changeValue);

cObj("exp_amnt").addEventListener("change",changeValue);
cObj("exp_amnt").addEventListener("keyup",changeValue);
function changeValue() {
    var quantity = cObj("exp_quant").value;
    var amount = cObj("exp_amnt").value;
    var total = quantity*amount;
    cObj("exp_total_amt").value = total;
}

//display todays expenses
function displayTodaysExpense() {
    var datapass = "?todays_expemse=true";
    sendData1("GET","finance/financial.php",datapass,cObj("my_table"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                //create a chart and get the data - decode the JSON data
                if (cObj("table_values2") != undefined) {
                    var datavalue = cObj("table_values2").innerText;
                    var dataval2 = JSON.parse(datavalue);
                    //get the value labels
                    var arrLabels = [];
                    for(let val in dataval2){
                        arrLabels.push(val);
                    }

                    //get the values and the color value
                    var arrData = [];
                    var arrColor = [];
                    for (let index = 0; index < arrLabels.length; index++) {
                        const element = arrLabels[index];
                        arrData.push(dataval2[element]);
                        arrColor.push(getRandomColor());
                    }
                    var title = cObj("title-charts2").innerText;
                    createChart2(cObj("expense-charted-in"),title,arrLabels,arrData,arrColor);
                }
                // get the data of the expense table
                if (cObj("expenses_data_json") != undefined) {
                    var expenses_data_json = cObj("expenses_data_json").innerText;
                    if (expenses_data_json.length > 0) {
                        if (expenses_data_json.length > 5) {
                            var expense_data = expenses_data_json.length>0 ? JSON.parse(expenses_data_json) : [];
                            // console.log(expense_data);
                            getExpensesNDisplay(expense_data);
                            // create the table
                            cObj("search_option_expenses").classList.remove("d-none");
                            cObj("tablefooter_expenses").classList.remove("invisible");
                        }else{
                            cObj("search_option_expenses").classList.add("d-none");
                            cObj("transDataReciever_expensess").innerHTML = "<p class='sm-text text-danger text-bold text-center'><span style='font-size:40px;'><i class='fas fa-exclamation-triangle'></i></span> <br>Ooops! No results found!</p>";
                            cObj("tablefooter_expenses").classList.add("invisible");
                        }
                    }

                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}

cObj("done_adding_exp").onclick = function () {
    cObj("recordexp").classList.add("hide");
    cObj("exp_options").classList.remove("hide");
}
cObj("add_exp").onclick = function () {
    cObj("recordexp").classList.remove("hide");
    cObj("exp_options").classList.add("hide");
}
cObj("done_display_exp").onclick = function () {
    cObj("find_exp_date").classList.add("hide");
    cObj("exp_options").classList.remove("hide");
}
cObj("find_exp_da").onclick = function () {
    cObj("find_exp_date").classList.remove("hide");
    cObj("exp_options").classList.add("hide");
}
cObj("disp_btns").onclick = function () {
    var options = cObj("view-options-date").value;
    if (options == "by-date") {
        var err = checkBlank("date_for_exp");
        if (err == 0) {
            cObj("date_err").innerHTML = "<p class='green_notice'></p>";
            var datapass = "?date_display="+cObj("date_for_exp").value;
            sendData1("GET","finance/financial.php",datapass,cObj("my_table"));
        }else{
            cObj("date_err").innerHTML = "<p class='red_notice'>Select date!</p>";
        }
    }else if (options == "by-month") {
        var err = checkBlank("sele-years");
        err+=checkBlank("month_for_exp");
        if (err == 0) {
            cObj("date_err").innerHTML = "<p class='green_notice'></p>";
            var datapass = "?get_expenses=true&years="+cObj("sele-years").value+"&months="+cObj("month_for_exp").value;
            sendData1("GET","finance/financial.php",datapass,cObj("my_table"));
            //create table
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        //create a chart and get the data - decode the JSON data
                        if (cObj("table_values") != undefined) {
                            var datavalue = cObj("table_values").innerText;
                            var dataval2 = JSON.parse(datavalue);
                            //get the value labels
                            var arrLabels = [];
                            for(let val in dataval2){
                                arrLabels.push(val);
                            }

                            //get the values and the color value
                            var arrData = [];
                            var arrColor = [];
                            for (let index = 0; index < arrLabels.length; index++) {
                                const element = arrLabels[index];
                                arrData.push(dataval2[element]);
                                arrColor.push(getRandomColor());
                            }
                            var title = cObj("title-charts").innerText;
                            createChart2(cObj("expense-charts-in"),title,arrLabels,arrData,arrColor);
                        }
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }
    }
}

//get the income finance statement
function incomeStatement() {
    var datapass = "?incomestatement=true";
    sendData1("GET","finance/financial.php",datapass,cObj("finance_statements"));
}
//create the select teachers to get the teachers in their pay roll
cObj("enroll_staff_btn").onclick = function () {
    cObj("payroll_enroll").classList.remove("hide");
    cObj("viewEnrolledPay").classList.add("hide");
    cObj("salary_infor").classList.add("hide");
    cObj("pay_salary_staff").classList.add("hide");
    cObj("view_payment_history").classList.add("hide");
    cObj("salary_infor").classList.add("hide");
    //get the staff information
    getStaff_id();
}
function getStaff_id() {
    var datapass = "?mystaff=true";
    sendData1("GET","finance/financial.php",datapass,cObj("staff_li"));
}
//save the staff information
cObj("enrol_staf_btn").onclick = function () {
    //check first for the staff list
    var err = 0;
    if (cObj("staff_l") != null) {
        err+=checkBlank("staff_l");
        err+=checkBlank("amount_to_pay");
        err+=checkBlank("effect_year");
        err+=checkBlank("balances");
        err+=checkBlank("effect_from");
        if (err == 0) {
            var salary_breakdown = get_salary_breakdown();
            cObj("enroll_err_handler").innerHTML = "";
            var datapass = "?enroll_payroll=true&staff_id="+cObj("staff_l").value+"&salary_amount="+cObj("amount_to_pay").value+"&effect_year="+cObj("effect_year").value+"&balance="+cObj("balances").value+"&effect_month="+cObj("effect_from").value+"&salary_breakdown="+salary_breakdown;
            sendData1("GET","finance/financial.php",datapass,cObj("enroll_err_handler"));
            cObj("payroll_enroll").reset();
        }else{
            cObj("enroll_err_handler").innerHTML = "<p class='red_notice'>Please fill all the fields covered with red border.</p>";
        }
    }else{
        cObj("enroll_err_handler").innerHTML = "<p class='red_notice'>No staff available for enrollment</p>";
    }
}

//display information about the system
cObj("staff_en").onclick = function () {
    cObj("head_infor").innerText = "Who to select?";
    cObj("para_infor").innerText = "Select the staff you want to enroll to the school payroll system.";
}
cObj("staff_salo").onclick = function () {
    cObj("head_infor").innerText = "What is salary amount?";
    cObj("para_infor").innerText = "This is the amount of money to pay the staff monthly.";
}
cObj("staff_currMon").onclick = function () {
    cObj("head_infor").innerText = "What is the current month?";
    cObj("para_infor").innerText = "This is the month that the staff was last paid.  Its also the month at which the salary was effective";
}
cObj("staff_currYear").onclick = function () {
    cObj("head_infor").innerText = "What is the current year?";
    cObj("para_infor").innerText = "This is the year that the staff was last paid. Its also the year at which the salary was effective";
}
cObj("staff_accruedbal").onclick = function () {
    cObj("head_infor").innerText = "Balance?";
    cObj("para_infor").innerHTML = "At this field you are expected to fill the balance of the last month the staff was paid. <br>Example <i>If the staff was last paid in june this year with a balance was 12,000 and we are at August you record the 12,000 as the balance</i><br>The system will able to know the payments made monthly and their balances.<br>Leave it at zero if there is no balance";
}

//view those enrolled for the payroll
cObj("see_enrolled").onclick = function () {
    cObj("viewEnrolledPay").classList.remove("hide");
    cObj("payroll_enroll").classList.add("hide");
    cObj("pay_salary_staff").classList.add("hide");
    cObj("view_payment_history").classList.add("hide");
    cObj("salary_infor").classList.add("hide");
    seeEnrolled();
}
//get enrolled class
function seeEnrolled() {
    var datapass = "?getEnrolled=true";
    sendData1("GET","finance/financial.php",datapass,cObj("my_enrolled_staff"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var edit_salary = document.getElementsByClassName("edit_salary");
                for (let index = 0; index < edit_salary.length; index++) {
                    const element = edit_salary[index];
                    element.addEventListener("click",editSalaries);
                }
                var pay_staff_salo = document.getElementsByClassName("pay_staff_salo");
                for (let index = 0; index < pay_staff_salo.length; index++) {
                    const element = pay_staff_salo[index];
                    element.addEventListener("click",showPaymentwin);
                }
                var view_salos_pay = document.getElementsByClassName("view_salos_pay");
                for (let index = 0; index < view_salos_pay.length; index++) {
                    const element = view_salos_pay[index];
                    element.addEventListener("click",viewSalaryPay);
                }
                var enroll_pays = document.getElementsByClassName("enroll_pays");
                for (let index = 0; index < enroll_pays.length; index++) {
                    const element = enroll_pays[index];
                    element.addEventListener("click",enrollPay);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("pay_mode").onchange = function () {
    //hide the bank and cash window when neccessary
    var sel_val  = this.value;
    if (sel_val == "m-pesa") {
        cObj("mpesa_salary").classList.remove("hide");
        cObj("banks_sal").classList.add("hide");
    }else if (sel_val == "bank") {
        cObj("banks_sal").classList.remove("hide");
        cObj("mpesa_salary").classList.add("hide");
    }else if (sel_val == "cash") {
        cObj("mpesa_salary").classList.add("hide");
        cObj("banks_sal").classList.add("hide");
    }
    cObj("amount_sal").classList.remove("hide");
    cObj("sal_pay_btns").classList.remove("hide");
}

function editSalaries() {
    var stfid = this.id.substr(3);
    cObj("stf_id_sal").innerText = stfid;
    cObj("pay_salary_staff").classList.add("hide");
    cObj("viewEnrolledPay").classList.add("hide");
    cObj("staff_name_ids_sal").value = cObj("namd"+stfid).innerText;
    cObj("change_salary").value = cObj("salo"+stfid).innerText;
    cObj("old_salo").innerText = cObj("salo"+stfid).innerText;
    cObj("old_salary").innerText = cObj("salo"+stfid).innerText;
    cObj("salary_infor").classList.remove("hide");
    cObj("gross_salary_edit").value = 0;
    cObj("personal_relief_accept").checked = false;
    cObj("nhif_relief_accept").checked = false;
    cObj("dedcut_nhif_edit").checked = false;
    cObj("dedcut_paye_edit").checked = false;
    cObj("allowance_holder_edit").innerText = "";
    cObj("gross_sa").innerText = 0;
    cObj("allowance_html").innerHTML = "<p class='text-success'>No allowances to display at the moment.</p>";
    // get the salary details
    var datapass = "?salary_details="+stfid;
    sendData1("GET","finance/financial.php",datapass,cObj("salary_infor_br"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var data = cObj("salary_infor_br").innerText;
                if (data.length > 0) {
                    // change the data to JSON format and get the salary and allowances
                    var obj = JSON.parse(data);
                    // get the allowances
                    var allowances = JSON.stringify(obj.allowances);
                    cObj("allowance_holder_edit").innerText = allowances;
                    // set the nssf rates
                    var nssf_id = obj.nssf_rates;
                    cObj(nssf_id).selected = true;
                    // set the reliefs
                    var nhif_relief = obj.nhif_relief;
                    if (nhif_relief == "yes") {
                        cObj("nhif_relief_accept").checked = true;
                    }else{
                        cObj("nhif_relief_accept").checked = false;
                    }
                    // personal relief
                    var personal_relief = obj.personal_relief;
                    if(personal_relief == "yes"){
                        cObj("personal_relief_accept").checked = true;
                    }else{
                        cObj("personal_relief_accept").checked = false;
                    }

                    // deduct NHIF
                    var deduct_NHIF = obj.deduct_nhif;
                    if (deduct_NHIF == "yes") {
                        cObj("dedcut_nhif_edit").checked = true;
                    }else{
                        cObj("dedcut_nhif_edit").checked = false;
                    }
                    // deduct PAYE
                    var dedcut_paye_edit = obj.deduct_paye;
                    if (dedcut_paye_edit == "yes") {
                        cObj("dedcut_paye_edit").checked = true;
                    }else{
                        cObj("dedcut_paye_edit").checked = false;
                    }
                    var gross_salary = obj.gross_salary;
                    cObj("gross_salary_edit").value = gross_salary;
                    cObj("gross_sa").innerText = gross_salary;
                    //year 
                    var year = "yr_"+obj.year;
                    cObj(year).selected = true;
                    addAllowances2(obj.allowances);
                    cObj("error_calaculator").innerHTML = "";
                }else{
                    cObj("error_calaculator").innerHTML = "<p class='text-success'>The staff salary tax and deductions is not calculated.You can calculate or leave as is.</p>";
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function showPaymentwin() {
    let id = this.id.substr(4);
    cObj("viewEnrolledPay").classList.add("hide");
    cObj("pay_salary_staff").classList.remove("hide");
    cObj("last_paid_time").innerText = cObj("lastpay"+id).innerText;
    cObj("salary_balances").innerText = cObj("salo_balance"+id).innerText;
    cObj("stf_ids_pay").innerText = id;
    cObj("staff_name").value = cObj("namd"+id).innerText;
    cObj("monthly_salo").innerText = cObj("montly_sal"+id).innerText;
    checkBalance(id);
}
function viewSalaryPay() {
    let id = this.id.substr(3);
    cObj("viewEnrolledPay").classList.add("hide");
    cObj("view_payment_history").classList.remove("hide");
    var date = new Date();
    cObj("userPayId").value = id;
    var datapass = "?view_salo_history=true&staff_id="+id+"&curr_year="+date.getFullYear();
    sendData1("GET","finance/financial.php",datapass,cObj("getmysalohistory"));
}

cObj("sel_yrs").onchange = function () {
    let id = cObj("userPayId").value;
    cObj("viewEnrolledPay").classList.add("hide");
    cObj("view_payment_history").classList.remove("hide");
    var date = new Date();
    var datapass = "?view_salo_history=true&staff_id="+id+"&curr_year="+this.value;
    sendData1("GET","finance/financial.php",datapass,cObj("getmysalohistory"));
}

function enrollPay() {
    cObj("enroll_staff_btn").click();
}
function checkBalance(id) {
    var datapass = "?checkBalance=true&ids="+id;
    sendData1("GET","finance/financial.php",datapass,cObj("tot_bal"));
}
cObj("back_to_payroll123").onclick = function () {
    cObj("view_payment_history").classList.add("hide");
    cObj("viewEnrolledPay").classList.remove("hide");
}
cObj("back2_to_payroll123").onclick = function () {
    cObj("back_to_payroll123").click();
}
cObj("changes_salary_btn").onclick = function () {
    //save changes of the new salary
    var err = 0;
    err+=checkBlank("change_salary");
    if (err == 0) {
        if (cObj("change_salary").value > 0) {
            grayBorder(cObj("change_salary"));
            cObj("err_handler_F").innerHTML = "";
            var new_salo = cObj("change_salary").value;
            var old_salo = cObj("old_salo").innerText;
            if (old_salo != new_salo) {
                var salobreakdown = get_salary_breakdown2();
                var datapass = "?change_salo=true&id="+cObj("stf_id_sal").innerText+"&new_amnt="+new_salo+"&salo_breakdown="+salobreakdown;
                sendData1("GET","finance/financial.php",datapass,cObj("err_handler_F"));
                setTimeout(() => {
                    var timeout = 0;
                    var ids = setInterval(() => {
                        timeout++;
                        //after two minutes of slow connection the next process wont be executed
                        if (timeout==1200) {
                            stopInterval(ids);                        
                        }
                        if (cObj("loadings").classList.contains("hide")) {
                            cObj("see_enrolled").click();
                            setTimeout(() => {
                                cObj("err_handler_F").innerHTML = "";
                            }, 3000);
                            stopInterval(ids);
                        }
                    }, 100);
                }, 200);
            }else{
                cObj("err_handler_F").innerHTML = "<p class='green_notice'>Change the salary to a new value!</p>";
                setTimeout(() => {
                    cObj("err_handler_F").innerHTML = "";
                }, 3000);
            }
        }else{
            redBorder(cObj("change_salary"));
            cObj("err_handler_F").innerHTML = "<p class='red_notice'>Salary should be greater than zero!</p>";
        }
    }else{
        cObj("err_handler_F").innerHTML = "<p class='red_notice'>Check for errors where necessary!</p>";
    }
}
cObj("unenroll_staff_salary").onclick = function () {
    cObj("unenroll_confirm").classList.remove("hide");
    cObj("name_sake").innerText = cObj("staff_name_ids_sal").value;
}
cObj("no_unenroll").onclick = function () {
    cObj("unenroll_confirm").classList.add("hide");
}
cObj("yes_unenroll").addEventListener("click",unenrollUser);
function unenrollUser() {
    let id = cObj("stf_id_sal").innerText;
    var datapass = "?unenroll_user=true&userids="+id;
    sendData1("GET","finance/financial.php",datapass,cObj("err_handler_F"));
    cObj("unenroll_confirm").classList.add("hide");
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                cObj("see_enrolled").click();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}

cObj("salary_pays_btns").onclick = function () {
    //pay staff salary
    //FIRST CHECK FOR ERRORS
    var err = checkBlank("pay_mode");
    err+=checkBlank("amount_salary");
    var selection = cObj("pay_mode").value;
    if (selection == "m-pesa") {
        err+=checkBlank("mpesa_code");
    }else if (selection == "bank") {
        err+=checkBlank("bank_code");
    }
    if (err == 0) {
        cObj("err_handler_in").innerHTML = "";
        cObj("name_sake_2").innerText = cObj("staff_name").value
        cObj("amount_salo").innerText = cObj("amount_salary").value
        cObj("pay_salo_winds").classList.remove("hide");
    }else{
        cObj("err_handler_in").innerHTML = "<p class='red_notice'>Check all the fields colored with a redborder!</p>";
    }
}
cObj("no_salo_pay").onclick = function () {
    cObj("pay_salo_winds").classList.add("hide");
}

let divine = 0;
cObj("yes_salo_pay").onclick = function () {
    if (divine == 0) {
        makeSaloPay();
        divine ++;
        setTimeout(() => {
            divine = 0;
        }, 10000);
    }
}
function makeSaloPay() {
    var selection = cObj("pay_mode").value;
    var mode_of_pay = selection;
    var transaction_code = "cash"
    if (selection == "m-pesa") {
        transaction_code = cObj("mpesa_code").value;
    }else if (selection == "bank") {
        transaction_code = cObj("bank_code").value;
    }
    var datapass = "?pay_staff=true&staff_id="+cObj("stf_ids_pay").innerText+"&mode_of_pay="+mode_of_pay+"&transactioncode="+transaction_code+"&amount="+cObj("amount_salary").value;
    sendData1("GET","finance/financial.php",datapass,cObj("err_handler_in"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                seeEnrolled();
                var id = cObj("stf_ids_pay").innerText;
                cObj("pay_salo_winds").classList.add("hide");
                //delete values from the inputs
                cObj("amount_salary").value = 0;
                cObj("mpesa_code").value = 0;
                cObj("bank_code").value = 0;
                setTimeout(() => {
                    cObj("lipa"+id).click();
                }, 2000);
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("refresh_paydets").onclick = function () {
    var id = cObj("stf_ids_pay").innerText;
    cObj("lipa"+id).click();
}
cObj("back_to_payroll").onclick = function () {
    cObj("pay_salary_staff").classList.add("hide");
    cObj("viewEnrolledPay").classList.remove("hide");
    cObj("err_handler_in").innerHTML = "";
    //reset everything
    cObj("mpesa_salary").classList.add("hide");
    cObj("banks_sal").classList.add("hide");
    cObj("amount_sal").classList.add("hide");
    cObj("sal_pay_btns").classList.add("hide");
    cObj("def_opt").selected = true;
}
cObj("back_to_payrolls12").onclick = function () {
    cObj("salary_infor").classList.add("hide");
    cObj("viewEnrolledPay").classList.remove("hide");
}

//print the fees structure
cObj("print_structure").addEventListener("click",feesStructed);
function feesStructed() {
    //get the value of the fields
    var t_ones = document.getElementsByClassName("t-one");
    var t_two = document.getElementsByClassName("t-two");
    var t_three = document.getElementsByClassName("t-three");
    var vote_head = document.getElementsByClassName("vote_heads");
    var roles = document.getElementsByClassName("roles_in");
    //alert three
    //create the table and add the data to the field
    var table_data = "<table><tr><th>Votehead</th><th>Term One</th><th>Term Two</th><th>Term Three</th><th>Roles</th><th>Total</th></tr>";
    if (t_ones.length > 0) {
        var grand_total = 0;
        var termone = 0;
        var termtwo = 0;
        var termthree = 0;
        for (let index = 0; index < t_two.length; index++) {
            var total = (t_ones[index].innerText*1)+(t_two[index].innerText*1)+(t_three[index].innerText*1);
            grand_total+=total;
            termone+=t_ones[index].innerText*1;
            termtwo+=t_two[index].innerText*1;
            termthree+=t_three[index].innerText*1;
            table_data+="<tr><td>"+vote_head[index].innerText+"</td><td>Kes "+t_ones[index].innerText+"</td><td>Kes "+t_two[index].innerText+"</td><td>Kes "+t_three[index].innerText+"</td><td>"+roles[index].innerText+"</td><td><b>Kes "+total+"</b></td></tr>";
        }
        table_data+="<tr><td><b>Total</b></td><td><b>Kes "+termone+"</b></td><td><b>Kes "+termtwo+"</b></td><td><b>Kes "+termthree+"</b></td></tr>";
        table_data+="<tr><td><b>Grand Total</b></td><td><b>Kes "+grand_total+"</b></td></tr>";
        //fill all the fields in that class with the data 
        var dataholder = document.getElementsByClassName("terms_fees");
        for (let index = 0; index < dataholder.length; index++) {
            const element = dataholder[index];
            element.innerHTML = table_data;
        }
        //add the class value in the fees struct
        var inside = document.getElementsByClassName("class_struct_in");
        for (let index = 0; index < inside.length; index++) {
            const element = inside[index];
            element.innerText = cObj("class_display_fees").innerText;
        }

        //show the window
        hideWindow();
        cObj("print_fees_struct").classList.remove("hide");
    }
    
}

cObj("view-options-date").onchange = function () {
    if (this.value == "by-date") {
        cObj("bydates_viewings").classList.remove("hide");
        cObj("by_months_viewing").classList.add("hide");
    }else if (this.value == "by-month") {
        cObj("bydates_viewings").classList.add("hide");
        cObj("by_months_viewing").classList.remove("hide");
    }
    cObj("date_err").innerText = "";
}


var rowsColStudents = [];
var pagecountTransaction = 0; //this are the number of pages for transaction
var pagecounttrans = 1; //the current page the user is
var startpage = 1; // this is where we start counting the page number



function getMpesaPayments() {
    // get the exams that are already done
    rowsColStudents = [];
    var datapass = "?mpesaTransaction=true";
    sendData2("GET", "../ajax/finance/financial.php", datapass, cObj("output"), cObj("completedTransHolder"));
    setTimeout(() => {
        var timeout = 0;
        var idms = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(idms);
            }
            if (cObj("completedTransHolder").classList.contains("hide")) {
                // get the arrays
                var results = cObj("output").innerText;
                if (results != "NULL" && results.length > 0) {
                    var rows = results.split("|");
                    //create a column now
                    for (let index = 0; index < rows.length; index++) {
                        const element = rows[index];
                        var col = element.split(":");
                        rowsColStudents.push(col);
                    }

                    cObj("tot_records").innerText = rows.length;
                    //create the display table
                    //get the number of pages
                    cObj("transDataReciever").innerHTML = displayRecord(1, 10, rowsColStudents);

                    //show the number of pages for each record
                    var counted = rows.length / 10;
                    pagecountTransaction = Math.ceil(counted);

                } else {
                    cObj("transDataReciever").innerHTML = "<p class='sm-text text-danger text-bold text-center'><span style='font-size:40px;'><i class='fas fa-exclamation-triangle'></i></span> <br>Ooops! No Students has sat for the test!</p>";
                    cObj("tablefooter").classList.add("invisible");
                }

                // set the listener for the assign button
                var assign_payment = document.getElementsByClassName("assign_payment");
                for (let index = 0; index < assign_payment.length; index++) {
                    const element = assign_payment[index];
                    element.addEventListener("click",find_Payment)
                }
                stopInterval(idms);
            }
        }, 100);
    }, 100);
}
// create a function to assign payment to value
function setAssignLis() {
    // set the listener for the assign button
    var assign_payment = document.getElementsByClassName("assign_payment");
    for (let index = 0; index < assign_payment.length; index++) {
        const element = assign_payment[index];
        element.addEventListener("click",find_Payment)
    }
}

// display records

function displayRecord(start, finish, arrays) {
    start--;
    if (start < 0) {
        start = 0;
    }
var total = arrays.length;
//the finish value
var fins = 0;
//this is the table header to the start of the tbody
var tableData = "<table class='table'><tr><th class='text-uppercase text-secondary text-xxs font-weight-bolder'>#</th><th class='text-uppercase text-secondary text-xxs font-weight-bolder'>Transaction No</th><th class='text-uppercase text-secondary text-xxs font-weight-bolder ps-2'>Amount</th><th class='text-uppercase text-secondary text-xxs font-weight-bolder ps-2'>Adm No</th><th class='text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2'>Time Of Transaction<br></th><th class='text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2'>ACTION<br></th><!-- <th></th><th></th> --></tr>";
if (finish < total) {
    fins = finish;
    //create a table of the 10 records
    for (let index = start; index < finish; index++) {
        //create table of 10 elements
        //the rows now with their respective data
        //check if the user has a null payment or not
        var status = arrays[index][7];
        var action = "";
        if (status == 0) {
            status = "<span style='color:red;'>Not-Assigned</span>";
            action = "<span class='link assign_payment' id='"+arrays[index][8]+"'><i class='fas fa-eye'></i> Assign</span>";
        } else {
            status = "<span style='color:green;'>Assigned</span>";
            action = "<span>Assigned</span>";
        }
        tableData += "<tr><td>"+(index+1)+"</td><td><div class='d-flex px-2 align-content-center'><div class='my-auto'><p class='mb-0 text-sm'><span class='text-uppercase text-secondary text-sm font-weight-bolder text-center'>" + arrays[index][0] + "</span></p></div></div></td><td><p class='text-sm font-weight-bold mb-0'>Kes " + arrays[index][1] + " </p></td><td><span class='text-xs font-weight-bold'>" + arrays[index][2] + "</span></td><td class='align-middle text-center'><p class='text-xs font-weight-bold'>" + arrays[index][3] + "</p></td><td class='align-middle'>"+action+"</td></tr>";
    }
} else {
    //create a table of the 10 records
    for (let index = start; index < total; index++) {
        //create table of 10 elements
        //the rows now with their respective data
        var status = arrays[index][7];
        var action = "";
        if (status == 0) {
            status = "<span style='color:red;'>Not-Assigned</span>";
            action = "<span class='link assign_payment' id='"+arrays[index][8]+"'><i class='fas fa-eye'></i> Assign</span>";
        } else {
            status = "<span style='color:green;'>Assigned</span>";
            action = "<span>Assigned</span>";
        }
        tableData += "<tr><td>"+(index+1)+"</td><td><div class='d-flex px-2 align-content-center'><div class='my-auto'><p class='mb-0 text-sm'><span class='text-uppercase text-secondary text-sm font-weight-bolder text-center'>" + arrays[index][0] + "</span></p></div></div></td><td><p class='text-sm font-weight-bold mb-0'>Kes " + arrays[index][1] + " </p></td><td><span class='text-xs font-weight-bold'>" + arrays[index][2] + "</span></td><td class='align-middle text-center'><p class='text-xs font-weight-bold'>" + arrays[index][3] + "</p></td><td class='align-middle'>"+action+"</td></tr>";
    }
    fins = total;
}
tableData += "</tbody></table>";
//set the start and the end value
cObj("startNo").innerText = (start+1);
cObj("finishNo").innerText = fins;
//set the page number
cObj("pagenumNav").innerText = pagecounttrans;
return tableData;
}
//next record 
//add the page by one and the number os rows to dispay by 10
cObj("tonextNav").onclick = function() {
    if (pagecounttrans < pagecountTransaction) { // if the current page is less than the total number of pages add a page to go to the next page
        startpage += 10;
        pagecounttrans++;
        var endpage = startpage + 11;
        cObj("transDataReciever").innerHTML = displayRecord(startpage, endpage, rowsColStudents);
    } else {
        pagecounttrans = pagecountTransaction;
    }
    setAssignLis();
}
// end of next records
cObj("toprevNac").onclick = function() {
if (pagecounttrans > 1) {
    pagecounttrans--;
    startpage -= 10;
    var endpage = (startpage + 10) - 1;
    cObj("transDataReciever").innerHTML = displayRecord(startpage, endpage, rowsColStudents);
}
setAssignLis();
}
cObj("tofirstNav").onclick = function() {
if (pagecountTransaction > 0) {
    pagecounttrans = 1;
    startpage = 0;
    var endpage = startpage + 10;
    cObj("transDataReciever").innerHTML = displayRecord(startpage, endpage, rowsColStudents);
}
setAssignLis();
}
cObj("tolastNav").onclick = function() {
if (pagecountTransaction > 0) {
    pagecounttrans = pagecountTransaction;
    startpage = ((pagecounttrans * 10) - 10) + 1;
    var endpage = startpage + 10;
    cObj("transDataReciever").innerHTML = displayRecord(startpage, endpage, rowsColStudents);
}
setAssignLis();
}

// seacrh keyword at the table
cObj("searchkey").onkeyup = function() {
    checkName(this.value);
    // set the listener for the assign button
    var assign_payment = document.getElementsByClassName("assign_payment");
    for (let index = 0; index < assign_payment.length; index++) {
        const element = assign_payment[index];
        element.addEventListener("click",find_Payment);
    }
}
//create a function to check if the array has the keyword being searched for
function checkName(keyword) {
if (keyword.length > 0) {
    cObj("tablefooter").classList.add("invisible");
    // set the 
} else {
    cObj("tablefooter").classList.remove("invisible");
}
var rowsNcol2 = [];
var keylower = keyword.toLowerCase();
var keyUpper = keyword.toUpperCase();
//row break
for (let index = 0; index < rowsColStudents.length; index++) {
    const element = rowsColStudents[index];
    //column break
    var present = 0;
    if (element[1].includes(keylower) || element[1].includes(keyUpper)) {
        present++;
    }
    if (element[2].includes(keylower) || element[2].includes(keyUpper)) {
        present++;
    }
    if (element[0].includes(keylower) || element[0].includes(keyUpper)) {
        present++;
    }
    //here you can add any other columns to be searched for
    if (present > 0) {
        rowsNcol2.push(element);
    }
}
if (rowsNcol2.length > 0) {
    cObj("transDataReciever").innerHTML = displayRecord(1, 10, rowsNcol2);
} else {
    cObj("transDataReciever").innerHTML = "<p class='sm-text text-danger text-bold text-center'><span style='font-size:40px;'><i class='fas fa-exclamation-triangle'></i></span> <br>Ooops! your search for \"" + keyword + "\" was not found</p>";
    cObj("tablefooter").classList.add("invisible");
}
}

// here we find payments 
function find_Payment() {
    // get the transaction information
    var datapass = "?mpesa_transaction_id="+this.id;
    sendData2("GET", "../ajax/finance/financial.php", datapass, cObj("output_mpesa_transactions"), cObj("loadings"));
    setTimeout(() => {
        var timeout = 0;
        var idms = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(idms);
            }
            if (cObj("loadings").classList.contains("hide")) {
                // get the arrays
                var results = cObj("output_mpesa_transactions").innerText;
                var mpesa_data = results.split(":");
                cObj("mpesa_id").innerText = mpesa_data[1];
                cObj("amount_paid").innerText = mpesa_data[2];
                cObj("wrong_adm").innerText = mpesa_data[3];
                cObj("trans_time").innerText = mpesa_data[4];
                cObj("payer_name").innerText = mpesa_data[7];
                cObj("msisdn").innerText = mpesa_data[6];
                cObj("payment_id").innerText = mpesa_data[0];
                cObj("mpesa_idds").innerText = mpesa_data[1];
                cObj("amount_to_transfer").innerText = mpesa_data[2];
                stopInterval(idms);
            }
        }, 100);
    }, 100);


    // switdh through the window
    cObj("mpesa_payment_tbl").classList.add("hide");
    cObj("payment_information").classList.remove("hide");
}
cObj("goback_link").onclick = function () {
    cObj("mpesa_payment_tbl").classList.remove("hide");
    cObj("payment_information").classList.add("hide");

    // clear some areas
    cObj("result_holder").classList.remove("hide");
    cObj("student_results").innerHTML = "";
    cObj("error_handled").innerHTML = "";
    cObj("payments_options").innerHTML = "";
    cObj("mpesaTrans").click();
}

// find the students results to assign the unassigned payment to
cObj("find_student_assign").onclick = function () {
    // get the student admission number
        var datapass = "?findadmno="+valObj("stud_admission_no");
        sendData2("GET", "../ajax/finance/financial.php", datapass, cObj("student_results"), cObj("loadings"));
        setTimeout(() => {
            var timeout = 0;
            var idms = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout == 1200) {
                    stopInterval(idms);
                }
                if (cObj("loadings").classList.contains("hide")) {
                    cObj("result_holder").classList.remove("hide");
                    if(cObj("student_results").innerText != "Admission number entered is invalid!"){
                        // this gets the payment options for that particular student
                        var class_studs_in = document.getElementsByClassName("class_studs_in");
                        var student_names = document.getElementsByClassName("student_names");
                        var queried = document.getElementsByClassName("queried");
                        // if the length is two then its the second one if its one then its the first one
                        var cl_length = class_studs_in.length;
                        var datapass = "?payfordetails=true&class_use=";
                        if (cl_length == 2) {
                            // get the length of the class
                            datapass+=class_studs_in[1].innerText;
                            cObj("stud_name").innerText = student_names[1].innerText;
                            queried[1].id = "std_closing_bal";
                        }else{
                            datapass+=class_studs_in[0].innerText;
                            cObj("stud_name").innerText = student_names[0].innerText;
                            queried[0].id = "std_closing_bal";
                        }
                        // send the data to get the select
                        sendData2("GET", "../ajax/finance/financial.php", datapass, cObj("payments_options"), cObj("loadings"));
                        setTimeout(() => {
                            var timeout = 0;
                            var idfs = setInterval(() => {
                                timeout++;
                                //after two minutes of slow connection the next process wont be executed
                                if (timeout == 1200) {
                                    stopInterval(idfs);
                                }
                                if (cObj("loadings").classList.contains("hide")) {
                            
                                    var payments_options = document.getElementsByClassName("payments_options");
                                    // if the length is two then its the second one if its one then its the first one
                                    var cl_length = payments_options.length;
                                    if (cl_length == 2) {
                                        payments_options[1].id = "payment_for_option";
                                    }else{
                                        payments_options[0].id = "payment_for_option";
                                    }
                                    stopInterval(idfs);
                                }
                            }, 100);
                        }, 100);
                    }
                    stopInterval(idms);
                }
            }, 100);
        }, 100);
}
var click = 0;
cObj("assigne_payment_btn").onclick = function () {
    // check if the object is selected
    if (cObj("student_results").innerText != "Admission number entered is invalid!") {
        checkBlank("payment_for_option");
        var payfor = cObj("payment_for_option").value;
        if (payfor.length > 0) {
            // var queried = document.getElementsByClassName("queried");
            if (click == 0) {
                cObj("error_handled").innerHTML = "";
                var prevbal = (cObj("std_closing_bal").innerText*1);
                var amountpaid = (cObj("amount_paid").innerText*1);
                var balance = prevbal;
                var datapass = "?insertpayments=true&stuadmin="+valObj("stud_admission_no")+"&transcode="+cObj("mpesa_id").innerText+"&amount="+amountpaid+"&payfor="+payfor+"&paidby=mpesa&modeofpay=mpesa&balances="+balance+"&send_sms=true&mpesa_id="+cObj("payment_id").innerText;
                sendData2("GET", "../ajax/finance/financial.php", datapass, cObj("error_handled"), cObj("loadings"));
                setTimeout(() => {
                    var timeout = 0;
                    var idfs = setInterval(() => {
                        timeout++;
                        //after two minutes of slow connection the next process wont be executed
                        if (timeout == 1200) {
                            stopInterval(idfs);
                        }
                        if (cObj("loadings").classList.contains("hide")) {
                            if (cObj("error_handled").innerText == "Transaction completed successfully!") {
                                setTimeout(() => {
                                    cObj("goback_link").click();
                                }, 2000);
                            }
                            stopInterval(idfs);
                        }
                    }, 100);
                }, 100);
                click = 1;
            }
            setTimeout(() => {
                click = 0;
            }, 2000);
            
        }else{
            cObj("error_handled").innerHTML = "<p class='text-danger'>Select what the fund is allocated for.</p>";
        }
    }else{
        // show error message
        cObj("error_handled").innerHTML = "<p class='text-danger'>You have not selected a student to associate the payment to.</p>";
    }
}
var stud_fname = [];
var sec_name = [];
var sur_name = [];
var stud_clases = [];
var adm_nos = [];
// get the students name, admission number and class
function getStudentNameAdmno() {
    stud_fname = [];
    sec_name = [];
    sur_name = [];
    stud_clases = [];
    adm_nos = [];
    datapass = "?getstudentdetails=true";
    sendData2("GET", "../ajax/finance/financial.php", datapass, cObj("err_handler"), cObj("loadings"));
    setTimeout(() => {
        var timeout = 0;
        var idfs = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(idfs);
            }
            if (cObj("loadings").classList.contains("hide")) {
                if (cObj("err_handler").innerText.length > 0) {
                    // change the data recieved to arrays
                    var data = cObj("err_handler").innerText;
                    var student_data = data.split("|");
                    for (let index = 0; index < student_data.length; index++) {
                        var element = student_data[index];
                        var single_stud = element.split(":");
                        // add the array to the student data array
                        stud_fname.push(single_stud[0]);
                        sec_name.push(single_stud[1]);
                        sur_name.push(single_stud[2]);
                        stud_clases.push(single_stud[3]);
                        adm_nos.push(single_stud[4]);
                    }
                }
                autocomplete(document.getElementById("studids"), stud_fname,sec_name,sur_name,adm_nos,stud_clases);
                autocomplete(document.getElementById("student_admno_in"), stud_fname,sec_name,sur_name,adm_nos,stud_clases);
                stopInterval(idfs);
            }
        }, 100);
    }, 100);
}

function autocomplete(inp, arr , arr2, arr3, arr4, arr5) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) {
            return false;
        }
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        var counter = 0;
        for (i = 0; i < arr.length; i++) {
            if (counter > 10) {
                break;
            }
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase() 
                || arr2[i].substr(0, val.length).toUpperCase() == val.toUpperCase()
                || arr3[i].substr(0, val.length).toUpperCase() == val.toUpperCase()
                || arr5[i].substr(0, val.length) == val
            ) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = /**"<strong>" +*/arr[i]+" "+arr2[i]+" "+arr3[i]+"("+arr4[i]+") - ("+arr5[i]+")"/**.substr(0, val.length)*/ /**+ "</strong>"*/;
                // b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr5[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
                counter++;
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function(e) {
        closeAllLists(e.target);
    });
}

// payroll calculations corner
cObj("add_allowances_in").onclick = function () {
    // display the window that will add allowances
    cObj("allowance_window").classList.remove("hide");
}
cObj("cancel_allowances").onclick = function () {
    // hide the window that will add allowances
    cObj("allowance_window").classList.add("hide");
}
//add allowances that are to be stored in the allowances holder
cObj("add_allowances").onclick = function () {
    var err = checkBlank("allowance_name");
    err+=checkBlank("allowance_amounts");
    if (err < 1) {
        // continue and make the data to JSON
        cObj("allowance_err1_handler").innerHTML = "";
        var name = valObj("allowance_name");
        var values = valObj("allowance_amounts");
        var json_data = cObj("allowance_holder").innerText;
        if (json_data.length > 0) {
            json_data= json_data.substr(0,(json_data.length-1))+",{\"name\":\""+name+"\",\"value\":\""+values+"\"}]";
        }else{
            json_data+="[{\"name\":\""+name+"\",\"value\":\""+values+"\"}]";
        }
        cObj("allowance_holder").innerText = json_data;
        // enpty the fields
        cObj("allowance_err1_handler").innerHTML = "<p class='text-success'>Data added successfully!</p>";
        setTimeout(() => {
            cObj("allowance_name").value = "";
            cObj("allowance_amounts").value = "";
            cObj("allowance_err1_handler").innerHTML = "";
            cObj("allowance_window").classList.add("hide");
        }, 1000);

        // take the string above and change it to json data
        const obj = JSON.parse(json_data);
        addAllowances(obj);
    }else{
        cObj("allowance_err1_handler").innerHTML = "<p class='text-danger'>Fill all fields marked with red-border to proceed!</p>";
    }
}

// function to add the allowances to be seen by the administrator
function addAllowances(data) {
    var data_to_display = "";
    var index = 1;
    data.forEach(element => {
        data_to_display+="<div class='row'><div class='col-md-6' ><label for='select_allowance"+index+"'><i>"+index+". "+element.name+":</i></label></div>"
        data_to_display+="<div class='col-md-3'><p>Kes "+element.value+" <span id='hold_val"+index+"' class='hide'>"+element.value+"</span></p></div><div class='col-md-3'><input type='checkbox' checked class='select_allowances' id='select_allowance"+index+"'>"
        data_to_display+=" <span class='funga remove_allowance mx-1' style='font-size: 15px;cursor: pointer;' id='remove_allowance"+index+"'>&times</span></div></div>";
        index++;
    });
    cObj("allowances_and_bonuses").innerHTML = data_to_display;
    // set listeners for the allowance removers
    var remove_allowance = document.getElementsByClassName("remove_allowance");
    for (let index = 0; index < remove_allowance.length; index++) {
        const element = remove_allowance[index];
        // set listeners 
        element.addEventListener("click",deleteAllowances);
    }
    var select_allowances = document.getElementsByClassName("select_allowances");
    for (let index = 0; index < select_allowances.length; index++) {
        const element = select_allowances[index];
        element.addEventListener("change",breakdownPayments);
    }
    breakdownPayments();
}
// function to add the allowances to be seen by the administrator
function addAllowances2(data) {
    var data_to_display = "";
    var index = 1;
    data.forEach(element => {
        data_to_display+="<div class='row'><div class='col-md-6'><label for='accept_allowance"+index+"'>"+index+". "+element.name+"</label></div><div class='col-md-3'>";
        data_to_display+="<p>Kes "+comma3(element.value)+"<span id='value_holder"+index+"' class='hide value_holder'>"+element.value+"</span></p></div><div class='col-md-3'>"
        data_to_display+="<input type='checkbox' checked class='accept_allowance' id='accept_allowance"+index+"'>";
        data_to_display+="<span class='funga removed_allowance mx-1' style='font-size: 15px;cursor: pointer;' id='removed_allowance"+index+"'>&times</span></div></div>";
        index++;
    });
    cObj("allowance_html").innerHTML = data_to_display;
    // set listeners for the allowance removers
    var removed_allowance = document.getElementsByClassName("removed_allowance");
    for (let index = 0; index < removed_allowance.length; index++) {
        const element = removed_allowance[index];
        // set listeners 
        element.addEventListener("click",deleteAllowances2);
    }
    // var accept_allowance = document.getElementsByClassName("accept_allowance");
    // for (let index = 0; index < accept_allowance.length; index++) {
    //     const element = accept_allowance[index];
    //     element.addEventListener("change",breakdownPayments);
    // }
    breakdownPayments2();
}
function deleteAllowances() {
    // get the id
    // remove index 1
    var index2 = this.id.substr(this.id.length-1);
    // get the data as string
    var data = cObj("allowance_holder").innerText;
    if (data.length > 0) {
        var obj = JSON.parse(data);
        var data2 = "[";
        for (let index = 0; index < obj.length; index++) {
            const element = obj[index];
            // skip the element data
            if (index+1 == index2) {
                continue;
            }
            data2+=JSON.stringify(element)+",";
        }
        data2 = data2.substring(0,data2.length-1)+"]";
        cObj("allowance_holder").innerText = data2;
        if (data2.length > 1) {
            var obj = JSON.parse(data2);
            addAllowances(obj);
        }else{
            cObj("allowance_holder").innerText = "";
            cObj("allowances_and_bonuses").innerHTML = "<p class='text-success'>No allowances to display at the moment.</p>";
        }
    }else{
        cObj("allowance_holder").innerText = "";
        cObj("allowances_and_bonuses").innerHTML = "<p class='text-success'>No allowances to display at the moment.</p>";
    }
}

function deleteAllowances2() {
    // get the id
    // remove index 1
    var index2 = this.id.substr(this.id.length-1);
    // get the data as string
    var data = cObj("allowance_holder_edit").innerText;
    if (data.length > 0) {
        var obj = JSON.parse(data);
        var data2 = "[";
        for (let index = 0; index < obj.length; index++) {
            const element = obj[index];
            // skip the element data
            if (index+1 == index2) {
                continue;
            }
            data2+=JSON.stringify(element)+",";
        }
        data2 = data2.substring(0,data2.length-1)+"]";
        cObj("allowance_holder_edit").innerText = data2;
        if (data2.length > 1) {
            var obj = JSON.parse(data2);
            addAllowances2(obj);
        }else{
            cObj("allowance_holder_edit").innerText = "";
            cObj("allowance_html").innerHTML = "<p class='text-success'>No allowances to display at the moment.</p>";
        }
    }else{
        cObj("allowance_holder_edit").innerText = "";
        cObj("allowance_html").innerHTML = "<p class='text-success'>No allowances to display at the moment.</p>";
    }
}
function breakdownPayments() {
    // get the additions
    var gross_salary = valObj("gross_salary");
    var teir = valObj("nssf_rates")?valObj("nssf_rates"):"none";
    var nssf_contribution = getNSSFContribution(gross_salary,teir);
    var income_after_nssf = gross_salary - nssf_contribution;
    var allowances = getAllowances();
    var taxable_income = income_after_nssf+allowances;
    var year = valObj("paye_effect_year");
    var income_tax = getIncomeTax(taxable_income,year);
    var personal_relief = 0;
    var final_income_tax = income_tax;
    // console.log(cObj("personal_relief").checked );
    if (cObj("personal_relief").checked  == true) {
        if (gross_salary > 24000) {
            personal_relief = 2400;
            if (income_tax > 2400) {
                final_income_tax = income_tax - personal_relief;
            }else{
                final_income_tax = 0;
            }
        }
    }
    var nhif_contribution = getNHIFContribution(gross_salary);
    var nhif_relief = nhif_contribution>200?200:0;
    var netSalary = (taxable_income - (final_income_tax + (nhif_contribution)));
    if (cObj("NHIF_relief").checked == true && cObj("deduct_NHIF").checked == true) {
        netSalary = (taxable_income - (final_income_tax + (nhif_contribution-nhif_relief)));
    }
    if (cObj("deduct_paye").checked == false) {
        netSalary+=final_income_tax;
    }
    if (cObj("deduct_NHIF").checked == false) {
        netSalary+=nhif_contribution;
    }
    cObj("gros_salo_rec").innerText = "Ksh "+comma3(gross_salary);
    cObj("nssf_contributes").innerText = "Ksh "+comma3(nssf_contribution);
    cObj("income_after_nssf_contribute").innerText = "Ksh "+comma3(income_after_nssf);
    cObj("all_allowances").innerText = "Ksh "+comma3(allowances);
    cObj("taxable_income_records").innerText = "Ksh "+comma3(taxable_income);
    cObj("incomeTaxRecord").innerText = "Ksh "+comma3(income_tax);
    cObj("personal_relief_records").innerText = "Ksh "+comma3(personal_relief);
    cObj("final_income_taxe").innerText = "Ksh "+comma3(final_income_tax);
    cObj("nhif_contributions_records").innerText = "Ksh "+comma3(nhif_contribution);
    cObj("nhif_relief_record").innerText = "Ksh "+comma3(nhif_relief);
    cObj("net_salary_record").innerText = "Ksh "+comma3(netSalary);
    cObj("amount_to_pay").value = netSalary.toFixed(0);
}
function breakdownPayments2() {
    // get the additions
    var gross_salary = valObj("gross_salary_edit");
    var teir = valObj("nssf_rates")?valObj("nssf_rates_edit"):"none";
    var nssf_contribution = getNSSFContribution(gross_salary,teir);
    var income_after_nssf = gross_salary - nssf_contribution;
    var allowances = getAllowances2();
    var taxable_income = income_after_nssf+allowances;
    var year = valObj("year_of_effect_paye");
    var income_tax = getIncomeTax(taxable_income,year);
    var personal_relief = 0;
    var final_income_tax = income_tax;
    // console.log(cObj("personal_relief").checked );
    if (cObj("personal_relief_accept").checked  == true) {
        if (gross_salary > 24000) {
            personal_relief = 2400;
            if (income_tax > 2400) {
                final_income_tax = income_tax - personal_relief;
            }else{
                final_income_tax = 0;
            }
        }
    }
    var nhif_contribution = getNHIFContribution(gross_salary);
    var nhif_relief = (nhif_contribution>200 && cObj("nhif_relief_accept").checked == true) ? 200:0;
    var netSalary = (taxable_income - (final_income_tax + (nhif_contribution)));
    if (cObj("nhif_relief_accept").checked == true && cObj("dedcut_nhif_edit").checked == true) {
        netSalary = (taxable_income - (final_income_tax + (nhif_contribution-nhif_relief)));
    }
    if (cObj("dedcut_paye_edit").checked == false) {
        netSalary+=final_income_tax;
    }
    if (cObj("dedcut_nhif_edit").checked == false) {
        netSalary+=nhif_contribution;
    }
    cObj("gros_salo_rec_edit").innerText = "Ksh "+comma3(gross_salary);
    cObj("nssf_contributes_edit").innerText = "Ksh "+comma3(nssf_contribution);
    cObj("income_after_nssf_contribute_edit").innerText = "Ksh "+comma3(income_after_nssf);
    cObj("all_allowances_edit").innerText = "Ksh "+comma3(allowances);
    cObj("taxable_income_records_edit").innerText = "Ksh "+comma3(taxable_income);
    cObj("incomeTaxRecord_edit").innerText = "Ksh "+comma3(income_tax);
    cObj("personal_relief_records_edit").innerText = "Ksh "+comma3(personal_relief);
    cObj("final_income_taxe_edit").innerText = "Ksh "+comma3(final_income_tax);
    cObj("nhif_contributions_records_edit").innerText = "Ksh "+comma3(nhif_contribution);
    cObj("nhif_relief_record_edit").innerText = "Ksh "+comma3(nhif_relief);
    cObj("net_salary_record_edit").innerText = "Ksh "+comma3(netSalary);
    cObj("change_salary").value = netSalary.toFixed(0);
}

function getNHIFContribution(gross_salary){
    if (gross_salary> 0 && gross_salary<= 5999) {
        return 150;
    }else if (gross_salary > 5999 && gross_salary <= 7999) {
        return 300;
    }else if (gross_salary > 7999 && gross_salary <= 11999) {
        return 400;
    }else if (gross_salary > 11999 && gross_salary <= 14999) {
        return 500;
    }else if (gross_salary > 14999 && gross_salary <= 19999) {
        return 600;
    }else if (gross_salary > 19999 && gross_salary <= 24999) {
        return 750;
    }else if (gross_salary > 24999 && gross_salary <= 29999) {
        return 850;
    }else if (gross_salary > 29999 && gross_salary <= 34999) {
        return 900;
    }else if (gross_salary > 34999 && gross_salary <= 39999) {
        return 950;
    }else if (gross_salary > 39999 && gross_salary <= 44999) {
        return 1000;
    }else if (gross_salary > 44999 && gross_salary <= 49999) {
        return 1100;
    }else if (gross_salary > 49999 && gross_salary <= 59999) {
        return 1200;
    }else if (gross_salary > 59999 && gross_salary <= 69999) {
        return 1300;
    }else if (gross_salary > 69999 && gross_salary <= 79999) {
        return 1400;
    }else if (gross_salary > 79999 && gross_salary <= 89999) {
        return 1500;
    }else if (gross_salary > 89999 && gross_salary <= 99999) {
        return 1600;
    }else if (gross_salary > 99999) {
        return 1700;
    }else{
        return 0;
    }
}

function getAllowances(){
    var select_allowances = document.getElementsByClassName("select_allowances");
    var allowance = 0;
    for (let index = 0; index < select_allowances.length; index++) {
        const element = select_allowances[index];
        // get the id of the element
        if (element.checked == true) {
            var id = "hold_val"+(element.id.substring(element.id.length-1)*1);
            allowance+=cObj(id).innerText*1;
        }
    }
    return allowance;
}
function getAllowances2(){
    var accept_allowance = document.getElementsByClassName("accept_allowance");
    var allowance = 0;
    for (let index = 0; index < accept_allowance.length; index++) {
        const element = accept_allowance[index];
        // get the id of the element
        if (element.checked == true) {
            var id = "value_holder"+(element.id.substring(element.id.length-1)*1);
            allowance+=cObj(id).innerText*1;
        }
    }
    return allowance;
}

function getIncomeTax(taxable_income,year){
    if (year == "2022") {
        if (taxable_income > 24000) {
            var tax = 0;
            // calculate the income tax
            if (taxable_income >= 12298) {
                var first_ten = 12298 * 0.1; //10%
                tax+=first_ten;
                if (taxable_income >= 23885) {
                    var second = (23885-12298) * 0.15//15%
                    tax+=second;
                    if (taxable_income >= 35472) {
                        var third = (35472 - 23885) * 0.2//20%
                        tax+=third;
                        if (taxable_income >= 47059) {
                            var fourth = (47059 - 35472) * 0.25;//25%
                            tax+=fourth;
                            if (taxable_income > 47059) {
                                var fifth = (taxable_income-47059) * 0.3
                                tax+=fifth;
                            }
                        }else{
                            var fourth = (taxable_income - 35472) * 0.20//20%
                            tax+=fourth; 
                        }
                    }else{
                        var third = (taxable_income - 23885) * 0.20//20%
                        tax+=third; 
                    }
                }else{
                    var second = (taxable_income - 12299) * 0.15//15%
                    tax+=second;
                }
            }else{
                tax += taxable_income * 0.1;
            }
            return tax;
        }else{return 0;}
    }else if (year == "2021") {
        var tax = 0;
        if (taxable_income >= 24000) {
            tax += (24000 * 0.1);
            if (taxable_income >= 32333) {
                tax+= (8333 * 0.25);
                if (taxable_income > 32333) {
                    tax += (taxable_income - 32333) * 0.3;
                }
            }else{
                tax+= (taxable_income - 24000) * 0.25;
            }
        }else{
            tax+= taxable_income*0.1;
        }
        return tax;
    }
}

function getNSSFContribution(gross_salary,teir) {
    var teir1 = 0;
    if (teir == "teir_1") {
        if (gross_salary >= 6000) {
            teir1 = 360;
        }else{
            teir1 = 0.06 * gross_salary;
        }
        return teir1;
    }else if (teir == "teir_1_2") {
        var teir1n2 = 0;
        if (gross_salary >= 6000) {
            // get the teir 1
            teir1n2+=360;
            if (gross_salary >=18000 ) {
                teir1n2+=720;
            }else{
                teir1n2+=(0.06 * (gross_salary-6000));
            }
        }else{
            teir1n2 = 0.06 * gross_salary;
        }
        return teir1n2;
    }else if (teir == "teir_old") {
        if(gross_salary >= 200){
            return 200;
        }else{
            return 0;
        }
    }else{
        return 0;
    }
}

cObj("gross_salary").onkeyup = function () {
    breakdownPayments();
}
cObj("personal_relief").onchange = function () {
    breakdownPayments();
}
cObj("NHIF_relief").onchange = function () {
    breakdownPayments();
}
cObj("nssf_rates").onchange = function () {
    breakdownPayments();
}
cObj("deduct_paye").onchange = function () {
    breakdownPayments();
}
cObj("deduct_NHIF").onchange = function () {
    breakdownPayments();
}
cObj("paye_effect_year").onchange = function () {
    breakdownPayments();
}
function get_salary_breakdown(){
    var salary_breakdown = "{\"gross_salary\":\""+valObj("gross_salary")+"\",";
    var personal_relief = cObj("personal_relief").checked ? "yes":"no";
    var nhif_relief = cObj("NHIF_relief").checked ? "yes":"no";
    var deduct_paye = cObj("deduct_paye").checked ? "yes":"no";
    var deduct_nhif = cObj("deduct_NHIF").checked ? "yes":"no";
    var nssf_rates = valObj("nssf_rates");
    salary_breakdown+="\"personal_relief\":\""+personal_relief+"\",\"nhif_relief\":\""+nhif_relief+"\"";
    salary_breakdown+=",\"deduct_paye\":\""+deduct_paye+"\",\"deduct_nhif\":\""+deduct_nhif+"\",\"nssf_rates\":\""+nssf_rates+"\""
    var allowances = cObj("allowance_holder").innerText.length>0 ? cObj("allowance_holder").innerText:"\"\"";
    salary_breakdown+=",\"allowances\":"+allowances+"";
    salary_breakdown+=",\"year\":\""+valObj("paye_effect_year")+"\"}";
    return salary_breakdown;
}
function get_salary_breakdown2(){
    var salary_breakdown = "{\"gross_salary\":\""+valObj("gross_salary_edit")+"\",";
    var personal_relief = cObj("personal_relief_accept").checked ? "yes":"no";
    var nhif_relief = cObj("nhif_relief_accept").checked ? "yes":"no";
    var deduct_paye = cObj("dedcut_paye_edit").checked ? "yes":"no";
    var deduct_nhif = cObj("dedcut_nhif_edit").checked ? "yes":"no";
    var nssf_rates = valObj("nssf_rates_edit");
    salary_breakdown+="\"personal_relief\":\""+personal_relief+"\",\"nhif_relief\":\""+nhif_relief+"\"";
    salary_breakdown+=",\"deduct_paye\":\""+deduct_paye+"\",\"deduct_nhif\":\""+deduct_nhif+"\",\"nssf_rates\":\""+nssf_rates+"\""
    var allowances = cObj("allowance_holder_edit").innerText.length>0 ? cObj("allowance_holder_edit").innerText:"\"\"";
    salary_breakdown+=",\"allowances\":"+allowances+"";
    salary_breakdown+=",\"year\":\""+valObj("year_of_effect_paye")+"\"}";
    return salary_breakdown;
}

cObj("edit_allowances").onclick = function () {
    cObj("allowance_window2").classList.remove("hide");
}
cObj("cancel_allowances2").onclick = function () {
    cObj("allowance_window2").classList.add("hide");
}

//add allowances that are to be stored in the allowances holder
cObj("add_allowances2").onclick = function () {
    var err = checkBlank("allowance_name2");
    err+=checkBlank("allowance_amounts2");
    if (err < 1) {
        // continue and make the data to JSON
        cObj("allowance_err2_handler").innerHTML = "";
        var name = valObj("allowance_name2");
        var values = valObj("allowance_amounts2");
        var json_data = cObj("allowance_holder_edit").innerText;
        if (json_data.length > 0) {
            json_data= json_data.substr(0,(json_data.length-1))+",{\"name\":\""+name+"\",\"value\":\""+values+"\"}]";
        }else{
            json_data+="[{\"name\":\""+name+"\",\"value\":\""+values+"\"}]";
        }
        cObj("allowance_holder_edit").innerText = json_data;
        // enpty the fields
        cObj("allowance_err2_handler").innerHTML = "<p class='text-success'>Data added successfully!</p>";
        setTimeout(() => {
            cObj("allowance_name2").value = "";
            cObj("allowance_amounts2").value = "";
            cObj("allowance_err2_handler").innerHTML = "";
            cObj("allowance_window2").classList.add("hide");
        }, 1000);

        // take the string above and change it to json data
        const obj = JSON.parse(json_data);
        addAllowances2(obj);
    }else{
        cObj("allowance_err2_handler").innerHTML = "<p class='text-danger'>Fill all fields marked with red-border to proceed!</p>";
    }
}
cObj("gross_salary_edit").onkeyup = function () {
    breakdownPayments2();
}
cObj("personal_relief_accept").onchange = function () {
    breakdownPayments2();
}
cObj("nhif_relief_accept").onchange = function () {
    breakdownPayments2();
}
cObj("nssf_rates_edit").onchange = function () {
    breakdownPayments2();
}
cObj("dedcut_paye_edit").onchange = function () {
    breakdownPayments2();
}
cObj("dedcut_nhif_edit").onchange = function () {
    breakdownPayments2();
}
cObj("year_of_effect_paye").onchange = function () {
    breakdownPayments2();
}