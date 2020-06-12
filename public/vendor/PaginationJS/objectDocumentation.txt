With the changes made to the pagination program to make the entire program reusable, a problem occurred where I 
kept adding parameters to the class object and it started to get out of hand. To make this easier I decided
to only have 2 parameters, the first parameters is the data that you want your table to display. The second
parameter is the reason I made this document, the parameter is an object that can have many properties to 
specialize the table. This document will outline each of the properties of the object and it will give
information like what type of variable the properties take and if they are required or not for the program to
work.



-> The data variable is just the array of data that you will be feeding into the table.
   The form of the data variable should be an array of objects [{}, {}], with any properties 
   you would like. 
   [
    {
        Task_Id: "1",
        Task_Name: "clean room",
    },
    {
        Task_Id: "2",
        Task_Name: "fix Computer",
    },
    {
        Task_Id: "3",
        Task_Name: "Finish homework",
    }
   ]

-> tableHeaders is a property that is required for the program to work. This property must be an array
   of strings. These strings must be in the same order as the properties in your objects since they display
   from 0 index till the end of the array. Here is an example

   var table = new Table(data, {
      tableHeaders: ["Id", "Name", "Start Time"]

    });

    Note: the table header will displayed with the "Id" being first in this example so remember to keep
    your field name inputs and the table headers in the same index.

-> tableId is the id of the element you wish to display the table in, this field is required in order for 
   the program to work. example
   var table = new Table(data, {
      tableHeaders: ["Id", "Name", "Start Time"],
      tableId: document.getElementById("mainTable"),
    });

-> fields is the object fields that are inside the array of objects. This allows some items not to be displayed.
   This field is required in order for the program to work. Here is an example

    var table = new Table(data, {
      tableHeaders: ["Id", "Name", "Start Time"],
      tableId: document.getElementById("mainTable"),
      fields: ["Id", "Name", "Start Time"],
      
    });

-> numOfItemsDropdownDisplay is a object property that is not required in order for the program to work. 
   the object has 2 properties, the first is a boolean called "display", if set to true it will displayed
   the dropdown. the second property is the numbers you want in the dropdown, these numbers have to be
   full  numbers no negative or decimals allowed

   <div id="numOfItemsDisplay"></div>

   <script>
    var table = new Table(data, {
      tableHeaders: tableHeads,
      tableId: sourceId,
      fields: objectFields,
      numOfItemsDropdownDisplay: {
        display: true,
        numberList: ["5","10","15"]
      }
    });
   </script>

-> searchBarDisplay is a boolean property that is not required in order for the program to work. if
   the boolean is set to true then a search bar will be displayed. If nothing is inputed it will 
   automatically be set to false; Also if set to true, this propety will require a div with the Id 
   named "searchBar". Here is an example

    <div id="searchBar"></div>

   <script>
      var table = new Table(data, {
      tableHeaders: tableHeads,
      tableId: sourceId,
      fields: objectFields,
      numOfItemsDropdownDisplay: true,
      searchBarDisplay: true,
    });
   </script>

-> specialButtons is a array of objects property thas is not required for the program to work.
   This property allows the user to put in special buttons at the end of their table, things like
   edit or delete, or anything since this is pretty customizable. The objects for this program
   have 3 properties. They are "btnName","btnClasses","text"


      var table = new Table(data, {
      tableHeaders: tableHeads,
      tableId: sourceId,
      fields: objectFields,
      numOfItemsDropdownDisplay: true,
      searchBarDisplay: true,
      specialButtons: [
        {
          btnName: "edit",
          btnClasses: ["btn", "btn-warning"],
          text: "Edit"
        },
        {
          btnName: "delete",
          btnClasses: ["btn", "btn-danger"],
          text: "Delete"
        }
      ]
    });
    