<?php

// app/Http/Controllers/StoreProfileController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreProfile;

class StoreProfileController extends Controller
{
    public function index()
    {
        $profile = StoreProfile::first();
        return view('pages.profil.index', compact('profile'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required',
            'owner_name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logo', $logoName);
            $data['logo_url'] = $logoName;
        } else {
            // pertahankan logo lama jika tidak upload baru
            $existing = StoreProfile::first();
            if ($existing && $existing->logo_url) {
                $data['logo_url'] = $existing->logo_url;
            }
        }

        StoreProfile::updateOrCreate(['id' => 1], $data);
        return redirect()->back()->with('success', 'Profil toko berhasil disimpan!');
    }
    
    public function edit()
    {
        $profile = StoreProfile::first();
        return view('pages.profil.edit', compact('profile'));
    }
    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name' => 'required',
            'owner_name' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->storeAs('public/logo', $logoName);
            $data['logo_url'] = $logoName;
        } else {
            $existing = StoreProfile::first();
            if ($existing && $existing->logo_url) {
                $data['logo_url'] = $existing->logo_url;
            }
        }

        StoreProfile::updateOrCreate(['id' => 1], $data);

        return redirect()->route('store.profile')->with('success', 'Profil toko berhasil diperbarui!');
    }



    // API for Flutter
    public function apiGet()
    {
        return response()->json(StoreProfile::first());
    }

    public function apiUpdate(Request $request)
    {
        $data = $request->all();
        $profile = StoreProfile::updateOrCreate(['id' => 1], $data);
        return response()->json(['message' => 'Profil toko berhasil diperbarui.', 'data' => $profile]);
    }
}
