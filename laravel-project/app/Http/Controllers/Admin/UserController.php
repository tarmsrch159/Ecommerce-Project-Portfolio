<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    /**
     * Display the list of users
     */
    public function index()
    {
        //ดึงข้อมูล review จาก database
        $users = User::latest()->get();
        return view('admin.users.index')->with([
            'users' => $users
        ]);
    }



    /**
     * Delete reviews
     */
    public function delete(User $user)
    {
        //เช็คถ้าuser มีรูปโปรไฟล์ ให้ลบออก
        if (File::exist(public_path($user->profile_image))) {
            File::delete(public_path($user->profile_image));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with([
            'success' => 'User has been deleted successfully'
        ]);
    }
}
