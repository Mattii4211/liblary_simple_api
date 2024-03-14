<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\CreateRental;
use App\Models\Rental;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'book_id' => 'required|numeric',
                'customer_id' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
             return new JsonResponse(
                [
                    'message' => 'Incorrect data',
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $createRental = new CreateRental(
            $request->get('book_id'),
            $request->get('customer_id')
        );

        $correct = true;

        try {
           $message = $createRental->create();
        } catch (Exception $e) {
            $message = $e->getMessage();
            $correct = false;
        }
       
        return new JsonResponse(
            $correct ? $message : ['message' => $message],
            $correct ? JsonResponse::HTTP_OK : JsonResponse::HTTP_BAD_REQUEST
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(Rental $rental)
    {
        try {
           $rental->delete();
        } catch (Exception $e) {
        }

        return new JsonResponse(
            [
                'message' => isset($e) ? $e->getMessage() : 'success'
            ],
            isset($e) ? JsonResponse::HTTP_BAD_REQUEST : JsonResponse::HTTP_OK
        );
    }
}
