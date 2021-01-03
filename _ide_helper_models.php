<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Food
 *
 * @mixin IdeHelperFood
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $detail
 * @property string|null $brand
 * @property float $serving_size
 * @property string|null $serving_unit
 * @property float $serving_weight
 * @property float $calories
 * @property float $fat
 * @property float $cholesterol
 * @property float $sodium
 * @property float $carbohydrates
 * @property float $protein
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @method static \Illuminate\Database\Eloquent\Builder|Food findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCarbohydrates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCholesterol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereServingWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereSodium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Food whereUpdatedAt($value)
 */
	class IdeHelperFood extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FoodAmount
 *
 * @mixin IdeHelperFoodAmount
 * @property int $id
 * @property int $food_id
 * @property float $amount
 * @property string|null $unit
 * @property int $recipe_id
 * @property int $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Food $food
 * @property-read \App\Models\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount query()
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FoodAmount whereWeight($value)
 */
	class IdeHelperFoodAmount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JournalEntry
 *
 * @mixin IdeHelperJournalEntry
 * @property int $id
 * @property int $user_id
 * @property \datetime $date
 * @property string $summary
 * @property float $calories
 * @property float $fat
 * @property float $cholesterol
 * @property float $sodium
 * @property float $carbohydrates
 * @property float $protein
 * @property string $meal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Food[] $foods
 * @property-read int|null $foods_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recipe[] $recipes
 * @property-read int|null $recipes_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCarbohydrates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCholesterol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereMeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereSodium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereUserId($value)
 */
	class IdeHelperJournalEntry extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Recipe
 *
 * @mixin IdeHelperRecipe
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $servings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FoodAmount[] $foodAmounts
 * @property-read int|null $food_amounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\JournalEntry[] $journalEntries
 * @property-read int|null $journal_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RecipeStep[] $steps
 * @property-read int|null $steps_count
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereServings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe whereUpdatedAt($value)
 */
	class IdeHelperRecipe extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RecipeStep
 *
 * @mixin IdeHelperRecipeStep
 * @property int $id
 * @property int $recipe_id
 * @property int $number
 * @property string $step
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep query()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeStep whereUpdatedAt($value)
 */
	class IdeHelperRecipeStep extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @mixin IdeHelperUser
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class IdeHelperUser extends \Eloquent {}
}

