<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses;
        return view('addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        $isDefault = !Address::where('user_id', auth()->id())->exists();

        $address = Address::create([
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address_line_1' => $request->address_line_1,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'is_default' => $isDefault || $request->has('is_default'),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'address' => $address]);
        }

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        $address->update($request->only(['full_name', 'phone', 'address_line_1', 'city', 'state', 'postal_code']));

        if ($request->ajax()) {
            return response()->json(['success' => true, 'address' => $address]);
        }

        return redirect()->back()->with('success', 'Address updated successfully.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->delete();
        return redirect()->back()->with('success', 'Address deleted successfully.');
    }

    public function setDefault(Address $address): JsonResponse
    {
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->setAsDefault();

        return response()->json(['success' => true]);
    }
}
