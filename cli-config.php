<?php
/**
 * Created by PhpStorm.
 * User: Rafael Freitas
 * Date: 18/02/2019
 * Time: 12:00
 */

use App\Config\Doctrine;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__ . '/src/Config/Doctrine.php';
$doctrine = new Doctrine();
$entityManager = $doctrine->getEntityManager();
return ConsoleRunner::createHelperSet($entityManager);