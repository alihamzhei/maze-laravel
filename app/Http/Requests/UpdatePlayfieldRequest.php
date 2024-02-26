<?php

namespace App\Http\Requests;

use App\Enums\Labyrinth\Playfield;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePlayfieldRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $x = config('app.labyrinth_x');
        $y = config('app.labyrinth_y');

        return [
            'x' => ['required', 'int', "lt:$x"],
            'y' => ['required', 'int', "lt:$y"],
            'type' => ['required', new Enum(Playfield::class)]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'x' => $this->route('x'),
                'y' => $this->route('y'),
                'type' => $this->route('type'),
            ]
        );
    }
}
