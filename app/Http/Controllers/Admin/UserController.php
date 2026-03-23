<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->load(['addresses', 'orders']);
        
        $userOrders = Order::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('admin.users.show', compact('user', 'userOrders'));
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        $message = $user->is_blocked ? 'User blocked successfully.' : 'User unblocked successfully.';
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'is_blocked' => $user->is_blocked]);
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete admin users.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
