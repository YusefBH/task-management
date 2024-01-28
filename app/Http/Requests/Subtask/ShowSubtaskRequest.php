<?php

namespace App\Http\Requests\Subtask;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property mixed $project
 * @property mixed $task
 * @property mixed $subtask
 */
class ShowSubtaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('IsThereUserInProject', $this->project)
            and Gate::allows('IsThereTaskInProject', [$this->project, $this->task])
            and Gate::allows('IsThereSubtaskInTask', [$this->task, $this->subtask]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
