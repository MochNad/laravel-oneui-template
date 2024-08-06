<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateAccountRequest;
use App\Http\Requests\Profile\UpdateBannerRequest;
use App\Http\Requests\Profile\UpdatePictureRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $modules = ["profile"];

    public function index()
    {
        $user = auth()->user();

        return view('pages.profile.index')->with([
            'user' => $user,
        ]);
    }

    public function updateAccount(UpdateAccountRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            DB::commit();
            return jsonRedirect('profile.index', 'Account updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePicture(UpdatePictureRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            if ($user->profile->picture) {
                Storage::disk('public')->delete($user->profile->picture);
            }
            $user->profile->picture = $request->file('picture')->store('profile/pictures', 'public');
            $user->profile->save();
            DB::commit();
            return jsonRedirect('profile.index', 'Picture updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateBanner(UpdateBannerRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            if ($user->profile->banner) {
                Storage::disk('public')->delete($user->profile->banner);
            }
            $user->profile->banner = $request->file('banner')->store('profile/banners', 'public');
            $user->profile->save();
            DB::commit();
            return jsonRedirect('profile.index', 'Banner updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
