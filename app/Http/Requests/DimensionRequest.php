<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DimensionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $x = config('app.labyrinth_x');
        $y = config('app.labyrinth_y');

        return [
            'x' => ['required', 'int', "lt:$x"],
            'y' => ['required', 'int', "lt:$y"],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'x' => $this->route('x'),
                'y' => $this->route('y'),
            ]
        );
    }
}
