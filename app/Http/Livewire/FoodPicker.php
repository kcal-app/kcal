<?php

namespace App\Http\Livewire;

use App\Models\Food;
use Livewire\Component;

class FoodPicker extends Component
{
    public ?string $term = NULL;
    public int $index;
    public ?int $defaultId = NULL;
    public ?string $defaultName = NULL;

    /**
     * Set the default term on mount.
     */
    public function mount() {
        $this->term = $this->defaultName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (!empty($this->term)) {
            $foods = Food::search($this->term);
        } else {
            $foods = [];
        }
        return view('livewire.food-picker')
            ->with('foods', $foods);
    }
}
