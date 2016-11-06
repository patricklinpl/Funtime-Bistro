<?php declare(strict_types = 1);

namespace ProjectFunTime\Template;

use ProjectFunTime\Menu\MenuReader;

class FrontendTwigRenderer implements FrontendRenderer
{
   private $menuReader;
   private $renderer;

   public function __construct(MenuReader $menuReader, Renderer $renderer)
   {
      $this->menuReader = $menuReader;
      $this->renderer = $renderer;
   }

   public function render($template, $data = []) : string
   {
      $data = array_merge($data, [
         'menuItems' => $this->menuReader->readMenu(),
      ]);
      return $this->renderer->render($template, $data);
   }
}