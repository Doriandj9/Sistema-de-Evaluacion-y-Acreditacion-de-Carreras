<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as FrameworkTestCase;
use Symfony\Component\Dotenv\Dotenv;
/**
 * Esta clase extiende de TestCase de PhpUnit y realiza la accion
 * de inicializar las variables globales guardadas en el archivo
 * .env para uso de la base de datos
 * 
 * @author Dorian Armijos
 * @link <>
 * @author Nataly Fernandes
 * @link <>
 */
class TestCase extends FrameworkTestCase
{
    public function __construct()
    {
        parent::__construct();
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../config/.env');
    }
}
