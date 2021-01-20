<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class IngredientPickerController extends Controller
{
    /**
     * Search for ingredients.
     */
    public function search(): JsonResponse
    {
        return response()->json([
            ['id' => 1, 'name' => 'Flour'],
            ['id' => 2, 'name' => 'Eggs'],
        ]);
    }
}
