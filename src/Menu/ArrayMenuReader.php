<?php declare(strict_types = 1);

namespace ProjectFunTime\Menu;

class ArrayMenuReader implements MenuReader
{
   public function readMenu($accType) : array
   {
      if (is_null($accType)) {
         return [];
      }
      elseif (strcasecmp($accType, 'customer') == 0 ||
              strcasecmp($accType, 'chef') == 0 ||
              strcasecmp($accType, 'admin') == 0) {
         return [
            ['href' => '/menuItems', 'text' => 'Menu'],
            ['href' => '/orders', 'text' => 'Orders'],
            ['href' => '/ingredients', 'text' => 'Ingredients'],
            ['href' => '/account', 'text' => 'Account']
         ];
      }
   }
}