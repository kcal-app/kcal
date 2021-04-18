<?php

namespace App\View\Components\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public ?bool $hasError;
    public Collection|array $options;
    public ?string $selectedValue;

    /**
     * Select constructor.
     */
    public function __construct(
        Collection|array $options,
        ?bool $hasError = false,
        ?string $selectedValue = '',
    ) {
        $this->options = $options;
        $this->hasError = $hasError;
        $this->selectedValue = $selectedValue;
    }

    public function render(): View
    {
        return view('components.inputs.select')
            ->with('options', $this->options)
            ->with('hasError', $this->hasError)
            ->with('selectedValue', $this->selectedValue);
    }

}
