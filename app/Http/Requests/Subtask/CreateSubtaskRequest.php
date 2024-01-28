<?php

namespace App\Http\Requests\Subtask;

use App\Models\Label;
use App\Models\User;
use App\Rules\DaedlineRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @property mixed $label_id
 * @property mixed $project
 * @property mixed $task
 * @property mixed $name
 * @property mixed $description
 * @property mixed $deadline
 * @property mixed $user_id
 */
class CreateSubtaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = User::find($this->user_id);
        if(!$user){return false;}

        if ($this->label_id) {
            $label = Label::find($this->label_id);
            if (!$label) {
                return false;
            }
            return Gate::allows('checkOwner', $this->project)
                and Gate::allows('IsThereLabelInProject', [$this->project, $label])
                and Gate::allows('IsThereTaskInProject', [$this->project, $this->task])
                and Gate::forUser($user)->allows('IsThereUserInProject', $this->project);
        } else {
            return Gate::allows('checkOwner', $this->project)
                and Gate::allows('IsThereTaskInProject', [$this->project, $this->task])
                and Gate::forUser($user)->allows('IsThereUserInProject', $this->project);
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
            'description' => 'string',
            'deadline' => ['required','integer', new DaedlineRule()],
            'label_id' => ['integer', Rule::exists('labels', 'id')],
            'user_id' => ['required','integer', Rule::exists('users', 'id')],
        ];
    }
}
