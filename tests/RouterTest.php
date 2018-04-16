<?php

use Controller\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    public function testProcessInvalidCsv(): void
    {
        $this->expectException(Exception::class);
        $router = new Router('fake');
        $router->index();
    }

}
