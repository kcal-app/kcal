<?php

namespace App\View\Components\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Textarea extends Component
{
    public ?string $value;

    /**
     * Select constructor.
     *
     * @param ?string $value
     */
    public function __construct(?string $value = '') {
        $this->value = $value;
    }

    public function render(): View
    {
        return view('components.inputs.textarea')
            ->with('value', $this->value);
    }

}
