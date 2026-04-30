<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'integer', 'between:0,10000'],
            'image' => ['nullable', 'mimes:jpg,png'],
            'season_ids' => ['required','array'],
            'description' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.between' => '0∼10000円以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'season_ids.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
        ];
    }

    public function prepareForValidation()
    {
    if ($this->hasFile('image') && $this->file('image')->isValid()) {
        $tempPath = $this->file('image')->store('temp', 'public');
        session(['temp_image_path' => $tempPath]);
        session(['temp_image_name' => $this->file('image')->getClientOriginalName()]);
        }
    }
}
