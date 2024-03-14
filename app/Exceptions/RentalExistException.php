<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class RentalExistException extends Exception
{
    public function __construct() {
        parent::__construct('Rental existing');
    }
}