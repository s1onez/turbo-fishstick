<?php

declare(strict_types=1);

namespace App\Infrastructure;

interface ConnectionInterface {
    public function get();
}
