<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\Customer;
use App\Models\Rental;
use App\Models\Book;
use App\Exceptions\NotFoundBookOrCustomerException;
use App\Exceptions\RentalExistException;
use Exception;

final readonly class CreateRental
{
    public function __construct(private int $bookId, private int $customerId) {}

    public function create(): array
    {
        $book = Book::find($this->bookId);
        $customer = Customer::find($this->customerId);

        if ($book === null || $customer === null) {
            throw new NotFoundBookOrCustomerException();
        }

       
        try {
            $existRental = Rental::where(
                'book_id', '=',  $book->id
            )->firstOrFail();
        } catch (Exception $e) {
            $existRental = null;
        }

        if ($existRental !== null) {
           throw new RentalExistException();
        }

        try {
            $rental = Rental::create([
                'customer_id' => $customer->id,
                'book_id' => $book->id,
            ]);

            $correct = $rental->save();
        } catch (Exception $e) {
            $correct = false;
        }
       
        return [
            'rentalId' => $correct ? $rental->uuid : null,
            'message' => $correct ? 'success' : $e->getMessage(),
        ];
    }
}