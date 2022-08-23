<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Symfony\Component\Dotenv\Dotenv;

class TestCase extends FrameworkTestCase
{
    public function __construct()
    {
        parent::__construct();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../config/.env');
    }
}
