
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
// get the data from the database
// var student_data = data;
// get an object by id 
function cObj(id) {
    return document.getElementById(id);
}

function stopInterval(id) {
    clearInterval(id);
}

var rowsColStudents_fees = [];
var rowsNCols_original_fees = [];
var pagecountTransaction = 0; //this are the number of pages for transaction
var pagecounttrans = 1; //the current page the user is
var startpage_fees = 0; // this is where we start counting the page number

// load the user data
function getFeesNDisplay(student_data) {
    rowsColStudents_fees = [];
    rowsNCols_original_fees = [];
    pagecountTransaction = 0; //this are the number of pages for transaction
    pagecounttrans = 1; //the current page the user is
    startpage_fees = 0; // this is where we start counting the page number
    // console.log(student_data.length);
    // get the arrays
    if (student_data.length > 0) {
        var rows = student_data;
        //create a column now
        for (let index = 0; index < rows.length; index++) {
            const element = rows[index];
            // create the collumn array that will take the row value
            var col = [];
            // console.log(element);
            col.push(element['stud_admin']);
            col.push(element['amount']);
            col.push(element['date_of_transaction']);
            col.push(element['student_name']);
            col.push(element['mode_of_pay']);
            col.push(element['payment_for']);
            col.push(element['amount_sort']);
            col.push(element['trans_date_sort']);
            col.push((index+1));
            // var col = element.split(":");
            rowsColStudents_fees.push(col);
        }
        rowsNCols_original_fees = rowsColStudents_fees;
        cObj("tot_records_fees").innerText = rows.length;
        //create the display table
        //get the number of pages
        cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);

        //show the number of pages for each record
        var counted = rows.length / 50;
        pagecountTransaction = Math.ceil(counted);

    } else {
        cObj("transDataReciever_fees").innerHTML = "<p class='sm-text text-danger text-bold text-center'><span style='font-size:40px;'><i class='fas fa-exclamation-triangle'></i></span> <br>Ooops! No results found!</p>";
        cObj("tablefooter_fees").classList.add("invisible");
    }
}

function displayRecord_fees(start, finish, arrays) {
    var total = arrays.length;
    //the finish value
    var fins = 0;
    //this is the table header to the start of the tbody
    var tableData = "<table class='table'><thead><tr><th title='Sort all' id='sortall_th'># <span id='sortall'><i class='fas fa-caret-down'></i></span></th><th id='sortadmno_th' title='Sort by Reg No'>Student Name {Adm no}<span id='sortadmno'><i class='fas fa-caret-down'></i></span></th><th  id='sortfeeamount_th' title='Sort by Amount'>Paid Amount <span id='sortfeeamount'><i class='fas fa-caret-down'></i></span></th><th  title='Sort by date' id='sortdate_th'>D.O.P <span id='sortdate'><i class='fas fa-caret-down'></i></span></th><th>M.O.P</th><th>Purpose</th></tr></tr></thead><tbody>";
    if(finish < total) {
        fins = finish;
        //create a table of the 50 records
        var counter = start+1;
        for (let index = start; index < finish; index++) {
            tableData += "<tr><td>"+arrays[index][8]+"</td><td><small class='text-sm'>"+arrays[index][3]+"</small> {"+arrays[index][0]+"}</td><td>Kes "+arrays[index][1]+"</td><td>"+arrays[index][2]+"</td><td>"+arrays[index][4]+"</td><td>"+arrays[index][5]+"</td></tr>";
            counter++;
        }
    }else{
        //create a table of the 50 records
        var counter = start+1;
        for (let index = start; index < total; index++) {
            tableData += "<tr><td>"+arrays[index][8]+"</td><td><small class='text-sm'>"+arrays[index][3]+"</small> {"+arrays[index][0]+"}</td><td>Kes "+arrays[index][1]+"</td><td>"+arrays[index][2]+"</td><td>"+arrays[index][4]+"</td><td>"+arrays[index][5]+"</td></tr>";
            counter++;
        }
        fins = total;
    }

    tableData += "</tbody></table>";
    //set the start and the end value
    cObj("startNo_fees").innerText = start + 1;
    cObj("finishNo_fees").innerText = fins;
    //set the page number
    cObj("pagenumNav_fees").innerText = pagecounttrans;
    // set tool tip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    setTimeout(() => {
        sortTable();
    }, 500);
    return tableData;
}
//next record 
//add the page by one and the number os rows to dispay by 50
cObj("tonextNav_fees").onclick = function() {
    console.log(pagecounttrans+" "+pagecountTransaction);
        if (pagecounttrans < pagecountTransaction) { // if the current page is less than the total number of pages add a page to go to the next page
            startpage_fees += 50;
            pagecounttrans++;
            var endpage = startpage_fees + 50;
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(startpage_fees, endpage, rowsColStudents_fees);
        } else {
            pagecounttrans = pagecountTransaction;
        }
    }
    // end of next records
