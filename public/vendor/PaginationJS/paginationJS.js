  /* 
  "StAuth10065: I Colton Davies, 000746723 certify that this material is my original work.
  No other person's work has been used without due acknowledgement. I have not made my 
  work available to anyone else."
  */
class Table{
    constructor(Data , parameterObject){
         
         //This is the data being fed to the table
        if(Array.isArray(Data) == true){
          this.data = Data;
        }else{
          this.data = null;
        }

        if(Array.isArray(parameterObject.tableHeaders) == true){
          this.tableHeaders = parameterObject.tableHeaders.splice(0);
        }else{
          this.tableHeaders = "";
        }
         //these are the table headers
        this.tableId = parameterObject.tableId; //The id of the table location
        if(Array.isArray(parameterObject.fields) == true){
          this.objectFields = parameterObject.fields; // The fields of the items in the table
        }else{
          this.objectFields = null;
        }

        this.showNumItemsDropdown = parameterObject.numOfItemsDropdownDisplay.display;// true or false if the dropdown is displayed

        if(this.showNumItemsDropdown == true){
          if(Array.isArray(parameterObject.numOfItemsDropdownDisplay.numberList) == true){
            this.numItemsForDisplay = parameterObject.numOfItemsDropdownDisplay.numberList.splice(0);
          }else{
            console.log("dropdown input must be an array");
          }
        }


        this.showSearchBar = parameterObject.searchBarDisplay; // true or false if the search bar is displayed
        this.customButtons = parameterObject.specialButtons.splice(0);

        this.pageStart = 0; // this is where the loop will start on the array
        this.pageEnd = 5; // this is where the loop will end on the array
        this.pageNumber = 1;
        this.maxItemsPerPage = 5; // this is the max number of items that will display per page
        this.maxPages = Math.ceil(this.data.length / this.maxItemsPerPage); //displays the max number of pages
        this.searchResults = [];
        this.inSearchMode = false;

    }

    //This function creates the table and checks all the parameters
    createTable(){

      if(this.data.length != 0 || this.data != null){

        if(this.tableId != "" && this.tableId != null && this.tableId != undefined){

          if(this.tableHeaders != "" ){

            if(this.objectFields != null){
              if(this.dataAndHeaderCheck() == true){
                this.generateTableSkeleton();
                if(this.showSearchBar == true){
                  this.createSearchBar();
                }
                if(this.showNumItemsDropdown == true){
                  this.createDropdown();
                }
                this.createPagination();
                this.displayTable(this.data);

              }else{
                console.log("The object fields don't match the real object fields");
              }
            }else{
              console.log("The objectFields cannot be empty");
            }
          }else{
            console.log("Table Headers are required");
          }
        }else{
          console.log("table Id is empty or null or undefined");
        }
      }else{
        console.log("The data array entered is empty");
      }

    }

    /*This function is called if the user wants to have a search bar that will search through their data */
    createSearchBar(){
      //creates the tags
      var label = document.createElement("label");
      var input = document.createElement("input");
      var div = document.createElement("div");

      input.addEventListener("keyup", this.search.bind(this));

      label.innerText = "Search for Task";

      div.setAttribute("class", "form-group");

      label.setAttribute("for", "searchName");

      input.setAttribute("type", "text");
      input.setAttribute("class", "form-control");
      input.setAttribute("id", "searchName");
      input.setAttribute("placeholder", "Search Task Name");

      div.appendChild(label);
      div.appendChild(input);

      document.getElementById("searchBar").appendChild(div);
    }

    /*This function is called if the user wants to have a dropdown to control the number of items displayed
      on the table */
    createDropdown(){
      var label = document.createElement("label");
      var select = document.createElement("select");

      label.innerText = "Number of items displayed per page (select one):";

      select.setAttribute("class","form-control");
      select.setAttribute("id","NumberDropdown");

      var range = this.numItemsForDisplay;

      select.addEventListener("change", this.numItemsDisplay.bind(this));

      for(var i = 0; i < range.length; i++){
        var option = document.createElement("option");
        option.innerText = range[i];
        select.appendChild(option);
      }

      document.getElementById("numOfItemsDisplay").appendChild(label);
      document.getElementById("numOfItemsDisplay").appendChild(select);

    }

