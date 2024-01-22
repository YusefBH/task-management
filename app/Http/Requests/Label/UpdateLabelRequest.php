<?php

namespace App\Http\Requests\Label;

use App\Rules\ColorRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @property mixed $color
 * @property mixed $title
 */
class UpdateLabelRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('checkOwner', $this->project)
            and Gate::allows('IsThereLabelInProject', [$this->project, $this->label]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'color' => ['string', 'required_without:title' ,'nullable', new ColorRule()],
            'title' => [
                'string',
                'required_without:color',
                'nullable',
                Rule::unique('labels', 'title')
                    ->where('project_id', $this->project)
                    ->where('color', $this->color)
            ]
        ];
    }
}
