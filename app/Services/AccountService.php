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

    private function processProfileImage($image, Account $user)
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

        if ($user->profile_image && file_exists($path . '/' . $user->profile_image)) {
            unlink($path . '/' . $user->profile_image);
        }

        return $filename;
    }

    public function register(array $data)
    {
        $user = Account::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'bio' => $data['bio'] ?? null,
        ]);

        if (isset($data['profile_image'])) {
            $user->profile_image = $this->processProfileImage($data['profile_image'], $user);
            $user->save();
        }

        return $user;
    }

    public function update(Account $user, array $data)
    {
        $user->fill(array_diff_key($data, array_flip(['password', 'profile_image'])));

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (!empty($data['profile_image'])) {
            $user->profile_image = $this->processProfileImage($data['profile_image'], $user);
        }

        $user->save();

        return $user;
    }

    public function destroy(Account $user)
    {
        if ($user->profile_image) {
            $path = public_path('img/profile/' . $user->profile_image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        foreach ($user->photos as $photo) {
            if (file_exists(public_path($photo->path))) {
                unlink(public_path($photo->path));
            }
            $photo->delete();
        }
        
        $user->favorites()->detach();
        $user->delete();
    }
}
