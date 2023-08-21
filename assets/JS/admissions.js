let presentBCNO = false;
let studentinformation;
let presentid;
let staffdata =[];
/***active windows */
cObj("admitbtn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("admitsStudents").classList.remove("hide");
    removesidebar();
    //get the classes from the database for the admissions window
    getClasses("class_admission","errolment","");
}
cObj("pleasewaiting").onclick = function () {
    //removePleasewait();
}
function getClasses(object_id,select_class_id,value_prefix) {
    var datapass = "?getclass=true&select_class_id="+select_class_id+"&value_prefix="+value_prefix;
    sendData1("GET","administration/admissions.php",datapass,cObj(object_id));
}
function showPleasewait() {
    cObj("pleasewaiting").classList.add("animate");
    cObj("pleasewaiting").classList.remove("hide");
}
function removePleasewait() {
    cObj("pleasewaiting").classList.remove("animate");
    cObj("pleasewaiting").classList.add("animate10");
    setTimeout(() => {
        cObj("pleasewaiting").classList.add("hide");
        cObj("pleasewaiting").classList.remove("animate10");
    }, 900);
}
cObj("dash").onclick = function () {
    hideWindow();
    unselectbtns();
    var auth = cObj("authoriti").value;
    if (auth=='0') {
        cObj("adminsdash").classList.remove("hide");        
    }else if (auth == '1') {
        cObj("htdash").classList.remove("hide");        
    }else if (auth == '5') {
        cObj("ctdash").classList.remove("hide");
    }else if (auth == '2') {
        cObj("tr_dash").classList.remove("hide");
    }else if (auth == '3') {
        cObj("dp_dash").classList.remove("hide");
    }else{
        cObj("tr_dash").classList.remove("hide");
    }
}
cObj("skip").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("admitsStudents").classList.remove("hide");
}
var auth = cObj("authoriti").value;
if (auth == 1 || auth == 3) {
    cObj("check_logs").onclick = function () {
        hideWindow();
        cObj("loggers_page").classList.remove("hide");
    }
}
cObj("findstudsbtn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("findstudents").classList.remove("hide");
    removesidebar();
    //get the classes from the database for the admissions window
    getClasses("stud_class_find","selclass","");
    getClasses("class_holders","classed","cl");
    getClubSportsList();
    cObj("resultsbody").classList.remove("hide");
    cObj("viewinformation").classList.add("hide");
}
cObj("update_school_profile").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("update_school_profile_page").classList.remove("hide");
    removesidebar();
    getSchoolInformation();
}
cObj("update_personal_profile").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("personal_profile_page").classList.remove("hide");
    removesidebar();
    //get my personal information
    getPersonalInformation();
}
function getSchoolInformation() {
    var datapass = "?getSchoolInformation=true";
    sendData1("GET","login/login.php",datapass,cObj("store_sch_information"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var schoolInformation = cObj("store_sch_information").innerText.split("|");
                cObj("school_name_s").value = schoolInformation[1];
                cObj("school_motto_s").value = schoolInformation[2];
                cObj("school_vission").value = schoolInformation[5];
                // console.log(schoolInformation);
                // console.log(cObj("store_sch_information").innerText);
                cObj("school_codes").value = schoolInformation[0];
                cObj("school_message_name").value = schoolInformation[8];
                cObj("administrator_name").value = schoolInformation[9];
                cObj("administrator_contacts").value = schoolInformation[6];
                cObj("administrator_email").value = schoolInformation[7];
                cObj("school_box_no").value = schoolInformation[10];
                cObj("box_Code").value = schoolInformation[11];

                // commented for null values
                // cObj(schoolInformation[12]).selected = true;
                // cObj(schoolInformation[13]).selected = true;
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function getPersonalInformation() {
    //get the personal informaton
    var datapass = "?get_my_information=true;";
    sendData1("GET","login/login.php",datapass,cObj("my_information_inner"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {                     
            }
            if (cObj("loadings").classList.contains("hide")) {
                if (cObj("my_information").innerText.length > 0) {
                    var personalInformation = cObj("my_information").innerText.split("|");
                    if (personalInformation.length > 0) {
                        cObj("my_full_name").value = personalInformation[0];
                        cObj("my_dob").value = personalInformation[1];
                        cObj(personalInformation[4]+"12").selected = true;
                        cObj("my_phone_no").value = personalInformation[3];
                        cObj("my_nat_id").value = personalInformation[6];
                        cObj("my_tsc_code").value = personalInformation[7];
                        cObj("my_mail").value = personalInformation[10];
                        cObj("my_address").value = personalInformation[5];
                        cObj("sys_username").value = personalInformation[8];
                    }
                    stopInterval(ids);   
                }
            }
        }, 100);
    }, 200);
}

cObj("callregister").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("classregister").classList.remove("hide");
    removesidebar();
}

// mpesa tables
cObj("mpesaTrans").onclick = function() {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("mpesa_trans").classList.remove("hide");
    removesidebar();
    getMpesaPayments();
}

cObj("my_reports").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("my_reports_page").classList.remove("hide");
    removesidebar();
    getMyReportclasses();
    getStudentNameAdmno();
}
cObj("send_feedback").onclick = function () {
    cObj("feed_back_btns").click();
}
cObj("feed_back_btns").onclick = function () {
    hideWindow();
    unselectbtns();
    cObj("send_feed_page").classList.remove("hide");
    removesidebar();
}
cObj("set_btns").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("settings_page").classList.remove("hide");
    removesidebar();
    //comeback
    getMyClassList();
    getActiveHours();
    activeTerms();
    getAdmissionEssentials();
    allowCTadmit();
    getRoleData();
    getClubHouses();
}

if(typeof(cObj("callrollcall")) != 'undefined' && cObj("callrollcall") != null){
    cObj("callrollcall").onclick = function () {
        hideWindow();
        unselectbtns();
        addselected("callregister");
        cObj("classregister").classList.remove("hide");
    }
}
/***
cObj("dashbutn").onclick = function () {
    hideWindow();
    unselectbtns();
    var auth = cObj("authoriti").value;
    if (auth=='0') {
        cObj("adminsdash").classList.remove("hide");        
    }else if (auth == '1') {
        cObj("htdash").classList.remove("hide");        
    }else if (auth == '5') {
        cObj("ctdash").classList.remove("hide");
    }else{
        cObj("ctdash").classList.remove("hide");
    }
    removesidebar();
} */
cObj("regstaffs").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("regstaff").classList.remove("hide");
    removesidebar();
    getStaff_roles();
}

cObj("managestaf").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("managestaff").classList.remove("hide");
    removesidebar();
    getStaff_roles_maanage();
}

cObj("promoteStd").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("promoteStdd").classList.remove("hide");
    removesidebar();
    displayWholeSchool();
}
cObj("payfeess").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("payfeesd").classList.remove("hide");
    removesidebar();
    getStudentNameAdmno();
}

cObj("findtrans").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("findtransaction").classList.remove("hide");
    removesidebar();
    getClasses("manage_trans","classedd","");
}

cObj("feestruct").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("feestructure").classList.remove("hide");
    removesidebar();
    getClasses("fees_struct_class","daros","");
}

cObj("expenses_btn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("expenses_win").classList.remove("hide");
    removesidebar();
    //get daily expenses
    displayTodaysExpense();
    //getClasses("fees_struct_class","daros","");
}

cObj("regsub").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("regsubjects").classList.remove("hide");
    removesidebar();
}
cObj("managesub").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("managesubjects").classList.remove("hide");
    removesidebar();
}

cObj("managetrnsub").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("managesubanteach").classList.remove("hide");
    removesidebar();
}
cObj("maanage_dorm").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("dorm_registration").classList.remove("hide");
    removesidebar();
    cObj("refresh_dorm_list").click();
}
cObj("exam_fill_btn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("exam_fillings").classList.remove("hide");
    removesidebar();
}
cObj("sms_broadcast").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("send_sms").classList.remove("hide");
    removesidebar();
    //function to display teachers
    displayTeacherNotice();
    //get recent sent messages
    getRecentMessage();
}
cObj("finance_report_btn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("finance_statement").classList.remove("hide");
    removesidebar();
    incomeStatement();
}
cObj("payroll_sys").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("payrolled_win").classList.remove("hide");
    removesidebar();
}
cObj("routes_n_trans").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("transport_n_route").classList.remove("hide");
    removesidebar();
    getRouteList();
    getTransport();
}
cObj("enroll_students").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("enroll_students_transportsystem").classList.remove("hide");
    removesidebar();
    getStudentsTransport();
}
cObj("generate_tt_btn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("timetable_window").classList.remove("hide");
    removesidebar();
}
cObj("enroll_boarding_btn").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("enroll_boarding").classList.remove("hide");
    removesidebar();
    cObj("display_all_present").click();
}
function selectListeners() {
    cObj("btn_panel").classList.remove("btns");
    cObj("btn_panel").classList.add("hide");
    cObj("classes_list").classList.add("hide");
    cObj("grading_methods").classList.add("hide");
    cObj("subject_list").classList.remove("hide");
    var exam_id = this.value;
    var datapass = "?get_exam_class="+exam_id;
    sendData1("GET","academic/academic.php",datapass,cObj("subject_list"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                if(typeof(cObj("sub_jectlists")) != 'undefined' && cObj("sub_jectlists") != null){
                    cObj("sub_jectlists").addEventListener("change",selectSubject);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function selectSubject() {
    cObj("classes_list").classList.remove("hide");
    cObj("grading_methods").classList.remove("hide");
    cObj("btn_panel").classList.add("btns");
    cObj("btn_panel").classList.remove("hide");
    //show classes available 
    var subject_id = this.value;
    var exam_id = cObj("exam_list").value;
    var datapass = "?subjects_id_ds="+subject_id+"&exams_id_ids="+exam_id;
    sendData1("GET","academic/academic.php",datapass,cObj("classes_list"));
}
cObj("examanagement").onclick = function () {
    hideWindow();
    unselectbtns();
    addselected(this.id);
    cObj("exammanagement").classList.remove("hide");
    removesidebar();
    var datapass = "?getExamination=onetermexams";
    sendData1("GET","academic/academic.php",datapass,cObj("holdExaminfor"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var viewExams = document.getElementsByClassName("viewExams");
                for (let dc = 0; dc < viewExams.length; dc++) {
                    const element = viewExams[dc];
                    setExamListener(element.id);
                }
                var prints_exams = document.getElementsByClassName("prints_exams");
                for (let ind = 0; ind < prints_exams.length; ind++) {
                    const element = prints_exams[ind];
                    element.addEventListener("click",printExamsFunc);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
/******end of active window****** */

/********change password controls***********/
cObj("cancelchngebtn1").onclick = function () {
    cObj("passwindows").classList.remove("animate5");
    cObj("changepasswin").classList.add("hide");
    cObj("passwindows").style.left = '0px';
    cObj("changepass").style.height = '220px';
    valObj("enterpass").value='';
    valObj("reenterpass").value='';
}
cObj("cancelchngebtn2").onclick = function () {
    cObj("passwindows").classList.remove("animate5");
    cObj("changepasswin").classList.add("hide");
    cObj("passwindows").style.left = '0px';
    cObj("changepass").style.height = '220px';
    valObj("enterpass").value='';
    valObj("reenterpass").value='';
}

cObj("menubtn").onclick = function () {
    cObj("sideme").classList.remove("animate4");
    cObj("sideme").classList.add("animate3");
    cObj("sideme").classList.add("unhide");
    cObj("sideme").style.display='block';
    cObj("paneled").style.display='block';
}
cObj("closesidebar").onclick = function () {
    cObj("paneled").style.display='none';
    cObj("sideme").classList.remove("animate3");
    cObj("sideme").classList.add("animate4");
    setTimeout(() => {
        cObj("sideme").style.display = 'none';
    }, 400);
}
cObj("proceed").onclick = function () {
    cObj("passwindows").classList.add("animate5");
    setTimeout(() => {
        cObj("passwindows").style.left = '-400px';        
    }, 499);
    cObj("changepass").style.height = '300px';
}
cObj("back_one").onclick = function () {
    cObj("backtostaff").click();
}

cObj("changepwd").onclick = function () {
    cObj("changepasswin").classList.remove("hide");
}

cObj("changebtns").onclick = function () {
    let err = 0;
    var full = cObj("fullnamed").value;
    var split = full.split(" ");
    cObj("namesdd").innerText = split[0]+"`s";
    err+=checkBlank("enterpass");
    err+=checkBlank("reenterpass");
    if(err>0){
        cObj("passworderrors").innerHTML = "<p style='color:red;'>Please fill both the password fields!</p>";
    }else{
        if(valObj("enterpass")==valObj("reenterpass")){
            cObj("passworderrors").innerHTML = "<p style='color:green;'>Password do match</p>";
            cObj("changepasswin").classList.add("hide");
            let datapassings = "?updatingpassword="+valObj("reenterpass")+"&usersids="+cObj("staffid").innerText;
            sendData1("GET","administration/admissions.php",datapassings,cObj("passworderrors2"));
            cObj("cancelchngebtn1").click();
        }else{
            cObj("passworderrors").innerHTML = "<p style='color:red;'>Passwords don`t match!</p>";
        }
    }
}
/********end of change password***********/






/*********Admission essentials**********/
window.onload = function () {
    //get essentials
    var datapas = "?getessentials=true";
    sendData("GET","administration/admissions.php",datapas,cObj("admissionessentials"));
    var userid = cObj("authoriti").value;
    createTimetabe(userid);
    if (userid==5){
        var admin = document.getElementsByClassName("htbtn");
        for (let index = 0; index < admin.length; index++) {
            const element = admin[index];
            element.style.display = 'none';
        }
        cObj("class_tr_only").classList.add("hide");
        cObj("class_tr_onl").classList.remove("hide");
        cObj("class_assigned_tr").value = cObj("classselected").value;
        cObj("clas_tr_na").classList.remove("topsearch2");
        cObj("clas_tr_na").classList.add("hide");
        cObj("class_tr_search").classList.remove("hide");
        cObj("updatestudinfor").classList.add("hide");
        //in name
        var ct_cg_val = cObj("ct_cg_gc").value;
        if (ct_cg_val == "Yes") {
            cObj("admitbtn").style.display  = "flex";
        }
    }else if(userid==2){
        var admin = document.getElementsByClassName("htbtn");
        for (let index = 0; index < admin.length; index++) {
            const element = admin[index];
            element.style.display = 'none';
        }
        var admin = document.getElementsByClassName("tr_hides");
        for (let index = 0; index < admin.length; index++) {
            const element = admin[index];
            element.style.display = 'none';
        }
        cObj("class_tr_only").classList.add("hide");
        cObj("class_tr_onl").classList.remove("hide");
        cObj("class_assigned_tr").value = cObj("classselected").value;
        cObj("clas_tr_na").classList.remove("topsearch2");
        cObj("clas_tr_na").classList.add("hide");
        cObj("class_tr_search").classList.remove("hide");
        cObj("updatestudinfor").classList.add("hide");
    }else{
        // console.log(userid);
        cObj("clas_tr_na").classList.add("topsearch2");
        cObj("clas_tr_na").classList.remove("hide");
        showNyMenu(userid);

    }
    /***********start of class displays************/
    if(typeof(cObj("showmystuds")) != 'undefined' && cObj("showmystuds") != null){
        cObj("showmystuds").onclick = function () {
            alert("My name is hillary");
        }
    }

    //get the payment details here
    var datapass2 = "?payfordetails=true";
    sendData("GET","finance/financial.php",datapass2,cObj("payments"));

    var datapass3 = "?showsubjects=true";
    sendData("GET","academic/academic.php",datapass3,cObj("subjectlist"));
    var datapass3 = "?showsubjected=true";
    sendData("GET","academic/academic.php",datapass3,cObj("classeslist"));
    datapass3 = "?showsubject=true";
    sendData("GET","academic/academic.php",datapass3,cObj("subjClass"));
    //show school logo
    changeSchoolDpLocale();
    //show dp
    changeDpLocale();
/***********end of class displays************/
// start of checkbox selection
    var administration1 = document.getElementsByClassName("administration1");
    for (let index = 0; index < administration1.length; index++) {
        const element = administration1[index];
        element.addEventListener("change",administration_check);
    }
    var finance1 = document.getElementsByClassName("finance1");
    for (let index = 0; index < finance1.length; index++) {
        const element = finance1[index];
        element.addEventListener("change",finance_check);
    }
    var routesnvans1 = document.getElementsByClassName("routesnvans1");
    for (let index = 0; index < routesnvans1.length; index++) {
        const element = routesnvans1[index];
        element.addEventListener("change",route_check);
    }
    var academic_sect = document.getElementsByClassName("academic_sect");
    for (let index = 0; index < academic_sect.length; index++) {
        const element = academic_sect[index];
        element.addEventListener("change",academic_check);
    }
    var boarding_sect = document.getElementsByClassName("boarding_sect");
    for (let index = 0; index < boarding_sect.length; index++) {
        const element = boarding_sect[index];
        element.addEventListener("change",boarding_check);
    }
    var sms_broadcasted = document.getElementsByClassName("sms_broadcasted");
    for (let index = 0; index < sms_broadcasted.length; index++) {
        const element = sms_broadcasted[index];
        element.addEventListener("change",all_sms_check);
    }
    var accounts_section = document.getElementsByClassName("accounts_section");
    for (let index = 0; index < accounts_section.length; index++) {
        const element = accounts_section[index];
        element.addEventListener("change",all_account_settings);
    }
    /******************DONT CONFUSE*****************/
    // start of edit checks 2
    var administration12 = document.getElementsByClassName("administration12");
    for (let index = 0; index < administration12.length; index++) {
        const element = administration12[index];
        element.addEventListener("change",administration_check2);
    }
    var finance12 = document.getElementsByClassName("finance12");
    for (let index = 0; index < finance12.length; index++) {
        const element = finance12[index];
        element.addEventListener("change",finance_check2);
    }
    var routesnvans12 = document.getElementsByClassName("routesnvans12");
    for (let index = 0; index < routesnvans12.length; index++) {
        const element = routesnvans12[index];
        element.addEventListener("change",route_check2);
    }
    var academic_sect2 = document.getElementsByClassName("academic_sect2");
    for (let index = 0; index < academic_sect2.length; index++) {
        const element = academic_sect2[index];
        element.addEventListener("change",academic_check2);
    }
    var boarding_sect2 = document.getElementsByClassName("boarding_sect2");
    for (let index = 0; index < boarding_sect2.length; index++) {
        const element = boarding_sect2[index];
        element.addEventListener("change",boarding_check2);
    }
    var sms_broadcasted2 = document.getElementsByClassName("sms_broadcasted2");
    for (let index = 0; index < sms_broadcasted2.length; index++) {
        const element = sms_broadcasted2[index];
        element.addEventListener("change",all_sms_check2);
    }
    var accounts_section2 = document.getElementsByClassName("accounts_section2");
    for (let index = 0; index < accounts_section2.length; index++) {
        const element = accounts_section2[index];
        element.addEventListener("change",all_account_settings2);
    }

    // get if the reports button is set
    var datapass = "set_report_button=true";
    sendDataPost("POST","/sims/ajax/administration/admissions.php",datapass,cObj("set_reports"),cObj("set_reports2"));
    // get the student list 
    // 
    // load initial data
    
    if (auth == '1') {
        cObj("sch_logos").onclick = function () {
            cObj("update_school_profile").click();
        }
        //get number of students
        var datapass = "?getStudentCount=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studentscount"));

        //get number of students registerd today
        var datapass = "?studentscounttoday=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studentscounttoday"));
        

        //get number of students present in school today
        var datapass = "?studentspresenttoday=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studpresenttoday"));

        //get number off students absent

        setInterval(() => {
            if (!cObj("htdash").classList.contains("hide")){
                var total = cObj("studentscount").innerText.split(" ");
                var present = cObj("studpresenttoday").innerText.split(" ");
                var total1 = total[0];
                var present1 = present[0];
                if (present1!=0) {
                    cObj("absentstuds").innerText = (total1-present1)+" Student(s)";
                }else{
                    cObj("absentstuds").innerText = "Roll call not taken.";
                }
            }
        }, 900000);

        //number of active users
        var datapass = "?checkactive=true&userid="+cObj("useriddds").value;
        sendData("GET","administration/admissions.php",datapass,cObj("activeusers"));
        

        //number of school fees recieved
        var datapass = "?schoolfeesrecieved=true";
        sendData("GET","administration/admissions.php",datapass,cObj("schoolfeesrecieved"));
        

        //number of transfered students
        var datapass = "?transfered_students=true";
        sendData("GET","administration/admissions.php",datapass,cObj("transfered_studs"));
        
        //number of alumnis students
        var datapass = "?alumnis_number=true";
        sendData("GET","administration/admissions.php",datapass,cObj("alumnis_number"));
        

        //get the logs
        var datapass = "?get_loggers=true";
        sendData("GET","administration/admissions.php",datapass,cObj("loggers_table"));
        
        //get the active exams
        var datapass = "?active_exams_lts=true";
        sendData("GET","academic/academic.php",datapass,cObj("active_examination"));
        
        var datapass = "?subs_lists=true";
        sendData("GET","academic/academic.php",datapass,cObj("my_subjects"));
        
        //head teacher dashboard end
    }

    //deputy prncipal
    if (auth == 3) {
        
        //get number of students
        var datapass = "?getStudentCount=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studentscount"));
        
        //get number of students registerd today
        var datapass = "?studentscounttoday=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studentscounttoday"));
        
        //get number of students present in school today
        var datapass = "?studentspresenttoday=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studpresenttoday"));
        
        //number of active users
        var datapass = "?checkactive=true&userid="+cObj("useriddds").value;
        sendData("GET","administration/admissions.php",datapass,cObj("activeusers"));
        
        
        //get the logs
        var datapass = "?get_loggers=true";
        sendData("GET","administration/admissions.php",datapass,cObj("loggers_table"));
        
        //get the active exams
        var datapass = "?active_exams_lts=true";
        sendData("GET","academic/academic.php",datapass,cObj("active_examination"));
        
        //my subjects
        var datapass = "?subs_lists=true";
        sendData("GET","academic/academic.php",datapass,cObj("my_subjects"));
        
        //end of the deputy principal
    }
    
    //administrator dashboard = 0
    if (auth == 0) {
        //get number of students
        var datapass = "?getStudentCount=true";
        sendData("GET","administration/admissions.php",datapass,cObj("students"));

        //get number of users present in school
        var datapass = "?totaluserspresent=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studpresenttoday"));
        
        //number of active users
        var datapass = "?checkactive=true&userid="+cObj("useriddds").value;
        sendData("GET","administration/admissions.php",datapass,cObj("activeusers"));
        
        //get number of students present in school today
        var datapass = "?studentspresenttoday=true";
        sendData("GET","administration/admissions.php",datapass,cObj("rollcalnumber"));

        //get the logs
        var datapass = "?get_loggers=true";
        sendData("GET","administration/admissions.php",datapass,cObj("loggers_table"));
        
        //number of transfered students
        var datapass = "?transfered_students=true";
        sendData("GET","administration/admissions.php",datapass,cObj("transfered_stud2"));
        
        //number of alumnis students
        var datapass = "?alumnis_number=true";
        sendData("GET","administration/admissions.php",datapass,cObj("alumnis_number2"));
    }
    //classteacher dashboard = 5
    if (auth == 5) {
        //get total number of students in my class
        var datapass = "?number_of_me_studnets=true";
        sendData("GET","administration/admissions.php",datapass,cObj("studclass"));
        
        //get total number of students regestered today in my class
        var datapass = "?reg_today_my_class=true";
        sendData("GET","administration/admissions.php",datapass,cObj("reg_tod_mine"));
        
        //get total number of students present in school today in my class
        var datapass = "?today_attendance=true";
        sendData("GET","administration/admissions.php",datapass,cObj("my_att_clas"));

        //get total number of students present in school today in my class 
        var datapass = "?absent_students=true";
        sendData("GET","administration/admissions.php",datapass,cObj("my_absent_list"));

        //my subjects
        var datapass = "?subs_lists=true";
        sendData("GET","academic/academic.php",datapass,cObj("my_subjects"));
    
    }
    //the teachers` dashboard
    if (auth == 2) {
        //get the active exams
        var datapass = "?active_exams_lts=true";
        sendData("GET","academic/academic.php",datapass,cObj("active_examination"));

        //my subjects
        var datapass = "?subs_lists=true";
        sendData("GET","academic/academic.php",datapass,cObj("my_subjects"));
        
    }
}

        /*******end of it********/


