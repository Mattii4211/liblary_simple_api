<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class HasRentalException extends Exception
{
    public function __construct() {
        parent::__construct('Customer has rental, remove rental first');
    }
}