    //This function checks through the data header and makes sure they match the object fields inputed
    dataAndHeaderCheck(){
      if(this.data.length !=0){
          for(var i = 0; i < this.objectFields.length; i++){
            for(var j = 0; j < 10; j++ ){
                if(this.data[j].hasOwnProperty(objectFields[i]) == false){
                  
                  return false;
                }
            }
        }

        return true;

      }else{
        return true;
      }
        
    }

    //This function generates the skeleton of the table, it creates the t body and t head and inputs the headers
    generateTableSkeleton(){

        var tHead = document.createElement("thead");
        for(var i = 0; i < this.tableHeaders.length; i++){
            var th = document.createElement("th");
            th.setAttribute("scope", "col");
            th.innerText = this.tableHeaders[i];
            tHead.appendChild(th);

        }

        var tbody = document.createElement("tbody");
        tbody.setAttribute("id", "tableBody");

        this.tableId.appendChild(tHead);
        this.tableId.appendChild(tbody);

    }



    /*This function is called when the user starts typing in the searchName input field
      it takes the user input and removes the table and pagination to make way for the updated
      table.
    */
    search() {
      var searchInput = document.getElementById("searchName").value;

      //if the length of value is 0 then there is nothing in the input box, it resets the table
      //to its basic table display
      if (searchInput === "" ) {

        this.maxPages = Math.ceil(this.data.length / this.maxItemsPerPage);

        this.inSearchMode = false;

        this.pageStart = 0;

        this.pageEnd = this.maxItemsPerPage;

        this.removeTable();

        this.removePagination();

        this.displayTable(this.data);

        this.createPagination();

        this.disablingButtons(this.pageNumber);

      }
      /* if the length of the input string is greater than 0 it means the user typed something in
         the program removes the table and pagination and called search table  function */
      else {
        this.pageStart = 0;
        this.pageEnd = this.maxItemsPerPage;
        this.pageNumber = 1;
        this.inSearchMode = true;

        this.removeTable();

        this.removePagination();

        this.searchTable(searchInput);

      }

    }

    /*This function goes through the data array looking for items that contain searchInput
      all of the results are put into and array and displayed along with the proper pagination
    */
    searchTable(searchInput) {
      var results = [];
      var counter = 0;


      searchInput = searchInput.toLowerCase();


      if (this.data.length > 0) {

        if(searchInput.length == 0){
          this.removeTable();

          this.displayTable(this.data);

          this.createPagination();

          this.disablingButtons(this.pageNumber);

        }else{
          //This loop goes through the data checking for items that match what has been inputed
          //It then stores them in an array.

          //clears out the search result array to make way for the new user input
          if(this.searchResults.length > 0){
            this.searchResults = [];
          }

          for (var i = 0; i < this.data.length; i++) {
            if (this.data[i].Task_Name.toLowerCase().includes(searchInput)) {
              this.searchResults[counter] = this.data[i];
              counter++;
            }
          }

          this.maxPages = Math.ceil(this.searchResults.length / this.maxItemsPerPage);

          this.removeTable();

          this.displayTable(this.searchResults);

          this.createPagination();

          this.disablingButtons(this.pageNumber);

        }
      }
    }

    /*This function is called when the user changes the dropdown menu. It resets the program
      to the first page and increases the number of items displayed on the screen
    */
    numItemsDisplay(e) {

      this.maxItemsPerPage = parseInt(e.target.value);

      var searchValueLength = document.getElementById("searchName").value;
      if (searchValueLength.length > 0) {
        this.maxPages = Math.ceil(this.searchResults.length / this.maxItemsPerPage);
      } else {
        this.maxPages = Math.ceil(this.data.length / this.maxItemsPerPage);
      }

      this.pageEnd = this.maxItemsPerPage;

      this.pageNumber = 1;

      this.pageStart = 0;

      //grabs the table and clears all the children elements
      this.removeTable();

      this.removePagination();

      this.createPagination();

      //calls the displayTable() function to re display the table

      if (searchValueLength.length > 0) {
        this.displayTable(this.searchResults);
      } else {
        this.displayTable(this.data);
      }

      this.disablingButtons(this.pageNumber);
    }


