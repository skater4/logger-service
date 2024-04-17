<?php

namespace App\Http\Requests;

use App\Models\Log\Enum\Levels;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'client' => 'required|string|max:255',
            'message' => 'required|string|max:2048',
            'level' => 'required|string|in:' . implode(',', array_column(Levels::cases(), 'value')),
            'user_id' => 'nullable|integer|exists:users,id'
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     */
    protected function failedValidation(Validator $validator): mixed
    {
        $response = response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors()
        ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
