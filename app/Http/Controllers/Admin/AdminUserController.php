<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController
{
    public function getUsers()
    {
        $users = User::select('id', 'name', 'phone')->get();
        if (!$users) {
            return response()->json(['message' => 'Không có người dùng nào !']);
        }
        return response()->json($users);
    }

    public function deleteUser($id)
    {
        $user = User::where('id', $id);
        if (!$user) {
            return response()->json(['message' => 'Không tìm thấy người dùng !']);
        }
        $user->delete();
        return response()->json(['message' => 'Đã xóa người dùng !']);
    }
}
