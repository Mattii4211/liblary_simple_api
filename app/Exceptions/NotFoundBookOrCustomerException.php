<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class NotFoundBookOrCustomerException extends Exception
{
    public function __construct() {
        parent::__construct('Book or Customer not exist');
    }
}