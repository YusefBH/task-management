<?php

namespace App\Http\Requests\ProjectUser;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateProjectUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::forUser($this->user)->allows('IsThereUserInProject', $this->project)
            and Gate::allows('checkOwner', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role' => ['required' , Rule::in([Role::ROLE_MEMBER , Role::ROLE_VIEWER])],
        ];
    }
}
