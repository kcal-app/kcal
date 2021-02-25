<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientPickerController extends Controller
{
    /**
     * Search for ingredients.
     */
    public function search(Request $request): JsonResponse
    {
        $results = new Collection();
        $term = $request->query->get('term');
        if (!empty($term)) {
            $results = $results->merge(Food::search($term)->get());
            $results = $results->merge(Recipe::search($term)->get());
        }
        return response()->json($results->sortBy('name')->values());
    }
}
