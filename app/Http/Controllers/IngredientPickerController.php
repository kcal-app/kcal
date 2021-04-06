<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Recipe;
use App\Search\Ingredient;
use ElasticScoutDriverPlus\Builders\MultiMatchQueryBuilder;
use ElasticScoutDriverPlus\Builders\TermsQueryBuilder;
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
            $results = match (env('SCOUT_DRIVER')) {
                'algolia' => $this->searchWithAlgolia($term),
                'elastic' => $this->searchWithElasticSearch($term),
                default => $this->searchWithDatabaseLike($term),
            };

        }
        return response()->json($results->values());
    }

    /**
     * Search using an Algolia service.
     */
    private function searchWithAlgolia(string $term): Collection {
        return Ingredient::search($term)->take(10)->get();
    }

    /**
     * Search using an ElasticSearch service.
     */
    private function searchWithElasticSearch(string $term): Collection {
        return Food::boolSearch()
            ->join(Recipe::class)

            // Attempt to match exact phrase first.
            ->should('match_phrase', ['name' => $term])

            // Attempt multi-match search on all relevant fields with search-as-you-type on name.
            ->should((new MultiMatchQueryBuilder())
                ->fields(['name', 'name._2gram', 'name._3gram', 'detail', 'brand', 'source'])
                ->query($term)
                ->type('bool_prefix')
                ->analyzer('simple')
                ->fuzziness('AUTO'))

            // Attempt to match on any tags in the term.
            ->should((new TermsQueryBuilder())
                ->terms('tags', explode(' ', $term)))

            // Get resulting models.
            ->execute()
            ->models();
    }

    /**
     * Search using basic database WHERE ... LIKE queries.
     */
    private function searchWithDatabaseLike(string $term): Collection {
        $foods = Food::query()->where('foods.name', 'like', "%{$term}%")
            ->orWhere('foods.detail', 'like', "%{$term}%")
            ->orWhere('foods.brand', 'like', "%{$term}%")
            ->get();
        $recipes = Recipe::query()->where('recipes.name', 'like', "%{$term}%")
            ->orWhere('recipes.description', 'like', "%{$term}%")
            ->orWhere('recipes.source', 'like', "%{$term}%")
            ->get();
        return $foods->merge($recipes);
    }
}
