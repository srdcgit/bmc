<?php

namespace App\Http\Controllers\CollectionStaff;

use App\Http\Controllers\Controller;
use App\Models\StreetVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StreetVendorController extends Controller
{
    public function index()
    {
        $street_vendors = StreetVendor::all();
        return view('collection_staff.street_vendor.index', compact('street_vendors'));
    }

    public function add()
    {
        return view('collection_staff.street_vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobilenumber' => 'nullable|string|max:10',
            'photo' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['name', 'area','address', 'mobilenumber']);
        $data['uu_id'] = 'SV-' . rand(100000, 999999);

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('photos'), $photoName);
            $data['photo'] = 'photos/' . $photoName;
        }

        StreetVendor::create($data);

        return redirect()->route('collection_staff.street_vendor.index')->with('success', 'Street vendor created successfully.');
    }
    public function edit($id)
    {
        $street_vendors = StreetVendor::find($id);
        return view('collection_staff.street_vendor.edit', compact('street_vendors'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobilenumber' => 'nullable|string|max:10',
            'photo' => 'nullable|image|max:2048'
        ]);

        $vendor = StreetVendor::findOrFail($id);

        $data = $request->only(['name', 'area','address', 'mobilenumber']);

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('photos'), $photoName);
            $data['photo'] = 'photos/' . $photoName;
        }

        $vendor->update($data);

        return redirect()->route('collection_staff.street_vendor.index')->with('success', 'Street vendor updated successfully.');
    }
    public function delete($id)
    {
        $vendor = StreetVendor::find($id);
        $vendor->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
