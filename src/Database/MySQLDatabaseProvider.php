<?php declare(strict_types = 1);

namespace ProjectFunTime\Database;

class MySQLDatabaseProvider implements DatabaseProvider
{
   private $dbProvider;

   public function __construct()
   {
      session_start();

// change to match your environment
      $dbhost = "localhost";
      $dbuser = "FTBistro";
      $dbpass = "donaldtrump";
      $dbname = "funtime";

      $this->dbProvider = new \mysqli($dbhost, $dbuser, $dbpass, $dbname);
   }

   public function selectQuery($query) : array
   {
      $queryResult = $this->dbProvider->query($query);
      $queryArr = \mysqli_fetch_array($queryResult);

      if (is_null($queryArr)) {
         return [];
      } 
      else {
         return $queryArr;
      }
   }

   public function insertQuery($query)
   {
      $queryResult = $this->dbProvider->query($query);
      return $queryResult;
   }
}