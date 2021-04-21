<?php

namespace App\View\Components\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Image extends Component
{
    public Model $model;
    public ?string $previewName;

    /**
     * Image constructor.
     */
    public function __construct(Model $model, string $previewName = 'preview') {
        $this->model = $model;
        $this->previewName = $previewName;
    }

    public function render(): View
    {
        return view('components.inputs.image')
            ->with('model', $this->model)
            ->with('previewName', $this->previewName);
    }

}