    /*
      This functions when called creates the elements that make up the pagination.
    */
    createPagination() {
      //This creates the Li for the previous button and adds the disabled
      var prevButton = document.createElement("li");
      prevButton.classList.add("page-item");
      if (this.pageNumber == 1) {
        prevButton.classList.add("disabled");
      }

      //this adds the internal link to the previous button LI
      var prevButtonLink = document.createElement("a");
      prevButtonLink.classList.add("page-link");
      prevButtonLink.setAttribute("id", "prevBtn");
      prevButtonLink.setAttribute("href", "#");
      prevButtonLink.innerText = "Previous";

      //adds the event listener
      prevButtonLink.addEventListener("click", this.prevPage.bind(this));
      //this appends the a tag to the LI
      prevButton.appendChild(prevButtonLink);
      //this adds the LI to the pagination ID
      document.getElementById("pagination").appendChild(prevButton);

      //if the number of pages is less than or equal to 6 then use this method to display
      if (this.maxPages <= 6) {
        //This loop goes through displaing the pagnation number items
        for (var i = 1; i <= this.maxPages; i++) {
          //creates the li, if its the first item then add active class
          var paginationItem = document.createElement("li");
          paginationItem.classList.add("page-item");
          if (i == this.pageNumber) {
            paginationItem.classList.add("active");
          }
          //this creates the a tag to put inside the li tag
          var paginationLink = document.createElement("a");
          paginationLink.classList.add("page-link");
          paginationLink.setAttribute("href", "#");
          var textNode = document.createTextNode(i);
          paginationLink.appendChild(textNode);

          paginationLink.addEventListener("click", this.specificPage.bind(this));

          paginationItem.appendChild(paginationLink);

          document.getElementById("pagination").appendChild(paginationItem);
        }



      } else {
        if (this.pageNumber > 3) {

          for (var i = 1; i == 1; i++) {
            var paginationItem = document.createElement("li");
            paginationItem.classList.add("page-item");

            //this creates the a tag to put inside the li tag
            var paginationLink = document.createElement("a");
            paginationLink.classList.add("page-link");
            paginationLink.setAttribute("href", "#");
            var textNode = document.createTextNode(i);
            paginationLink.appendChild(textNode);

            paginationLink.addEventListener("click", this.specificPage.bind(this));

            paginationItem.appendChild(paginationLink);

            document.getElementById("pagination").appendChild(paginationItem);
          }

          var firstTripleDots = document.createElement("li");
          firstTripleDots.classList.add("page-item");
          firstTripleDots.classList.add("disabled");

          var firstTripleDotLink = document.createElement("a");
          firstTripleDotLink.classList.add("page-link");
          firstTripleDotLink.setAttribute("href", "#");
          var firstTripleDotLinkText = document.createTextNode('...');
          firstTripleDotLink.appendChild(firstTripleDotLinkText);

          firstTripleDots.appendChild(firstTripleDotLink);

          document.getElementById("pagination").appendChild(firstTripleDots);

          var pagesInBetween = this.maxPages - this.pageNumber;

          if (pagesInBetween > 6) {
            var pagesAhead = 5;
          } else if (pagesInBetween == 6) {
            var pagesAhead = 6;
          }
          else {
            var pagesAhead = pagesInBetween;
          }

          for (var i = this.pageNumber - 2; i <= this.pageNumber + pagesAhead; i++) {


            var paginationItem = document.createElement("li");
            paginationItem.classList.add("page-item");
            if (i == this.pageNumber) {
              paginationItem.classList.add("active");
            }

            //this creates the a tag to put inside the li tag
            var paginationLink = document.createElement("a");
            paginationLink.classList.add("page-link");
            paginationLink.setAttribute("href", "#");
            var textNode = document.createTextNode(i);
            paginationLink.appendChild(textNode);

            paginationLink.addEventListener("click", this.specificPage.bind(this));

            paginationItem.appendChild(paginationLink);

            document.getElementById("pagination").appendChild(paginationItem);
          }

        } else {

          for (var i = 1; i <= this.pageNumber + 5; i++) {
            var paginationItem = document.createElement("li");
            paginationItem.classList.add("page-item");
            if (i == this.pageNumber) {
              paginationItem.classList.add("active");
            }

            //this creates the a tag to put inside the li tag
            var paginationLink = document.createElement("a");
            paginationLink.classList.add("page-link");
            paginationLink.setAttribute("href", "#");
            var textNode = document.createTextNode(i);
            paginationLink.appendChild(textNode);

            paginationLink.addEventListener("click", this.specificPage.bind(this));

            paginationItem.appendChild(paginationLink);

            document.getElementById("pagination").appendChild(paginationItem);

          }
        }
        // if the page number + 5 is smaller than max pages - 1 then we will display "..."
        // before we display the last page
        if (this.pageNumber + 5 < this.maxPages - 1) {
          var tripleDots = document.createElement("li");
          tripleDots.classList.add("page-item");
          tripleDots.classList.add("disabled");

          var tripleDotLink = document.createElement("a");
          tripleDotLink.classList.add("page-link");
          tripleDotLink.setAttribute("href", "#");
          var tripleDotLinkText = document.createTextNode('...');
          tripleDotLink.appendChild(tripleDotLinkText);

          tripleDots.appendChild(tripleDotLink);

          document.getElementById("pagination").appendChild(tripleDots);

          for (var i = this.maxPages; i <= this.maxPages; i++) {
            var paginationItem = document.createElement("li");
            paginationItem.classList.add("page-item");

            //this creates the a tag to put inside the li tag
            var paginationLink = document.createElement("a");
            paginationLink.classList.add("page-link");
            paginationLink.setAttribute("href", "#");
            var textNode = document.createTextNode(i);
            paginationLink.appendChild(textNode);

            paginationLink.addEventListener("click", this.specificPage.bind(this));

            paginationItem.appendChild(paginationLink);

            document.getElementById("pagination").appendChild(paginationItem);
          }
        }
        //if pageNumber + 5 == maxPage -1 then means there is exactly enough pages
        //to display minus the last one, so we will display the last page anyways
        //but we wont display the "..."
        else if (this.pageNumber + 5 == this.maxPages - 1) {
          for (var i = this.maxPages; i <= this.maxPages; i++) {
            var paginationItem = document.createElement("li");
            paginationItem.classList.add("page-item");

            //this creates the a tag to put inside the li tag
            var paginationLink = document.createElement("a");
            paginationLink.classList.add("page-link");
            paginationLink.setAttribute("href", "#");
            var textNode = document.createTextNode(i);
            paginationLink.appendChild(textNode);

            paginationLink.addEventListener("click", this.specificPage.bind(this));

            paginationItem.appendChild(paginationLink);

            document.getElementById("pagination").appendChild(paginationItem);
          }

        }

      }

      //this creates the nextButton LI tag
      var nextButton = document.createElement("li");
      nextButton.classList.add("page-item");
      //this creates the a tag to put inside the li tag
      var nextButtonLink = document.createElement("a");
      nextButtonLink.classList.add("page-link");
      nextButtonLink.setAttribute("id", "nextBtn");
      nextButtonLink.setAttribute("href", "#");
      nextButtonLink.innerText = "Next";
      //adds the event listener
      nextButtonLink.addEventListener("click", this.nextPage.bind(this));

      nextButton.appendChild(nextButtonLink);

      document.getElementById("pagination").appendChild(nextButton);

    }

