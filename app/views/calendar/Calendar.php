<?php if(isset($_SESSION['user_id'])): ?>
   <!--NOTE
    Still have to add the php code to edit and delete a task
    The time on the edit is not matching with the code
    -->
    <?php require APPROOT . '/views/inc/header.php'; ?>

    <!-- Sidebar -->
    <?php require APPROOT . '/views/inc/sideNav.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require APPROOT . '/views/inc/topNav.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->

          <!--====================MY CODE==================-->

          <style>
          .text-left {
              text-align: left!important;
          }

          .text-center{
              text-align: center;
          }

          #calendar td{
              padding: 1.75rem!important;
              position: relative;
          }

          .button-spacing{
              margin-right: 5%;
          }

          .tableHeading-Spacing{
              margin-top: 1%;
              margin-bottom: 1%;
          }

          .cellNumber{
              top: 0;
              right: 10px;
              position: absolute;
          }

          .buttonCategory-spacing{
              margin-right: 100px;
          }

          th{
              text-align: center!important;
          }

          td{
              height: 110px;
          }

          .green-dash{
              background-color: green;
              width: 70%;
              height: 18px;
              font-size: 13px;
              color: white;
              position: absolute;
          }

          .hiddenDisplay{
              display: none;
          }

          .timeHeaderSpacing{
              width: 30%;
          }

          dl
          {
              width: 200px;
              background: #fff;
              border: 1px solid #000;
          }

          dt, dd
          {
              display: inline;
          }     



          /*Weekly Calender styles */
          table.weeklyCalendar {
              margin-bottom: 0;
          }

          table.weeklyCalendar > thead > tr > th {
              text-align: center;
          }

          table.weeklyCalendar > tbody > tr > td {
              height: 20px;
          }

          table.weeklyCalendar > tbody > tr > td > div {
              padding: 8px;
              height: 40px;
              overflow: hidden;
              display: inline-block;
              vertical-align: middle;
              float: left;
          }

          table.weeklyCalendar > tbody > tr > td.has-events {
              color: white;
              cursor: pointer;
              padding: 0;
              border-radius: 4px;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div {
              background-color: #08C;
              border-left: 1px solid white;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div:first-child {
              border-left: 0;
              margin-left: 1px;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div.practice {
              opacity: 0.7;
          }
          table.weeklyCalendar > tbody > tr > td.conflicts > div > span.title {
              color: red;
          }
          table.weeklyCalendar > tbody > tr > td.max-conflicts > div {
              background-color: red;
              color: white;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div > span {
              display: block;
              text-align: center;
          }
          table.weeklyCalendar > tbody > tr > td.has-events > div > span a {
              color: white;
          }

          table.weeklyCalendar > tbody > tr > td.has-events > div > span.title {
              font-weight: bold;
          }

          table.table-borderless > thead > tr > th, table.table-borderless > tbody > tr > td {
              border: 0;
          }

          .table tbody tr.hover td, .table tbody tr.hover th {
              background-color: whiteSmoke;
          }

          /* Day Calendar*/
          table.weeklyCalendar {
              margin-bottom: 0;
          }

          table.dailyCalendar > thead > tr > th {
              text-align: center;
          }

          table.dailyCalendar > tbody > tr > td {
              height: 20px;
          }

          table.dailyCalendar > tbody > tr > td > div {
              padding: 8px;
              height: 40px;
              overflow: hidden;
              display: inline-block;
              vertical-align: middle;
              float: left;
          }

          table.dailyCalendar > tbody > tr > td.has-events {
              color: white;
              cursor: pointer;
              padding: 0;
              border-radius: 4px;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div {
              background-color: #08C;
              border-left: 1px solid white;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div:first-child {
              border-left: 0;
              margin-left: 1px;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div.practice {
              opacity: 0.7;
          }
          table.dailyCalendar > tbody > tr > td.conflicts > div > span.title {
              color: red;
          }
          table.dailyCalendar > tbody > tr > td.max-conflicts > div {
              background-color: red;
              color: white;
          }

          table.dailyCalendar > tbody > tr > td.has-events > div > span {
              display: block;
              text-align: center;
          }

          .daySized{
              width: 30%!important;
          }

          
          
          </style>

          <h1 class="h3 mb-4 text-gray-800">Calendar</h1>

          <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="row tableHeading-Spacing">
              <h3 class="col-sm-4 col-md-4 col-lg-4 text-left" id="monthAndYear"></h3>
              <div class="col-sm-3 col-md-4 col-lg-3 buttonCategory-spacing">
                <div class="row" id="calendarViewButtons"></div>
              </div>
              <div class="col-sm-3 col-md-4 col-lg-2">
                <div class="row" id="nxtPrevButtons"></div>
              </div>
            </div>

            <table class="table table-bordered table-responsive-sm" id="calendar"></table>

            <table class="weeklyCalendar table table-bordered" id="weekCalendar"></table>

            <table class="dailyCalendar table table-bordered table-responsive-sm daySized" id="dayCalendar"></table>
 
            <br/>

          <div id="jumpTo"></div>
        </div>


          

          <!--====================END OF MY CODE==================-->

      </div>
        <!-- /.container-fluid -->

    </div>
      <!-- End of Main Content -->

      <?php require APPROOT . '/views/inc/footer.php'; ?>

      <script>

            var http = new XMLHttpRequest();
              var url = '<?php echo URLROOT; ?>/CalendarController/getUsersTasks';
              http.open('POST', url, true);

              //Send the proper header information along with the request
              http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

              http.onreadystatechange = function() {//Call a function when the state changes.
                  if(http.readyState == 4 && http.status == 200) {
                    
                    var data = JSON.parse(http.responseText);
                    console.log(data)

                    var calendar = new Calendar(data,{
                      tables: {
                          day: true,
                          week: true,
                          month: true
                      },
                      nextPrevButtons:true,
                      jumpTo:true,
                      legend:true,
                      tableButtons:{
                        dayBtn: true,
                        weekBtn: true,
                        monthBtn: true
                      }
                    });

                    calendar.displayCalendar(); 
                     


                  }
              }
              http.send();
        
        
        
          
      </script>

<?php else: ?>
    <?php redirect('userController/login'); ?>
<?php endif;?>