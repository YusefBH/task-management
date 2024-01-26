<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use App\Models\Label;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @property mixed $name
 * @property mixed $status
 * @property mixed $label_id
 * @property mixed $label
 * @property mixed $project
 */
class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->label_id) {
            $label = Label::find($this->label_id);
            if(!$label){return false;}
            return Gate::allows('checkOwner', $this->project)
                and Gate::allows('IsThereLabelInProject', [$this->project, $label]);
        } else {
            return Gate::allows('checkOwner', $this->project);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:80',
            'status' => ['required', Rule::in(TaskStatus::STATUS)],
            'label_id' => ['integer', Rule::exists('labels', 'id')]
        ];
    }
}
