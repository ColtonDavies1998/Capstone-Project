//Structure of the task Object

var singleTask = {
    Task_Id: 0,
    Task_Name: "clean room",
    Task_Description: "make room look better",
    Task_StartTime: "8:00 am",
    Task_EndTime: "10:30 am",
    Task_Type: "Chore",
    Task_Date: "December 21 2019",
    Task_Day: 21,
    Task_Month: 12,
    Task_Year: 2019,
    Task_Priority: "5.5",
    Task_Completed: "false"
}

/* 
    Task_ID -> Every Task will have a Task_Id, this is the unique identifier for the object. This Id should 
               always be an integer. (REQUIRED)

    Task_Name -> This holds the name of the task, ie clean room or study for test etc. (REQUIRED)

    Task_Description -> This holds the description given to the task, this field is not required and can be
                        left empty. If filled this will give an in depth look at the task. 

    Task_StartTime -> This holds the start time of the task, the format of the time is going to be in hh:mm
                      (REQUIRED)
    
    Task_EndTime -> This holds the end time of the task, the format of the time is going to be in hh:mm 
                    (REQUIRED)
    
    Task_Type -> This holds the type of the task, for users who want to be a little bit more organize, this will
                 be used to color code your tasks on the map. 

    Task_Date -> This variable Contains the date that the task is set on, this will display with the name of
                 the month first, then the day number and finally the year. (REQUIRED)
    
    Task_Day -> This holds the day of the month of the task, this just holds the day and it is in number form
                (int). (REQUIRED)
    
    Task_Month -> This holds the month of the task, this holds the month in number form, So for example if 
                  the month is December, then the value in will be 12. (REQUIRED)
    
    Task_Year -> This holds the year of the task, this holds the year in number form. (REQUIRED)

    Task_Priority -> This holds the priority of the task, this is in float form so it is able to hold decimals.

    Task_Completed -> This holds a boolean value of true or false, and that determines if the task has been
                      completed or not.(REQUIRED)
                     
*/

//Data Array
var fakedata = [
    {
        Task_Id: 1,
        Task_Name: "clean room",
        Task_Description: "make room look better",
        Task_StartTime: "8:00 am",
        Task_EndTime: "10:30 am",
        Task_Type: "Chore",
        Task_Date: "December 21 2019",
        Task_Day: 21,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "5.5",
        Task_Completed: "false"
    },
    {
        Task_Id: 2,
        Task_Name: "Study for math test",
        Task_Description: "There is a math test next week",
        Task_StartTime: "10:00 am",
        Task_EndTime: "12:30 pm",
        Task_Type: "School",
        Task_Date: "December 22 2019",
        Task_Day: 22,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "7.9",
        Task_Completed: "false"
    },
    {
        Task_Id: 3,
        Task_Name: "feed the cats",
        Task_Description: "make room look better",
        Task_StartTime: "7:00 am",
        Task_EndTime: "7:30 am",
        Task_Type: "Chore",
        Task_Date: "December 21 2019",
        Task_Day: 21,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "8",
        Task_Completed: "true"
    },
    {
        Task_Id: 4,
        Task_Name: "Sign up for school",
        Task_Description: "",
        Task_StartTime: "3:00 pm",
        Task_EndTime: "4:30 pm",
        Task_Type: "Chore",
        Task_Date: "December 17 2019",
        Task_Day: 17,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "3.5",
        Task_Completed: "false"
    },
    {
        Task_Id: 5,
        Task_Name: "clean room",
        Task_Description: "make room look better",
        Task_StartTime: "8:00 am",
        Task_EndTime: "10:30 am",
        Task_Type: "Chore",
        Task_Date: "December 21 2019",
        Task_Day: 21,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "5.5",
        Task_Completed: "false"
    },
    {
        Task_Id: 6,
        Task_Name: "Study for math test",
        Task_Description: "There is a math test next week",
        Task_StartTime: "10:00 am",
        Task_EndTime: "12:30 pm",
        Task_Type: "School",
        Task_Date: "December 22 2019",
        Task_Day: 22,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "7.9",
        Task_Completed: "false"
    },
    {
        Task_Id: 7,
        Task_Name: "feed the cats",
        Task_Description: "make room look better",
        Task_StartTime: "7:00 am",
        Task_EndTime: "7:30 am",
        Task_Type: "Chore",
        Task_Date: "December 21 2019",
        Task_Day: 21,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "8",
        Task_Completed: "true"
    },
    {
        Task_Id: 8,
        Task_Name: "Sign up for school",
        Task_Description: "",
        Task_StartTime: "3:00 pm",
        Task_EndTime: "4:30 pm",
        Task_Type: "Chore",
        Task_Date: "December 17 2019",
        Task_Day: 17,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "3.5",
        Task_Completed: "false"
    },
    {
        Task_Id: 9,
        Task_Name: "clean room",
        Task_Description: "make room look better",
        Task_StartTime: "8:00 am",
        Task_EndTime: "10:30 am",
        Task_Type: "Chore",
        Task_Date: "December 21 2019",
        Task_Day: 21,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "5.5",
        Task_Completed: "false"
    },
    {
        Task_Id: 10,
        Task_Name: "Study for math test",
        Task_Description: "There is a math test next week",
        Task_StartTime: "10:00 am",
        Task_EndTime: "12:30 pm",
        Task_Type: "School",
        Task_Date: "December 22 2019",
        Task_Day: 22,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "7.9",
        Task_Completed: "false"
    },
    {
        Task_Id: 11,
        Task_Name: "feed the cats",
        Task_Description: "make room look better",
        Task_StartTime: "7:00 am",
        Task_EndTime: "7:30 am",
        Task_Type: "Chore",
        Task_Date: "December 21 2019",
        Task_Day: 21,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "8",
        Task_Completed: "true"
    },
    {
        Task_Id: 12,
        Task_Name: "Sign up for school",
        Task_Description: "",
        Task_StartTime: "3:00 pm",
        Task_EndTime: "4:30 pm",
        Task_Type: "Chore",
        Task_Date: "December 17 2019",
        Task_Day: 17,
        Task_Month: 12,
        Task_Year: 2019,
        Task_Priority: "3.5",
        Task_Completed: "false"
    }
]