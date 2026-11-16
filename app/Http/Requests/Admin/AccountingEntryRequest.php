<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountingEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $amount = $this->input('amount_try');

        if (is_string($amount)) {
            // Accept "1.250,50" style as well as "1250.50".
            $normalized = str_contains($amount, ',')
                ? str_replace(',', '.', str_replace('.', '', $amount))
                : $amount;

            $this->merge(['amount_try' => trim($normalized)]);
        }

        // Legacy forms post 0 for "not selected".
        foreach (['material_id', 'company_id', 'project_id'] as $key) {
            if (in_array($this->input($key), [0, '0', ''], true)) {
                $this->merge([$key => null]);
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in([0, 1])],
            'material_id' => ['nullable', 'integer', Rule::exists('materials', 'id')],
            'company_id' => ['nullable', 'integer', Rule::exists('companies', 'id')],
            'project_id' => ['nullable', 'integer', Rule::exists('projects', 'id')],
            'amount_try' => ['required', 'numeric', 'between:-2147483647,2147483647'],
            'note' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:5000'],
            'recorded_on' => [$this->isMethod('POST') ? 'nullable' : 'required', 'date'],
        ];
    }
}
