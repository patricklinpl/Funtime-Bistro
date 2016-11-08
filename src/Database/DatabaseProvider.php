<?php declare(strict_types = 1);

namespace ProjectFunTime\Database;

interface DatabaseProvider
{
   public function query($queryStr) : array;
}