function showNyMenu(authoriti) {
    var datapass = "?staff_roles=true";
    sendData2("GET","academic/academic.php",datapass,cObj("menu_data"),cObj("allow_ct_reg_clock_elect"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(ids);
            }
            if (cObj("allow_ct_reg_clock_elect").classList.contains("hide")) {
                var menu_data = cObj("menu_data").innerText;
                if(menu_data.length > 0){
                    var object = JSON.parse(menu_data);
                    for (let index = 0; index < object.length; index++) {
                        const element = object[index];
                        // console.log(element.roles);
                        if (element.name == authoriti) {
                            var roles = element.roles;
                            for (let index = 0; index < roles.length; index++) {
                                const ele = roles[index];
                                cObj(ele.name).style.display = "none"
                                if(ele.Status == "yes"){
                                    cObj(ele.name).style.display = "";
                                }
                            }
                        }
                    }
                }
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}

cObj("backtostaff").onclick = function(){
    //setwindow open
    cObj("constable").classList.remove("hide");
    cObj("informationwindow").classList.add("hide");
    viewstaffavailablebtn();
}
cObj("display_my_students").onclick = function () {
    //show the students by class
    var datapassing = "?find=true"+"&classes="+valObj("class_assigned_tr");
    //showPleasewait();
    sendData1("GET","administration/admissions.php",datapassing,cObj("resultsbody"));
    setTimeout(() => {
        cObj("resultsbody").classList.remove("hide");
        cObj("viewinformation").classList.add("hide");
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                    var btns = document.getElementsByClassName("view_students");
                    for (let index = 0; index < btns.length; index++) {
                        const element = btns[index];
                        setListenerBtnTab(element.id);
                    }
                    if (valObj("sach")=="allstuds") {
                        var obj = document.getElementsByClassName("viewclass");
                        setListenerViewbtn1(obj);
                    }else{                
                    }
                    //removePleasewait();
                stopInterval(ids);
            }
        }, 100);
    }, 200);

}

