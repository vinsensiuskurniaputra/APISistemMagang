<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebLecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with(['user'])->latest()->paginate(10);
        return view('admin.lecturers.index', compact('lecturers'));
    }

    public function create()
    {
        return view('admin.lecturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make('polines*2023'),
                'role' => User::ROLES['Lecturer'],
            ]);

            Lecturer::create([
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer created successfully');
    }

    public function edit(Lecturer $lecturer)
    {
        return view('admin.lecturers.edit', compact('lecturer'));
    }

    public function update(Request $request, Lecturer $lecturer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $lecturer->user_id,
            'username' => 'required|string|unique:users,username,' . $lecturer->user_id,
        ]);

        DB::transaction(function () use ($request, $lecturer) {
            $lecturer->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
            ]);
        });

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer updated successfully');
    }

    public function destroy(Lecturer $lecturer)
    {
        DB::transaction(function () use ($lecturer) {
            $lecturer->user->delete(); // This will cascade delete the lecturer record
        });

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer deleted successfully');
    }
}
