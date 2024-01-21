<?php

namespace App\Http\Requests\Project;

use App\Enums\Role;
use App\Models\ProjectUser;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $role
 */
class IndexProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->has('role')) {
            if (!in_array($this->input('role'), Role::ROLE)) {
                return false;
            }
        }
        return true;
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
