<?php

namespace App\Http\Requests\Invitation;

use App\Models\Invitation;
use Illuminate\Foundation\Http\FormRequest;

class AcceptInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $invitation = Invitation::find($this->route('invitation'))->first();

        $hash = sha1($invitation->email.$invitation->role);

        return hash_equals($hash, (string)$this->route('hash'));
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
