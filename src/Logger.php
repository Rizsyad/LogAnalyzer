<?php

namespace Rizsyad\LogAnalyzer;

use MVar\Apache2LogParser\AccessLogParser;
use donatj\UserAgent\UserAgentParser;
use MVar\LogParser\LogIterator;

class Logger
{

   public $accessLogs;
   public $errorLogs;

   private $parser;
   private $uaparser;

   public function __construct()
   {
      $this->parser = new AccessLogParser('%h %l %u %t "%r" %>s %O "%{Referer}i" "%{User-Agent}i"');
      $this->parser->setTimeFormat('Y-m-d H:i:s');

      $this->uaparser = new UserAgentParser();
   }

   public function setAccessLogs($accessLogs)
   {
      $this->accessLogs = $accessLogs;
   }

   public function getAccessLogs()
   {
      return $this->accessLogs;
   }

   public function setErrorLogs($errorLogs)
   {
      $this->errorLogs = $errorLogs;
   }

   public function geterrorLogs()
   {
      return $this->errorLogs;
   }

   public function readApacheLog()
   {
      $readLines = file_get_contents($this->getaccessLogs());
      return $readLines;
   }

   public function readApacheErrorLog()
   {
      $readLines = file_get_contents($this->geterrorLogs());
      return $readLines;
   }

   private function parseApacheLog()
   {      
      $log = [];

      foreach (new LogIterator($this->getaccessLogs(), $this->parser) as $line => $data) {
         array_push($log, $data);
      }

      return $log;  
   }

   public function getParseLog() {
      return $this->parseApacheLog();
   }

   public function countLog()
   {
      $logs = $this->parseApacheLog();
      $data = [];

      $countLog = count($logs);
      
      // Extract IP addresses
      $ipAddresses = [];
      $ipCounts = [];

      foreach ($logs as $entry) {
         $ip = $entry['remote_host'] ?? null;

         if(!isset($ip)) continue;
         $ipAddresses[] = $ip;
         
         // Count IP occurrences
         if (isset($ipCounts[$ip])) {
            $ipCounts[$ip]++;
         } else {
            $ipCounts[$ip] = 1;
         }
      }

      $requstMethod = [];

      foreach ($logs as $entry) {
         $method = $entry["request"]['method'] ?? null;
         if(!isset($method)) continue;
         
         // Count IP occurrences
         if (isset($requstMethod[$method])) {
            $requstMethod[$method]++;
         } else {
            $requstMethod[$method] = 1;
         }
      }

      $platform = [];
      foreach ($logs as $entry) {
         $useragent = $this->uaparser->parse(@$entry["request_headers"]['User-Agent'])->platform() ?? "null";
         if (isset($platform[$useragent])) {
            $platform[$useragent]++;
         } else {
            $platform[$useragent] = 1;
         }
      }

      $browser = [];
      foreach ($logs as $entry) {
         $browserType = $this->uaparser->parse(@$entry["request_headers"]['User-Agent'])->browser() ?? "null";
         if (isset($browser[$browserType])) {
            $browser[$browserType]++;
         } else {
            $browser[$browserType] = 1;
         }
      }

      $domain = [];
      foreach ($logs as $entry) {
         $host = parse_url(@$entry["request_headers"]['Referer'])["host"] ?? "null";
         if (isset($domain[$host])) {
            $domain[$host]++;
         } else {
            $domain[$host] = 1;
         }
      }
      
      // Count unique IP addresses
      $uniqueIPCount = count(array_unique($ipAddresses));

      arsort($ipCounts);
      arsort($requstMethod);
      arsort($platform);
      arsort($browser);
      arsort($domain);

      $data["countLog"] = $countLog;
      $data["ipUnique"] = $uniqueIPCount;
      $data["ipVisited"] = $ipCounts;
      $data["requestType"] = $requstMethod;
      $data["platformType"] = $platform;
      $data["browserType"] = $browser;
      $data["referer"] = $domain;

      return $data;
   }

}