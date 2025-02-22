<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pay-method' => 'required|in:easymoney,superwalletz',
            'currency'   => 'required|in:USD,EUR',
            'amount'     => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages(): array
    {
        return [
            'pay-method.in' => 'Payment method not supported.',
            'currency.in'   => 'Currency not supported.',
            'amount.numeric' => 'Invalid amount.',
            'amount.regex' => 'Invalid amount.',
        ];
    }


    protected function withValidator($validator)
    {
        $validator->after(function (Validator $validator) {
            if ($this->input('pay-method') === 'easymoney') {
                $amount = $this->input('amount');
                if ($amount != intval($amount)) {
                    $validator->errors()->add('amount', 'Amount must be an integer for easymoney.');
                }
            }
        });
    }
}
