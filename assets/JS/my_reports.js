// set the report button to the different roles present in the database
function getMyReportclasses() {
    var datapass = "getmystudents=select_report_class";
    sendDataPost("POST","/sims/ajax/administration/admissions.php",datapass,cObj("reports_classes"),cObj("class_load_report"));
    var datapass = "getmystudents=student_class_fin";
    sendDataPost("POST","/sims/ajax/administration/admissions.php",datapass,cObj("class_fin_in"),cObj("class_fin_in_load"));
}

cObj("select_entity").onchange = function () {
    if (this.value == "student") {
        var student = document.getElementsByClassName("student");
        cObj("entity_option").classList.remove("hide");
        var admin = document.getElementsByClassName("admin");
        for (let index = 0; index < admin.length; index++) {
            const element = admin[index];
            element.classList.add("hide");
        }
    }else{
        var student = document.getElementsByClassName("student");
        for (let index = 0; index < student.length; index++) {
            const element = student[index];
            element.classList.add("hide");
        }
        cObj("staff_options_two").classList.remove("hide");
    }
}

cObj("staff_options").onchange = function () {
    if (this.value == "logs") {
        cObj("date_select_staff").classList.remove("hide");
    }else{
        cObj("date_select_staff").classList.add("hide");
    }
}

cObj("select_student_option").onchange = function () {
    var stud_option = this.value;
    // console.log(stud_option);
    if (stud_option == "all_students") {
        var ctrl = document.getElementsByClassName("ctrl");
        for (let index = 0; index < ctrl.length; index++) {
            const element = ctrl[index];
            element.classList.add("hide");
        }
        cObj("class_select_report").classList.remove("hide");
    }else if (stud_option == "students_admitted") {
        var ctrl = document.getElementsByClassName("ctrl");
        for (let index = 0; index < ctrl.length; index++) {
            const element = ctrl[index];
            element.classList.add("hide");
        }
        // get the students admitted
        cObj("date_select_report").classList.remove("hide");
        cObj("class_select_report").classList.remove("hide");
    }else if (stud_option == "school_in_attendance") {
        var ctrl = document.getElementsByClassName("ctrl");
        for (let index = 0; index < ctrl.length; index++) {
            const element = ctrl[index];
            element.classList.add("hide");
        }
        // get the students admitted
        cObj("date_select_report").classList.remove("hide");
        cObj("class_select_report").classList.remove("hide");
    }else if (stud_option == "show_alumni") {
        var ctrl = document.getElementsByClassName("ctrl");
        for (let index = 0; index < ctrl.length; index++) {
            const element = ctrl[index];
            element.classList.add("hide");
        }
    }
}
cObj("finance_entity").onchange = function () {
    var my_val = this.value;
    if(my_val == "fees_collection"){
        var student_opt = document.getElementsByClassName("student_opt");
        for (let index = 0; index < student_opt.length; index++) {
            const element = student_opt[index];
            element.classList.remove("hide");
        }
        cObj("stud_opt_fin").classList.remove("hide");
        cObj("fees_reminder_message").classList.add("hide");
        cObj("compose_reminder_message").classList.add("hide");
        cObj("staff_list_windoweds").classList.add("hide");
    }else if (my_val == "class_balances") {
        var student_opt = document.getElementsByClassName("student_opt");
        for (let index = 0; index < student_opt.length; index++) {
            const element = student_opt[index];
            element.classList.add("hide");
        }
        cObj("stud_opt_fin").classList.remove("hide");
        cObj("time_period").classList.add("hide");
        cObj("specific_date").classList.add("hide");
        cObj("fees_reminder_message").classList.add("hide");
        cObj("compose_reminder_message").classList.add("hide");
        cObj("staff_list_windoweds").classList.add("hide");
    }else if (my_val == "fees_reminders") {
        var student_opt = document.getElementsByClassName("student_opt");
        for (let index = 0; index < student_opt.length; index++) {
            const element = student_opt[index];
            element.classList.add("hide");
        }
        cObj("stud_opt_fin").classList.remove("hide");
        cObj("time_period").classList.add("hide");
        cObj("specific_date").classList.add("hide");
        cObj("fees_reminder_message").classList.remove("hide");
        cObj("compose_reminder_message").classList.remove("hide");
        cObj("staff_list_windoweds").classList.add("hide");
    }else if (my_val == "fees_structure") {
        var student_opt = document.getElementsByClassName("student_opt");
        for (let index = 0; index < student_opt.length; index++) {
            const element = student_opt[index];
            element.classList.add("hide");
        }
        cObj("stud_opt_fin").classList.remove("hide");
        cObj("time_period").classList.add("hide");
        cObj("specific_date").classList.add("hide");
        cObj("fees_reminder_message").classList.add("hide");
        cObj("compose_reminder_message").classList.add("hide");
        cObj("staff_list_windoweds").classList.add("hide");
    }else if (my_val == "payroll_information") {
        var student_opt = document.getElementsByClassName("student_opt");
        for (let index = 0; index < student_opt.length; index++) {
            const element = student_opt[index];
            element.classList.add("hide");
        }
        cObj("stud_opt_fin").classList.add("hide");
        cObj("time_period").classList.add("hide");
        cObj("specific_date").classList.add("hide");
        cObj("fees_reminder_message").classList.add("hide");
        cObj("compose_reminder_message").classList.add("hide");
        cObj("staff_list_windoweds").classList.remove("hide");
        var datapass = "get_me_staff=true";
        sendDataPost("POST","/sims/ajax/administration/admissions.php",datapass,cObj("mystaff_lists"),cObj("staff_list_windoweds_load"));
    }
}
cObj("period_selection").onchange = function () {
    var my_val = this.value;
    if (my_val == "specific_date") {
        cObj("time_period").classList.add("hide");
        cObj("specific_date").classList.remove("hide");
    }else{
        cObj("time_period").classList.remove("hide");
        cObj("specific_date").classList.add("hide");
    }
    // cObj("specific_date_finance").value = "";
    // cObj("from_date_finance").value = "";
    // cObj("to_date_finance").value = "";
}
cObj("student_options").onchange = function () {
    var my_val = this.value;
    if (my_val == "byClass") {
        cObj("specific_class").classList.remove("hide");
        cObj("specific_stud_admno").classList.add("hide");
    }else if (my_val == "byAll") {
        cObj("specific_class").classList.add("hide");
        cObj("specific_stud_admno").classList.add("hide");
    }else if (my_val == "bySpecific") {
        cObj("specific_class").classList.add("hide");
        cObj("specific_stud_admno").classList.remove("hide");
    }
    // cObj("specific_date_finance").value = "";
    // cObj("from_date_finance").value = "";
    // cObj("to_date_finance").value = "";
}