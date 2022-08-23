<?php

declare(strict_types=1);

namespace App\backend\Controllers;
/**
 * Esta interface es la base para cualquier controlador
 * que debe complir con al menos la vista que va a utilizar
 * ese controlador
 * @author Dorian Armijos
 * @link <>
 * @author Nataly Fernandez
 * @link <>
 */
interface Controller
{

    public function vista($variables = []): array;
}
