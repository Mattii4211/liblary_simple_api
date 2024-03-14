<?php

declare(strict_types=1);

namespace App\Http\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Collection;

final readonly class BookRepository
{
    private const MAX_RESULTS = 20;

    public function getBooks(?string $filter): LengthAwarePaginator
    {
        $select = DB::raw(
            "b.name, IF(rentals.uuid IS NOT NULL, true, false) AS borrowed, CONCAT(customers.name, ' ', customers.last_name) AS borrower"
        );
        $filters = $filter ? DB::raw(
            "b.name LIKE '%$filter%' OR b.author LIKE '%$filter%' OR customers.name LIKE '%$filter%' OR customers.last_name LIKE '%$filter%'"
        ) : null;
        
        return $this->getData($select, $filters, true);
    }

    public function getBookRentalDetails(int $id): Collection
    {
        $select = DB::raw(
            "IF(rentals.uuid IS NOT NULL, true, false) AS borrowed, CONCAT(customers.name, ' ', customers.last_name) AS borrower"
        );
        $filters = "b.id = $id";

        return $this->getData($select, $filters);
    }

    private function getData(
        Expression $expression, 
        Expression|string|null $filters, 
        bool $paginate = false
    ): LengthAwarePaginator|Collection
    {

        $data = DB::table('books', 'b')
            ->select($expression)
            ->leftJoin('rentals', 'rentals.book_id', '=', 'b.id')
            ->leftJoin('customers', 'customers.id', '=', 'rentals.customer_id');
        
        if ($filters) {
            $data->whereRaw($filters);
        }
        
        return $paginate ? $data->paginate(self::MAX_RESULTS) : $data->get();
    }
}