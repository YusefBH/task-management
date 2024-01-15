<?php

namespace App\Http\Requests\Invitation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * @property mixed $email
 * @property mixed $role
 */
class CreateInvitationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('createInvitation', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('invitations', 'email')
                    ->where('project_id', $this->project)
            ],
            'role' => [
                'required',
                Rule::in([\App\Enums\Role::ROLE_MEMBER , \App\Enums\Role::ROLE_VIEWER]),
            ],
        ];
    }
}
