<?php declare(strict_types = 1);

namespace ProjectFunTime\Session;

class PHPSessionWrapper implements SessionWrapper
{
   public function getValue($key)
   {
      if (isset($_SESSION[$key])) {
         return $_SESSION[$key];
      }
      else {
         return null;
      }
   }
}