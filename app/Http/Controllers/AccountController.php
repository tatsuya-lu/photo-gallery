<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function showLoginForm()
    {
        return view('account.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('photos.index'));
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません。',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('photos.index');
    }

    public function showRegistrationForm()
    {
        return view('account.register', ['user' => null]);
    }

    public function register(AccountRequest $request)
    {
        $user = $this->accountService->register($request->all());

        if ($user) {
            Auth::login($user);
            return redirect()->route('photos.index')->with('success', 'アカウントが正常に登録されました。');
        } else {
            return redirect()->route('register')->with('error', 'ユーザーの登録に失敗しました。');
        }
    }

    public function showEditForm()
    {
        return view('account.register', ['user' => Auth::user()]);
    }

    public function update(AccountRequest $request)
    {
        $user = Auth::user();
        $this->accountService->update($user, $request->all());
        return redirect()->route('account.edit')->with('success', 'プロフィールが更新されました。');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $this->accountService->destroy($user);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('photos.index')->with('success', 'アカウントが削除されました。');
    }
}