function createTimetabe(id) {
    if (id==2 || id==5) {
        cObj("create_tt_in").classList.add("hide");
    }
}
cObj("optd").onchange = function () {
    cObj("tableinformation").innerHTML = "";
    var err = checkBlank("optd");
    if (err==0) {
        if (valObj("optd")=="callreg") {
            cObj("moreopt").classList.remove("hide");
            cObj("moreopt2").classList.add("hide");
            cObj("register_btns").classList.remove("hide");
            //get classes
            getClasses("class_register_class","selectclass","");
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        if(typeof(cObj("selectclass")) != 'undefined' && cObj("selectclass") != null){
                            cObj("selectclass").addEventListener("change",selectClass);
                        }
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else if (valObj("optd")=="view_attendance") {
            cObj("moreopt").classList.add("hide");
            cObj("moreopt2").classList.remove("hide");
            cObj("register_btns").classList.add("hide");
        }
    }
}


cObj("natids").onblur = function () {
    let nationalid = this.value;
    if (nationalid.length>0) {   
        let staffid = cObj("staffid").innerText;
        let datapass = '?findnationalid='+nationalid+'&userids='+staffid;
        sendData("GET","administration/admissions.php",datapass,cObj("nationalids"));
    }
}

cObj("phonenumberd").onblur = function () {
    let phonenumber = this.value;
    if (phonenumber.length>0) {   
        let staffid = cObj("staffid").innerText;
        let datapass = '?findphonenumberd='+phonenumber+'&userids='+staffid;
        sendData("GET","administration/admissions.php",datapass,cObj("phoneerrord"));
    }
}

cObj("staffmail").onblur = function () {
    let emails = this.value;
    if (emails.length>0) {   
        let staffid = cObj("staffid").innerText;
        let datapass = '?findstafsemails='+emails+'&userids='+staffid;
        sendData("GET","administration/admissions.php",datapass,cObj("emailstaff"));
    }
}

cObj("usererrors").onblur = function () {
    let username = this.value;
    if (username.length>0) {   
        let staffid = cObj("staffid").innerText;
        let datapass = '?findusername='+username+'&userids='+staffid;
        sendData("GET","administration/admissions.php",datapass,cObj("emailstaff"));
    }
}


cObj('updatestaff').onclick = function () {
    let errors = 0;
    //check if changes are made
    let alikes = 0;
    if (staffdata.length>0) {
        alikes+=compareTwo(valObj1('dobd'),staffdata[1]);
        alikes+=compareTwo(valObj1('fullnamed'),staffdata[0]);
        alikes+=compareTwo(valObj1('natids'),staffdata[6]);
        alikes+=compareTwo(valObj1('phonenumberd'),staffdata[3]);
        alikes+=compareTwo(valObj1('addresdd'),staffdata[5]);
        // alikes+=compareTwo(valObj1('staffmail'),staffdata[12]);
        alikes+=compareTwo(valObj1('tscnosd'),staffdata[7]);
        alikes+=compareTwo(valObj1('usenames'),staffdata[8]);
        alikes+=compareTwo(valObj1("gende"),staffdata[4]);
        alikes+=compareTwo(valObj1("deleted"),staffdata[9]);
        alikes+=compareTwo(valObj1("activated"),staffdata[10]);
        alikes+=compareTwo(valObj1("auths"),staffdata[11]);
        if (alikes<12) {
            errors+=checkBlank("fullnamed");
            errors+=checkBlank("gende");
            errors+=checkBlank("dobd");
            errors+=checkBlank("natids");
            errors+=checkBlank("phonenumberd");
            errors+=checkBlank("auths");
            // errors+=checkEmails("staffmail","emailstaff");
            errors+=checkBlank("addresdd");
            if (errors>0) {
                cObj("updateerror").innerHTML = "<p style='color:red;'>Please fill all the field with red borders</p>";
            }else{
                cObj("updateerror").innerHTML = "<p style='color:red;'></p>";    
                let staffid = cObj("staffid").innerText;
                let datapassing = '?updatestaff=true&fullnames='+valObj1('fullnamed')+'&dob='+valObj1('dobd')+'&natids='+valObj1('natids')+'&phonenumber='+valObj1('phonenumberd')+'&address='+valObj1('addresdd');
                datapassing+='&emails='+valObj1('staffmail')+'&tscno='+valObj1('tscnosd')+'&username='+valObj1('usenames')+'&genders='+valObj1('gende')+'&activated='+valObj1('activated')+'&authorities='+valObj1('auths')+'&staffid='+staffid+'&deleted='+valObj1("deleted");
                datapassing+="&nssf_numbers="+valObj1("nssf_numbers")+"&nhif_numbers="+valObj1("nhif_numbers");
                sendData1('GET',"administration/admissions.php",datapassing,cObj('updateerror'));
                setTimeout(() => {
                    var timeout = 0;
                    var ids = setInterval(() => {
                        timeout++;
                        //after two minutes of slow connection the next process wont be executed
                        if (timeout==1200) {
                            stopInterval(ids);                        
                        }
                        if (cObj("loadings").classList.contains("hide")) {
                            setTimeout(() => {
                                cObj("updateerror").innerText = "";
                            }, 3000);
                            //removePleasewait();
                            stopInterval(ids);
                        }
                    }, 100);
                }, 200);
            }
        }
    }
}

cObj("delete_staff_permanently").onclick = function () {
    cObj("staff_name_del").innerText = cObj("fullnamed").value;
    cObj("delete_staff_perm").classList.remove("hide");
}
cObj("no_delete_permanently").onclick = function () {
    cObj("delete_staff_perm").classList.add("hide");
}
cObj("yes_delete_permanently").onclick = function () {
    var datapass = "?delete_staff=true&staff_ids="+cObj("staffid").innerText;
    sendData1('GET',"administration/admissions.php",datapass,cObj('updateerror'));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                cObj("delete_staff_perm").classList.add("hide");
                cObj("back_one").click();
                setTimeout(() => {
                    cObj("updateerror").innerText = "";
                }, 4000);
                //removePleasewait();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}



function  viewstaffavailablebtn() {
    cObj("informationwindow").classList.remove("hide");
    cObj("subject_and_teacher").classList.add("hide");
    //setwindow open
    cObj("constable").classList.remove("hide");
    cObj("informationwindow").classList.add("hide");
    var datastring = "?getavalablestaff=true";
    //showPleasewait();
    sendData1("GET","administration/admissions.php",datastring,cObj("stafferrors"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var collectbtn = document.getElementsByClassName('viewtr');
                for (let index = 0; index < collectbtn.length; index++) {
                    const element = collectbtn[index];
                    setListenertblstaff(element.id);
                }
                //removePleasewait();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function setListenertblstaff(id) {
    cObj(id).addEventListener('click',clicks);
}
//check if phone number , email,tscnumber and national id entered are present in the database
//cObj("").onblur = function () {
//    var value = this.value;
//    var idval = cObj("").innerText;
//}
function clicks() {
    var datapass = "?staffdata="+this.id;
    //showPleasewait();
    sendData1("GET","administration/admissions.php",datapass,cObj("errorsviewing"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var data = cObj("errorsviewing").innerText;
                //split the data
                var splitdata = data.split("^");
                staffdata = splitdata;
                cObj('dobd').value=splitdata[1];
                cObj(splitdata[4]).selected = true;
                setDatalen('fullnamed',splitdata[0]);
                setDatalen('natids',splitdata[6]);
                setDatalen('phonenumberd',splitdata[3]);
                setDatalen('addresdd',splitdata[5]);
                setDatalen('staffmail',splitdata[12]);
                setDatalen('tscnosd',splitdata[7]);
                setDatalen('usenames',splitdata[8]);
                setDatalen('nssf_numbers',splitdata[14]);
                setDatalen('nhif_numbers',splitdata[15]);
                // staff role
                var auth = splitdata[11];
                var data = "";
                if(auth==0){
                    data+="Administrator";
                }else if (auth == "1") {
                    data+="Headteacher";
                }else if (auth == "2") {
                    data+="Teacher";
                }else if (auth == "3") {
                    data+="Deputy principal";
                }else if (auth == "4") {
                    data+="Staff";
                }else if (auth == "6") {
                    data+="Student";
                }else if (auth == "5") {
                    data+="Class Teacher";
                }else {
                    data+=auth;
                }
                cObj("myauthorities").innerHTML = "<span style='color:blue;'>{"+data+"}</span>";
                cObj("del"+splitdata[9]).selected = true;
                cObj("act"+splitdata[10]).selected = true;
                cObj("staffid").innerText = splitdata[13];
                // cObj("auths"+splitdata[11]).selected = true;
        
                //setwindow open
                cObj("constable").classList.add("hide");
                cObj("informationwindow").classList.remove("hide");
                //removePleasewait();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
    
}
cObj("registerstaff").onclick = function () {
    var errs = checkerrorsstaf();
    if (cObj("err_hand_check_uname").innerText.length>0) {
        errs++;
        alert("Please use another username, the one given is already used!");
    }
    if(errs==0){
        var data = "";
        cObj("errors").innerHTML = "<p style='color:red;font-size:14px;'></p>";
        if(valObj("pword") == valObj("pword2")){
            var datapassing = "?insertstaff=true&fullnames="+valObj("fullnames")+"&dobos="+valObj("dobo")+"&genders="+valObj("gen")+"&phonenumbers="+valObj("phonenumber")+"&address="+valObj("adress");
            datapassing+="&idnumber="+valObj("poridnumber")+"&authority="+valObj("authority")+"&username="+valObj("username")+"&password="+valObj("pword")+"&tscnumber="+valObj("tscno")+"&emails="+valObj("staffemail");
            datapassing+="&nhif_number="+valObj("nhif_number")+"&nssf_number="+valObj("nssf_number");
            sendData1("GET","administration/admissions.php",datapassing,cObj("errors"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        let answer = cObj("errors").innerText.substr(0,12);
                        if(answer=="Registration"){
                            cObj("staffdatas").reset();
                        }

                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else{
            cObj("errors").innerHTML = "<p style='text-align:center;color:red;font-size:14px;'>Passwords don`t match!</p>";
        }

    }else{
        cObj("errors").innerHTML = "<p style='text-align:center;color:red;font-size:14px;'>Please fill all the field marked with red border</p>";
    }
}

cObj("resetstaffdatas").onclick = function () {
    cObj("staffdatas").reset();
}

cObj("username").onblur = function () {
    if (this.value.length > 0) {
        var datapass = "?usernames_value="+this.value;
        sendData2("GET","administration/admissions.php",datapass,cObj("err_hand_check_uname"),cObj("check_usernames_clock"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("check_usernames_clock").classList.contains("hide")) {
                    if (cObj("err_hand_check_uname").innerText.length>0) {
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

function checkerrorsstaf() {
    let errors = 0;
    errors+=checkBlank("fullnames");
    errors+=checkBlank("dobo");
    errors+=checkBlank("gen");
    errors+=checkPhone("phonenumber","phonehandler");
    errors+=checkBlank("adress");
    errors+=checkBlank("poridnumber");
    errors+=checkBlank("authority");
    errors+=checkBlank("username");
    errors+=checkBlank("pword");
    errors+=checkBlank("pword2");
    errors+=checkEmails("staffemail","emailhandler");
    return errors;

}
cObj("phonenumber").onblur = function () {
    let phone = this.value;
    if(this.value.length>0){
        let datapas = "?findphone="+phone;
        sendData("GET","administration/admissions.php",datapas,cObj("phonehandler"));
    }else{
        cObj("phonehandler").innerHTML = "<p></p>";
    }
}
cObj("poridnumber").onblur = function () {
    let id = this.value;
    if(this.value.length>0){
        let datapas = "?findidpass="+id;
        sendData("GET","administration/admissions.php",datapas,cObj("idpasshandler"));
    }else{
        cObj("idpasshandler").innerHTML = "<p></p>";
    }
}
cObj("tscno").onblur = function () {
    let tscnod = this.value;
    if(this.value.length>0){
        let datapas = "?findtscno="+tscnod;
        sendData("GET","administration/admissions.php",datapas,cObj("tschandler"));
    }else{
        cObj("tschandler").innerHTML = "<p></p>";
    }
}

cObj("staffemail").onblur = function () {
    let emails = this.value;
    if(this.value.length>0){
        let datapas = "?findemail="+emails;
        sendData("GET","administration/admissions.php",datapas,cObj("emailhandler"));
    }else{
        cObj("emailhandler").innerHTML = "<p></p>";
    }
}


cObj("sach").onchange = function () {
    if(this.value=="name"){
        cObj("swindow").classList.remove("hide");
        cObj("named").classList.remove("hide");
        cObj("admnosd").classList.add("hide");
        cObj("classenroll").classList.add("hide");
        cObj("bcnos").classList.add("hide");
    }else if(this.value=="AdmNo"){
        cObj("swindow").classList.remove("hide");
        cObj("named").classList.add("hide");
        cObj("admnosd").classList.remove("hide");
        cObj("classenroll").classList.add("hide");
        cObj("bcnos").classList.add("hide");
    }else if(this.value=="class"){
        cObj("swindow").classList.remove("hide");
        cObj("named").classList.add("hide");
        cObj("admnosd").classList.add("hide");
        cObj("classenroll").classList.remove("hide");
        cObj("bcnos").classList.add("hide");
    }else if(this.value=="bcno"){
        cObj("swindow").classList.remove("hide");
        cObj("named").classList.add("hide");
        cObj("admnosd").classList.add("hide");
        cObj("classenroll").classList.add("hide");
        cObj("bcnos").classList.remove("hide");
    }else if(this.value=="allstuds"){
        cObj("swindow").classList.add("hide");
    }else if(this.value=="regtoday"){
        cObj("swindow").classList.add("hide");
    }
}

cObj("findingstudents").onclick = function () {
    cObj("resultsbody").classList.remove("hide");
    cObj("viewinformation").classList.add("hide");
    if(valObj("sach").length>0){
        grayBorder(cObj("sach"));
        cObj("errorSearch").innerHTML = "<p style='color:red;font-size:14px'></p>";
        var datapassing = "?find=true";
        
        var erroro = 0;
        if(valObj("sach")=="name"){
            if(valObj("name").length>0){
                grayBorder(cObj("name"));
                datapassing+="&comname="+valObj("name");
            }else{
                redBorder(cObj("name"));
                erroro++;
            }
        }else if(valObj("sach")=="AdmNo"){
            if (valObj("admno").length > 0) {
                grayBorder(cObj("admno"));
                datapassing+="&comadm="+valObj("admno");
            }else{
                redBorder(cObj("admno"));
                erroro++;
            }
        }else if(valObj("sach")=="class"){
            if (cObj("selclass") != null) {
                if (valObj("selclass").length >0) {
                    grayBorder(cObj("selclass"));
                    datapassing+="&classes="+valObj("selclass");
                }else{
                    redBorder(cObj("selclass"));
                    erroro++;
                }
            }else{
                erroro++;
            }
        }else if(valObj("sach")=="bcno"){
            if (valObj("bcnosd")>0) {
                grayBorder(cObj("bcnosd"));
                datapassing+="&combcno="+valObj("bcnosd");
            }else{
                redBorder(cObj("bcnosd"));
                erroro++;
            }
        }else if (valObj("sach")=="allstuds") {
            datapassing+="&allstudents=true";
        }
        else if (valObj("sach")=="regtoday") {
            datapassing+="&todayreg=true";
        }
        if (erroro==0) {
            //showPleasewait();
            sendData1("GET","administration/admissions.php",datapassing,cObj("resultsbody"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                            var btns = document.getElementsByClassName("view_students");
                            for (let index = 0; index < btns.length; index++) {
                                const element = btns[index];
                                setListenerBtnTab(element.id);
                            }
                            if (valObj("sach")=="allstuds") {
                                var obj = document.getElementsByClassName("viewclass");
                                setListenerViewbtn1(obj);
                            }else{                            
                            }
                            //removePleasewait();
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }
    }else{
        redBorder(cObj("sach"));
        cObj("errorSearch").innerHTML = "<p style='color:red;font-size:14px'>Select an option to proceed!</p>";
    }
}

function setListenerViewbtn1(ids) {
    for (let index = 0; index < ids.length; index++) {
        const element = ids[index];
        element.addEventListener('click' , viewlisteners);
    }
}

function viewlisteners(){
    var ids = this.id;
    var datapassing = "?find=true";
    datapassing+="&classes="+ids;
    //showPleasewait();
    sendData1("GET","administration/admissions.php",datapassing,cObj("resultsbody")); setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                    var btns = document.getElementsByClassName("view_students");
                    for (let index = 0; index < btns.length; index++) {
                        const element = btns[index];
                        setListenerBtnTab(element.id);
                    }
                    //removePleasewait();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("name").onkeyup = function () {
    var name = this.value;
    cObj("resultsbody").classList.remove("hide");
    cObj("viewinformation").classList.add("hide");
    if(name.length>0){
        //query the server
        var datapass = "?find=true&bynametype="+name;
        sendData2("GET","administration/admissions.php",datapass,cObj("resultsbody"),cObj("names_loaders_find"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("names_loaders_find").classList.contains("hide")) {
                    var btns = document.getElementsByClassName("view_students");
                    for (let index = 0; index < btns.length; index++) {
                        const element = btns[index];
                        setListenerBtnTab(element.id);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 100);
    }
}

cObj("viewpresent").onclick = function () {
    if(typeof(cObj("selectclass")) != 'undefined' && cObj("selectclass") != null  ){
        var err = checkBlank("selectclass");
        if (err==0) {
            //if(valObj("selectclass").length>0)
            var daro = valObj("selectclass");
            var datapass = "?class="+daro+"&dates=today";
            //showPleasewait();
            sendData1("GET","administration/admissions.php",datapass,cObj("atendanceinfor"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        //removePleasewait();
                        stopInterval(ids);
                    }
                }, 100);
            }, 500);
            cObj("view_attendances").classList.remove("hide");
            cObj("mains").classList.add("hide");
        }
    }else if (valObj("classselected") != "0") {
        var daro = valObj("classselected");
        var datapass = "?class="+daro+"&dates=today";
        //showPleasewait();
        sendData1("GET","administration/admissions.php",datapass,cObj("atendanceinfor"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    //removePleasewait();
                    stopInterval(ids);
                }
            }, 100);
        }, 500);
        cObj("view_attendances").classList.remove("hide");
        cObj("mains").classList.add("hide");
    }else{
        alert("Select a class to proceed!")
    }
}
cObj("show_class_att").onclick = function () {
    if(valObj("classselected") != "0"){
        cObj("register_btns").classList.remove("hide");
        var classed = valObj("classselected");
        var date_used = valObj("class_register_dates_cltr");
        if(valObj("classselected").length>0){
            var datapass = "?getclassinformation=true&daro="+classed+"&date_used="+date_used;
            //showPleasewait();
            sendData1("GET","administration/admissions.php",datapass,cObj("tableinformation"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        //removePleasewait();
                        stopInterval(ids);
                    }
                }, 100);
            }, 500);
        }
    }
}

cObj("manage_tr_option").onchange = function () {
    if (this.value == "viewstaffavailable") {
        viewstaffavailablebtn();
    }else if (this.value == "assignclasses") {
        assignsubjectsbtn();
    }
}

cObj("display_attendance").onclick = function () {
    var err = checkBlank("date_selected");
    if (err == 0) {
        var date = cObj("date_selected").value;
        //
        if(typeof(cObj("selectclass")) != 'undefined' && cObj("selectclass") != null){
            if(valObj("selectclass").length>0){
                var daro = valObj("selectclass");
                var datapass = "?class="+daro+"&dates="+date;
                //showPleasewait();
                sendData1("GET","administration/admissions.php",datapass,cObj("atendanceinfor"));
                setTimeout(() => {
                    var timeout = 0;
                    var ids = setInterval(() => {
                        timeout++;
                        //after two minutes of slow connection the next process wont be executed
                        if (timeout==1200) {
                            stopInterval(ids);                        
                        }
                        if (cObj("loadings").classList.contains("hide")) {
                            //removePleasewait();
                            stopInterval(ids);
                        }
                    }, 100);
                }, 500);
                cObj("view_attendances").classList.remove("hide");
                cObj("mains").classList.add("hide");
            }
        }else if (valObj("classselected") != "0") {
            var daro = valObj("classselected");
            var datapass = "?class="+daro+"&dates="+date;
            //showPleasewait();
            sendData1("GET","administration/admissions.php",datapass,cObj("atendanceinfor"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        //removePleasewait();
                        stopInterval(ids);
                    }
                }, 100);
            }, 500);
            cObj("view_attendances").classList.remove("hide");
            cObj("mains").classList.add("hide");
        }
    }
}

cObj("backtosearch").onclick = function () {
    cObj("view_attendances").classList.add("hide");
    cObj("mains").classList.remove("hide");
}
cObj("display_student_attendances").onclick = function () {
    selectClass();
}
function  selectClass() {
    var classed = cObj("selectclass").value;
    var date_used = cObj("class_register_dates").value;
    if(cObj("selectclass").value.length>0 && date_used.length>0){
        cObj("register_btns").classList.remove("hide");
        var datapass = "?getclassinformation=true&daro="+classed+"&date_used="+date_used;
        //showPleasewait();
        sendData1("GET","administration/admissions.php",datapass,cObj("tableinformation"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    //removePleasewait();
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }
}

var classreg = "";
cObj("submitclasspresent").onclick = function () {
    var studpresnt = document.getElementsByClassName("present");
    var ids = "";
    let count =0;
    for (let index = 0; index < studpresnt.length; index++) {
        const element = studpresnt[index];
        if(element.checked){
            ids+=element.id+",";
            count++;
        }
    }
    if(count>0){
        var auth = cObj("authoriti").value;
        if (auth == 5) {
            var idcollection = ids.substr(0,ids.length-1).split(",");
            var name = cObj("myname").value;
            var daros = valObj("classselected");
            name+=","+daros+","+idcollection;
            var datapas = "?insertattendance="+name+"&calldate="+cObj("class_register_dates_cltr").value;
            cObj('message').innerHTML = "<p style='font-size:12px;'>Are you sure you want to submit attendance for "+classNameAdms(daros)+" on <b class='text-success'>"+cObj("class_register_dates_cltr").value+"</b>?</p>";
            classreg = datapas;
            cObj("dialogholder1").classList.remove("hide");
        }else{
            var idcollection = ids.substr(0,ids.length-1).split(",");
            var name = cObj("myname").value;
            var daros = valObj("selectclass");
            name+=","+daros+","+idcollection;
            var datapas = "?insertattendance="+name+"&calldate="+cObj("class_register_dates").value;
            cObj('message').innerHTML = "<p style='font-size:12px;'>Are you sure you want to submit attendance for "+classNameAdms(cObj("selectclass").value)+" on <b class='text-success'>"+cObj("class_register_dates").value+"</b>?</p>";
            classreg = datapas;
            cObj("dialogholder1").classList.remove("hide");
        }
        
    }
}
cObj("clasregyes").onclick = function () {
    sendData1("GET","administration/admissions.php",classreg,cObj("tablein"));
    cObj("dialogholder1").classList.add("hide");
}
cObj("clasregno").onclick = function () {
    cObj("dialogholder1").classList.add("hide");
    //sendData1("GET","administration/admissions.php",datapas,cObj("tablein"));
}

cObj("bcnosd").onkeyup = function () {
    var bcn = this.value;
    if(bcn.length>0){
        var datapass = "?find=true&bybcntype="+bcn;
        sendData("GET","administration/admissions.php",datapass,cObj("resultsbody"));
        setTimeout(() => {
            var btns = document.getElementsByClassName("view_students");
                for (let index = 0; index < btns.length; index++) {
                    const element = btns[index];
                    setListenerBtnTab(element.id);
                }
            }, 2000);
    }
}

function setListenerBtnTab(id) {
    cObj(id).addEventListener("click", tablebtnlistener);
}
function tablebtnlistener() {
    cObj("select_clubs_sports_def").selected = true;
    var admno = this.id.substr(4);
    //send the id to the database.
    let datapass = "?find=true&usingadmno="+admno;
    //showPleasewait();
    sendData1("GET","administration/admissions.php",datapass,cObj("studentinformation"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var infor = cObj("studentinformation").innerText;
                var splitdata = infor.split("^");
                studentinformation = splitdata;
                //check if he is the administrator
                var auth = cObj("authoriti").value;
                //if(auth == 1){
                    if(splitdata.length>10){
                        cObj("loadings").classList.remove("hide");
                        cObj("snamed_in").value = splitdata[0]
                        cObj("fnamed_in").value = splitdata[1]
                        cObj("lnamed_in").value = splitdata[2]
                        cObj("cl"+splitdata[6]).selected = true
                        cObj("adminnos").value = splitdata[7]
                        if(splitdata[3]==0){
                            cObj("indexnos").value = "N/A";
                        }else{
                            cObj("indexnos").value = splitdata[3];
                        }
            
                        if (splitdata[14]==0) {
                            cObj("bcnno").value = 'N/A';
                        }else{
                            cObj("bcnno").value = splitdata[14]
                        }
            
                        cObj("dobs").value = splitdata[4]
                        cObj("doas").value = splitdata[8]
                        if(splitdata[5].length>0){
                            cObj(splitdata[5]).selected = true
                        }
                        if(splitdata[15].length>0){
                            cObj(splitdata[15]).selected = true 
                        }
                        cObj("descriptionsd").value = splitdata[20];
                        cObj("addressed").value = splitdata[13];
                        cObj("pnamed").value = splitdata[9];
                        cObj("pcontacted").value = splitdata[10];
                        cObj("paddressed").value =splitdata[13];
                        cObj("pemails").value =splitdata[12];
                        cObj("parrelationship").value =splitdata[11];
                        cObj("resultsbody").classList.add("hide");
                        cObj("viewinformation").classList.remove("hide");
                        cObj("loadings").classList.add("hide");
                        cObj("updateerrors").innerHTML = "";
                        // console.log(splitdata);
                        cObj("paroccupation1").value = splitdata[26];
                        cObj("paroccupation2").value = splitdata[27];
                        cObj("medical_histry").value = splitdata[23];
                        //set for email and sms
                        if (splitdata[12].length > 5) {
                            var name = splitdata[1].substr(splitdata[1].length-1,splitdata.length);
                            var showname = splitdata[1]+"'s";
                            if (name == "s" || name == "S") {
                                showname = splitdata[1]+"'";
                            }
                            cObj("call_phone").innerHTML = "<a class='link' href='tel:"+splitdata[10]+"'>Click to call "+showname+" parent </a>";
                            cObj("mail_to").innerHTML = "<a class='link' href='mailto:"+splitdata[12]+"'>Click to send "+showname+" parent an email.</a>";
                        }
                        cObj("pnamed2").value = splitdata[16];
                        cObj("pcontacted2").value = splitdata[17];
                        cObj("pemails2").value = splitdata[19];
                        cObj("parrelationship2").value = splitdata[18];

                        var datainside = splitdata[22].trim().split(",");
                        var admission_essentialed = "<ol>";
                        var counting = 0;
                        for (let ind = 0; ind < datainside.length; ind++) {
                            const element = datainside[ind];
                            admission_essentialed+="<li>"+element+"</li>";
                            counting++;
                        }
                        admission_essentialed+="</ol>";
                        // console.log(datainside);
                        if (splitdata[22].trim().length > 1) {
                            cObj("admissionessentials_lists").innerHTML = admission_essentialed;
                        }else{
                            cObj("admissionessentials_lists").innerHTML = "No admission essentials";
                        }

                        // previous schools attended
                        var prev_schools = splitdata[24].trim().length>0? JSON.parse(splitdata[24]):[];
                        // console.log(prev_schools);
                        cObj("previous_school_json").innerText = splitdata[24];
                        var counters = 0;
                        var previous_schools = "<table class='table'><tr><th>No</th><th>School Name</th><th>Date Left</th><th>Marks Scored</th><th>Reason For Leaving</th><th>Leaving Certificate</th><th>Actions</th></tr>";
                        for (let indexes = 0; indexes < prev_schools.length; indexes++) {
                            counters++;
                            const element = prev_schools[indexes];
                            previous_schools+="<tr><td>"+(indexes+1)+"</td><td>"+element.school_name+"</td><td>"+element.date_left+"</td><td>"+element.marks_scored+"</td><td>"+element.reason_for_leaving+"</td><td>"+(element.leaving_cert=="true" ? "Submitted":"Not Submitted")+"</td><td><span class='link rm_prev_sch' id='rm_prev_sch"+indexes+"'><i class='fas fa-trash'></i> Remove</span></td></tr>";
                        }
                        previous_schools+="</table>";
                        if (counters > 0) {
                            cObj("prev_sch_list").innerHTML = previous_schools+"<br><p class='block_btn' id='edit_prev_school_btn'>Add Previous Schools</p>";
                            cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
                            // remove 
                            var rm_prev_sch = document.getElementsByClassName("rm_prev_sch");
                            for (let ind = 0; ind < rm_prev_sch.length; ind++) {
                                const element = rm_prev_sch[ind];
                                element.addEventListener("click", remove_school);
                            }
                        }else{
                            cObj("prev_sch_list").innerHTML = "<p class='block_btn'  id='edit_prev_school_btn'>Add Previous Schools</p><br><p class='text-danger'>No previous schools attended by the student has been recorded</p>";
                            cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
                        }
                        
                        // fees summary
                        cObj("current_term").innerHTML = splitdata[33];
                        cObj("current_term2").innerHTML = splitdata[33];
                        cObj("total_amount_to_pay").innerHTML = splitdata[30];
                        cObj("lastyr_fees_balance").innerHTML = splitdata[29];
                        cObj("fees_paid_this_term").innerHTML = splitdata[28];
                        cObj("fees_balances").innerHTML = splitdata[31];
                        cObj("total_paid_fees").innerHTML = splitdata[32];
                        cObj("transport_enrolled_std_infor").innerHTML = splitdata[34];
                        cObj("board_enrolled_std_infor").innerHTML = splitdata[35];

                        cObj("call_phone2").innerHTML = "<a class='link' href='tel:"+splitdata[17]+"'>Click to call "+showname+" parent </a>";
                        cObj("mail_to2").innerHTML = "<a class='link' href='mailto:"+splitdata[19]+"'>Click to send "+showname+" parent an email.</a>";

                        var clubs_in_sporter = document.getElementsByClassName("clubs_in_sporter");
                        // console.log(splitdata);
                        for (let index = 0; index < clubs_in_sporter.length; index++) {
                            const element = clubs_in_sporter[index];
                            if (element.value == splitdata[36]) {
                                element.selected = true;
                            }
                        }
                        // set the boarding data 
                        if (splitdata[21] != "enrolled" && splitdata[21] != "enroll") {
                            // the user has not been enrolled in any dormitory
                            cObj("boarding_status").innerHTML = "<span style='background-color: orange; color:white;' class='rounded p-1 '>Not-enrolled</span> || <span id='enroll_stud_boarding' class='link'>Click me to Enroll</span>";
                            // set the listener
                            cObj("enroll_stud_boarding").addEventListener("click",clickEnroll);
                        }else{
                            cObj("boarding_status").innerHTML = "<span style='background-color: green; color:white;' class='rounded p-1 '>Enrolled</span> || <span id='unenroll_stud_boarding' class='link' >CLick me to Un-Enroll ?</span>";
                            cObj("unenroll_stud_boarding").addEventListener("click",clickUnEnroll);
                        }
                    }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}

function edit_prev_school() {
    var previous_school_js = cObj("previous_school_json").innerText;
    // console.log(previous_school_js);
    cObj("previous_schools_windows_edit").classList.remove("hide");
}
cObj("canc_add_prev_sch_btn_edit").onclick = function () {
    cObj("previous_schools_windows_edit").classList.add("hide");
}
cObj("add_prev_sch_btn_edit").onclick = function () {
    var err = checkBlank("prev_school_name_edits");
    err+=checkBlank("date_left_edit");
    err+=checkBlank("marks_scored_edit");
    err+=checkBlank("leaving_certifcate_edit");
    err+=checkBlank("description_edit");
    if (err == 0) {
        // remove error
        cObj("add_prevsch_error_edit").innerHTML = "";
        // collect data
        var prev_school_name = cObj("prev_school_name_edits").value;
        var date_left = cObj("date_left_edit").value;
        var marks_scored = cObj("marks_scored_edit").value;
        var leaving_certifcate = cObj("leaving_certifcate_edit").checked;
        var description = cObj("description_edit").value;

        
        // proceed and add the information to the list
        var text = '[{"school_name":"'+prev_school_name+'","date_left":"'+date_left+'","marks_scored":"'+marks_scored+'","leaving_cert":"'+leaving_certifcate+'","reason_for_leaving":"'+description+'"}]';
        var available_txt = cObj("previous_school_json").innerText;
        if (available_txt.length > 0) {
            text = '{"school_name":"'+prev_school_name+'","date_left":"'+date_left+'","marks_scored":"'+marks_scored+'","leaving_cert":"'+leaving_certifcate+'","reason_for_leaving":"'+description+'"}';
            available_txt = available_txt.substring(0,available_txt.length-1)+","+text+"]";
            cObj("previous_school_json").innerText = available_txt;
            var prev_schools = JSON.parse(available_txt);
            var counters = 0;
            var previous_schools = "<p class='text-danger'><small>Please save before leaving this window</small></p><table class='table'><tr><th>No</th><th>School Name</th><th>Date Left</th><th>Marks Scored</th><th>Reason For Leaving</th><th>Leaving Certificate</th><th>Actions</th></tr>";
            for (let indexes = 0; indexes < prev_schools.length; indexes++) {
                counters++;
                const element = prev_schools[indexes];
                previous_schools+="<tr><td>"+(indexes+1)+"</td><td>"+element.school_name+"</td><td>"+element.date_left+"</td><td>"+element.marks_scored+"</td><td>"+element.reason_for_leaving+"</td><td>"+(element.leaving_cert=="true" ? "Submitted":"Not Submitted")+"</td><td><span class='link rm_prev_sch' id='rm_prev_sch"+indexes+"'><i class='fas fa-trash'></i> Remove</span></td></tr>";
            }
            previous_schools+="</table>";
            if (counters > 0) {
                cObj("prev_sch_list").innerHTML = previous_schools+"<br><p class='block_btn' id='edit_prev_school_btn'>Add Previous Schools</p>";
                cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
                // remove 
                var rm_prev_sch = document.getElementsByClassName("rm_prev_sch");
                for (let ind = 0; ind < rm_prev_sch.length; ind++) {
                    const element = rm_prev_sch[ind];
                    element.addEventListener("click", remove_school);
                }
            }else{
                cObj("prev_sch_list").innerHTML = "<p class='block_btn'  id='edit_prev_school_btn'>Add Previous Schools</p><br><p class='text-danger'>No previous schools attended by the student has been recorded</p>";
                cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
            }
        }else{
            cObj("previous_school_json").innerText = text;
            cObj("prev_sch_list").innerHTML = "<p class='block_btn'  id='edit_prev_school_btn'>Add Previous Schools</p><br><p class='text-danger'>No previous schools attended by the student has been recorded</p>";
            cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);

            var prev_schools = JSON.parse(text);
            var counters = 0;
            var previous_schools = "<p class='text-danger'><small>Please save before leaving this window</small></p><table class='table'><tr><th>No</th><th>School Name</th><th>Date Left</th><th>Marks Scored</th><th>Reason For Leaving</th><th>Leaving Certificate</th><th>Actions</th></tr>";
            for (let indexes = 0; indexes < prev_schools.length; indexes++) {
                counters++;
                const element = prev_schools[indexes];
                previous_schools+="<tr><td>"+(indexes+1)+"</td><td>"+element.school_name+"</td><td>"+element.date_left+"</td><td>"+element.marks_scored+"</td><td>"+element.reason_for_leaving+"</td><td>"+(element.leaving_cert=="true" ? "Submitted":"Not Submitted")+"</td><td><span class='link rm_prev_sch' id='rm_prev_sch"+indexes+"'><i class='fas fa-trash'></i> Remove</span></td></tr>";
            }
            previous_schools+="</table>";
            if (counters > 0) {
                cObj("prev_sch_list").innerHTML = previous_schools+"<br><p class='block_btn' id='edit_prev_school_btn'>Add Previous Schools</p>";
                cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
                // remove 
                var rm_prev_sch = document.getElementsByClassName("rm_prev_sch");
                for (let ind = 0; ind < rm_prev_sch.length; ind++) {
                    const element = rm_prev_sch[ind];
                    element.addEventListener("click", remove_school);
                }
            }else{
                cObj("prev_sch_list").innerHTML = "<p class='block_btn'  id='edit_prev_school_btn'>Add Previous Schools</p><br><p class='text-danger'>No previous schools attended by the student has been recorded</p>";
                cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
            }
        }
        cObj("previous_schools_windows_edit").classList.add("hide");
        cObj("prev_school_name_edits").value = "";
        cObj("date_left_edit").value = "";
        cObj("marks_scored_edit").value = "";
        cObj("leaving_certifcate_edit").checked = false;
        cObj("description_edit").value = "";
    }else{
        cObj("add_prevsch_error_edit").innerHTML = "<p class='text-danger'>Please fill all the fields with red borders</p>";
    }
}
function remove_school() {
    var ids = this.id.substr(11);
    var previous_school_js = cObj("previous_school_json").innerText.length > 0 ? JSON.parse(cObj("previous_school_json").innerText):[];
    var datapass = '[';
    var counter = 0;
    for (let index = 0; index < previous_school_js.length; index++) {
        const element = previous_school_js[index];
        if (index != ids) {
            datapass+=JSON.stringify(element)+",";
            counter++;
        }
    }
    if (counter > 0) {
        datapass = datapass.substring(0,(datapass.length-1))+"]";
        var prev_schools = JSON.parse(datapass);
        var counters = 0;
        var previous_schools = "<p class='text-danger'><small>Please save before leaving this window</small></p><table class='table'><tr><th>No</th><th>School Name</th><th>Date Left</th><th>Marks Scored</th><th>Reason For Leaving</th><th>Leaving Certificate</th><th>Actions</th></tr>";
        for (let indexes = 0; indexes < prev_schools.length; indexes++) {
            counters++;
            const element = prev_schools[indexes];
            previous_schools+="<tr><td>"+(indexes+1)+"</td><td>"+element.school_name+"</td><td>"+element.date_left+"</td><td>"+element.marks_scored+"</td><td>"+element.reason_for_leaving+"</td><td>"+(element.leaving_cert=="true" ? "Submitted":"Not Submitted")+"</td><td><span class='link rm_prev_sch' id='rm_prev_sch"+indexes+"'><i class='fas fa-trash'></i> Remove</span></td></tr>";
        }
        previous_schools+="</table>";
        
        cObj("prev_sch_list").innerHTML = previous_schools+"<br><p class='block_btn' id='edit_prev_school_btn'>Add Previous Schools</p>";
        cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
        // remove 
        var rm_prev_sch = document.getElementsByClassName("rm_prev_sch");
        for (let ind = 0; ind < rm_prev_sch.length; ind++) {
            const element = rm_prev_sch[ind];
            element.addEventListener("click", remove_school);
        }
        cObj("previous_school_json").innerText = datapass;
    }else{
        cObj("prev_sch_list").innerHTML = "<p class='text-danger'><small>Please save before leaving this window</small></p><p class='block_btn'  id='edit_prev_school_btn' >Add Previous Schools</p><br><p class='text-danger'>No previous schools attended by the student has been recorded</p>";
        cObj("edit_prev_school_btn").addEventListener("click",edit_prev_school);
        cObj("previous_school_json").innerText = "";
    }
}

cObj("delete_student").onclick = function () {
    var admno = cObj("adminnos").value;
    // get the student id to delete
    var datapass = "delete_student="+admno;
    sendDataPost("POST","/sims/ajax/administration/admissions.php",datapass,cObj("boarding_status_changer"),cObj("delete_student_load"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);
            }
            if (cObj("delete_student_load").classList.contains("hide")) {
                setTimeout(() => {
                    cObj("boarding_status_changer").innerHTML = "";
                    cObj("returnfind").click();
                    cObj("delete_studs_perm").classList.add("hide");
                }, 1000);
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}

cObj("prompt_delete_student").onclick = function () {
    cObj("stud_name_del").innerText = cObj("snamed_in").value+" "+cObj("fnamed_in").value+" "+cObj("lnamed_in").value;
    cObj("delete_studs_perm").classList.remove("hide");
}
cObj("no_delete_students").onclick = function () {
    cObj("delete_studs_perm").classList.add("hide");
}

function clickEnroll() {
    // click enroll
    // get the admission number of the student to enroll
    var admno = cObj("adminnos").value;
    // send the admission number to be enrolled
    var datapass = "?enroll_boarding_this="+admno;
    sendData2("GET","administration/admissions.php",datapass,cObj("boarding_status_changer"),cObj("boarding_status_load"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("boarding_status_load").classList.contains("hide")) {
                setTimeout(() => {
                    cObj("boarding_status_changer").innerHTML = "";
                }, 10000);
                stopInterval(ids);
                cObj("boarding_status").innerHTML = "<span style='background-color: green; color:white;' class='rounded p-1 '>Enrolled</span> || <span id='unenroll_stud_boarding' class='link' >CLick me to Un-Enroll ?</span>";
                cObj("unenroll_stud_boarding").addEventListener("click",clickUnEnroll);
            }
        }, 100);
    }, 200);
}
function clickUnEnroll() {
    // click enroll
    // get the admission number of the student to enroll
    var admno = cObj("adminnos").value;
    // send the admission number to be enrolled
    var datapass = "?unenroll_boarding_this="+admno;
    sendData2("GET","administration/admissions.php",datapass,cObj("boarding_status_changer"),cObj("boarding_status_load"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("boarding_status_load").classList.contains("hide")) {
                setTimeout(() => {
                    cObj("boarding_status_changer").innerHTML = "";
                }, 10000);
                cObj("boarding_status").innerHTML = "<span style='background-color: orange; color:white;' class='rounded p-1 '>Not-enrolled</span> || <span id='enroll_stud_boarding' class='link'>Click me to Enroll</span>";
                // set the listener
                cObj("enroll_stud_boarding").addEventListener("click",clickEnroll);
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}

cObj("updatestudinfor").onclick = function () {
    var changes = checkforchanged(studentinformation);
    changes = 1;
    var err = checkBlank("classed");
    if (err == 0) {
        cObj("updateerrors").innerHTML = "";
        cObj("coppy_cat_err").innerHTML = "";
        if(changes!=0){
            var classed  = valObj("classed");
            var index = valObj("indexnos");
            var bcnos = valObj("bcnno");
            var dobs = valObj("dobs");
            var gender = valObj("genders");
            var disabled = valObj("disableds");
            var describe = valObj("descriptionsd");
            var addressed = valObj("addressed");
            var pnamed = valObj("pnamed");
            var pcontacted = valObj("pcontacted");
            var paddressed = valObj("paddressed");
            var pemails = valObj("pemails");
            var parrelationship = valObj("parrelationship");
            var admnos = valObj("adminnos");
            var snamed = valObj("snamed_in");
            var fnamed = valObj("fnamed_in");
            var lnamed = valObj("lnamed_in");
            var occupation1 = valObj("paroccupation1");
            var occupation2 = valObj("paroccupation2");
            var medical_history = valObj("medical_histry");
            var clubs_in_sporters = valObj("clubs_in_sporters");
            var previous_schools = cObj("previous_school_json").innerText;
    
            var parname2 = valObj('pnamed2');
            var parconts2 = valObj('pcontacted2');
            var parrelation2 = valObj('parrelationship2');
            var pemail2 = valObj('pemails2');
            //collect the data and send to the database
            var datapass = "?updatestudinfor=true&class="+classed+"&index="+index+"&bcnos="+bcnos+"&dob="+dobs+"&genders="+gender+"&disabled="+disabled+"&describe="+describe;
            datapass+="&address="+addressed+"&pnamed="+pnamed+"&pcontacts="+pcontacted+"&paddress="+paddressed+"&pemail="+pemails+"&prelation="+parrelationship+"&adminnumber="+admnos;
            datapass+="&parentname2="+parname2+"&parentcontact="+parconts2+"&parentrelation="+parrelation2+"&pemails="+pemail2+"&snamed="+snamed+"&fnamed="+fnamed+"&lnamed="+lnamed;
            datapass+="&occupation1="+occupation1+"&occupation2="+occupation2+"&medical_history="+medical_history+"&clubs_in_sporters="+clubs_in_sporters+"&previous_schools="+previous_schools;
            cObj("updateerrors").innerHTML = "";
            sendData1("GET","administration/admissions.php",datapass,cObj("updateerrors"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        cObj("coppy_cat_err").innerHTML = cObj("updateerrors").innerHTML;
                        setTimeout(() => {
                            cObj("updateerrors").innerHTML = "";
                            cObj("coppy_cat_err").innerHTML = cObj("updateerrors").innerHTML;
                        }, 4000);
                        stopInterval(ids);
                    }
                }, 100);
            }, 100);
        }else{
        }
    }else{
        console.log(err);
        cObj("updateerrors").innerHTML = "<p class='text-danger'>Select class before you proceed!</p>";
        cObj("coppy_cat_err").innerHTML = "<p class='text-danger'>Select class before you proceed!</p>";
    }
}
function checkforchanged(olddata) {
    let changed = 0;
    if (valObj("classed")!=olddata[6]) {
        changed++;
    }

    var indexno = 0;
    if(valObj("indexnos")=="N/A"){
        indexno = 0;
    }else{
        indexno = valObj("indexnos");
    }

    if (indexno!=olddata[3]) {
        changed++;
    }

    var bcnos = 0;
    if(valObj("bcnno")=="N/A"){
        bcnos = 0;
    }else{
        bcnos = valObj("bcnno");
    }

    if (bcnos!=olddata[14]) {
        changed++;
    }

    if (valObj("dobs")!=olddata[4]) {
        changed++;
    }

    if (valObj("genders")!=olddata[5]) {
        changed++;
    }

    if (valObj("disableds")!=olddata[15]) {
        changed++;
    }
    if (valObj("descriptionsd")!=olddata[16]) {
        changed++;
    }

    if (valObj("addressed")!=olddata[13]) {
        changed++;
    }
    if (valObj("pnamed")!=olddata[9]) {
        changed++;
    }
    if (valObj("pcontacted")!=olddata[10]) {
        changed++;
    }
    if (valObj("paddressed")!=olddata[13]) {
        changed++;
    }
    if (valObj("pemails")!=olddata[12]) {
        changed++;
    }
    
    if (valObj("parrelationship")!=olddata[11]) {
        changed++;
    }
    return changed;
}
cObj("admno").onkeyup = function () {
    var admissionno = this.value;
    cObj("resultsbody").classList.remove("hide");
    cObj("viewinformation").classList.add("hide");
    if(admissionno.length>0){
        var datapass = "?find=true&admnoincomplete="+admissionno;
        sendData2("GET","administration/admissions.php",datapass,cObj("resultsbody"),cObj("admnos_loaders_find"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("admnos_loaders_find").classList.contains("hide")) {
                    var btns = document.getElementsByClassName("view_students");
                    for (let index = 0; index < btns.length; index++) {
                        const element = btns[index];
                        setListenerBtnTab(element.id);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 100);
    }
}
cObj("returnfind").onclick = function () {
    goBack();
}
cObj("go_back_1").onclick = function () {
    goBack();
}
function goBack () {
    cObj("resultsbody").classList.remove("hide");
    cObj("viewinformation").classList.add("hide");
    cObj("findingstudents").click();
}
if(typeof(cObj("showexpenses")) != 'undefined' && cObj("showexpenses") != null){
    cObj("showexpenses").onclick = function () {
        if(this.value == "Show"){
            this.value = "Hide";
            cObj("shwexpense").classList.add("hide");
        }else if(this.value == "Hide"){
            this.value = "Show";
            cObj("shwexpense").classList.remove("hide");
        }
    }
}


cObj("completeadmbtn").onclick = function () {
    //check if disabled is selected
    let err = 0;
    //data needed
    let disabled = "";
    let describe = "none";
    let paymode = "none";
    let payamount = "";
    let paycode = "cash";
    let boarded = "";
    //check disabled

    disabled = valObj("disabled");
    if(disabled == "Yes"){
        grayBorder(cObj("disabled"));
        describe = valObj("disability");
        if(describe.length>5){
            grayBorder(cObj("disability"));
        }else{
            redBorder(cObj("disability"));
            err++;
        }
    }else if (disabled =="No") {
        grayBorder(cObj("disabled"));
    }else{
        redBorder(cObj("disabled"));
        err++;
    }
    
    //check mode of payments
    var payedadmfee = valObj("payfees");
    if(payedadmfee=="Yes"){
        grayBorder(cObj("payfees"));
        paymode=valObj("paymode");
        if(paymode == "mpesa"){
            grayBorder(cObj("paymode"));
            paycode = valObj("mpesa");
            payamount = valObj("amounts");
            err+=checkBlank("mpesa");
            err+=checkBlank("amounts");
        }else if(paymode == "cash"){
            grayBorder(cObj("paymode"));
            payamount = valObj("amnt");
            err+=checkBlank("amnt");
        }else if(paymode == "bank"){
            grayBorder(cObj("paymode"));
            paycode = valObj("bank");
            payamount = valObj("amount");
            err+=checkBlank("bank");
            err+=checkBlank("amount");
        }else{
            err++;
            redBorder(cObj("paymode"));
        }
    }else if (payedadmfee=="No") {
        grayBorder(cObj("payfees"));
    }else{
        err++;
        redBorder(cObj("payfees"));
    }
    boarded = valObj("board");
    if(boarded=="enroll") {
        grayBorder(cObj("board"));
    }else if(boarded=="none") {
        grayBorder(cObj("board"));
    }else{
        redBorder(cObj("board"));
    }
    //check the selected checkbox
    var admissionessentials = document.getElementsByClassName("elementsadm");
    var len = admissionessentials.length;
    var admissionessentialscollected ="";
    if(len>0){
        for (let index = 0; index < admissionessentials.length; index++) {
            const element = admissionessentials[index];
            if (element.checked==true) {
                admissionessentialscollected+=element.value+",";
            }            
        }
        admissionessentialscollected = admissionessentialscollected.substr(0,(admissionessentialscollected.length-1));
    }
    //update information to the new students
    if(err==0){
        var admissno = cObj("admissionno").innerText;
        // console.log(admissno);
        var medical_history = cObj("medical_history").value;
        var source_of_funding_data = cObj("source_of_funding_data").value;
        var previous_schools = cObj("previous_schools").innerText;
        var clubs_n_sports = cObj("select_clubs_sports").value;
        if(admissno.length > 0){
            var datapass = "?completeadmit=true&disabled="+disabled+"&description="+describe+"&paymode="+paymode+"&payamount="+payamount+"&paycode="+paycode+"&boarded="+boarded+"&admno="+admissno+"&admissionessentials="+ admissionessentialscollected+"&fees_paid="+payedadmfee;
            datapass+="&medical_history="+medical_history+"&source_of_funding_data="+source_of_funding_data+"&previous_schools="+previous_schools+"";
            datapass+="&clubs_n_sports="+clubs_n_sports;
            sendData1("GET","administration/admissions.php",datapass,cObj("errorcomadmit"));
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (cObj("loadings").classList.contains("hide")) {
                        var errormessage = cObj("errorcomadmit").innerText.substr(0,12);
                        if(errormessage=="Registration"){
                            cObj("completeadm").reset();
                            cObj("errorcomadmit").innerHTML="<p></p>";
                            cObj("paysmode").classList.add("hide");
                            cObj("boardings").classList.add("hide");
                            cObj("cashed").classList.add("hide");
                            cObj("mpesas").classList.add("hide");
                            cObj("banks").classList.add("hide");
                            hideWindow();
                            cObj("admitsStudents").classList.remove("hide");
                        }
                        stopInterval(ids);
                    }
                }, 100);
            }, 500);
        }else{
            cObj("errorcomadmit").innerHTML = "<p style='color:red;'>Check your admission number and try again</p>";
        }
    }else{
        cObj("errorcomadmit").innerHTML = "<p style='color:red;'>Check for errors and try again!</p>";
    }
}

cObj("board").onchange = function () {
    if(this.value=="enroll"){
        cObj("boardings").classList.remove("hide");
    }else if(this.value=="none"){
        cObj("boardings").classList.add("hide");
    }else{
        cObj("boardings").classList.add("hide");
    }
}

cObj("disabled").onchange = function () {
    if(this.value=="Yes"){
        cObj("disable").classList.remove("hide");
    }else if (this.value=="No") {
        cObj("disable").classList.add("hide");
    }
}
cObj("payfees").onchange = function () {
    if(this.value=="Yes"){
        cObj("paysmode").classList.remove("hide");
    }else if (this.value=="No") {
        cObj("paysmode").classList.add("hide");
    }
}
cObj("paymode").onchange = function () {
    if(this.value=="mpesa"){
        cObj("cashed").classList.add("hide");
        cObj("mpesas").classList.remove("hide");
        cObj("banks").classList.add("hide");
    }else if (this.value=="cash") {
        cObj("cashed").classList.remove("hide");
        cObj("mpesas").classList.add("hide");
        cObj("banks").classList.add("hide");
    }else if (this.value=="bank") {
        cObj("cashed").classList.add("hide");
        cObj("mpesas").classList.add("hide");
        cObj("banks").classList.remove("hide");
    }
}


cObj("resetadmitform").onclick = function () {
    cObj("admitform").reset();
}
cObj("submitbtn").onclick = function () {
    //check for any blank field
    let errors = checkAdmission();
    if(errors==0 && presentBCNO==false){
        if(typeof(cObj("errolment")) != 'undefined' && cObj("errolment") != null){
            //proceed and upload the data
            cObj("erroradm").innerHTML = "<p style='color:green;font-size:14px;'>Good to go!</p>";
            //GET VALUES
            var surname = valObj('surname');
            var fname = valObj('fname');
            var sname = valObj('sname');
            var dob = valObj('dob');
            var gender = valObj('gender');
            var errolment = valObj('errolment');
            var parname = valObj('parname');
            var parconts = valObj('parconts');
            var parrelation = valObj('parrelation');
            var pemail = valObj('pemail');

            var parname2 = valObj('parname2');
            var parconts2 = valObj('parconts2');
            var parrelation2 = valObj('parrelation2');
            var pemail2 = valObj('pemail2');

            var bcno = valObj('bcno');
            var address = valObj('address');
            var upis = valObj("upis");
            var admno = "";
            if (valObj("automated_amd") == "insertmanually") {
                admno = cObj("mangen").value;
            }
            if (valObj("automated_amd") == "automate_adm") {
                admno = cObj("autogen").value;
            }

            var parent_accupation1 = valObj("parent_accupation1").trim().length > 0 ? valObj("parent_accupation1").trim() : "none";
            var parent_accupation2 = valObj("parent_accupation2").trim().length > 0 ? valObj("parent_accupation2").trim() : "none";
    
            var datapass = "?admit=true&surname="+surname+"&fname="+fname+"&sname="+sname+"&dob="+dob+"&gender="+gender+"&enrolment="+errolment+"&parentname="+parname+"&parentconts="+parconts+"&upis="+upis;
            datapass+="&parentrela="+parrelation+"&pemail="+pemail+"&bcno="+bcno+"&address="+address+"&admnos="+admno;
            datapass+="&parentrela2="+parrelation2+"&pemail2="+pemail2+"&parentname2="+parname2+"&parentconts2="+parconts2;
            datapass+="&parent_accupation1="+parent_accupation1+"&parent_accupation2="+parent_accupation2+"";
            sendData1("GET","administration/admissions.php",datapass,cObj("erroradm"));
            setTimeout(() => {
                var ids = setInterval(() => {
                    if (cObj("loadings").classList.contains("hide")) {
                        if(cObj("admnohold") != null){
                            var admnos = valObj("admnohold");
                            var names = valObj("namehold");
                            cObj("admissionno").innerText = admno;
                            cObj("studname").innerText = names;
                            cObj("admitform").reset();
                            //bring the complete admission window
                            hideWindow();
                            cObj("completeadmission").classList.remove("hide");
                            getClubsNSports();
                        }
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else{
            cObj("erroradm").innerHTML = "<p style='color:red;font-size:14px;'><strong>Errors</strong><br>No class selected!</p>";
        }
    }else{
        cObj("erroradm").innerHTML = "<p style='color:red;font-size:14px;'><strong>Errors</strong><br>Please fill all the fields with the red border and read their instructions correctly</p>";
        if(typeof(cObj("errolment")) == 'undefined' && cObj("errolment") == null){
            cObj("erroradm").innerHTML = "<p style='color:red;font-size:14px;'><strong>Errors</strong><br>No class selected!</p>";
        }
    }
}
cObj("bcno").onblur = function () {
    if(this.value.length>0){
        //check if the BCNO is present
        var datapassing = "?checkbcno="+this.value;
        sendData("GET","administration/admissions.php",datapassing,cObj("bcnerr"));
        setTimeout(() => {
            if(cObj("bcnerr").innerText.substr(0,3)=="The"){
                redBorder(this);
                presentBCNO=true;
            }else{
                grayBorder(this);
                presentBCNO=false;
            }
        }, 200);
        
    }
}
function checkAdmission() {
    let err =0;
    err+=checkBlank("surname");//username
    err+=checkBlank("fname");
    err+=checkBlank("sname");
    err+=checkBlank("dob");
    err+=checkBlank("gender");
    if(typeof(cObj("errolment")) != 'undefined' && cObj("errolment") != null){
        err+=checkBlank("errolment");
    }else{
        err++;
    }
    err+=checkBlank("parname");
    err+=checkPhone("parconts","parerr");
    err+=checkBlank("parrelation");
    err+=checkBlank("automated_amd");
    if (valObj("automated_amd") == "automate_adm") {
        err+=checkBlank("autogen");
    }
    if (valObj("automated_amd") == "insertmanually") {
        err+=checkBlank("mangen");
    }
    if (cObj("admgenman").innerText.length > 0) {
        err++;
    }
    return err;
}
function assignsubjectsbtn() {
    cObj("constable").classList.add("hide");
    cObj("informationwindow").classList.add("hide");
    cObj("subject_and_teacher").classList.remove("hide");
    //get the class teachers with no class assigned to them
    var datapass = "?get_CLassteacher=true";
    sendData1("GET","administration/admissions.php",datapass,cObj("getteacherdata"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                var change_classteacher = document.getElementsByClassName("change_classteacher");
                for (let fled = 0; fled < change_classteacher.length; fled++) {
                    const element = change_classteacher[fled];
                    setChangeTeacherListener(element.id);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}

function setChangeTeacherListener(ids) {
    cObj(ids).addEventListener("click",changeTeacherListener);
}
function changeTeacherListener() {
    cObj("tr_na_me").innerText = cObj("ccN"+this.id.substr(2)).innerText;
    cObj("class_assigned").innerText = cObj("ccD"+this.id.substr(2)).innerText;
    cObj("tr_id_s").innerText = this.id.substr(2);
    cObj("class_information").classList.remove("hide");
}
cObj("show_subjects").onclick = function () {
    cObj("assign_teacher").classList.remove("hide");
    //send data to the database to show those teachers with no classes
    var datapass = "?get_available_teacher=true;";
    sendData2("GET","administration/admissions.php",datapass,cObj("assign_data"),cObj("loader_win"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loader_win").classList.contains("hide")) {
                var check_subjects = document.getElementsByClassName("check_subjects");
                for (let fled = 0; fled < check_subjects.length; fled++) {
                    const element = check_subjects[fled];
                    setTeacherListener(element.id);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);

}
function setTeacherListener(ids) {
    cObj(ids).addEventListener("change",teacherListener);
}
function teacherListener() {
    if (this.checked == true) {
        cObj("partition").classList.remove("hide");
        cObj("select_teacher").classList.add("hide");
        cObj("add_subject").classList.remove("hide");
        //set name and id
        cObj("tr_ids").innerText = this.id.substr(4);
        cObj("tr_name").innerText = this.value;
        //get classes with no class teachers
        var datapass = "?get_Class_available=true";
        sendData2("GET","administration/admissions.php",datapass,cObj("class_list12"),cObj("loading_12"));
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("loading_12").classList.contains("hide")) {
                    var check_class = document.getElementsByClassName("check_class");
                    for (let fled = 0; fled < check_class.length; fled++) {
                        const element = check_class[fled];
                        setClassListener(element.id);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }
}
function setClassListener(ids) {
    cObj(ids).addEventListener("click",listenClas);
}


function listenClas() {
    if (this.checked == true) {
        //add the teacher to the database
        var check_class = document.getElementsByClassName("check_class");
        for (let fled = 0; fled < check_class.length; fled++) {
            const element = check_class[fled];
            element.checked = false;
        }
        this.checked = true;
    }
}
cObj("add_subject").onclick = function () {
    var check_class = document.getElementsByClassName("check_class");
    var class_selected = "";
    for (let fled = 0; fled < check_class.length; fled++) {
        const element = check_class[fled];
        if(element.checked == true){
            class_selected = element.value;
            break;
        }
    }
    if (class_selected.length>0) {
        cObj("errorhandler12031").innerHTML = "";
        //send data to the database
        var datapass = "?add_classteacher=true&clas_s="+class_selected+"&teacher_ids="+cObj("tr_ids").innerText;
        sendData1("GET","administration/admissions.php",datapass,cObj("errorhandler12031"));
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("loading_12").classList.contains("hide")) {
                    cObj("partition").classList.add("hide");
                    cObj("select_teacher").classList.remove("hide");
                    assignsubjectsbtn();
                    //close the window
                    cObj("assign_teacher").classList.add("hide");
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }else{
        cObj("errorhandler12031").innerHTML = "<p style='color:red;font-size:14px;'>Select a class to proceed!</p>";
    }
}
cObj("returnback2").onclick = function () {
    cObj("errorhandler12031").innerHTML = "";
    cObj("partition").classList.add("hide");
    cObj("select_teacher").classList.remove("hide");
    cObj("add_subject").classList.add("hide");
    //uncheck all checked fields
    var check_subjects = document.getElementsByClassName("check_subjects");
    for (let fled = 0; fled < check_subjects.length; fled++) {
        const element = check_subjects[fled];
        element.checked = false;
    }

}
cObj("cancel_addsub").onclick = function () {
    cObj("errorhandler12031").innerHTML = "";
    cObj("add_subject").classList.add("hide");
    cObj("partition").classList.add("hide");
    cObj("select_teacher").classList.remove("hide");
    cObj("assign_teacher").classList.add("hide");
}
cObj("cancel_win1").onclick = function () {
    cObj("errorhandler12031").innerHTML = "";
    cObj("add_subject").classList.add("hide");
    cObj("partition").classList.add("hide");
    cObj("select_teacher").classList.remove("hide");
    cObj("assign_teacher").classList.add("hide");
}
cObj("close_ci").onclick = function () {
    cObj("no_unassign").click();
    cObj("returnback3").click();
    cObj("class_information").classList.add("hide");
}
cObj("close_ci_1").onclick = function () {
    cObj("no_unassign").click();
    cObj("returnback3").click();
    cObj("class_information").classList.add("hide");
}
cObj("un_assign_btn").onclick = function () {
    cObj("confirm_delete_btns").classList.remove("hide");
    cObj("option_s").classList.add("hide");
}
cObj("no_unassign").onclick = function () {
    cObj("confirm_delete_btns").classList.add("hide");
    cObj("option_s").classList.remove("hide");
}
cObj("yes_unassign").onclick = function () {
    var datapass = "?teacher_unassign_id="+cObj("tr_id_s").innerText;
    sendData1("GET","administration/admissions.php",datapass,cObj("set_class_err"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                assignsubjectsbtn();
                cObj("set_class_err").innerText = "";
                cObj("close_ci").click();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("change_assigned_tr").onclick = function () {
    cObj("find_opts").classList.add("hide");
    cObj("options_ones").classList.remove("hide");
    cObj("save_inform").classList.remove("hide");
    var datapass="?get_teacher_for_subject=true";
    sendData2("GET","administration/admissions.php",datapass,cObj("populate_data"),cObj("load_teacher"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                var savedata = document.getElementsByClassName("check_teachers_subjects");
                for (let infor = 0; infor < savedata.length; infor++) {
                    const element = savedata[infor];
                    setListenerTrSub(element.id);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function setListenerTrSub(ids) {
    cObj(ids).addEventListener("change",listenerTrSub);
}
function listenerTrSub() {
    if (this.checked == true) {
        var savedata = document.getElementsByClassName("check_teachers_subjects");
        for (let index = 0; index < savedata.length; index++) {
            const element = savedata[index];
            element.checked = false;
        }
        cObj(this.id).checked = true;
    }
}
cObj("returnback3").onclick = function () {
    cObj("find_opts").classList.remove("hide");
    cObj("options_ones").classList.add("hide");
    cObj("save_inform").classList.add("hide");
    cObj("set_class_err").innerHTML="";
}
cObj("save_inform").onclick = function () {
    var savedata = document.getElementsByClassName("check_teachers_subjects");
    var present = 0;
    var id="";
    for (let index = 0; index < savedata.length; index++) {
        const element = savedata[index];
        if (element.checked == true) {
            present = 1;
            id = element.id.substr(7);
        }
    }
    if (present == 1) {
        cObj("set_class_err").innerHTML = "";
        var datapass = "?replace_tr_id="+id+"&existing_id="+cObj("tr_id_s").innerText;
        sendData1("GET","administration/admissions.php",datapass,cObj("set_class_err"));
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("loadings").classList.contains("hide")) {
                    cObj("set_class_err").innerHTML = "";
                    cObj("close_ci_1").click();
                    assignsubjectsbtn();
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }else{
        cObj("set_class_err").innerHTML = "<p style='color:red;font-size:14px;'>Select a teacher to proceed!</p>";
    }
}
/**
cObj("savers").onclick = function () {
    cObj("jj").classList.add("hide");
    cObj("imager1").classList.remove("hide");
    cObj("imager3").classList.add("hide");
    setTimeout(() => {
        cObj("imager2").classList.remove("hide");
        cObj("imager1").classList.add("hide");
        setTimeout(() => {
            cObj("imager3").classList.remove("hide");
            cObj("imager2").classList.add("hide");
        }, 1000);
    }, 1200);
}
 */
cObj("update_school_in4").onclick = function () {
    //check for error!
    var err = checkBlank("school_name_s");
    err+=checkBlank("school_motto_s");
    err+=checkBlank("school_message_name");
    err+=checkBlank("school_vission");
    err+=checkBlank("school_codes");
    err+=checkBlank("administrator_name");
    err+=checkBlank("administrator_contacts");
    err+=checkBlank("school_box_no");
    err+=checkBlank("box_Code");
    err+checkBlank("sch_country");
    err+=checkBlank("sch_county");
    if (err == 0) {
        cObj("school_information_err_handler").innerHTML = "";
        var datapass = "?update_school_information=true&school_name="+cObj("school_name_s").value+"&school_motto="+cObj("school_motto_s").value+"&school_message_name="+cObj("school_message_name").value+"&school_vission="+cObj("school_vission").value;
        datapass+="&school_codes="+cObj("school_codes").value+"&administrator_name="+cObj("administrator_name").value+"&administrator_contacts="+cObj("administrator_contacts").value+"&administrator_email="+cObj("administrator_email").value;
        datapass+="&postalcode="+cObj("box_Code").value+"&sch_box_no="+cObj("school_box_no").value;
        datapass+="&sch_country="+cObj("sch_country").value+"&sch_county="+cObj("sch_county").value;
        //alert(datapass);
        sendData1("GET","login/login.php",datapass,cObj("school_information_err_handler"));
    }else{
        cObj("school_information_err_handler").innerHTML = "<p style='font-size:13px;font-weight:600;color:red;'>Check all blank fields that are marked with a red border!</p>";
    }
}
cObj("change_my_information").onclick = function () {
    //check for blank spaces
    var err = checkBlank("my_full_name");
    err+=checkBlank("my_dob");
    err+=checkBlank("sys_username");
    err+=checkBlank("my_gender");
    err+=checkBlank("my_phone_no");
    err+=checkBlank("my_nat_id");
    err+=checkBlank("my_tsc_code");
    err+=checkBlank("my_address");
    err+=checkBlank("my_mail");
    if (cObj("check_me_username").innerText.length > 0) {
        err++;
    }
    if (err == 0) {
        cObj("update_my_infor").innerHTML = "";
        if (valObj("sys_username").trim().length > 4) {
            var datapass = "?change_my_information=true&my_name="+cObj("my_full_name").value+"&my_dob="+cObj("my_dob").value+"&my_username="+cObj("sys_username").value.trim()+"&my_gender="+cObj("my_gender").value+"&my_phone="+cObj("my_phone_no").value+"&my_nat_id="+cObj("my_nat_id").value+"&my_tsc_code="+cObj("my_tsc_code").value+"&my_address="+cObj("my_address").value+"&my_mail="+cObj("my_mail").value;
            sendData1("GET","login/login.php",datapass,cObj("update_my_infor"));
            grayBorder(cObj("sys_username"));
        }else{
            redBorder(cObj("sys_username"));
            cObj("update_my_infor").innerHTML = "<p style='font-size:13px;font-weight:600;color:red;'>Minimum of five characters to be used for the username!</p>";
        }
    }else{
        cObj("update_my_infor").innerHTML = "<p style='font-size:13px;font-weight:600;color:red;'>Check all blank fields that are marked with a red border!</p>";
    }
}
//change password
cObj("change_my_pass").onclick =  function () {
    //check blank
    var err = checkBlank("old_pass");
    err+=checkBlank("new_pass");
    err+=checkBlank("repeat_pass");
    if (err == 0) {
        if (valObj("new_pass").trim() == valObj("repeat_pass").trim()) {
            cObj("update_credential_infor").innerHTML = "";
            var datapass = "?update_password=true&old_pass="+valObj("old_pass").trim()+"&newpass="+valObj("new_pass").trim();
            sendData1("GET","login/login.php",datapass,cObj("update_credential_infor"));
            setTimeout(() => {
                var ids = setInterval(() => {
                    if (cObj("loadings").classList.contains("hide")) {
                        if (cObj("update_credential_infor").innerText == "Your old password is in-correct") {
                            redBorder(cObj("old_pass"));
                        }else{
                            grayBorder(cObj("old_pass"));
                        }
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else{
            redBorder(cObj("new_pass"));
            redBorder(cObj("repeat_pass"));
            cObj("update_credential_infor").innerHTML = "<p style='color:red;font-weight:600;font-size:13px;'>Passwords don`t match!</p>";
        }
    }else{
        cObj("update_credential_infor").innerHTML = "<p style='color:red;font-weight:600;font-size:13px;'>Check all blank fields that are marked with a red border!</p>";
    }
}
cObj("open_notify").onclick = function () {
    cObj("notification_win").classList.toggle("hide");
    cObj("log_notification").classList.toggle("hide");
    if (!cObj("notification_win").classList.contains("hide")) {
        //get the notification list
        var datapass = "?getNoticeTitles=true";
        sendData1("GET","notices/notices.php",datapass,cObj("notice_list"));
        setTimeout(() => {
            var ids = setInterval(() => {
                if (cObj("loadings").classList.contains("hide")) {
                    //set listeners for the view_students message button
                    var read_message = document.getElementsByClassName("set_notify");
                    for (let index = 0; index < read_message.length; index++) {
                        const element = read_message[index];
                        element.addEventListener("click",viewMessage);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }
}
cObj("open_more").onclick = function () {
    cObj("per_profile").classList.toggle("hide");
    cObj("log_notification").classList.toggle("hide");
}
cObj("log_notification").onclick = function () {
    if (!cObj("notification_win").classList.contains("hide")) {
        cObj("notification_win").classList.add("hide");
    }
    if (!cObj("per_profile").classList.contains("hide")) {
        cObj("per_profile").classList.add("hide");
    }
    this.classList.add("hide");
}
cObj("update_my_prof").onclick = function () {
    cObj("log_notification").classList.add("hide");
    cObj("per_profile").classList.add("hide");
    cObj("update_personal_profile").click();
}
cObj("logout_1").onclick = function () {
    cObj("log_notification").classList.add("hide");
    cObj("per_profile").classList.add("hide");
    cObj("logout").click();
}
cObj("close_read_notice1").onclick = function () {
    cObj("read_notice").classList.add("hide");
    refreshNotice();
}
cObj("close_read_notice").onclick = function () {
    cObj("read_notice").classList.add("hide");
    refreshNotice();
}
cObj("show_all_notices").onclick = function () {
    //show the notice window
    hideWindow();
    cObj("notices_window").classList.remove("hide");
//get the notices from the database
    var datapass = "?getAllMessages=true";
    sendData1("GET","notices/notices.php",datapass,cObj("notifies_holders"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                //set listeners for the view_students message button
                var read_message = document.getElementsByClassName("read_message");
                for (let index = 0; index < read_message.length; index++) {
                    const element = read_message[index];
                    element.addEventListener("click",viewMessage);
                }
                var delete_notice = document.getElementsByClassName("delete_notice");
                for (let index = 0; index < delete_notice.length; index++) {
                    const element = delete_notice[index];
                    element.addEventListener("click",deleteNofification);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
    //hide the notice pane
    cObj("notification_win").classList.add("hide");
    cObj("log_notification").classList.add("hide");

}
function viewMessage() {
    var notice_id = this.id.substr(3);
    viewMsg(notice_id);
}
function refreshNotice() {
    if (!cObj("notices_window").classList.contains("hide")) {
        cObj("show_all_notices").click();
    }
}
function deleteNofification() {
    //get the message id
    var datapas = "?delete_notice="+this.id.substr(4);
    sendData1("GET","notices/notices.php",datapas,cObj("delete_not"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                //refresh the notification
                cObj("show_all_notices").click();
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
function viewMsg(msg_id) {
    //get the data from the database
    var datapass = "?getMyNoticeid="+msg_id;
    sendData1("GET","notices/notices.php",datapass,cObj("msg_body"));
    //display the view_students message window
    cObj("read_notice").classList.remove("hide");
    //if the notice window is open close
    if (!cObj("notification_win").classList.contains("hide")){
        //hide the notice pane
        cObj("notification_win").classList.add("hide");
        cObj("log_notification").classList.add("hide");
    }
}
cObj("delete_message").onclick = function () {
    //get id
    var datapas = "?delete_notice="+cObj("notify_id").innerText;
    sendData1("GET","notices/notices.php",datapas,cObj("delete_not"));
    setTimeout(() => {
        var ids = setInterval(() => {
            if (cObj("loadings").classList.contains("hide")) {
                //hide the window
                cObj("read_notice").classList.add("hide");
                if (!cObj("notices_window").classList.contains("hide")) {
                    //refresh the notification
                    cObj("show_all_notices").click();
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("close_add_expense").onclick = function () {
    cObj("add_expense_par").classList.add("hide");
}
cObj("close_add_expense2").onclick = function () {
    cObj("add_expense_par").classList.add("hide");
}
cObj("add_expense").onclick = function () {
    cObj("add_expense_par").classList.remove("hide");
    var datapass = "?get_class_add_expense=true";
    sendData2("GET","finance/financial.php",datapass,cObj("class_list_fees"),cObj("loadings213111"));
}
cObj("save_add_expense").onclick = function () {
    //check for errors
    var err = checkBlank("exp_name");
    err+=checkBlank("term_one");
    err+=checkBlank("term_two");
    err+=checkBlank("term_three");
    err+=checkBlank("boarders_regular");
    if (cObj("expe_err").innerText.length > 0) {
        err++;
    }
    if (err == 0) {
        cObj("err_handler_10").innerHTML = "<p class='red_notice'></p>";
        //check if classes is selected
        var sell = 0;
        var class_list = "";
        var checkers =  document.getElementsByClassName("add_expense_check");
        for (let index = 0; index < checkers.length; index++) {
            const element = checkers[index];
            if (element.checked == true) {
                sell++;
                class_list+="|"+element.id.substr(6)+"|,";
            }
        }
        if (sell > 0) {
            class_list = class_list.substr(0,class_list.length-1);
            cObj("err_handler_10").innerHTML = "";
            //get class list and get the datas
            var expense_name  = valObj("exp_name");
            var term_one  = valObj("term_one");
            var term_two  = valObj("term_two");
            var term_three  = valObj("term_three");
            var roles = valObj("boarders_regular");
            var datapass = "?add_expense=true&expense_name="+expense_name+"&term_one="+term_one+"&term_two="+term_two+"&term_three="+term_three+"&class_lists="+class_list+"&roles="+roles;
            sendData1("GET","finance/financial.php",datapass,cObj("err_handler_10"));
            setTimeout(() => {
                var ids = setInterval(() => {
                    if (cObj("loadings").classList.contains("hide")) {
                        cObj("err_handler_10").innerHTML = "";
                        cObj("exp_names").reset();
                        cObj("add_expense_par").classList.add("hide");
                        stopInterval(ids);
                    }
                }, 100);
            }, 200);
        }else{
            cObj("err_handler_10").innerHTML = "<p class='red_notice'>Select a class to proceed!</p>";
        }
    }else{
        cObj("err_handler_10").innerHTML = "<p class='red_notice'>Check for errors for the fields covered with red border!</p>";
    }
}
function getMyClassList() {
    //get the class list
    var datapas = "?getmyClassList=true";
    sendData2("GET","administration/admissions.php",datapas,cObj("class_holder"),cObj("class_list_clock"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("class_list_clock").classList.contains("hide")) {
                var remove_class = document.getElementsByClassName("remove_class");
                for (let index = 0; index < remove_class.length; index++) {
                    const element = remove_class[index];
                    element.addEventListener("click",removeClassSys)
                }
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
function removeClassSys() {
    var class_val = this.id.substr(3);
    var datapass = "?remove_class="+class_val;
    sendData1("GET","administration/admissions.php",datapass,cObj("add_class_err_handler"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                getMyClassList();
                setTimeout(() => {
                    cObj("add_class_err_handler").innerHTML = "";
                }, 10000);
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
function getActiveHours() {
    var datapas = "?loginHours=true";
    sendData2("GET","administration/admissions.php",datapas,cObj("active_hours"),cObj("active_list_clock"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("active_list_clock").classList.contains("hide")) {
                //get the list of hours
                var active_hours = cObj("active_hours").innerText;
                if (active_hours.length > 0) {
                    var split_hours = active_hours.split("|");
                    cObj("from_time").value = split_hours[0];
                    cObj("to_time").value = split_hours[1];
                }
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
function activeTerms() {
    var datapass = "?academicCalender=true";
    sendData2("GET","administration/admissions.php",datapass,cObj("acad_table"),cObj("acad_table_clock"));
}
function getAdmissionEssentials() {
    var datapass = "?get_adm_essential=true";
    sendData2("GET","administration/admissions.php",datapass,cObj("adm_essential"),cObj("adm_essential_clock"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("adm_essential_clock").classList.contains("hide")) {
                var adms_essent = document.getElementsByClassName("adms_essent");
                for (let index = 0; index < adms_essent.length; index++) {
                    const element = adms_essent[index];
                    element.addEventListener("click",removeAdmComp);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
function removeAdmComp() {
    var componentval = this.id.substr(4);
    var datapass = "?remove_components=true&component_rem="+componentval;
    sendData1("GET","administration/admissions.php",datapass,cObj("add_admission_err_handler"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                getAdmissionEssentials();
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
cObj("add_class").onclick = function () {
    cObj("add_classes_win").classList.remove("hide");
}
cObj("close_add_class_win").onclick = function () {
    cObj("add_classes_win").classList.add("hide");
}
cObj("close_add_cl_win").onclick = function () {
    cObj("add_classes_win").classList.add("hide");
}
cObj("add_class_btn").onclick = function () {
    var datapass = "?add_class="+cObj("input_text").value;
    sendData2("GET","administration/admissions.php",datapass,cObj("add_class_outputtxt"),cObj("add_class_clock"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("add_class_clock").classList.contains("hide")) {
                getMyClassList();
                cObj("add_classes_win").classList.add("hide");
                cObj("add_class_outputtxt").innerText = "";
                cObj("input_text").value = "";
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
cObj("close_active_hours1").onclick = function () {
    cObj("active_hours_window").classList.add("hide");
}
cObj("close_active_hours").onclick = function () {
    cObj("active_hours_window").classList.add("hide");
}
cObj("change_active_hrs_btn").onclick = function () {
    cObj("active_hours_window").classList.remove("hide");
}
cObj("change_active_btn").onclick = function () {
    var from = cObj("from_timer").value;
    var to = cObj("to_timer").value;
    if (from > to) {
        alert("Starting time should be earlier than ending time.");
    }else if (to > from) {
        var datapass = "?change_active_hours=true&from="+from+"&to="+to;
        sendData2("GET","administration/admissions.php",datapass,cObj("outputbtn_activehours"),cObj("active_hour_clocker"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("add_class_clock").classList.contains("hide")) {
                    getActiveHours();
                    cObj("active_hours_window").classList.add("hide");
                    setTimeout(() => {
                        cObj("outputbtn_activehours").innerText = "";
                    }, 10000);
                    stopInterval(ids);
                }
            }, 100);
        }, 500);
    }else{
        alert("Starting time and ending time should not be the same.");
    }
}
cObj("next_page").onclick = function () {
    if (!cObj("term_ones").classList.contains("hide")) {
        var errs = errTerm1();
        if (errs == 0) {
            cObj("err_win_handlers").innerHTML = "";
            cObj("term_ones").classList.add("animate20");
            cObj("term_twos").classList.remove("hide");
            cObj("term_twos").classList.add("animate20");
            setTimeout(() => {
                cObj("term_ones").classList.add("hide");
                cObj("term_ones").classList.remove("animate20");
                cObj("term_twos").classList.remove("animate20");
            }, 900);
        }else{
            cObj("err_win_handlers").innerHTML = "<p class='red_notice'>Fill all fields with red border.</p>";
        }
    }else if (!cObj("term_twos").classList.contains("hide")) {
        var err = errTerm2();
        if (err == 0) {
            cObj("err_win_handlers").innerHTML = "";
            cObj("term_twos").classList.add("animate20");
            cObj("term_threes").classList.remove("hide");
            cObj("term_threes").classList.add("animate20");
            setTimeout(() => {
                cObj("term_twos").classList.add("hide");
                cObj("term_twos").classList.remove("animate20");
                cObj("term_threes").classList.remove("animate20");
                cObj("save_opts").classList.remove("hide");
            }, 900);
        }else{
            cObj("err_win_handlers").innerHTML = "<p class='red_notice'>Fill all fields with red border.</p>";
        }
    }else{
        var err = errTerm3();
        if (err == 0) {
            cObj("err_win_handlers").innerHTML = "<p class='green_notice'>Click to save your changes.</p>";
        }else{
            cObj("err_win_handlers").innerHTML = "<p class='red_notice'>Fill all fields with red border.</p>";
        }
    }
}
cObj("prev_page").onclick = function () {
    if (!cObj("term_threes").classList.contains("hide")) {
        cObj("term_threes").classList.add("animate21");
        cObj("term_twos").classList.remove("hide");
        cObj("term_twos").classList.add("animate21");
        setTimeout(() => {
            cObj("term_threes").classList.add("hide");
            cObj("term_threes").classList.remove("animate21");
            cObj("term_twos").classList.remove("animate21");
            cObj("save_opts").classList.add("hide");
        }, 900);
        
    }else if (!cObj("term_twos").classList.contains("hide")) {
        cObj("term_twos").classList.add("animate21");
        cObj("term_ones").classList.remove("hide");
        cObj("term_ones").classList.add("animate21");
        setTimeout(() => {
            cObj("term_twos").classList.add("hide");
            cObj("term_twos").classList.remove("animate21");
            cObj("term_ones").classList.remove("animate21");
        }, 900);
    }
}
//check term one errors
function errTerm1() {
    var err = 0;
    err+=checkBlank("term_one_start");
    err+=checkBlank("term_one_closing");
    err+=checkBlank("term_one_end");
    return err;
}
//check term two errors
function errTerm2() {
    var err = 0;
    err+=checkBlank("term_two_start");
    err+=checkBlank("term_two_closing");
    err+=checkBlank("term_two_end");
    return err;
}
function errTerm3() {
    var err = 0;
    err+=checkBlank("term_three_start");
    err+=checkBlank("term_three_closing");
    err+=checkBlank("term_three_end");
    return err;
}
function resetWindow() {
    var on_win = document.getElementsByClassName("on_win");
    for (let index = 0; index < on_win.length; index++) {
        const element = on_win[index];
        element.classList.add("hide");
        element.classList.remove("animate20");
        element.classList.remove("animate21");
    }
    cObj("term_ones").classList.remove("hide");
}
cObj("close_time_tables").onclick = function () {
    cObj("acad_timetable_win").classList.add("hide");
    resetWindow();
}
cObj("close_acad_cal").onclick = function () {
    cObj("acad_timetable_win").classList.add("hide");
    resetWindow();
}
cObj("change_acad_win").onclick = function () {
    cObj("acad_timetable_win").classList.remove("hide");
}
cObj("Change_acad_cal").onclick = function () {
    var err = errTerm3();
    if (err == 0) {
        var datapass = "?update_sch_cal=true&term_one_start="+valObj("term_one_start")+"&term_one_close="+valObj("term_one_closing")+"&term_one_end="+valObj("term_one_end")+"&term_two_start="+valObj("term_two_start")+"&term_two_close="+valObj("term_two_closing")+"&term_two_end="+valObj("term_two_end")+"&term_three_start="+valObj("term_three_start")+"&term_three_close="+valObj("term_three_closing")+"&term_three_end="+valObj("term_three_end")+"";
        sendData1("GET","administration/admissions.php",datapass,cObj("acad_cal_errhandler"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    resetWindow();
                    cObj("acad_timetable_win").classList.add("hide");
                    stopInterval(ids);
                }
            }, 100);
        }, 500);
    }
}
cObj("close_win").onclick = function () {
    cObj("admission_ess").classList.add("hide");
}
cObj("close_win_admissions").onclick = function () {
    cObj("admission_ess").classList.add("hide");
}
cObj("add_adm_ess").onclick = function () {
    cObj("admission_ess").classList.remove("hide");
}
cObj("save_comp").onclick = function () {
    //check errors
    var err = checkBlank("adm_ess");
    if (err == 0) {
        cObj("admission_essentials_err_handler").innerHTML = "";
        var datapass = "?add_admission_ess=true&component="+valObj("adm_ess");
        sendData1("GET","administration/admissions.php",datapass,cObj("admission_essentials_err_handler"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    cObj("admission_ess").classList.add("hide");
                    getAdmissionEssentials();
                    cObj("adm_ess").value = "";
                    stopInterval(ids);
                }
            }, 100);
        }, 500);
    }else{
        cObj("admission_essentials_err_handler").innerHTML = "<p class = 'red_notice'>Fill all the fields covered with red border!</p>";
    }
}
cObj("display_loggers").onclick = function () {
    var err = checkBlank("date_logs");
    if (err == 0) {
        var datapass = "?date_logs="+valObj("date_logs");
        sendData2("GET","administration/admissions.php",datapass,cObj("loggers_table_before"),cObj("logger_clock"));
    }else{
        cObj("loggers_table_before").innerHTML = "<p class='red_notice'>Select a date to display logs!</p>";
    }
}
cObj("sys_username").onblur = function () {
    //get if username was used
    if (this.value.length > 0) {
        var datapass = "?usernames_value="+this.value;
        sendData2("GET","administration/admissions.php",datapass,cObj("check_me_username"),cObj("ch_uname_clock"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("ch_uname_clock").classList.contains("hide")) {
                    if (cObj("check_me_username").innerText.length>0) {
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
cObj("close_change_dp").onclick = function () {
    cObj("change_dp_win").classList.add("hide");
}
cObj("change_dp_btns").onclick = function () {
    cObj("change_dp_win").classList.remove("hide");
}
cObj("change_my_dp_img").onclick = function () {
    var err = checkBlank("dp_image");
    if (err == 0) {
        var filepath = cObj("dp_image").value.split(".")[1];
        if (filepath == "jpeg" || filepath == "png"  || filepath == "jpg" || filepath == "gif") {
            //create an xml request to upload the image into the server
            var done = 0;
            const xhr = new XMLHttpRequest();
            const formdata = new FormData();
            cObj("insert_images").classList.remove("hide");
            for(const fills of cObj("dp_image").files){
                formdata.append("myFiles[]",fills);   
            }
            xhr.onreadystatechange = function () {
                if(this.readyState ==4 && this.status==200){
                    cObj("imagenotifier").innerHTML = "<p style='color:green; font-size:12px;'>Image Uploaded successfully!</p>";
                    //cObj("imagenotifier").innerHTML = this.responseText;
                    done = 1;
                    cObj("insert_images").classList.add("hide");
                }
            }
        
            xhr.open("POST","ajax/image_upload/change_dp.php");
            xhr.send(formdata);

            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (done == 1) {
                        //change the location of the dp in the database
                        var datapass = "?change_dp_local=true";
                        sendData1("GET","administration/admissions.php",datapass,cObj("dp_err_handler"));
                        setTimeout(() => {
                            var timeout = 0;
                            var id23w = setInterval(() => {
                                timeout++;
                                //after two minutes of slow connection the next process wont be executed
                                if (timeout==1200) {
                                    stopInterval(id23w);                        
                                }
                                if (cObj("loadings").classList.contains("hide")) {
                                    changeDpLocale();
                                    cObj("change_dp_win").classList.add("hide");
                                    cObj("dp_image").value = "";
                                    stopInterval(id23w);
                                }
                            }, 100);
                        }, 200);
                        stopInterval(ids);
                    }
                    }, 100);
                }, 500);
        }else{
            alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            cObj("dp_image").value = "";
        }
    }else{
        alert("select an image to proceed!");
    }
}
function changeDpLocale() {
    var datapass = "?getImages_dp=true";
    sendData1("GET","administration/admissions.php",datapass,cObj("dps_images"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var image_local = cObj("dps_images").innerText;
                if (image_local.length > 0) {
                    cObj("open_more").src = image_local;
                    cObj("dpimage-sett").src = image_local;
                    cObj("user_imged").src = image_local;
                    var auth = cObj("authoriti").value;
                    if (auth == 1) {
                        cObj("ht_dp_img").src = image_local;
                    }else if (auth == 5) {
                        cObj("ct_admin_dp").src = image_local;
                    }else if (auth == 3) {
                        cObj("dp_dash_dp").src = image_local;
                    }else if (auth == 2) {
                        cObj("tr_dash_dp").src = image_local;
                    }else if (auth == 0) {
                        cObj("admin_admin_dp").src = image_local;
                    }
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("close_sch_change_dp").onclick = function () {
    cObj("change_sch_dp_win").classList.add("hide");
}
cObj("change_sch_dp").onclick = function () {
    cObj("change_sch_dp_win").classList.remove("hide");
}
cObj("change_sch_dp_img").onclick = function () {
    var err = checkBlank("school_dp");
    if (err == 0) {
        var filepath = cObj("school_dp").value.split(".")[1];
        if (filepath == "jpeg" || filepath == "png"  || filepath == "jpg" || filepath == "gif") {
            //create an xml request to upload the image into the server
            var done = 0;
            const xhr = new XMLHttpRequest();
            const formdata = new FormData();
            for(const fills of cObj("school_dp").files){
                formdata.append("myFiles[]",fills);   
            }
            xhr.onreadystatechange = function () {
                if(this.readyState ==4 && this.status==200){
                    cObj("imagenotifiered").innerHTML = "<p style='color:green; font-size:12px;'>Image Uploaded successfully!</p>";
                    //cObj("imagenotifiered").innerHTML = this.responseText;
                    done = 1;
                }
            }
        
            xhr.open("POST","ajax/image_upload/change_sch_dp.php");
            xhr.send(formdata);

            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout==1200) {
                        stopInterval(ids);                        
                    }
                    if (done == 1) {
                        //change the location of the dp in the database
                        var datapass = "?change_dp_school=true";
                        sendData1("GET","administration/admissions.php",datapass,cObj("imagenotifiered"));
                        setTimeout(() => {
                            var timeout = 0;
                            var iddd = setInterval(() => {
                                timeout++;
                                //after two minutes of slow connection the next process wont be executed
                                if (timeout==1200) {
                                    stopInterval(iddd);                        
                                }
                                if (cObj("loadings").classList.contains("hide")) {
                                    cObj("change_sch_dp_win").classList.add("hide");
                                    changeSchoolDpLocale();
                                    stopInterval(iddd);
                                }
                            }, 100);
                        }, 200);
                        stopInterval(ids);
                    }
                    }, 100);
                }, 500);
        }else{
            alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            cObj("school_dp").value = "";
        }
    }
}
function changeSchoolDpLocale() {
    var datapass = "?bring_me_sch_dp=true";
    sendData1("GET","administration/admissions.php",datapass,cObj("sch_dp_images"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                var image_local = cObj("sch_dp_images").innerText;
                if (image_local.length > 0) {
                    cObj("sch_logos").src = image_local;
                    cObj("sch_logos2").src = image_local;
                    document.getElementById("images_bgs").style.backgroundImage = "url("+image_local+")";
                }
                stopInterval(ids);
            }
        }, 100);
    }, 200);
}
cObj("close_img_viewer").onclick = function () {
    cObj("imagers").classList.remove("image_view");
    cObj("imagers").classList.add("hide");
}
cObj("dpimage-sett").onclick = function () {
    cObj("image_viewer").src = cObj("dpimage-sett").src;
    cObj("imagers").classList.add("image_view");
    cObj("imagers").classList.remove("hide");
}
cObj("sch_logos2").onclick = function () {
    cObj("image_viewer").src = cObj("sch_logos2").src;
    cObj("imagers").classList.add("image_view");
    cObj("imagers").classList.remove("hide");
}
cObj("suggestion_box").onkeyup = function () {
    var len = this.value.length;
    cObj("count_char").innerText = len;
}
cObj("send-feedback_btns").onclick = function () {
    var err = checkBlank("suggestion_box");
    if (err == 0) {
        cObj("err_handlered").innerHTML = "";
        var datapass = "?feedback_message="+valObj("suggestion_box");
        sendData2("GET","administration/admissions.php",datapass,cObj("err_handlered"),cObj("feedback-clock"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("feedback-clock").classList.contains("hide")) {
                    cObj("suggestion_box").value = "";
                    setTimeout(() => {
                        cObj("err_handlered").innerHTML = "";
                    }, 10000);
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }else{
        cObj("err_handlered").innerHTML = "<p class = 'red_notice'>Write what you think in the box above!</p>";
    }
}
cObj("display_attendance_class").onclick = function () {
    var err = checkBlank("sel_att_date");
    if (err == 0) {
        cObj("err_date_handled").innerHTML = "";
        var datapass = "?get_attendance_school=true&dated="+valObj("sel_att_date");
        sendData1("GET","administration/admissions.php",datapass,cObj("tableinformation"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    var view_stud_attendance = document.getElementsByClassName("view_stud_attendance");
                    for (let index = 0; index < view_stud_attendance.length; index++) {
                        const element = view_stud_attendance[index];
                        element.addEventListener("click",viewClassAttend);
                    }
                    stopInterval(ids);
                }
            }, 100);
        }, 200);
    }else{
        cObj("err_date_handled").innerHTML = "<p class='red_notice'>Select a date!</p>";
    }
}
function viewClassAttend() {
    var daro = this.id;
    var date = valObj("sel_att_date");
    var datapass = "?class="+daro+"&dates="+date;
    //showPleasewait();
    sendData1("GET","administration/admissions.php",datapass,cObj("atendanceinfor"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                //removePleasewait();
                stopInterval(ids);
            }
        }, 100);
    }, 500);
    cObj("view_attendances").classList.remove("hide");
    cObj("mains").classList.add("hide");
}

//allow the ct to admit students only in their class
function allowCTadmit() {
    //get the value from the database
    var datapass = "?allowct=true";
    sendData2("GET","administration/admissions.php",datapass,cObj("allow_ct_err_handler"),cObj("allow_ct_reg_clock"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("allow_ct_reg_clock").classList.contains("hide")) {
                //removePleasewait();
                if (cObj("allow_ct_err_handler").innerText == "Yes") {
                    cObj("yes_opt_in1").selected = true;
                }else if (cObj("allow_ct_err_handler").innerText == "No") {
                    cObj("no_opt_in1").selected = true;
                }
                cObj("allow_ct_err_handler").innerText = "";
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
cObj("change_btns_inside").onclick = function () {
    var datapass = "?update_ct=true&ct_cg_value="+cObj("optioms_todo").value;
    sendData2("GET","administration/admissions.php",datapass,cObj("allow_ct_err_handler"),cObj("allow_ct_reg_clock"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("allow_ct_reg_clock").classList.contains("hide")) {
                setTimeout(() => {
                    cObj("allow_ct_err_handler").innerText = "";
                }, 1000);
                stopInterval(ids);
            }
        }, 100);
    }, 500);
}
cObj("automated_amd").onchange = function () {
    var selval = this.value;
    if (selval == "automate_adm") {
        cObj("auto_generate").classList.remove("hide");
        cObj("man_generate").classList.add("hide");
        //generate an admission number thats not used
        var datapass = "?generate_adm_auto=true";
        sendData2("GET","administration/admissions.php",datapass,cObj("admnogenerated"),cObj("autogenamds"));
        setTimeout(() => {
            var timeout = 0;
            var ids = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(ids);                        
                }
                if (cObj("autogenamds").classList.contains("hide")) {
                    cObj("autogen").value = cObj("admnogenerated").innerText;
                    stopInterval(ids);
                }
            }, 100);
        }, 100);
    }else if (selval == "insertmanually") {
        cObj("man_generate").classList.remove("hide");
        cObj("auto_generate").classList.add("hide");
    }
}

cObj("mangen").onkeyup = function () {
    //get if the admission number is used already
    var datapass = "?genmanuall=true&admno="+this.value;
    // alert(datapass);
    sendData2("GET","administration/admissions.php",datapass,cObj("admgenman"),cObj("manualassign"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("manualassign").classList.contains("hide")) {
                if (cObj("admgenman").innerText.length > 0) {
                    redBorder(this);
                }else{
                    grayBorder(this);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}

function displayWholeSchool() {
    // here we get the students to display in the whole school
    var datapass = "?getWholeSchool=true";
    sendData2("GET","administration/admissions.php",datapass,cObj("wholeSchool"),cObj("loader55"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loader55").classList.contains("hide")) {
                // assign the class a promote button an assignment
                var promoteclass = document.getElementsByClassName("promoteclass");
                for (let index = 0; index < promoteclass.length; index++) {
                    const element = promoteclass[index];
                    element.addEventListener("click",promoteClass);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}
function promoteClass() {
    var datapass = "?getclassData=true&classname="+this.id.substr(2);
    sendData2("GET","administration/admissions.php",datapass,cObj("wholeSchool"),cObj("loader55"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(ids);                        
            }
            if (cObj("loader55").classList.contains("hide")) {
                // assign the class a promote button an assignment
                cObj("goBack3").onclick = function () {
                    cObj("promoteStd").click();
                }

                // select all
                if (cObj("promoSelect") != null) {
                    cObj("promoSelect").onclick = function () {
                        if (this.checked == true) {
                            var promotionCheck = document.getElementsByClassName("promotionCheck");
                            for (let index = 0; index < promotionCheck.length; index++) {
                                const element = promotionCheck[index];
                                element.checked = true;
                            }
                        }else{
                            var promotionCheck = document.getElementsByClassName("promotionCheck");
                            for (let index = 0; index < promotionCheck.length; index++) {
                                const element = promotionCheck[index];
                                element.checked = false;
                            }
                        }
                    }
                }
                if (cObj("promoteStudents") != null){
                    cObj("promoteStudents").onclick = function () {
                        // get the students id to promote and the class they are in
                        var studentsSelected =  "";
                        var unselected = "";
                        var promotionCheck = document.getElementsByClassName("promotionCheck");
                        for (let index = 0; index < promotionCheck.length; index++) {
                            const element = promotionCheck[index];
                            if(element.checked == true){
                                studentsSelected+=element.id.substring(5)+",";
                            }else{
                                unselected+=element.id.substring(5)+",";
                            }
                        }
                        studentsSelected = studentsSelected.substring(0,studentsSelected.length-1);
                        unselected = unselected.substring(0,unselected.length-1);
                        if (studentsSelected.length > 0) {
                            cObj("errHandler44").innerHTML = "";
                            var datapass = "?promote=true&selectedStd="+studentsSelected+"&classselected="+cObj("theClass").value+"&unselected="+unselected;
                            sendData2("GET","administration/admissions.php",datapass,cObj("errHandler44"),cObj("loader55"));
                            setTimeout(() => {
                                var timeout = 0;
                                var ids = setInterval(() => {
                                    timeout++;
                                    //after two minutes of slow connection the next process wont be executed
                                    if (timeout==1200) {
                                        stopInterval(ids);                        
                                    }
                                    if (cObj("loader55").classList.contains("hide")) {
                                        // assign the class a promote button an assignment
                                        setTimeout(() => {
                                            cObj("goBack3").click();
                                        }, 2000);
                                        stopInterval(ids);
                                    }
                                }, 100);
                            }, 100);
                            // console.log(datapass);
                        }else{
                            cObj("errHandler44").innerHTML = "<span class='text-danger'>Select atleast one student to promote!</span>";
                            setTimeout(() => {
                                cObj("errHandler44").innerHTML = "";
                            }, 5000);
                        }
                    }
                }
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}
// user roles
cObj("add_user_type").onclick = function () {
    cObj("add_user_role_window").classList.remove("hide");
}
cObj("cancel_role_btn").onclick = function () {
    cObj("add_user_role_window").classList.add("hide");
}
function administration_check() {
    var classin = document.getElementsByClassName("administration1");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_administration").checked = true;
    }else{
        cObj("all_administration").checked = false;
    }
}

function finance_check() {
    var classin = document.getElementsByClassName("finance1");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_finance_sect").checked = true;
    }else{
        cObj("all_finance_sect").checked = false;
    }
}
function route_check() {
    var classin = document.getElementsByClassName("routesnvans1");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("route_transport_section").checked = true;
    }else{
        cObj("route_transport_section").checked = false;
    }
}
function academic_check() {
    var classin = document.getElementsByClassName("academic_sect");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("academic_section").checked = true;
    }else{
        cObj("academic_section").checked = false;
    }
}
function boarding_check() {
    var classin = document.getElementsByClassName("boarding_sect");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_boarding_section").checked = true;
    }else{
        cObj("all_boarding_section").checked = false;
    }
}
function all_sms_check() {
    var classin = document.getElementsByClassName("sms_broadcasted");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_sms_check").checked = true;
    }else{
        cObj("all_sms_check").checked = false;
    }
}
function all_account_settings() {
    var classin = document.getElementsByClassName("accounts_section");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("accounts_sector").checked = true;
    }else{
        cObj("accounts_sector").checked = false;
    }
}
/***HEY DONT CONFUSE UP AND DOWN */
function administration_check2() {
    var classin = document.getElementsByClassName("administration12");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_administration2").checked = true;
    }else{
        cObj("all_administration2").checked = false;
    }
}

function finance_check2() {
    var classin = document.getElementsByClassName("finance12");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_finance_sect2").checked = true;
    }else{
        cObj("all_finance_sect2").checked = false;
    }
}
function route_check2() {
    var classin = document.getElementsByClassName("routesnvans12");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("route_transport_section2").checked = true;
    }else{
        cObj("route_transport_section2").checked = false;
    }
}
function academic_check2() {
    var classin = document.getElementsByClassName("academic_sect2");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("academic_section2").checked = true;
    }else{
        cObj("academic_section2").checked = false;
    }
}
function boarding_check2() {
    var classin = document.getElementsByClassName("boarding_sect2");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_boarding_section2").checked = true;
    }else{
        cObj("all_boarding_section2").checked = false;
    }
}
function all_sms_check2() {
    var classin = document.getElementsByClassName("sms_broadcasted2");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("all_sms_check2").checked = true;
    }else{
        cObj("all_sms_check2").checked = false;
    }
}
function all_account_settings2() {
    var classin = document.getElementsByClassName("accounts_section2");
    var count = 0;
    for (let index = 0; index < classin.length; index++) {
        const element = classin[index];
        if (element.checked == true) {
            count++;
        }
    }
    if (count == classin.length) {
        cObj("accounts_sector2").checked = true;
    }else{
        cObj("accounts_sector2").checked = false;
    }
}
/****ENDS HERE */

cObj("all_administration").onchange = function () {
    var mychecks = document.getElementsByClassName("administration1");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}

cObj("all_finance_sect").onchange = function () {
    var mychecks = document.getElementsByClassName("finance1");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("route_transport_section").onchange = function () {
    var mychecks = document.getElementsByClassName("routesnvans1");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("academic_section").onchange = function () {
    var mychecks = document.getElementsByClassName("academic_sect");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("all_boarding_section").onchange = function () {
    var mychecks = document.getElementsByClassName("boarding_sect");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("all_sms_check").onchange = function () {
    var mychecks = document.getElementsByClassName("sms_broadcasted");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("accounts_sector").onchange = function () {
    var mychecks = document.getElementsByClassName("accounts_section");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
/**HEY HEYE HEYE HEY */
/**HEY DONT GET CONFUSED HERE THE UPPER CODE IS DUPLICATE AS DOWN HERE */
cObj("all_administration2").onchange = function () {
    var mychecks = document.getElementsByClassName("administration12");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}

cObj("all_finance_sect2").onchange = function () {
    var mychecks = document.getElementsByClassName("finance12");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("route_transport_section2").onchange = function () {
    var mychecks = document.getElementsByClassName("routesnvans12");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("academic_section2").onchange = function () {
    var mychecks = document.getElementsByClassName("academic_sect2");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("all_boarding_section2").onchange = function () {
    var mychecks = document.getElementsByClassName("boarding_sect2");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("all_sms_check2").onchange = function () {
    var mychecks = document.getElementsByClassName("sms_broadcasted2");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
cObj("accounts_sector2").onchange = function () {
    var mychecks = document.getElementsByClassName("accounts_section2");
    if (this.checked == true) {
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = true;
        }
    }else{
        for (let index = 0; index < mychecks.length; index++) {
            const element = mychecks[index];
            element.checked = false;
        }
    }
}
/**ENDS HERE BRUH */

function getStaffRole() {
    var role = "[";
    var status = cObj("admit_student_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"admitbtn\",\"Status\":\""+status+"\"},"
    status = cObj("manage_stud_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"findstudsbtn\",\"Status\":\""+status+"\"},"
    status = cObj("class_attendance_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"callregister\",\"Status\":\""+status+"\"},"
    status = cObj("register_staff_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"regstaffs\",\"Status\":\""+status+"\"},"
    status = cObj("manage_staff_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"managestaf\",\"Status\":\""+status+"\"},"
    status = cObj("promote_students_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"promoteStd\",\"Status\":\""+status+"\"},"
    status = cObj("pay_fees-sector").checked == true ? "yes":"no";
    role+="{\"name\":\"payfeess\",\"Status\":\""+status+"\"},"
    status = cObj("manage_transaction_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"findtrans\",\"Status\":\""+status+"\"},"
    status = cObj("mpesa_transaction_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"mpesaTrans\",\"Status\":\""+status+"\"},"
    status = cObj("fees_structures_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"feestruct\",\"Status\":\""+status+"\"},"
    status = cObj("expense_section").checked == true ? "yes":"no";
    role+="{\"name\":\"expenses_btn\",\"Status\":\""+status+"\"},"
    status = cObj("financial_report_section").checked == true ? "yes":"no";
    role+="{\"name\":\"finance_report_btn\",\"Status\":\""+status+"\"},"
    status = cObj("payroll_section").checked == true ? "yes":"no";
    role+="{\"name\":\"payroll_sys\",\"Status\":\""+status+"\"},"
    status = cObj("route_n_van_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"routes_n_trans\",\"Status\":\""+status+"\"},"
    status = cObj("enroll_students_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"enroll_students\",\"Status\":\""+status+"\"},"
    status = cObj("register_subject_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"regsub\",\"Status\":\""+status+"\"},"
    status = cObj("manage_subject_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"managesub\",\"Status\":\""+status+"\"},"
    status = cObj("manage_teacher_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"managetrnsub\",\"Status\":\""+status+"\"},"
    status = cObj("timetables_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"generate_tt_btn\",\"Status\":\""+status+"\"},"
    status = cObj("exam_management_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"examanagement\",\"Status\":\""+status+"\"},"
    status = cObj("student_marks_entry").checked == true ? "yes":"no";
    role+="{\"name\":\"exam_fill_btn\",\"Status\":\""+status+"\"},"
    status = cObj("enroll_boarding_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"enroll_boarding_btn\",\"Status\":\""+status+"\"},"
    status = cObj("manage_dormitory_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"maanage_dorm\",\"Status\":\""+status+"\"},"
    status = cObj("sms_and_broadcast").checked == true ? "yes":"no";
    role+="{\"name\":\"sms_broadcast\",\"Status\":\""+status+"\"},"
    status = cObj("update_school_profile_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"update_school_profile\",\"Status\":\""+status+"\"},"
    status = cObj("update_personal_profile_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"update_personal_profile\",\"Status\":\""+status+"\"},"
    status = cObj("settings_sect").checked == true ? "yes":"no";
    role+="{\"name\":\"set_btns\",\"Status\":\""+status+"\"},";
    status = cObj("my_school_reports").checked == true ? "yes":"no";
    role+="{\"name\":\"my_reports\",\"Status\":\""+status+"\"}]";
    return role;
}

/**Hey dont confuse this function to the one above */

function getStaffRole2(role_index,role_name) {
    var role = "[";
    var status = cObj("admit_student_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"admitbtn\",\"Status\":\""+status+"\"},"
    status = cObj("manage_stud_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"findstudsbtn\",\"Status\":\""+status+"\"},"
    status = cObj("class_attendance_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"callregister\",\"Status\":\""+status+"\"},"
    status = cObj("register_staff_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"regstaffs\",\"Status\":\""+status+"\"},"
    status = cObj("manage_staff_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"managestaf\",\"Status\":\""+status+"\"},"
    status = cObj("promote_students_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"promoteStd\",\"Status\":\""+status+"\"},"
    status = cObj("pay_fees-sector2").checked == true ? "yes":"no";
    role+="{\"name\":\"payfeess\",\"Status\":\""+status+"\"},"
    status = cObj("manage_transaction_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"findtrans\",\"Status\":\""+status+"\"},"
    status = cObj("mpesa_transaction_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"mpesaTrans\",\"Status\":\""+status+"\"},"
    status = cObj("fees_structures_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"feestruct\",\"Status\":\""+status+"\"},"
    status = cObj("expense_section2").checked == true ? "yes":"no";
    role+="{\"name\":\"expenses_btn\",\"Status\":\""+status+"\"},"
    status = cObj("financial_report_section2").checked == true ? "yes":"no";
    role+="{\"name\":\"finance_report_btn\",\"Status\":\""+status+"\"},"
    status = cObj("payroll_section2").checked == true ? "yes":"no";
    role+="{\"name\":\"payroll_sys\",\"Status\":\""+status+"\"},"
    status = cObj("route_n_van_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"routes_n_trans\",\"Status\":\""+status+"\"},"
    status = cObj("enroll_students_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"enroll_students\",\"Status\":\""+status+"\"},"
    status = cObj("register_subject_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"regsub\",\"Status\":\""+status+"\"},"
    status = cObj("manage_subject_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"managesub\",\"Status\":\""+status+"\"},"
    status = cObj("manage_teacher_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"managetrnsub\",\"Status\":\""+status+"\"},"
    status = cObj("timetables_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"generate_tt_btn\",\"Status\":\""+status+"\"},"
    status = cObj("exam_management_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"examanagement\",\"Status\":\""+status+"\"},"
    status = cObj("student_marks_entry2").checked == true ? "yes":"no";
    role+="{\"name\":\"exam_fill_btn\",\"Status\":\""+status+"\"},"
    status = cObj("enroll_boarding_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"enroll_boarding_btn\",\"Status\":\""+status+"\"},"
    status = cObj("manage_dormitory_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"maanage_dorm\",\"Status\":\""+status+"\"},"
    status = cObj("sms_and_broadcast2").checked == true ? "yes":"no";
    role+="{\"name\":\"sms_broadcast\",\"Status\":\""+status+"\"},"
    status = cObj("update_school_profile_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"update_school_profile\",\"Status\":\""+status+"\"},"
    status = cObj("update_personal_profile_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"update_personal_profile\",\"Status\":\""+status+"\"},"
    status = cObj("settings_sect2").checked == true ? "yes":"no";
    role+="{\"name\":\"set_btns\",\"Status\":\""+status+"\"},";
    status = cObj("my_school_reports2").checked == true ? "yes":"no";
    role+="{\"name\":\"my_reports\",\"Status\":\""+status+"\"}]";

    var data_in = cObj("show_roles").innerText;
    var roles_upload = "[";
    if (data_in.length > 0) {
        var object = JSON.parse(data_in);
        for (let index = 0; index < object.length; index++) {
            const element = object[index];
            if (index == role_index) {
                roles_upload+="{\"name\":\""+role_name+"\",\"roles\":"+role+"},";
            }else{
                roles_upload+=JSON.stringify(element)+",";
            }
        }
        roles_upload = roles_upload.substring(0,(roles_upload.length-1))+"]";
    }
    return roles_upload;
}
/**IT END HERE */
cObj("add_role_btns").onclick = function () {
    var role = getStaffRole();
    var err = checkBlank("role_name");
    if (err < 1) {
        cObj("allowance_err3_handler").innerHTML = "";
        var datapass = "?add_another_user=true&role_name="+valObj("role_name")+"&role_doing="+role;
        sendData2("GET","academic/academic.php",datapass,cObj("allowance_err3_handler"),cObj("add_user_roles_in"));
        setTimeout(() => {
            cObj("cancel_role_btn").click();
            cObj("allowance_err3_handler").innerHTML = "";
            cObj("role_name").value = "";
            cObj("set_btns").click();
        }, 1000);
        
    }else{
        cObj("allowance_err3_handler").innerHTML = "<p class='text-danger'>Fill all fields covered with red borders</p>";
    }
}
cObj("add_role_btns2").onclick = function () {
    var role_index = cObj("role_ids_in").innerText;
    var err = checkBlank("role_name2");
    if (err < 1) {
        cObj("allowance_err4_handler").innerHTML = "";
        var role = getStaffRole2(role_index,valObj("role_name2"));
        var datapass = "?edit_another_user=true&role_name="+valObj("role_name2")+"&old_role_name="+cObj("old_role_name").innerText+"&role_values="+role;
        sendData2("GET","academic/academic.php",datapass,cObj("allowance_err4_handler"),cObj("add_user_roles_in2"));
        setTimeout(() => {
            cObj("cancel_role_btn2").click();
            cObj("allowance_err4_handler").innerHTML = "";
            cObj("role_name2").value = "";
            cObj("set_btns").click();
        }, 1000);
        
    }else{
        cObj("allowance_err4_handler").innerHTML = "<p class='text-danger'>Fill all fields covered with red borders</p>";
    }
}
function getRoleData() {
    var datapass = "?get_user_roles=true";
    sendData2("GET","academic/academic.php",datapass,cObj("show_roles"),cObj("load_roles"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(ids);
            }
            if (cObj("load_roles").classList.contains("hide")) {
                // get the data in the object and decipher it
                var data = cObj("show_roles").innerText;
                if (data.length > 0) {
                    var obje = JSON.parse(data);
                    var data_to_display = "<table class='table'><tr><th>No.</th><th>Role Name</th><th>Options</th></tr>";
                    for (let index = 0; index < obje.length; index++) {
                        const element = obje[index];
                        // get the element data and display as a table
                        data_to_display += "<tr><td>" + (index + 1) + "</td><td>" + element.name + "</td><td><span class='link edit_role_' id='edit_role_" + index + "' ><i class='fa fa-pen'></i> Edit</span> <span class='link ml-2 delete_roles' id='delete_roles"+index+"'><i class='fa fa-trash'></i> Delete</span></td></tr>";

                    }
                    data_to_display += "</table>";
                    cObj("roles_holder").innerHTML = data_to_display;
                } else {
                    cObj("roles_holder").innerHTML = "<p class='text-success'>There are no roles added to the system currently!</p>";
                }
                var edit_role_ = document.getElementsByClassName("edit_role_");
                for (let index = 0; index < edit_role_.length; index++) {
                    const element = edit_role_[index];
                    element.addEventListener("click",editRoleListener);
                }
                var delete_roles = document.getElementsByClassName("delete_roles");
                for (let index = 0; index < delete_roles.length; index++) {
                    const element = delete_roles[index];
                    element.addEventListener("click",deleteRoles_Present);
                }
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}

function editRoleListener() {
    var ids = this.id.substring(("edit_role_".length));
    var data = cObj("show_roles").innerText;
    var object = JSON.parse(data);
    var obj = object[ids];
    // create a window to display the data
    cObj("add_user_role_window2").classList.remove("hide");
    var fill_data = document.getElementsByClassName("fill_data");
    var data2 = obj.roles;
    for (let index = 0; index < data2.length; index++) {
        const element = data2[index];
        if (element.Status == "yes") {
            fill_data[index].checked = true;
        }else{
            fill_data[index].checked = false;
        }
    }
    cObj("role_ids_in").innerText = ids;
    cObj("role_name2").value = obj.name;
    cObj("old_role_name").innerText = obj.name;
    administration_check2();
    finance_check2();
    route_check2();
    academic_check2();
    boarding_check2();
    all_sms_check2();
    all_account_settings2();
}
cObj("cancel_role_btn2").onclick = function () {
    cObj("add_user_role_window2").classList.add("hide");
}
function deleteRoles_Present() {
    // show the delet confirmation window
    var ids = this.id.substring("delete_roles".length);
    cObj("remove_roles_windows").classList.remove("hide");
    cObj("index_to_delete").innerText = ids;
}
cObj("confirmno_roled").onclick = function () {
    cObj("remove_roles_windows").classList.add("hide");
}
cObj("confirmyes_roled").onclick = function () {
    var role_index = cObj("index_to_delete").innerText;
    var roles_n_user = cObj("show_roles").innerText;
    if (roles_n_user.length > 0) {
        cObj("cancel_role_btn2").click()
        var object = JSON.parse(roles_n_user);
        var data_to_upload = "[";
        var role_name = "";
        var counted = 0;
        for (let index = 0; index < object.length; index++) {
            const element = object[index];
            if (index != role_index) {
                data_to_upload+=JSON.stringify(element)+",";
                counted++;
            }else{
                role_name=element.name;
            }
        }
        data_to_upload = data_to_upload.substring(0,(data_to_upload.length-1))+"]";
        if (counted>0) {
            // send data to be uploaded
            var datapass = "?delete_roles="+role_name+"&raw_data="+data_to_upload;
            sendData2("GET","academic/academic.php",datapass,cObj("roles_errors"),cObj("load_roles"));
            cObj("confirmno_roled").click();
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout == 1200) {
                        stopInterval(ids);
                    }
                    if (cObj("load_roles").classList.contains("hide")) {
                        cObj("set_btns").click()
                        setTimeout(() => {
                            cObj("roles_errors").innerText = "";
                        }, 4000);
                        stopInterval(ids);
                    }
                }, 100);
            }, 100);
        }else{
            data_to_upload = "";
            // send data to be uploaded
            var datapass = "?delete_roles="+role_name+"&raw_data="+data_to_upload;
            sendData2("GET","academic/academic.php",datapass,cObj("roles_errors"),cObj("load_roles"));
            cObj("confirmno_roled").click();
            setTimeout(() => {
                var timeout = 0;
                var ids = setInterval(() => {
                    timeout++;
                    //after two minutes of slow connection the next process wont be executed
                    if (timeout == 1200) {
                        stopInterval(ids);
                    }
                    if (cObj("load_roles").classList.contains("hide")) {
                        cObj("set_btns").click()
                        setTimeout(() => {
                            cObj("roles_errors").innerText = "";
                        }, 4000);
                        stopInterval(ids);
                    }
                }, 100);
            }, 100);
        }
    }else{
        cObj("confirmno_roled").click();
    }
}

function getStaff_roles() {
    var datapass = "?staff_roles=true";
    sendData2("GET","academic/academic.php",datapass,cObj("role_data_2322"),cObj("load_roles2"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(ids);
            }
            if (cObj("load_roles2").classList.contains("hide")) {
                var data_to_display = "<select  class='form-control' style='width: 90%;' name='authority' id='authority'><option value='' hidden>Select..</option><option value='0'>Administrator</option><option value='1'>Headteacher/Principal</option><option value='3'>Deputy principal</option><option value='2'>Teacher</option><option value='5'>Class teacher</option><option value='6'>School Driver</option>";
                // console.log(cObj("role_data_23").innerText);
                var data_in = cObj("role_data_2322").innerText.length;
                if (data_in > 0) {
                    var data = cObj("role_data_2322").innerText;
                    var object = JSON.parse(data);
                    for (let index = 0; index < object.length; index++) {
                        const element = object[index];
                        var majina = element.name;
                        data_to_display += "<option style='color:blue;' value='"+majina+"'>"+ucwords(majina)+"</option>";
                    }
                }
                data_to_display+="</select>";
                cObj("other_roles_inside").innerHTML = data_to_display;
                
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}

function getStaff_roles_maanage() {
    var datapass = "?staff_roles=true";
    sendData2("GET","academic/academic.php",datapass,cObj("staff_detail_out"),cObj("load_roles43"));
    setTimeout(() => {
        var timeout = 0;
        var ids = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout == 1200) {
                stopInterval(ids);
            }
            if (cObj("load_roles43").classList.contains("hide")) {
                var data_to_display = "<select  class='form-control' style='width: 90%;' name='auths' id='auths'><option value='' hidden>Select..</option><option value='0'>Administrator</option><option value='1'>Headteacher/Principal</option><option value='3'>Deputy principal</option><option value='2'>Teacher</option><option value='5'>Class teacher</option><option value='6'>School Driver</option>";
                // console.log(cObj("role_data_23").innerText);
                var data_in = cObj("staff_detail_out").innerText.length;
                if (data_in > 0) {
                    var data = cObj("staff_detail_out").innerText;
                    var object = JSON.parse(data);
                    for (let index = 0; index < object.length; index++) {
                        const element = object[index];
                        var majina = element.name;
                        data_to_display += "<option style='color:blue;' value='"+majina+"'>"+ucwords(majina)+"</option>";
                    }
                }
                data_to_display+="</select>";
                cObj("data_in_display").innerHTML = data_to_display;
                
                stopInterval(ids);
            }
        }, 100);
    }, 100);
}
cObj("canc_add_prev_sch_btn").onclick = function () {
    cObj("previous_schools_windows").classList.add("hide");
}
cObj("prev_school").onclick = function () {
    cObj("previous_schools_windows").classList.remove("hide");
    cObj("prev_school_name").value = "";
    cObj("date_left").value = "";
    cObj("marks_scored").value = "";
    cObj("leaving_certifcate").checked = false;
    cObj("description").value = "";
    cObj("add_prevsch_error").innerHTML = "";
    
    grayBorder(cObj("prev_school_name"));
    grayBorder(cObj("date_left"));
    grayBorder(cObj("marks_scored"));

}

cObj("add_prev_sch_btn").onclick = function () {
    // record the schools absent
    var prev_school_name = cObj("prev_school_name").value;
    var date_left = cObj("date_left").value;
    var marks_scored = cObj("marks_scored").value;
    var leaving_certifcate = cObj("leaving_certifcate").checked;
    var description = cObj("description").value;
    
    var err = checkBlank("prev_school_name");
    err+=checkBlank("date_left");
    err+=checkBlank("marks_scored");
    if (err > 0) {
        cObj("add_prevsch_error").innerHTML = "<p class='text-danger'>Please fill all the fields with a red border.</p>";
    }else{
        cObj("add_prevsch_error").innerHTML = "";
        // proceed and add the information to the list
        var text = '[{"school_name":"'+prev_school_name+'","date_left":"'+date_left+'","marks_scored":"'+marks_scored+'","leaving_cert":"'+leaving_certifcate+'","reason_for_leaving":"'+description+'"}]';
        var available_txt = cObj("previous_schools").innerText;
        if (available_txt.length > 0) {
            text = '{"school_name":"'+prev_school_name+'","date_left":"'+date_left+'","marks_scored":"'+marks_scored+'","leaving_cert":"'+leaving_certifcate+'","reason_for_leaving":"'+description+'"}';
            available_txt = available_txt.substring(0,available_txt.length-1)+","+text+"]";
            cObj("previous_schools").innerText = available_txt;
        }else{
            cObj("previous_schools").innerText = text;
        }
        cObj("previous_schools_windows").classList.add("hide");
        create_tbl_prev_sch();
    }
}

function create_tbl_prev_sch() {
    var data = cObj("previous_schools").innerText;
    // create tables to display the data
    if (data.length > 0) {
        var previous_schools = JSON.parse(data);
        var count = 0;
        var data_to_display = "<table class='table'><tr><th>No</th><th>School Name</th><th>Date Left</th><th>Marks Scored</th><th>Reason for Leaving</th><th>Actions</th></tr>";
        for (let index = 0; index < previous_schools.length; index++) {
            count++;
            const element = previous_schools[index];
            data_to_display+="<tr><td>"+(index+1)+"</td><td>"+element.school_name+"</td><td>"+element.date_left+"</td><td>"+element.marks_scored+"</td><td>"+element.reason_for_leaving+"</td><td><span class='edit_prev_sch link' id='edit_prev_sch_"+index+"'><i class='fas fa-trash'></i> Remove</span></td></tr>";
        }
        data_to_display+="</table>";
        if (count > 0) {
            cObj("previous_school_list").innerHTML = data_to_display;
        }else{
            cObj("previous_school_list").innerHTML = "<p class='text-secondary'>No school previously attended by the student listed!</p>";
        }
    
        // Add Previous Schools
        var edit_prev_sch = document.getElementsByClassName("edit_prev_sch");
        for (let indexes = 0; indexes < edit_prev_sch.length; indexes++) {
            const element = edit_prev_sch[indexes];
            element.addEventListener("click",delete_prev_schs);
        }
    }else{
        cObj("previous_school_list").innerHTML = "<p class='text-secondary'>No school previously attended by the student listed!</p>";
    }
}
cObj("source_of_funding").onchange = function () {
    var my_val = cObj("source_of_funding").value;
    cObj("source_of_funding_data").value = my_val;
    if (my_val == "Others") {
        cObj("source_of_funding_data").value = "";
        cObj("source_of_funding_data").classList.remove("hide");
    }else{
        cObj("source_of_funding_data").classList.add("hide");
    }
}

function delete_prev_schs() {
    var ids = this.id.substring(14);
    var school_data = JSON.parse(cObj("previous_schools").innerText);
    var data = "[";
    var count =0;
    for (let index = 0; index < school_data.length; index++) {
        const element = school_data[index];
        if (index != ids) {
            count++;
            data+='{"school_name":"'+element.school_name+'","date_left":"'+element.date_left+'","marks_scored":"'+element.marks_scored+'","leaving_cert":"'+element.leaving_cert+'","reason_for_leaving":"'+element.reason_for_leaving+'"},';
        }
    }
    if (count > 0) {
        data = data.substring(0,data.length-1)+"]";
    }else{
        data = "";
    }
    cObj("previous_schools").innerText = data;
    create_tbl_prev_sch();
}

// display the add clubs window
cObj("cancel_add_sports_btn").onclick = function () {
    cObj("add_clubs_win").classList.add("hide");
}
cObj("add_sports_clubs").onclick = function () {
    cObj("add_clubs_win").classList.remove("hide");
}
cObj("add_clubs_btn").onclick = function () {
    // submit the data in the back end
    var err = checkBlank("club_name");
    if (err == 0) {
        // no errors present
        cObj("clubs_errors_in").innerHTML = "<p class='text-danger' ></p>";
        var club_name = valObj("club_name");
        var datapass = "?add_club=true&club_name="+club_name;
        sendData1("GET","administration/admissions.php",datapass,cObj("clubs_sport_houses"));
        cObj("club_name").value = "";
        cObj("add_clubs_win").classList.add("hide");
        setTimeout(() => {
            var timeout = 0;
            var idd = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(idd);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    // add the function that displays the data of the clubs
                    getClubHouses();
                    stopInterval(idd);
                }
            }, 100);
        }, 200);
    }else{
        cObj("clubs_errors_in").innerHTML = "<p class='text-danger' >Please fill the Sports House or Club name and proceed to add!</p>";
    }
}
function getClubHouses() {
    var datapass = "?getClubHouses=true";
    sendData1("GET","administration/admissions.php",datapass,cObj("clubs_house_tables"));
    setTimeout(() => {
        var timeout = 0;
        var idd = setInterval(() => {
            timeout++;
            //after two minutes of slow connection the next process wont be executed
            if (timeout==1200) {
                stopInterval(idd);                        
            }
            if (cObj("loadings").classList.contains("hide")) {
                // add the function that displays the data of the clubs
                var edit_clubs = document.getElementsByClassName("edit_clubs");
                for (let index = 0; index < edit_clubs.length; index++) {
                    const element = edit_clubs[index];
                    element.addEventListener("click",editClubData);
                }
                // delete the clusbs
                var delete_clubs = document.getElementsByClassName("delete_clubs");
                for (let index = 0; index < delete_clubs.length; index++) {
                    const elem = delete_clubs[index];
                    elem.addEventListener("click",delete_club);
                }
                stopInterval(idd);
            }
        }, 100);
    }, 200);
}
function delete_club() {
    // delete the clubs
    var its_id = this.id;
    var suffix = its_id.substr(its_id.length-1,its_id.length);
    // pull the confirmation window
    cObj("delete_clubs_window").classList.remove("hide");
    cObj("clubs_ids_delete").innerText = suffix;
    var ids = "club_named"+suffix;
    cObj("sports_house_name").innerText = cObj(ids).innerText;
}
cObj("cancel_delete_clubs").onclick = function () {
    cObj("delete_clubs_window").classList.add("hide");
}
cObj("delete_clubs_yes").onclick = function () {
    var ids = cObj("clubs_ids_delete").innerText;
    var datapass = "?delete_clubs=true&ided="+ids;
    sendData1("GET","administration/admissions.php",datapass,cObj("clubs_sport_houses"));
    cObj("delete_clubs_window").classList.add("hide");
        setTimeout(() => {
            var timeout = 0;
            var idd = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(idd);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    getClubHouses();
                    stopInterval(idd);
                }
            }, 100);
        }, 200);
}
function editClubData() {
    var its_id = this.id;
    var suffix = its_id.substr(its_id.length-1,its_id.length);
    cObj("edit_clubs_win").classList.remove("hide");
    var ids = "club_named"+suffix;
    cObj("clubs_ids").innerText = suffix;
    cObj("club_edit_name").value = cObj(ids).innerText;
}
cObj("cancel_edit_sports_btn").onclick = function (){
    cObj("edit_clubs_win").classList.add("hide");
}
cObj("edit_clubs_btn").onclick = function () {
    var err = checkBlank("club_edit_name");
    if (err == 0) {
        // proceed and upload the data
        cObj("clubs_edit_errors_in").innerHTML = "";
        var datapass = "?edit_clubs=true&club_name="+valObj("club_edit_name")+"&club_id="+cObj("clubs_ids").innerText;
        sendData1("GET","administration/admissions.php",datapass,cObj("clubs_sport_houses"));
        cObj("edit_clubs_win").classList.add("hide");
        setTimeout(() => {
            var timeout = 0;
            var idd = setInterval(() => {
                timeout++;
                //after two minutes of slow connection the next process wont be executed
                if (timeout==1200) {
                    stopInterval(idd);                        
                }
                if (cObj("loadings").classList.contains("hide")) {
                    getClubHouses();
                    stopInterval(idd);
                }
            }, 100);
        }, 200);
    }else{
        cObj("clubs_edit_errors_in").innerHTML = "<p class='text-danger' >Please fill the Sports House or Club name and proceed to Edit!</p>";
    }
}

function getClubsNSports() {
    var datapass = "?getmyclubs=true";
    sendData1("GET","administration/admissions.php",datapass,cObj("clubs_n_sports"));
}
function getClubSportsList() {
    var datapass = "?getmyclubs2=true";
    sendData1("GET","administration/admissions.php",datapass,cObj("clubs_for_sports_in"));
}

cObj("close_window_tutorial").onclick = function () {
    cObj("tutorial_windows").src = "";
    this.classList.add("hide");
}


// tutorial videos

cObj("admit_student_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/bA7yaVvS81Q")
};
cObj("student_attendance_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/PKPcHFAGTyY");
}
cObj("register_staff_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/za6dCeuGtDI");
}
cObj("payfees_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/XW06SZn5ZHo");
}
cObj("manage_transactions_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/LrXzyzzeEdU");
}
cObj("mpesa_trans_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/GeH02-Bbn2U");
}
cObj("fees_structure_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/xg8tBhn0OXk");
}
cObj("record_expenses_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/5iAF_yGEINk");
}
cObj("payroll_sys_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/z5mcUSZkbGw");
}
cObj("transport_system_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/CHsK_glWYJ4");
}
cObj("transport_system_student_tutorial").onclick = function () {
    showTutorial("https://www.youtube.com/embed/CHsK_glWYJ4");
}
function showTutorial(link) {
    // console.log(cObj("tutorial_windows").src);
    cObj("tutorial_windows").src = link;
    cObj("close_window_tutorial").classList.remove("hide");
}