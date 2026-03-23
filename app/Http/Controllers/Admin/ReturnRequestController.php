<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnRequest;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $returns = ReturnRequest::with(['user', 'order'])->latest()->paginate(15);
        return view('admin.returns.index', compact('returns'));
    }

    public function show($id)
    {
        $return = ReturnRequest::with(['order.user', 'order.items.product', 'user'])->findOrFail($id);
        return view('admin.returns.show', compact('return'));
    }

    public function updateStatus(Request $request, $id)
    {
        $return = ReturnRequest::findOrFail($id);

        $rules = [
            'status' => 'required|in:requested,approved,rejected,picked,received,refunded'
        ];

        if ($request->status === 'approved' || $request->status === 'picked') {
            $rules['courier_name'] = 'required|string';
            $rules['tracking_id'] = 'required|string';
        }

        $request->validate($rules);

        $updateData = ['status' => $request->status];

        if ($request->status === 'approved' || $request->status === 'picked') {
            $updateData['courier_name'] = $request->courier_name;
            $updateData['tracking_id'] = $request->tracking_id;
        }

        if ($request->status === 'received') {
            $updateData['processed_at'] = now();
        }

        if ($request->status === 'refunded') {
            $updateData['refunded_at'] = now();
            $return->order->update(['payment_status' => 'refunded']);
        }

        $return->update($updateData);

        return response()->json(['success' => true, 'message' => 'Return status updated.']);
    }

    public function destroy($id)
    {
        $return = ReturnRequest::findOrFail($id);
        $return->delete();
        return redirect()->back()->with('success', 'Return request deleted.');
    }
}
