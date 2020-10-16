class Calendar{
    constructor(Data, ParameterObject){

        //Checks the parameters the programer has implemented 
        if(this.parameterCheck(ParameterObject) == true){
            //Takes the data from the parameter
            this.dataSet = Data;

            this.weeklyTable = document.getElementById("weekCalendar");
            //Create global date variable then assign the current month and year to global variables
            this.today = new Date();
            //Gets the current month from the today object (this number is 1 less than the actually month number, 0 position in the array is january)
            this.currentMonth = this.today.getMonth();
            //Gets the current year from the today object
            this.currentYear = this.today.getFullYear();
            //Gets the current day number, for example 23 August from the today object
            this.currentDay = this.today.getDate();
            //Gets the day of the week number (sunday is 0, monday is 1 .... and so forth)
            this.dayOfTheWeek = this.today.getDay();
            //This takes the current month (adds 1 to get correct number) current day and current yea and presses them together
            this.currentFullDay = (this.currentMonth + 1) + "/" +  this.currentDay + "/" + this.currentYear;

            this.monthAndYear = document.getElementById("monthAndYear");
            //Grabs the week table node from the HTMl
            this.weekTable = document.getElementById("weekCalendar");


            //These 3 booleans are for things that are only ever displayed to the screen once, the header, and jump to
            this.headerGenerated = false; 
            this.weekCalendarGenerated = false; 
            this.dayCalendarGenerated = false; 
            this.displayingWeekCalendar = false; 
            this.displayingMonthCalendar = true; 
            this.displayingDayCalendar = false;

            //These 2 variables are arrays for the months of the year and the days in the week
            this.months = ["January", "February", "March", "April", "May", "June", "July", "August","September","October", "November", "December"];
            this.days = ["Sun", "Mon", "Tues", "Wed", "Thur", "Fri", "Sat"];
            //this.weeks = ["Sun","Mon", "Tues", "Wed", "Thurs", "Fri", "Satur"];
            //this.times = ["1:00 AM", "1:15 AM", "1:30 AM" , "1:45 AM","2:00 AM" , "2:15 AM","2:30 AM", "2:45 AM", "3:00 AM", "3:15 AM", "3:30 AM", "3:45 AM","4:00 AM", "4:15 AM", "4:30 AM", "4:45 AM", "5:00 AM", "5:15 AM" ,"5:30 AM", "5:45 AM" ,"6:00 AM", "6:15 AM" ,"6:30 AM", "6:45 AM","7:00 AM", "7:15 AM", "7:30 AM", "7:45 AM", "8:00 AM", "8:15 AM", "8:30 AM", "8:45 AM", "9:00 AM", "9:15 AM", "9:30 AM", "9:45 AM", "10:00 AM", "10:15 AM", "10:30 AM" , "10:45 AM", "11:00 AM", "11:15 AM" ,"11:30 AM", "11:45 AM" ,"12:00 PM", "12:15 PM" ,"12:30 PM", "12:45 PM" ,"1:00 PM", "1:15 PM" ,"1:30 PM", "1:45 PM" ,"2:00 PM", "2:15 PM" ,"2:30 PM", "2:45 PM" ,"3:00 PM", "3:15 PM" ,"3:30 PM", "3:45 PM","4:00 PM", "4:15 PM" ,"4:30 PM", "4:45 PM" ,"5:00 PM" ,"5:15 PM","5:30 PM", "5:45 PM" ,"6:00 PM", "6:15 PM" ,"6:30 PM", "6:45 PM" ,"7:00 PM", "7:15 PM", "7:30 PM", "7:45 PM" ,"8:00 PM",  "8:15 PM", "8:30 PM", "8:45 PM" ,"9:00 PM", "9:15 PM" ,"9:30 PM", "9:45 PM" ,"10:00 PM" , "10:15 PM" ,"10:30 PM", "10:45 PM" ,"11:00 PM", "11:15 PM" ,"11:30 PM", "11:45 PM" ,"12:00 AM", "12:15 AM","12:30 AM", "12:45 AM"]
            this.theWeek = ["Sunday","Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            this.times = this.createTheTime();
            //This array will store the current week in a format the exact same as current day
             this.theCurrentWeek = [];
             this.newWeek = [];
		
        }
    }

    //============================== Starting function ==============================================
    displayCalendar(){

        //This if checks if the users wants the jump form to be displayed, it also requires the month view
        if(this.allowJumpToForm == true && this.allowMonthTable == true){
            this.createJumpToItem();
        }


        /*checks if the user wants the day table displayed, if yes and the user wants the week and or
          month table displayed as well, then the day table will be created but hidden at the start */


        if(this.allowDayTable == true && this.allowWeekTable == true || this.allowDayTable == true && this.allowMonthTable == true){
            
            this.createDayCalendar(this.currentDay);
            document.getElementById("dayCalendar").classList.add("hiddenDisplay");
        }



        else if(this.allowDayTable == true && this.allowWeekTable == false || this.allowMonthTable == false){
            
            this.createDayCalendar(this.currentDay);
        }

        /*checks if the user wants the week table displayed, if yes and the user wants the month table
          displayed as well, then the week table will be created but hidden at the start */
        if(this.allowWeekTable == true &&  this.allowMonthTable == true){
            console.log("in")
            this.createWeeklyTable();
            document.getElementById("weekCalendar").classList.add("hiddenDisplay");
        }
        else if(this.allowWeekTable == true && this.allowMonthTable == false){
            console.log("in")
            this.createWeeklyTable();
        }
        //This if checks if the user wants to display the month table
        if(this.allowMonthTable == true){
            
            this.createMonthCalendar(this.currentMonth, this.currentYear);
        }
        //This checks if the user wants to display the next and previous buttons
        if(this.allowNextPrevButtons == true){
  
            this.createNextPrevBtn();
        }


        //This if checks if any of the calendar buttons should be displayed
        if(this.allowDayTableBtn == true || this.allowWeekTableBtn == true || this.allowMonthBtn == true){
            this.createCalendarViewButtons();
        }
       
    }

    //============================== Object parameter check =========================================
    parameterCheck(parameters){
        //This if statement checks if the length of the table object is 3, because there are 3 types of tables
        if(Object.keys(parameters.tables).length == 3){
            //Checks if day, week and month are set to true meaning the user wants those tables displayed
            if(parameters.tables.day == true){this.allowDayTable = true}
            else{this.allowDayTable = false}
            if(parameters.tables.week == true){this.allowWeekTable = true}
            else{this.allowWeekTable = false}
            if(parameters.tables.month == true){this.allowMonthTable = true}
            else{this.allowMonthTable = false}
        }else{
            console.log("Missing parameter in the tables property");
            return false;
        }

        //If all three tables are set to false then no tables are gonna be displayed, so return false
        if(this.allowDayTable == false && this.allowWeekTable == false && this.allowMonthTable == false){
            console.log("One of the tables must be set to true");
            return false;
        }

        //This if checks if the programmer wants to display the next and previous buttons
        if(parameters.nextPrevButtons == true){
            this.allowNextPrevButtons = true;
        }else{
            this.allowNextPrevButtons = false;
        }
        //This if checks if the programmer wants the jump to form displayed
        if(parameters.jumpTo == true){
            this.allowJumpToForm = true;
        }else{
            this.allowJumpToForm = false;
        }

        if(parameters.jumpTo == true && parameters.tables.month == false){
            console.log("The JumpTo functionality only works with the month calendar view");
            return false;
        }

        //This checks if the programmer wants the day week month buttons to be displayed
        if(Object.keys(parameters.tableButtons).length == 3){
            //Checks if both the day button and allowDayTable are set to true
            if(parameters.tableButtons.dayBtn == true && this.allowDayTable == true){
                this.allowDayTableBtn = true;
            }else if(parameters.tableButtons.dayBtn == true && this.allowDayTable == false){
                console.log("Cant have the day table set to false and the dayBtn set true");
                return false;
            }else{
                this.allowDayTableBtn = false;
            }

            if(parameters.tableButtons.weekBtn == true && this.allowWeekTable == true){
                this.allowWeekTableBtn = true;
            }else if(parameters.tableButtons.weekBtn == true && this.allowWeekTable == false){
                console.log("Cant have the week table set to false and the weekBtn set true");
                return false;
            }else{
                this.allowWeekTableBtn = false;
            }

            if(parameters.tableButtons.monthBtn == true && this.allowMonthTable == true){
                this.allowMonthBtn = true;
            }else if(parameters.tableButtons.monthBtn == true && this.allowMonthTable == false){
                console.log("Cant have the month table set to false and the monthBtn set true");
                return false;
            }else{
                this.allowMonthBtn = false;
            }

        }else{
            console.log("Missing parameter in the tableButtons property");
        }

        return true;
    }

    
    //============================== Display the day Table ==========================================
    createDayCalendar(theCurrentDay){
		
		
		
        var table = document.getElementById("dayCalendar");

        var thead = document.createElement("thead");

        var trHead = document.createElement("tr");

        var blankCell = document.createElement("th");
        blankCell.style.backgroundColor = "white";

        var todayCell = document.createElement("th");
        todayCell.style.backgroundColor = "white";

        todayCell.innerText = (this.currentMonth + 1) + "/" + theCurrentDay + "/" + this.currentYear;
        

        trHead.appendChild(blankCell);
        trHead.appendChild(todayCell);

        thead.appendChild(trHead);

        table.appendChild(thead);

        var tbody = document.createElement("tbody");
        for(var i = 0; i < this.times.length; i++){
            var tr = document.createElement("tr");

            var timeCell = document.createElement("td");
            timeCell.innerText = this.times[i];

            timeCell.style.backgroundColor = "white";

            var taskCell = document.createElement("td");
            taskCell.classList.add("no-events");
            taskCell.style.backgroundColor = "white";
            taskCell.rowSpan = 1;

            tr.appendChild(timeCell);
            tr.appendChild(taskCell);

            tbody.appendChild(tr);
        }
        table.appendChild(tbody);

        //========================Task creation display============================

        var tempTaskArray = this.dataSet.slice(0);
        var tempSingleDay = this.currentMonth + 1 + "/" + this.currentDay + "/" + this.currentYear;
        var tableBody = table.childNodes[1];

        var taskForToday = [];
        let taskCounter = 0;

        for(let z = 0; z < tempTaskArray.length; z++){

            var tempDateSplit = tempTaskArray[z].Task_Start_Date.toString().split("-");
            var taskNumberDate = tempDateSplit[1] + "/" + tempDateSplit[2] + "/" + tempDateSplit[0];

            if(taskNumberDate == tempSingleDay){
 
                taskForToday[taskCounter] = tempTaskArray[z];
                taskCounter++;
            }
        }

        for(var i = 0; i < tableBody.childNodes.length; i++){
            
            for(var j = 0; j < taskForToday.length; j++){ 
                
                var tempDateSplit = taskForToday[j].Task_Start_Date.toString().split("-");
                var taskNumberDate = tempDateSplit[1] + "/" + tempDateSplit[2] + "/" + tempDateSplit[0];


                let convertStartTime = this.convertMilitaryToCivilianTime(taskForToday[j].Task_Start_Time.toString());

                    if(convertStartTime == tableBody.childNodes[i].childNodes[0].innerText){
                        
                        var div = document.createElement("div");
                        div.classList.add("row-fluid");
                        div.classList.add("lecture");
                        div.style.width = "99%";
                        div.style.height = "100%";

                        var divSpan = document.createElement("span");
                        divSpan.classList.add("title");
                        divSpan.innerText = taskForToday[j].Task_Name;
            
                        div.appendChild(divSpan);

                        var timeSpan = document.createElement("span");
                        timeSpan.innerText = convertStartTime + "-" + this.convertMilitaryToCivilianTime(taskForToday[j].Task_End_Time.toString()); 

                        div.appendChild(timeSpan);

                        var incrementor = 0;
                        var colCounter = 0;

                        for(var z = 0; z < tableBody.childNodes.length; z++){
                            if(tableBody.childNodes[incrementor].childNodes[0].innerText == convertStartTime){
                                break;
                            }else{
                                incrementor++;
                            }
                        }      

                        var startMarker = incrementor;

                        for(var z = incrementor; z < tableBody.childNodes.length; z++){
                            if(tableBody.childNodes[incrementor].childNodes[0].innerText == this.convertMilitaryToCivilianTime(taskForToday[j].Task_End_Time.toString())){
                                break;
                            }else{
                                if(z != startMarker){
                                    tableBody.childNodes[z].removeChild(tableBody.childNodes[z].childNodes[1]);
                                }
                                incrementor++;
                                colCounter++;
                            }
                        }
                        tableBody.childNodes[startMarker].childNodes[1].appendChild(div);
                        tableBody.childNodes[startMarker].childNodes[1].classList = "";
                        tableBody.childNodes[startMarker].childNodes[1].classList.add("has-events");
                        tableBody.childNodes[startMarker].childNodes[1].rowSpan = colCounter;
                    }
                
            }
        }
    }

    
    //======================= Creates the week Table =============================================









    createWeeklyTableBody(){
        //========================Base table creation============================
                      
        var tbody = document.createElement("tbody");

        //This for loop runs through the times, displaying them in the first colum then it displays the 
        //empty colums in the same row to fill out the table.
        for(var i = 0; i < this.times.length; i++){
            //creates the row
            var bodyTr = document.createElement("tr");
            //creates the td and adds the time in
            var time = document.createElement("td");
            time.innerText = this.times[i];

            time.style.backgroundColor = "white";
            //appends the time to the row
            bodyTr.appendChild(time);

            //This loop runs through and appends empty td's to the rest of the row.
            for(var j = 0; j < 7; j++){
                var emptyCol = document.createElement("td");
                emptyCol.style.backgroundColor = "white";
                emptyCol.classList.add("no-events");
                emptyCol.rowSpan = 1;
                bodyTr.appendChild(emptyCol);
            }
            tbody.appendChild(bodyTr);
        }

        this.weeklyTable.appendChild(tbody);

        //========================End of Base table creation============================


        //========================Task creation display============================
        var tempTaskArray = this.dataSet.slice(0);

        var tableBody = this.weeklyTable.childNodes[1];

        var foundMatch = false;

        for(var i = 0; i < tableBody.childNodes.length; i++){
            for(var j = 0; j < tempTaskArray.length; j++){ 

                //Since the time coming from the database has seconds at the end we have to split it by the : character
                let tempStartTimeSplit = tempTaskArray[j].Task_Start_Time.split(":")
                //then rejoin the hours and minutes together so its the same format as before minus the seconda
                let correctStartTime = tempStartTimeSplit[0] + ":" + tempStartTimeSplit[1]; 
                //Converts the military time to civilian time, this function does not accept seconds for time
                correctStartTime = this.convertMilitaryToCivilianTime(correctStartTime);
                //This if checks the converted start time with the time listed on the table
                if(correctStartTime == tableBody.childNodes[i].childNodes[0].innerText){
                    //same issue as the start time, the time has seconds so we split
                    let tempEndTimeSplit = tempTaskArray[j].Task_End_Time.split(":");
                    //Put the strong back together
                    let correctEndTime = tempEndTimeSplit[0] + ":" + tempEndTimeSplit[1]; 
                    //Convert the milatry time to civilian time
                    correctEndTime = this.convertMilitaryToCivilianTime(correctEndTime);

                    var tempSplitDate = tempTaskArray[j].Task_Start_Date.toString().split("-");
                    var taskNumberDate = tempSplitDate[1] + "/" + tempSplitDate[2] + "/" + tempSplitDate[0];
                    for(var z = 0; z < this.theCurrentWeek.length; z++){

                        if(taskNumberDate == this.theCurrentWeek[z]){
                            var dayNumber = z + 1;
                            foundMatch = true;
                            break;
                        }
                    }

                    if(foundMatch == true){
                        var div = document.createElement("div");
                        div.classList.add("row-fluid");
                        div.classList.add("lecture");
                        div.style.width = "99%";
                        div.style.height = "100%";


                        var divSpan = document.createElement("span");
                        divSpan.classList.add("title");
                        divSpan.innerText = tempTaskArray[j].Task_Name;

                        div.appendChild(divSpan);

                        var timespan = document.createElement("span");
                        timespan.innerText = correctStartTime + " - " + correctEndTime;

                        div.appendChild(timespan);

                        var incrementor = 0;
                        var colCounter = 0;


                        for(var z = 0; z < tableBody.childNodes.length; z++){
                            if(tableBody.childNodes[incrementor].childNodes[0].innerText == correctStartTime){
                                break;
                            }else{
                                incrementor++;
                            }
                        }
                    
                        var startMarker = incrementor;
                    
                        for(var z = incrementor; z < tableBody.childNodes.length; z++){
                            if(tableBody.childNodes[incrementor].childNodes[0].innerText == correctEndTime){
                                break;
                            }else{
                                if(z != startMarker){
                                    tableBody.childNodes[z].removeChild(tableBody.childNodes[z].childNodes[dayNumber]);
                                }
                                incrementor++;
                                colCounter++;
                            }
                        }
                    
                        tableBody.childNodes[startMarker].childNodes[dayNumber].appendChild(div);
                        tableBody.childNodes[startMarker].childNodes[dayNumber].classList = "";
                        tableBody.childNodes[startMarker].childNodes[dayNumber].classList.add("has-events");
                        tableBody.childNodes[startMarker].childNodes[dayNumber].rowSpan = colCounter;

                        foundMatch = false;
                    }
                }
            }
        } 
        
    }

    monthSingleDayClick(e){

        let selected = e.target.id.toString().split("-")

        this.currentDay = parseInt(selected[1]);


        this.removeTable("dayCalendar");
		this.createDayCalendar(this.currentDay);

        this.displayingMonthCalendar = false;
        this.displayingWeekCalendar = false;
        this.displayingDayCalendar = true;


    
        document.getElementById("monthView").classList.remove("btn-primary");
        document.getElementById("weekView").classList.remove("btn-primary");
    
        document.getElementById("monthView").classList.add("btn-outline-primary");
        document.getElementById("weekView").classList.add("btn-outline-primary");
        
        document.getElementById("dayView").classList.remove("btn-outline-primary");
        document.getElementById("dayView").classList.add("btn-primary");
    
        document.getElementById("calendar").classList.add("hiddenDisplay");
        document.getElementById("weekCalendar").classList.add("hiddenDisplay");
    
        document.getElementById("dayCalendar").classList.remove("hiddenDisplay");
    
        document.getElementById("jumpTo").style.display = "none";
    }





    
    createWeeklyTable(){
        //counter for the while
        let weeklycounter = this.dayOfTheWeek;
        
        let tempDay = this.currentDay; 

        let tempYear = this.currentYear;
        let tempMonth = this.currentMonth;
        let tempMonthFixed = 0;

        if(tempMonth == 11){
            tempMonthFixed = 1;
        }else{
            tempMonthFixed = tempMonth;
            tempMonthFixed++;
        }


        while(weeklycounter < 7){
           
            if(weeklycounter > 0 && weeklycounter <= this.dayOfTheWeek){
             
                this.theCurrentWeek[weeklycounter] = tempMonth + 1 + "/" + tempDay + "/" + tempYear;
                weeklycounter = weeklycounter -1;
                tempDay = tempDay - 1;
                if(tempDay == 0){
                    if(tempMonth == 1){
                        tempDay = new Date(tempYear - 1, 11, 0).getDate();
                        tempMonth = 12;
                    }else{
                        tempDay = new Date(tempYear, tempMonth, 0).getDate();
                        tempMonth = tempMonth - 1;
                    } 
                }
            }else if (weeklycounter == 0){
                
                this.theCurrentWeek[weeklycounter] = tempMonth + 1 + "/" + tempDay + "/" + tempYear;
                weeklycounter = this.dayOfTheWeek + 1;
                tempDay = tempDay + 1;
                if(tempDay == 0){
                    if(tempMonth == 1){
                        tempDay = new Date(tempYear - 1, 11, 0).getDate();
                        tempMonth = 12;
                    }else{
                        tempDay = new Date(tempYear, tempMonth, 0).getDate();
                        tempMonth = tempMonth - 1;
                    } 
                }

                tempDay = this.currentDay + 1
                tempMonth = this.currentMonth;
            }else{
            
                this.theCurrentWeek[weeklycounter] = tempMonth + 1 + "/" + tempDay + "/" + tempYear;
                tempDay++;
                if(tempDay > new Date(tempYear, tempMonth, 0).getDate()){

                    if(tempMonth == 11){
                        tempDay = new Date(tempYear + 1, 0, 0).getDate();
                        tempMonth = 1;
                    }else{
                        
                        tempDay = 1//new Date(tempYear, tempMonth + 1, 0).getDate();
                        tempMonth = tempMonth + 1;
                    }
                }

                weeklycounter = weeklycounter + 1;
            }



            


            
        }

        //creates the thead and tr elements as well as the empty header box for the header
        var thead = document.createElement("thead");
        var theadRow = document.createElement("tr");
        var emptyCornerBox = document.createElement("th");

        //Here I add some stle and inner html to help make the empty header box the way it is, then I append it
        emptyCornerBox.style.width = "10%";
        emptyCornerBox.style.backgroundColor = "white";
        emptyCornerBox.innerHTML = "&nbsp;";
        theadRow.appendChild(emptyCornerBox);

        //This loop runs through the week display the day of the week and the date
        for(var i = 0; i < this.theWeek.length; i++){
                //creates the th element and gives it its style. It fills the innertext with the day of the week
                var th = document.createElement("th");
                th.style.backgroundColor = "white";
                th.style.width = "10%";
                th.innerText = this.theWeek[i];

                //Creates a break element and appends it to the th tag
                var tempBreak = document.createElement("br");
                th.appendChild(tempBreak);

                //Creates the span element and puts the date in the innerText of the HTML tag
                var tempSpan = document.createElement("span");
                tempSpan.innerText = this.theCurrentWeek[i];
                //This checks if any of the days are the current day, if so it adds a red color style to the tag
                var checkForDay = this.theCurrentWeek[i].split("/");
                if(checkForDay[1] == this.currentDay){
                    th.style.color = "red";
                }

                th.appendChild(tempSpan);

                theadRow.appendChild(th);
            }

            thead.appendChild(theadRow);

            this.weeklyTable.appendChild(thead);

            this.createWeeklyTableBody();

        
    }


    //============================== Display the month Table ==========================================

    /*This is the main function to display the calendar, it displays the proper day numbers and its called
    when  the user clicks next previous or either of the dropdowns*/
    createMonthCalendar(month, year) {

        let firstDay = (new Date(year, month)).getDay();
        let daysInMonth = 32 - new Date(year, month, 32).getDate();

        let fullTable = document.getElementById("calendar");

        var tableHead = document.createElement("thead");
        var tableHeadRow = document.createElement("tr");

        for(var i = 0; i < this.days.length; i++){
            var th = document.createElement("th");
            th.innerText = this.days[i];
            
            tableHeadRow.appendChild(th);
        }

        tableHead.appendChild(tableHeadRow);


        let tbl = document.createElement("tbody");// body of the calendar

        // clearing all previous cells
        tbl.innerHTML = "";

        /*These 3 if statments are active when the table is first being rendered, this displays the tables
        header and the options of the 2 dropdowns  for the year and month Jump To*/
        if(this.headerGenerated == false){
            this.generateDays();
            this.headerGenerated = true;
        }

        var tasks = this.dataSet; 
  

        // filing data about month and in the page via DOM.
        if(this.allowNextPrevButtons == true){
            this.monthAndYear.innerHTML = this.months[month] + " " + year;

            this.selectYear = document.getElementById("year");
            this.selectMonth = document.getElementById("month");
            this.selectYear.value = year;
            this.selectMonth.value = month; 
        }


        // creating all cells
        let date = 1;

        let counter = 0;
        let numberTasksDay = 0;

        for (let i = 0; i < 6; i++) {
            // creates a table row
            let row = document.createElement("tr");

            //creating individual cells, filing them up with data.
            for (let j = 0; j < 7; j++) {
                //If the month does not start on the Sunday then this if generates a few empty td boxes
                //until the start date number is found
                if (i === 0 && j < firstDay) {
                    let cell = document.createElement("td");
                    cell.style.backgroundColor = "white";
                    let cellText = document.createTextNode("");
                    cell.id = "empty";
                    cell.appendChild(cellText);
                    row.appendChild(cell);
                }
                //If the fate is greater than days in the month then this if breaks the loop
                else if (date > daysInMonth) {
                    break;
                }
                //This if prints the td's for the days in the month
                else {
                    let cell = document.createElement("td");
                    cell.style.backgroundColor = "white";
                    let ptag = document.createElement("p");
                    ptag.classList.add("cellNumber");

                    let cellText = document.createTextNode(date);
                    cell.id = this.months[this.currentMonth] + "-" + date + "-" + this.currentYear;
                    if (date === this.today.getDate() && year === this.today.getFullYear() && month === this.today.getMonth()) {
                        ptag.classList.add("bg-danger");
                    } // color today's date
                    ptag.appendChild(cellText);
                    
                    cell.appendChild(ptag);
                    
                    let tasksForTheDay = this.getMonthTasks(tasks, date);

                    if(tasksForTheDay != null){
                        let div = document.createElement("div");
                        let divNum = document.createElement("p");
    
                        div.classList.add("green-dash");
                        divNum.classList.add("text-center");
    
                        divNum.innerText = tasksForTheDay.length;
    
                        div.appendChild(divNum);
    
                        cell.appendChild(div);

                        numberTasksDay =0;
                    }
                    

                    cell.addEventListener("click", this.monthSingleDayClick.bind(this));
                            
                    row.appendChild(cell);
                    date++;
                }
            }
            tbl.appendChild(row); // appending each row into calendar body.
        }
        fullTable.appendChild(tbl);

    }

    getMonthTasks(tasks, theDay){
        
        let tasksForMonth = [];
        let counter = 0;
        for(let i = 0; i < tasks.length; i++){
            var splitTaskDay = tasks[i].Task_Start_Date.toString().split("-");
           
            if(parseInt(splitTaskDay[2]) === theDay && parseInt(splitTaskDay[1]) === (this.currentMonth + 1) && parseInt(splitTaskDay[0]) === this.currentYear){
                
                tasksForMonth[counter] = tasks[i];
                counter = counter + 1;
            }
        }

  

        if(tasksForMonth.length > 0 ){
            return tasksForMonth
        }else{
            return null;
        }

        
    }


    //============================== Display or hide tables ==========================================

    //============================== Display Day Table ==========================================
    changeToDayTable(){
		
        this.displayingMonthCalendar = false;
        this.displayingWeekCalendar = false;
        this.displayingDayCalendar = true;
    
        document.getElementById("monthView").classList.remove("btn-primary");
        document.getElementById("weekView").classList.remove("btn-primary");
    
        document.getElementById("monthView").classList.add("btn-outline-primary");
        document.getElementById("weekView").classList.add("btn-outline-primary");
        
        document.getElementById("dayView").classList.remove("btn-outline-primary");
        document.getElementById("dayView").classList.add("btn-primary");
    
        document.getElementById("calendar").classList.add("hiddenDisplay");
        document.getElementById("weekCalendar").classList.add("hiddenDisplay");
    
        document.getElementById("dayCalendar").classList.remove("hiddenDisplay");
    
        document.getElementById("jumpTo").style.display = "none";
    
    }


    //============================== Display Week Table ==========================================
    changeToWeekTable(){
        this.displayingMonthCalendar = false;
        this.displayingDayCalendar = false;
        this.displayingWeekCalendar = true;
    
        document.getElementById("monthView").classList.remove("btn-primary");
        document.getElementById("dayView").classList.remove("btn-primary");

        document.getElementById("monthView").classList.add("btn-outline-primary")
        document.getElementById("dayView").classList.add("btn-outline-primary")

        document.getElementById("weekView").classList.remove("btn-outline-primary");
        document.getElementById("weekView").classList.add("btn-primary");

        document.getElementById("calendar").classList.add("hiddenDisplay");
        document.getElementById("dayCalendar").classList.add("hiddenDisplay");

        document.getElementById("weekCalendar").classList.remove("hiddenDisplay");

        document.getElementById("jumpTo").style.display = "none";

    }

    //============================== Display Month Table ==========================================
    changeToMonthTable(){
        this.displayingMonthCalendar = true;
        this.displayingWeekCalendar = false;
        this.displayingDayCalendar = false;

        document.getElementById("weekView").classList.remove("btn-primary");
        document.getElementById("dayView").classList.remove("btn-primary");

        document.getElementById("weekView").classList.add("btn-outline-primary")
        document.getElementById("dayView").classList.add("btn-outline-primary")

        document.getElementById("monthView").classList.remove("btn-outline-primary");;
        document.getElementById("monthView").classList.add("btn-primary");

        document.getElementById("weekCalendar").classList.add("hiddenDisplay");
        document.getElementById("dayCalendar").classList.add("hiddenDisplay");

        document.getElementById("calendar").classList.remove("hiddenDisplay");

        document.getElementById("jumpTo").style.display = "";
    }




    //============================== Previous and Next button ==========================================
    /*This function is called when the event listener on the >> *next* button is clicked. It gets the current
    month and adds one and if it is greater than 12 it resets the month back to January then calls the
    createMonthCalendar function to re display the table.*/
    next() {

        if(this.displayingMonthCalendar == true){
            this.currentYear = (this.currentMonth === 11) ? this.currentYear + 1 : this.currentYear;
            this.currentMonth = (this.currentMonth + 1) % 12;
            this.removeTable("calendar");
            this.createMonthCalendar(this.currentMonth, this.currentYear);
        }
        if(this.displayingWeekCalendar == true){
            var tempcounter = 0;
            let newWeek = [];
                    

            let tempDay = this.theCurrentWeek[6].split("/");
            let nextMonth = tempDay[0];
            let nextDay = tempDay[1];
            let nextYear = tempDay[2];

            let tempMonthFixed = 0;

            let tempYear = this.currentYear;
            let tempMonth = this.currentMonth;

            if(tempMonth == 11){
                tempMonthFixed = 1;
            }else{
                tempMonthFixed = tempMonth;
                tempMonthFixed++;
            }

            for(let i = 0; i < this.theCurrentWeek.length; i++){
                nextDay++;
                if(nextDay > new Date(nextYear, nextMonth, 0).getDate()){
                    if(nextMonth == 12){
                        nextYear++;
                        nextDay = 1;
                        nextMonth = 1;
                    }else{   
                        nextMonth++;
                        nextDay = 1;
                    } 
                }

                newWeek[tempcounter] = nextMonth + "/" + nextDay + "/" + nextYear;

                tempcounter = tempcounter + 1;
            }

            for(var j = 0; j < newWeek.length; j++){
                this.theCurrentWeek[j] = newWeek[j];
            }

        

            while(this.weeklyTable.firstChild){
                this.weeklyTable.removeChild(this.weeklyTable.firstChild);
            }


            //creates the thead and tr elements as well as the empty header box for the header
            var thead = document.createElement("thead");
            var theadRow = document.createElement("tr");
            var emptyCornerBox = document.createElement("th");

            //Here I add some stle and inner html to help make the empty header box the way it is, then I append it
            emptyCornerBox.style.width = "10%";
            emptyCornerBox.innerHTML = "&nbsp;";
            theadRow.appendChild(emptyCornerBox);

            //This loop runs through the week display the day of the week and the date
            for(var i = 0; i < this.theWeek.length; i++){
                //creates the th element and gives it its style. It fills the innertext with the day of the week
                var th = document.createElement("th");
                th.style.width = "10%";
                th.innerText = this.theWeek[i];

                //Creates a break element and appends it to the th tag
                var tempBreak = document.createElement("br");
                th.appendChild(tempBreak);

                //Creates the span element and puts the date in the innerText of the HTML tag
                var tempSpan = document.createElement("span");
                tempSpan.innerText = this.theCurrentWeek[i];

                //This checks if any of the days are the current day, if so it adds a red color style to the tag
                var checkForDay = this.theCurrentWeek[i].split("/");

                if(checkForDay[1] == this.currentDay && checkForDay[0] == tempMonthFixed && checkForDay[2] == this.currentYear){
                    th.style.color = "red";
                }

                th.appendChild(tempSpan);

                theadRow.appendChild(th);
            }

            thead.appendChild(theadRow);

            this.weeklyTable.appendChild(thead);


            //========================End of Header creation=========================

            this.createWeeklyTableBody();
			
		
        }
        if(this.displayingDayCalendar == true){
			if(this.daysInMonth(this.currentMonth,this.currentYear) == this.currentDay){
				if(this.currentMonth === 11){
					this.currentYear = this.currentYear + 1;
					this.currentMonth = 0;
					this.currentDay = 1;
					this.removeTable("dayCalendar");
					this.createDayCalendar(this.currentDay);
				}else{
					this.currentMonth = this.currentMonth + 1;
					this.currentDay = 1;
					this.removeTable("dayCalendar");
					this.createDayCalendar(this.currentDay);
				}
			}else{
				this.currentDay = this.currentDay + 1;
				this.removeTable("dayCalendar");
				this.createDayCalendar(this.currentDay);
			}
        }


        
        
    }

    /*This function is called when the event listener on the << *previous* button is clicked. It gets the current
    month and subtracts one and if it is less than 0 it resets the month back to December then calls the
    createMonthCalendar function to re display the table. */
    previous() {

        if(this.displayingMonthCalendar == true){
            this.currentYear = (this.currentMonth === 0) ? this.currentYear - 1 : this.currentYear;
            this.currentMonth = (this.currentMonth === 0) ? 11 : this.currentMonth - 1;

            this.removeTable("calendar");
            this.createMonthCalendar(this.currentMonth, this.currentYear);
        }
        if(this.displayingWeekCalendar == true){
            let tempYear = this.currentYear;
            let tempMonth = this.currentMonth;

            var tempcounter = 6;
            let newWeek = [];

            let tempMonthFixed = 0;
            if(tempMonth == 11){
                tempMonthFixed = 1;
            }else{
                tempMonthFixed = tempMonth;
                tempMonthFixed++;
            }

            let tempDay = this.theCurrentWeek[0].split("/");
            let previousMonth = tempDay[0];
            let previousDay = tempDay[1];
            let previousYear = tempDay[2];

            for(let i = 0; i < this.theCurrentWeek.length; i++){
        
                previousDay = previousDay - 1;
                if(previousDay == 0){
                    if(previousMonth == 1){
                        previousYear = previousYear - 1
                        previousDay = new Date(previousYear, 12, 0).getDate();
                        previousMonth = 12;
                    }else{
                        
                        previousMonth = previousMonth - 1;
                        previousDay = new Date(previousYear, previousMonth, 0).getDate();

                    } 
                }

                newWeek[tempcounter] = previousMonth + "/" + previousDay + "/" + previousYear;

                tempcounter = tempcounter - 1;
            }
            
            

            for(var j = 0; j < newWeek.length; j++){
                this.theCurrentWeek[j] = newWeek[j];
            }

        


            while(this.weeklyTable.firstChild){
            this.weeklyTable.removeChild(this.weeklyTable.firstChild);
            }


            //creates the thead and tr elements as well as the empty header box for the header
            var thead = document.createElement("thead");
            var theadRow = document.createElement("tr");
            var emptyCornerBox = document.createElement("th");

            //Here I add some stle and inner html to help make the empty header box the way it is, then I append it
            emptyCornerBox.style.width = "10%";
            emptyCornerBox.innerHTML = "&nbsp;";
            theadRow.appendChild(emptyCornerBox);

            //This loop runs through the week display the day of the week and the date
            for(var i = 0; i < this.theWeek.length; i++){
                    //creates the th element and gives it its style. It fills the innertext with the day of the week
                    var th = document.createElement("th");
                    th.style.width = "10%";
                    th.innerText = this.theWeek[i];

                    //Creates a break element and appends it to the th tag
                    var tempBreak = document.createElement("br");
                    th.appendChild(tempBreak);

                    //Creates the span element and puts the date in the innerText of the HTML tag
                    var tempSpan = document.createElement("span");
                    tempSpan.innerText = this.theCurrentWeek[i];

                    //This checks if any of the days are the current day, if so it adds a red color style to the tag
                    var checkForDay = this.theCurrentWeek[i].split("/");

                    //increase current day by 1 to get accurate month
                    if(checkForDay[1] == this.currentDay && checkForDay[0] == tempMonthFixed && checkForDay[2] == this.currentYear){
                        th.style.color = "red";
                    }

                    th.appendChild(tempSpan);

                    theadRow.appendChild(th);
            }

            thead.appendChild(theadRow);

            this.weeklyTable.appendChild(thead);

            this.createWeeklyTableBody()




        }
        if(this.displayingDayCalendar == true){
			if(this.currentDay === 1){
				if(this.currentMonth === 0){
					this.currentYear = this.currentYear - 1;
					this.currentMonth = 11;
					this.currentDay = this.daysInMonth(this.currentMonth, this.currentYear);
					this.removeTable("dayCalendar");
					this.createDayCalendar(this.currentDay);
				}else{
					this.currentMonth = this.currentMonth - 1;
					this.currentDay = this.daysInMonth(this.currentMonth, this.currentYear);
					this.removeTable("dayCalendar");
					this.createDayCalendar(this.currentDay);
				}
			}else{
				this.currentDay = this.currentDay - 1;
				this.removeTable("dayCalendar");
				this.createDayCalendar(this.currentDay);
			}
        }   
    }
	
    //========================= Generating support functionality  =========================================

  
    /*This function generates the options for the jump to year dropdown. It takes the 
    current year and displays years from 15 years before the current year and 15 years
    after the current year */
    generateJumpYears(){
        var startingYear = this.currentYear - 15;
    
        while (startingYear < this.currentYear + 15){
            var yearOption = document.createElement("option");
            yearOption.setAttribute("value", startingYear);
            yearOption.innerText = startingYear;
            this.selectYear.appendChild(yearOption)
            startingYear++;
        }
    }
    
    /*This function generates the options for the jump to month dropdown. It runs through the months
    array displaying all the months */
    generateJumpToMonths(){
        for(var i = 0; i < this.months.length; i++){
            var option = document.createElement("option");
            option.setAttribute("value", i);
            option.innerText = this.months[i];
    
            this.selectMonth.appendChild(option);
        }
    }

    /*This function is called when the user changes either the month jump to dropdown or the year jump to
    dropdown. This function grabs the year or month selected and then calls the createMonthCalendar to 
    re display the calendar*/
    jump() {
        this.currentYear = parseInt(this.selectYear.value);
        this.currentMonth = parseInt(this.selectMonth.value);
        this.removeTable("calendar");
        this.createMonthCalendar(this.currentMonth, this.currentYear);
    }
    
    /*This function when called creates the header of the table, it displays all the days of the week */
    generateDays(){
        var thead = document.createElement("thead");
        var tr = document.createElement("tr");
        for(var i = 0; i < this.days.length; i++){
            var th = document.createElement("th");
            th.style.backgroundColor = "white";
            th.innerText = this.days[i];
            tr.appendChild(th);
        }
        thead.appendChild(tr);
        document.getElementById("calendar").appendChild(thead);
    }
    


    //========================= Other Helper functions  =========================================

    convertMilitaryToCivilianTime(time){

        let splitTime = time.split(":");
       

        var hours = Number(splitTime[0]);
        var minutes = Number(splitTime[1]);



        var timeValue;

        if (hours > 0 && hours <= 12) {
            timeValue= "" + hours;
        } else if (hours > 12) {
            timeValue= "" + (hours - 12);
        } else if (hours == 0) {
            timeValue= "12";
        }

        timeValue += (minutes < 10) ? ":0" + minutes : ":" + minutes;  // get minutes
        timeValue += (hours >= 12) ? " PM" : " AM";  // get AM/PM

        return timeValue;

    }

    //When called this function returns an array of time slots
    createTheTime(){
        let timeArray = [];
        let counter = 0;
        let amOrPm = "AM"
        
        for(let i = 1; i < 13; i++){
            if(i == 12 && amOrPm == "AM"){
                if(amOrPm == "AM"){
                    amOrPm = "PM"
                }
                
                for(let j = 0; j < 60; j+=5){
                    if(j < 10){
                        timeArray[counter] = i + ":0" + j + " " +  amOrPm
                        counter = counter + 1;
                    }else{
                        timeArray[counter] = i + ":" + j + " " +  amOrPm
                        counter = counter + 1;
                    }
                }

                if(amOrPm == "PM"){
                    i = 0;
                }

            }else{
                if(i == 12){
                    amOrPm = "AM"
                }

                for(let j = 0; j < 60; j+=5){
                    if(j < 10){
                        timeArray[counter] = i + ":0" + j + " " +  amOrPm
                        counter = counter + 1;
                    }else{
                        timeArray[counter] = i + ":" + j + " " +  amOrPm
                        counter = counter + 1;
                    }
                }
         
            }

        }

        return timeArray;
    }

    //This function when called gets the number of days in a given month, it gets passed the month and year
    daysInMonth(checkMonth, checkYear) { // Use 1 for January, 2 for February, etc.
        checkMonth++; //This program starts January as 1, mine starts at 0 so here I add 1
        return new Date(checkYear, checkMonth, 0).getDate();
    }

    //This function when called gets the day of the week a month starts on and returns it
    getMonthStartDay(year, month){
        var date = new Date(year, month, 1);
        var theDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return theDays[date.getDay()];
    }

    //When called this function removes all the children of a table. The parameter passed through is the table ID
    //This allows this function to work for all 3 of the calendars.
    removeTable(tableId){
        var table = document.getElementById(tableId);

        while(table.firstChild){
            if(tableId == "calendar"){

                table.removeChild(table.childNodes[1]);
                break;
            }else{
                table.removeChild(table.firstChild);
            }
            
        }
    }
	
	
    //========================= Generate HTML  =========================================

    
    //============================= Create the Jump to form structure ===============================
    createJumpToItem(){
        var form = document.createElement("form");
        form.classList.add("form-inline");

        var formGroupDiv = document.createElement("div");
        formGroupDiv.classList.add("form-group");

        var monthLabel = document.createElement("label");
        monthLabel.classList.add("lead");
        monthLabel.classList.add("mr-2");
        monthLabel.classList.add("ml-2");
        monthLabel.setAttribute("for", "month");
        monthLabel.innerText = "Jump To: ";

        var monthSelect = document.createElement("select");
        monthSelect.classList.add("form-control");
        monthSelect.setAttribute("name", "month");
        monthSelect.setAttribute("id", "month");
        monthSelect.addEventListener("change", this.jump.bind(this));

        var yearLabel = document.createElement("label");
        yearLabel.setAttribute("for","year");

        var yearSelect = document.createElement("select");
        yearSelect.classList.add("form-control");
        yearSelect.setAttribute("name", "year");
        yearSelect.setAttribute("id", "year");
        yearSelect.addEventListener("change", this.jump.bind(this));

        formGroupDiv.appendChild(monthLabel);
        formGroupDiv.appendChild(monthSelect);
        formGroupDiv.appendChild(yearLabel);
        formGroupDiv.appendChild(yearSelect);

        form.appendChild(formGroupDiv);
        
        
        document.getElementById("jumpTo").appendChild(form);

        this.selectYear = document.getElementById("year");
        this.selectMonth = document.getElementById("month");

        this.generateJumpYears();
        this.generateJumpToMonths();

    }

    //============================= Creates the Next and Previous buttons ===============================
    createNextPrevBtn(){
        var prevBtn = document.createElement("button");
        prevBtn.classList.add("btn");
        prevBtn.classList.add("btn-outline-primary");
        prevBtn.classList.add("col-sm-3");
        prevBtn.classList.add("col-md-3");
        prevBtn.classList.add("col-lg-3");
        prevBtn.classList.add("button-spacing");
        prevBtn.setAttribute("id", "previous");
        prevBtn.innerText = "<<";
        
        var nextBtn = document.createElement("button");
        nextBtn.classList.add("btn");
        nextBtn.classList.add("btn-outline-primary");
        nextBtn.classList.add("col-sm-3");
        nextBtn.classList.add("col-md-3");
        nextBtn.classList.add("col-lg-3");
        nextBtn.setAttribute("id", "next");
        nextBtn.innerText = ">>";

        //Adding the event listeners to the next and prev buttons and the months and year dropdown
        prevBtn.addEventListener("click", this.previous.bind(this));
        nextBtn.addEventListener("click", this.next.bind(this));
        
        document.getElementById("nxtPrevButtons").appendChild(prevBtn);
        document.getElementById("nxtPrevButtons").appendChild(nextBtn);
    }

    //============================= Creates Day Week Month buttons ===============================
    createCalendarViewButtons(){

        if(this.allowDayTableBtn == true){
            var dayBtn = document.createElement("button");
            dayBtn.classList.add("btn");
            dayBtn.classList.add("btn-outline-primary");
            dayBtn.classList.add("col-sm-3");
            dayBtn.classList.add("col-md-3");
            dayBtn.classList.add("col-lg-3");
            dayBtn.classList.add("button-spacing");
            dayBtn.setAttribute("id", "dayView");
            dayBtn.innerText = "Day";

            dayBtn.addEventListener("click", this.changeToDayTable.bind(this));

            document.getElementById("calendarViewButtons").appendChild(dayBtn);
        }
 
        if(this.allowWeekTableBtn == true){
            var weekBtn = document.createElement("button");
            weekBtn.classList.add("btn");
            weekBtn.classList.add("btn-outline-primary");
            weekBtn.classList.add("col-sm-3");
            weekBtn.classList.add("col-md-3");
            weekBtn.classList.add("col-lg-3");
            weekBtn.classList.add("button-spacing");
            weekBtn.setAttribute("id", "weekView");
            weekBtn.innerText = "Week";

            weekBtn.addEventListener("click", this.changeToWeekTable.bind(this));

            document.getElementById("calendarViewButtons").appendChild(weekBtn);
        }

        if(this.allowMonthBtn == true){
            var monthBtn = document.createElement("button");
            monthBtn.classList.add("btn");
            monthBtn.classList.add("btn-primary");
            monthBtn.classList.add("col-sm-3");
            monthBtn.classList.add("col-md-3");
            monthBtn.classList.add("col-lg-3");
            monthBtn.setAttribute("id", "monthView");
            monthBtn.innerText = "Month";

            monthBtn.addEventListener("click", this.changeToMonthTable.bind(this));

            document.getElementById("calendarViewButtons").appendChild(monthBtn);
        }

    }

}