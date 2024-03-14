<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use  Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\RemoveCustomer;
use App\Http\Repository\CustomerRepository;

class CustomerController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new JsonResponse(
            Customer::all(['name', 'last_name'])
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $data = $request->all(),
            [
                'name' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
                'last_name' => 'required|max:255|regex:/^[\pL\s\-]+$/u',
            ]
        );

        if ($validated = $validator->passes()) {
            $user = new Customer($data);
            $user->save();
        }
        return new JsonResponse(
            [
                'message' => $validated ? 'Add user' : 'Incorrect data',
            ],
            $validated ? JsonResponse::HTTP_OK : JsonResponse::HTTP_BAD_REQUEST
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): JsonResponse
    {
        $repository = new CustomerRepository();

        return new JsonResponse(
            [
                'name' => $customer->name,
                'last_name' => $customer->last_name,
                'books' => $repository->getRentalBooks($customer->id)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): JsonResponse
    {
        $removeService = new RemoveCustomer($customer);

        try {
            $removeService->remove();
        } catch (Exception $e) {
        }

        return new JsonResponse(
            [
                'messages' => isset($e) ? $e->getMessage() : 'Customer removed'
            ],
            isset($e) ? JsonResponse::HTTP_BAD_REQUEST : JsonResponse::HTTP_OK
        );
    }
}
