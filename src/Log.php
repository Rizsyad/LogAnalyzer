<?php

namespace Rizsyad\LogAnalyzer;

use Rizsyad\LogAnalyzer\Logger;

class Log 
{
   private $logger;

   private $pathAccessLogs;
   private $pathErrorLogs;
   
   public function __construct() 
   {
      $this->logger = new Logger();
   }

   public function setAccessLog($accessLogs)
   {
      $this->pathAccessLogs = $accessLogs;
      $this->logger->setAccessLogs($this->pathAccessLogs);
   }

   public function setErrorLogs($errorLogs)
   {
      $this->pathErrorLogs = $errorLogs;
      $this->logger->setErrorLogs($this->pathErrorLogs);
   }

   public function readApacheLog()
   {
      return $this->logger->getParseLog();
   }

   public function getAccessLogs() 
   {
      if($this->pathAccessLogs == "" && $this->pathErrorLogs == "") die("Path Apache/Error has not been input");
      return $this->logger->countLog();
   }
}