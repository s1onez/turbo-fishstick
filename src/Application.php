<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Database\MysqlConnection;
use App\Service\CategoryService;
use Throwable;

/**
 * Init the application
 */
class Application
{
    /**
     * @return void
     */
    public function run(): void
    {
        try {
            //todo: Connection Interface for future DI
            $db = new MysqlConnection();
            $service = new CategoryService($db->get());
            $service->execute();
            echo $service->print();
        } catch (Throwable $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
