<?php

declare(strict_types=1);

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Collection;

final readonly class CustomerRepository
{
    public function getRentalBooks(int $id): Collection
    {
        $select = DB::raw(
            "b.name"
        );
        $filters = "customers.id = $id";

        return $this->getData($select, $filters);
    }

    private function getData(Expression $expression, Expression|string $filters): Collection
    {

        return DB::table('books', 'b')
            ->select($expression)
            ->leftJoin('rentals', 'rentals.book_id', '=', 'b.id')
            ->leftJoin('customers', 'customers.id', '=', 'rentals.customer_id')
            ->whereRaw($filters)
            ->get();
    }
}