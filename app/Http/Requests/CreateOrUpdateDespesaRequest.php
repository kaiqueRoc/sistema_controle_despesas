<?php

namespace App\Http\Requests;

class CreateOrUpdateDespesaRequest extends ApiFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'descricao' => 'required|max:191',
            'user_id' => 'exists:users,id',
            'data' => 'required|date|before_or_equal:today',
            'valor' => 'required|numeric|regex:/^[0-9]*\.?[0-9]+$/'
        ];
    }
}