cObj("toprevNac_fees").onclick = function() {
    if (pagecounttrans > 1) {
        pagecounttrans--;
        startpage_fees -= 50;
        var endpage = startpage_fees + 50;
        cObj("transDataReciever_fees").innerHTML = displayRecord_fees(startpage_fees, endpage, rowsColStudents_fees);
    }
}
cObj("tofirstNav_fees").onclick = function() {
    if (pagecountTransaction > 0) {
        pagecounttrans = 1;
        startpage_fees = 0;
        var endpage = startpage_fees + 50;
        cObj("transDataReciever_fees").innerHTML = displayRecord_fees(startpage_fees, endpage, rowsColStudents_fees);
    }
}
cObj("tolastNav_fees").onclick = function() {
    if (pagecountTransaction > 0) {
        pagecounttrans = pagecountTransaction;
        startpage_fees = (pagecounttrans * 50) - 50;
        var endpage = startpage_fees + 50;
        cObj("transDataReciever_fees").innerHTML = displayRecord_fees(startpage_fees, endpage, rowsColStudents_fees);
    }
}

// seacrh keyword at the table
cObj("searchkey_fees").onkeyup = function() {
        checkName(this.value);
    }
    //create a function to check if the array has the keyword being searched for
function checkName(keyword) {
    rowsColStudents_fees = rowsNCols_original_fees;
    pagecounttrans = 1;
    if (keyword.length > 0) {
        // cObj("tablefooter").classList.add("invisible");
    } else {
        // cObj("tablefooter").classList.remove("invisible");
    }
    // console.log(keyword.toLowerCase());
    var rowsNcol2 = [];
    var keylower = keyword.toLowerCase();
    var keyUpper = keyword.toUpperCase();
    //row break
    for (let index = 0; index < rowsColStudents_fees.length; index++) {
        const element = rowsColStudents_fees[index];
        //column break
        var present = 0;
        if (element[0].toLowerCase().includes(keylower) || element[0].toUpperCase().includes(keyUpper)) {
            present++;
        }
        if (element[1].toLowerCase().includes(keylower) || element[1].toUpperCase().includes(keyUpper)) {
            present++;
        }
        if (element[2].toLowerCase().includes(keylower) || element[2].toUpperCase().includes(keyUpper)) {
            present++;
        }
        if (element[3].toLowerCase().includes(keylower) || element[3].toUpperCase().includes(keyUpper)) {
            present++;
        }
        if (element[4].toLowerCase().includes(keylower) || element[4].toUpperCase().includes(keyUpper)) {
            present++;
        }
        if (element[5].toLowerCase().includes(keylower) || element[5].toUpperCase().includes(keyUpper)) {
            present++;
        }
        if (element[6].toString().includes(keyword)) {
            present++;
        }
        //here you can add any other columns to be searched for
        // console.log(element[6]==keyword);
        if (present > 0) {
            rowsNcol2.push(element);
        }
    }
    if (rowsNcol2.length > 0) {
        rowsColStudents_fees = rowsNcol2;
        var counted = rowsNcol2.length / 50;
        pagecountTransaction = Math.ceil(counted);
        cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsNcol2);
        cObj("tot_records_fees").innerText = rowsNcol2.length;
    } else {
        cObj("transDataReciever_fees").innerHTML = "<div class='displaydata'><img class='' src='images/error.png'></div><p class='sm-text text-danger text-bold text-center'><br>Ooops! your search for \"" + keyword + "\" was not found</p>";
        // cObj("tablefooter").classList.add("invisible");
        cObj("startNo_fees").innerText = 0;
        cObj("finishNo_fees").innerText = 0;
        cObj("tot_records_fees").innerText = 0;
        pagecountTransaction = 1;
    }
}

