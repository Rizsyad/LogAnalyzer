<?php

namespace Rizsyad\LogAnalyzer;

use Rizsyad\LogAnalyzer\Log;

class WebView {

   protected $log;

   public function __construct()
   {
      $this->log = new Log();
   }

   public function setAccessLog($accessLogs)
   {
      $this->log->setAccessLog($accessLogs);
   }

   public function view()
   {
      $logs = $this->log->getAccessLogs();
      $parseLog = $this->log->readApacheLog();
      
      ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Log Analyzer</title>
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet' />
   <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rizsyad/LogAnalyzer@1.0.0/src/assets/css/style.css">
</head>

<body>

   <!-- Sidebar -->
   <div class="sidebar">
      <a href="#" class="logo">
         <i class='bx bx-code-alt'></i>
         <div class="logo-name"><span>Log</span>Analyzer</div>
      </a>
      <ul class="side-menu">
         <li><a href="#"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
      </ul>
   </div>
   <!-- End of Sidebar -->

   <!-- Main Content -->
   <div class="content">
      <!-- Navbar -->
      <nav>
         <i class='bx bx-menu'></i>
         <form action="#"></form>
         <input type="checkbox" id="theme-toggle" hidden>
         <label for="theme-toggle" class="theme-toggle"></label>
      </nav>

      <!-- End of Navbar -->

      <main>
         <div class="header">
            <div class="left">
               <h1>Dashboard</h1>
               <ul class="breadcrumb">
                  <li><a href="#" class="active">Dashboard</a></li>
               </ul>
            </div>
         </div>

         <!-- Insights -->
         <ul class="insights">
            <li>
               <i class='bx bx-calendar-check'></i>
               <span class="info">
                  <h3>
                     <?= $logs["countLog"]; ?>
                  </h3>
                  <p>Total Logs</p>
               </span>
            </li>
            <li><i class='bx bx-show-alt'></i>
               <span class="info">
                  <h3>
                     <?= $logs["ipUnique"]; ?>
                  </h3>
                  <p>ip Unique</p>
               </span>
            </li>
         </ul>
         <!-- End of Insights -->

         <div class="bottom-data">
            <div class="orders">
               <div class="header">
                  <h3>IP Visited</h3>
               </div>
               <table class="datables">
                  <thead>
                     <tr>
                        <th>IP</th>
                        <th>Count</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($logs["ipVisited"] as $key => $value): ?>
                     <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <div class="orders">
               <div class="header">
                  <h3>request Method</h3>
               </div>
               <table class="datables">
                  <thead>
                     <tr>
                        <th>Method</th>
                        <th>Count</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($logs["requestType"] as $key => $value): ?>
                     <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <div class="orders">
               <div class="header">
                  <h3>Platform</h3>
               </div>
               <table class="datables">
                  <thead>
                     <tr>
                        <th>Platform</th>
                        <th>Count</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($logs["platformType"] as $key => $value): ?>
                     <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <div class="orders">
               <div class="header">
                  <h3>Browser Type</h3>
               </div>
               <table class="datables">
                  <thead>
                     <tr>
                        <th>Useragent</th>
                        <th>Count</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($logs["browserType"] as $key => $value): ?>
                     <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>




            <div class="orders">
               <div class="header">
                  <h3>Referer</h3>
               </div>
               <table class="datables">
                  <thead>
                     <tr>
                        <th>Domain</th>
                        <th>Count</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($logs["referer"] as $key => $value): ?>
                     <tr>
                        <td><?= $key ?></td>
                        <td><?= $value ?></td>
                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>

            <div class="orders"></div>

            <div class="orders">
               <div class="header">
                  <h3>Logs</h3>
               </div>
               <table class="datables">
                  <thead>
                     <tr>
                        <th>IP</th>
                        <th>Date</th>
                        <th>Request</th>
                        <th>Status</th>
                        <th>Size</th>
                        <th>Referer</th>
                        <th>Useragent</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        foreach($parseLog as $value): 
                           if(@$value["remote_host"] == "") continue;
                     ?>

                     <tr>
                        <td><?= $value["remote_host"]  ?? "" ?></td>
                        <td><?= $value["time"]  ?? "" ?></td>
                        <td><?= $value["request_line"]  ?? "" ?></td>
                        <td><?= $value["response_code"]  ?? "" ?></td>
                        <td><?= $value["bytes_sent"]  ?? "" ?></td>
                        <td><?= $value["request_headers"]["Referer"]  ?? "" ?></td>
                        <td><?= $value["request_headers"]["User-Agent"]  ?? "" ?></td>

                     </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>


         </div>





      </main>

   </div>


   <script src="https://code.jquery.com/jquery-3.7.0.min.js"
      integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
   <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.jsdelivr.net/gh/rizsyad/LogAnalyzer@1.0.0/src/assets/js/style.js"></script>
</body>

</html>

<?php
   }

   
}