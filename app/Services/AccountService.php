<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class AccountService
{
    private $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new GdDriver());
    }

    private function processProfileImage($image, Account $account)
    {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('img/profile');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $fullPath = $path . '/' . $filename;

        $img = $this->imageManager->read($image->getRealPath());
        $img->cover(200, 200);
        $img->save($fullPath);

        if ($account->profile_image && file_exists($path . '/' . $account->profile_image)) {
            unlink($path . '/' . $account->profile_image);
        }

        return $filename;
    }

    public function register(array $data)
    {
        $account = Account::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'bio' => $data['bio'] ?? null,
        ]);

        if (isset($data['profile_image'])) {
            $account->profile_image = $this->processProfileImage($data['profile_image'], $account);
            $account->save();
        }

        return $account;
    }

    public function update(Account $account, array $data)
    {
        $account->fill(array_diff_key($data, array_flip(['password', 'profile_image'])));

        if (!empty($data['password'])) {
            $account->password = Hash::make($data['password']);
        }

        if (!empty($data['profile_image'])) {
            $account->profile_image = $this->processProfileImage($data['profile_image'], $account);
        }

        $account->save();

        return $account;
    }

    public function destroy(Account $account)
    {
        if ($account->profile_image) {
            $path = public_path('img/profile/' . $account->profile_image);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $account->delete();
    }
}
