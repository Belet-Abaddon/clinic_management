<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Role (0 for User, 1 for Admin)
        $query->when($request->filled('role'), function ($q) use ($request) {
            return $q->where('role', $request->role);
        });

        $users = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.user', compact('users'));
    }

    public function promote(User $user)
    {
        $user->update(['role' => 1]);
        return redirect()->back()->with('success', "{$user->name} is now an Admin.");
    }

    public function demote(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot demote yourself!');
        }

        $user->update(['role' => 0]);
        return redirect()->back()->with('success', "{$user->name} is now a regular user.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
