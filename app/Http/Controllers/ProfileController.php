<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $data = User::where('id', $user->id)->get();
        return view('profile.index', [
            'title' => 'Profile',
            'breadcrumb' => 'Profile',
            'user' => $user,
            'data' => $data,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'passwordLama' => 'required',
            'passwordBaru' => 'required|min:4',
            'konfirmasiPassword' => 'required|same:passwordBaru',
        ]);

        if (!Hash::check($request->passwordLama, $user->password)) {
            return back()->with('error', 'Password Lama Salah');
        }

        $user->password = Hash::make($request->passwordBaru);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
