<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Picker extends Component
{
    public string $model;
    public string $term = '';

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (!empty($this->term)) {
            $results = $this->model::search($this->term);
        } else {
            $results = [];
        }
        return view('livewire.picker')->with('results', $results);
    }
}
