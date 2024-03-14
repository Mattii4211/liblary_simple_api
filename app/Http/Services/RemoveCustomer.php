<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\Customer;
use App\Models\Rental;
use App\Exceptions\HasRentalException;
use Exception;

final readonly class RemoveCustomer
{
    public function __construct(private Customer $customer)
    {}

    public function remove(): bool
    {
        try {
            $existRental = Rental::where(
                'customer_id', '=', $this->customer->id
            )->firstOrFail();
        } catch (Exception $e) {
            $existRental = null;
        }

        if ($existRental !== null) {
            throw new HasRentalException();
        }

        try {
            $this->customer->delete();
        } catch (Exception $e) {
        }

        return !isset($e);
    }
}