<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('accounts')->ignore($this->user()),
            ],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        if ($this->isMethod('put') && $this->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => '名前は必須です。',
            'name.string' => '名前は文字列で入力してください。',
            'name.max' => '名前は255文字以内で入力してください。',
            'nickname.string' => 'ニックネームは文字列で入力してください。',
            'nickname.max' => 'ニックネームは255文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列で入力してください。',
            'email.email' => '有効なメールアドレス形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'password.required' => 'パスワードは必須です。',
            'password.confirmed' => 'パスワードが確認用と一致しません。',
            'profile_image.image' => 'プロフィール画像は画像ファイルを選択してください。',
            'profile_image.mimes' => 'プロフィール画像はjpeg, png, jpg, gif形式のみ許可されています。',
            'profile_image.max' => 'プロフィール画像は5MB以下のサイズにしてください。',
            'bio.string' => '自己紹介は文字列で入力してください。',
            'bio.max' => '自己紹介は1000文字以内で入力してください。',
            'current_password.required' => '現在のパスワードは必須です。',
            'current_password.current_password' => '現在のパスワードが正しくありません。',
        ];
    }
}