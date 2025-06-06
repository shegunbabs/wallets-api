<?php

namespace App\Http\Requests;

use App\Enums\WalletTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property string $owner_id
 * @property string $owner_type
 * @property string $currency
 * @property string $wallet_type
 * @property array $metadata
 */
class CreateWalletRequest extends FormRequest
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
            'owner_id' => ['required', 'string', 'min:2', 'max:50'],
            'owner_type' => ['sometimes', 'required'],
            'currency' => ['required','string', 'size:3'],
            'wallet_type' => [
                'required',
                Rule::unique('wallets')->where(function (Builder $query){
                    $query->where('owner_id', htmlspecialchars($this->owner_id ));
                })
            ],
            'metadata' => ['sometimes', 'required', 'array']
        ];
    }

    public function prepareForValidation()
    {
        $this->mergeIfMissing([
            'wallet_type' => WalletTypeEnum::PRIMARY->value,
        ]);
    }
}
