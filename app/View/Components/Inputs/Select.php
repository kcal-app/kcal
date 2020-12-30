<?php

namespace App\View\Components\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public Collection $options;
    public ?string $selectedValue;

    /**
     * Select constructor.
     *
     * @param \Illuminate\Support\Collection $options
     * @param ?string $selectedValue
     */
    public function __construct(
        Collection $options,
        ?string $selectedValue = '',
    ) {
        $this->options = $options;
        $this->selectedValue = $selectedValue;
    }

    public function render(): View
    {
        return view('components.inputs.select')
            ->with('options', $this->options)
            ->with('selectedValue', $this->selectedValue);
    }

}