// sort in ascending or descending order
var sortallstatus = 1;
var sortadmnostatus = 1;
var sortfeeamountstatus = 1;
function sortTable() {
    cObj("sortall_th").addEventListener("click",function () {
        // sort all in ascending order
        if (sortallstatus == 0) {
            // asc up to down
            sortallstatus = 1;
            //WITH FIRST COLUMN
            rowsColStudents_fees = rowsNCols_original_fees;
            rowsColStudents_fees = sortDesc(rowsColStudents_fees,8);
            var counted = rowsColStudents_fees.length / 50;
            pagecountTransaction = Math.ceil(counted);
            // console.log(rowsColStudents_fees);
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);
            cObj("tot_records_fees").innerText = rowsColStudents_fees.length;
            cObj("sortall").innerHTML = "- <i class='fas fa-caret-down'></i>";
        }else{
            // desc down to up
            sortallstatus = 0;
            //WITH FIRST COLUMN
            rowsColStudents_fees = rowsNCols_original_fees;
            rowsColStudents_fees = sortAsc(rowsColStudents_fees,8);
            var counted = rowsColStudents_fees.length / 50;
            // console.log(rowsColStudents_fees);
            pagecountTransaction = Math.ceil(counted);
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);
            cObj("tot_records_fees").innerText = rowsColStudents_fees.length;
            cObj("sortall").innerHTML = "- <i class='fas fa-caret-up'></i>";
        }
    });
    cObj("sortadmno_th").addEventListener("click",function () {
        // sort all in ascending order
        if (sortadmnostatus == 0) {
            // asc up to down
            sortadmnostatus = 1;
            // console.log(cObj("sortadmno").innerHTML);
            //WITH FIRST COLUMN
            rowsColStudents_fees = rowsNCols_original_fees;
            rowsColStudents_fees = sortDesc(rowsColStudents_fees,0);
            var counted = rowsColStudents_fees.length / 50;
            pagecountTransaction = Math.ceil(counted);
            // console.log(rowsColStudents_fees);
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);
            cObj("tot_records_fees").innerText = rowsColStudents_fees.length;
            cObj("sortadmno").innerHTML = "- <i class='fas fa-caret-down'></i>";
        }else{
            // desc down to up
            sortadmnostatus = 0;
            //WITH FIRST COLUMN
            rowsColStudents_fees = rowsNCols_original_fees;
            rowsColStudents_fees = sortAsc(rowsColStudents_fees,0);
            var counted = rowsColStudents_fees.length / 50;
            // console.log(rowsColStudents_fees);
            pagecountTransaction = Math.ceil(counted);
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);
            cObj("tot_records_fees").innerText = rowsColStudents_fees.length;
            cObj("sortadmno").innerHTML = "- <i class='fas fa-caret-up'></i>";
        }
    });
    cObj("sortfeeamount_th").addEventListener("click",function () {
        // sort all in ascending order
        if (sortfeeamountstatus == 0) {
            // asc up to down
            sortfeeamountstatus = 1;
            // console.log(cObj("sortfeeamount").innerHTML);
            //WITH FIRST COLUMN
            rowsColStudents_fees = rowsNCols_original_fees;
            rowsColStudents_fees = sortDesc(rowsColStudents_fees,6);
            var counted = rowsColStudents_fees.length / 50;
            pagecountTransaction = Math.ceil(counted);
            // console.log(rowsColStudents_fees);
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);
            cObj("tot_records_fees").innerText = rowsColStudents_fees.length;
            cObj("sortfeeamount").innerHTML = "- <i class='fas fa-caret-down'></i>";
        }else{
            // desc down to up
            sortfeeamountstatus = 0;
            //WITH FIRST COLUMN
            rowsColStudents_fees = rowsNCols_original_fees;
            rowsColStudents_fees = sortAsc(rowsColStudents_fees,6);
            var counted = rowsColStudents_fees.length / 50;
            // console.log(rowsColStudents_fees);
            pagecountTransaction = Math.ceil(counted);
            cObj("transDataReciever_fees").innerHTML = displayRecord_fees(0, 50, rowsColStudents_fees);
            cObj("tot_records_fees").innerText = rowsColStudents_fees.length;
            cObj("sortfeeamount").innerHTML = "- <i class='fas fa-caret-up'></i>";
        }
    });
    cObj("sortdate_th").addEventListener("click",function () {
        cObj("sortall_th").click();
    });
}
function sortDesc(arrays,index){
    arrays = arrays.sort(sortFunction);
    function sortFunction(a, b) {
        if (a[index] === b[index]) {
            return 0;
        }
        else {
            return (a[index] > b[index]) ? -1 : 1;
        }
    }
    return arrays;
}
function sortAsc(arrays,index){
    arrays = arrays.sort(sortFunction);
    function sortFunction(a, b) {
        if (a[index] === b[index]) {
            return 0;
        }
        else {
            return (a[index] < b[index]) ? -1 : 1;
        }
    }
    return arrays;
}