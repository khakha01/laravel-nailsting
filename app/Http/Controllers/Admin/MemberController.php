<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * List members with search & pagination.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('provider')) {
            if ($request->get('provider') === 'google') {
                $query->whereNotNull('google_id');
            } else {
                $query->whereNull('google_id');
            }
        }

        $members = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.member-management.index', compact('members'));
    }

    /**
     * Show member detail.
     */
    public function show(User $member)
    {
        return view('admin.member-management.show', compact('member'));
    }

    /**
     * Delete a member.
     */
    public function destroy(User $member)
    {
        try {
            $member->delete();

            return redirect()
                ->route('members.index')
                ->with('success', 'Xóa thành viên thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