    /* This function is called when a specific number is clicked on the pagination, this function
    Then grabs the number that was clicked and pages it the pageNumber. This function clears the
    table and pagination and then updates it with the proper information
    */
    specificPage(e) {

      var pageItems = document.getElementsByClassName("page-item");

      var pageSelected = e.target.innerText;

      if (pageSelected > this.pageNumber) {

        for (var i = 0; i < pageItems.length; i++) {
          if (pageItems[i].classList.contains("active")) {
            pageItems[i].classList.remove("active");
          }
        }

        var newPageset = pageSelected - this.pageNumber;

        var newPageEnd = this.pageEnd + (this.maxItemsPerPage * newPageset);
        var newPageStart = newPageEnd - this.maxItemsPerPage;

        this.pageStart = newPageStart;
        this.pageEnd = newPageEnd;
        this.pageNumber = this.pageNumber + newPageset;

        //grabs the table and clears all the children elements
        this.removeTable();

        this.removePagination();
        this.createPagination();

        this.displayTable(this.data);

        this.disablingButtons(pageSelected);


        var pageLinks = document.getElementsByClassName("page-link");

        for (var i = 0; i < pageLinks.length; i++) {
          if (pageLinks[i].innerText == this.pageNumber) {
            pageLinks[i].parentNode.classList.add("active");
          }
        }

      }
      else if (pageSelected < this.pageNumber) {


        for (var i = 0; i < pageItems.length; i++) {
          if (pageItems[i].classList.contains("active")) {
            pageItems[i].classList.remove("active");
          }
        }

        var newPageset = pageSelected - this.pageNumber;

        var newPageEnd = this.pageEnd + (this.maxItemsPerPage * newPageset);
        var newPageStart = newPageEnd - this.maxItemsPerPage;

        this.pageStart = newPageStart;
        this.pageEnd = newPageEnd;
        this.pageNumber = this.pageNumber + newPageset;

        //grabs the table and clears all the children elements
        this.removeTable();

        this.removePagination();
        this.createPagination();


        //calls the displayTable() function to re display the table
        if(this.showSearchBar == true){
          var searchValueLength = document.getElementById("searchName").value;
          if (searchValueLength.length > 0) {
            this.displayTable(this.searchResults);

          } else {
            this.displayTable(this.data);
          }
        }else {
          this.displayTable(this.data);
        }
        

        this.disablingButtons(pageSelected);

        var pageLinks = document.getElementsByClassName("page-link");

        for (var i = 0; i < pageLinks.length; i++) {
          if (pageLinks[i].innerText == this.pageNumber) {
            pageLinks[i].parentNode.classList.add("active");
          }
        }
      }
    }

    /*This function is called when the user clicks the "Prev" button, it increases the page number
   and removes both the table and the pagination and re displays them with the updated info
   */
    prevPage() {
      if (this.pageNumber > 0) {
        //grabs all the pagination elements
        var liElements = document.getElementsByClassName("page-item");



        //remove the active from the current page number
        for (var i = 0; i < liElements.length; i++) {
          if (liElements[i].classList.contains("active")) {
            liElements[i].classList.remove("active");
          }
        }

        //decreases the pageNumber
        this.pageNumber--;

        this.disablingButtons(this.pageNumber)

        //adds active class to the current page number
        for (var i = 0; i < liElements.length; i++) {
          if (liElements[i].childNodes[0].innerText == this.pageNumber) {
            liElements[i].classList.add("active");
          }
        }


        /*this statment is for when we get to the end of the pagination that has odd set of number,
          when you get to the end it brings it back to the regular display*/
        if (this.pageEnd == this.data.length) {
          this.pageEnd = this.pageStart + this.maxItemsPerPage;
        }

        //grabs the table and clears all the children elements
        this.removeTable();

        this.removePagination();
        this.createPagination();

        //increases the page start and end so it will get the next level of data
        this.pageStart = this.pageStart - this.maxItemsPerPage;
        this.pageEnd = this.pageEnd - this.maxItemsPerPage;

        //calls the displayTable() function to re display the table
        var searchValueLength = document.getElementById("searchName").value;
        if (searchValueLength.length > 0) {
          this.displayTable(this.searchResults);
        } else {
          this.displayTable(this.data);
        }

      }
    }

    /*This function is called when the user clicks the "Next" button, it increases the page number
    and removes both the table and the pagination and re displays them with the updated info
    */
    nextPage() {


      if (this.pageNumber < this.maxPages) {

        //grabs all the pagination elements
        var liElements = document.getElementsByClassName("page-item");

        //increase the pageNumber
        this.pageNumber++;

        //adds active class to the current page number

        for (var i = 0; i < liElements.length; i++) {

          if (liElements[i].childNodes[0].innerText == this.pageNumber) {
            liElements[i].classList.add("active");
          }
        }



        //grabs the table and clears all the children elements
        this.removeTable();

        this.removePagination();
        this.createPagination();

        this.disablingButtons(this.pageNumber)

        //increases the page start and end so it will get the next level of data
        this.pageStart = this.pageStart + this.maxItemsPerPage;
        this.pageEnd = this.pageEnd + this.maxItemsPerPage;

        //if there is an odd set of data this, will ensure, this will prevent the programming displaying undefined
        if (this.pageEnd > this.data.length) {
          this.pageEnd = this.data.length;

        }

        //calls the displayTable() function to re display the table
        var searchValueLength = document.getElementById("searchName").value;
        if (searchValueLength.length > 0) {
          this.displayTable(this.searchResults);
        } else {
          this.displayTable(this.data);
        }

      }
    }
    //This function displays the items into the table
    displayTable(displayData) {
      var emptyCounter = 0;

      

      for (var i = this.pageStart; i < this.pageEnd; i++) {
        
        if (displayData[i] != undefined && displayData[i] != null) {
          var row = document.createElement("tr");

          //grabs all of the keys of the current object
          var keys = Object.keys(displayData[i]);

          
            //This goes through a loop of all the object fields inputed
          for(var z = 0; z < this.objectFields.length; z++){
            //Then goes through a loop of the keys that have been pulled from the object
            for(var j = 0; j < keys.length; j++){
                //if the objectfield matches the key then we build a td tag for the object property
                if(this.objectFields[z] == keys[j]){
                    
                    var cell = document.createElement("td");

                    if(this.objectFields[z] == "Task_Completed"){
                      
                      if(displayData[i][keys[j]] == 1){
                        
                        var textNode = document.createTextNode("Completed");
                        cell.setAttribute("class", "Table-Item");

                      }else{
                        
                        var textNode = document.createTextNode("Incomplete");
                        cell.setAttribute("class", "Table-Item");
                      }
                    }else{
                      var textNode = document.createTextNode(displayData[i][keys[j]]);
                      cell.setAttribute("class", "Table-Item");
                      
                    }

                    cell.appendChild(textNode);
                    row.appendChild(cell);

                    
                }
            }
          }

          //this section displays buttons that the user has inputed that they want in the table
          if(this.customButtons.length != 0){
            for(var z = 0; z < this.customButtons.length; z++){
              var buttonCell = document.createElement("td");
              var buttonText = document.createTextNode(this.customButtons[z].text);
              var button = document.createElement("button");

              buttonCell.setAttribute("class", "Table-Item");

              if(this.customButtons[z].btnClasses.length != 0){
                for(var y = 0; y < this.customButtons[z].btnClasses.length; y++){
                  button.classList.add(this.customButtons[z].btnClasses[y]);
                }
              }

              button.appendChild(buttonText);
              buttonCell.appendChild(button);

              row.appendChild(buttonCell);

            }
          }
          document.getElementById("tableBody").appendChild(row);
        }
        else{
          //everytime a null is shown in the array this counter increases
          emptyCounter++;
        }
      }

      /*if the emptyCounter number is equal to the maxItemsPerPage number that means there are no items on the
        table. That triggers this if */
      if(emptyCounter == this.maxItemsPerPage){
        //removes the table and pagination
        this.removeTable();
        this.removePagination();

        /*reduces the page Number by one and reduces the page start and end by the number of items that can
        be displayed */
        this.pageNumber--;
        this.pageStart = this.pageStart - this.maxItemsPerPage;
        this.pageEnd = this.pageEnd - this.maxItemsPerPage;

      }
    }

    //This function removes all items from the table
    removeTable() {
      //grabs the table and clears all the children elements
      var tableNode = document.getElementById("tableBody");

      while (tableNode.firstChild) {
        tableNode.removeChild(tableNode.firstChild);
      }
    }

    //This functions removes everything in the pagination ID
    removePagination() {
      //grabs the table and clears all the children elements
      var paginationNode = document.getElementById("pagination");
      while (paginationNode.firstChild) {
        paginationNode.removeChild(paginationNode.firstChild);
      }
    }

    //this function is responsible for removing and adding disabled buttons to the Next and Prev
    disablingButtons(pageSelected) {
      //if pageSelected is greater than 1 remove disabled from previous button
      if (pageSelected > 1) {
        document.getElementById("prevBtn").parentNode.classList.remove("disabled");

      }
      //if pageSelected is equal to the max number of pages, then add disabled to Next and Last button
      if (pageSelected == this.maxPages) {
        document.getElementById("nextBtn").parentNode.classList.add("disabled");
      }
      //if pageSelected is equal to one then previous button is disabled
      if (pageSelected == 1) {
        document.getElementById("prevBtn").parentNode.classList.add("disabled");

      }
      //if pageSelected is smaller then max pages then next and last button are un disabled
      if (pageSelected < this.maxPages) {
        document.getElementById("nextBtn").parentNode.classList.remove("disabled");
      }
    }
}
