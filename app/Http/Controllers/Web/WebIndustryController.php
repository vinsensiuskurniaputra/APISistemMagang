<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;

class WebIndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::withCount('internships')->latest()->paginate(10);
        return view('admin.industries.index', compact('industries'));
    }

    public function create()
    {
        return view('admin.industries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        Industry::create($validated);

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry created successfully');
    }

    public function edit(Industry $industry)
    {
        $industry->load([
            'internships.student.user' => function($query) {
                $query->select('id', 'name', 'username');
            },
        ]);
        return view('admin.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        $industry->update($validated);

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry updated successfully');
    }

    public function destroy(Industry $industry)
    {
        $industry->delete();

        return redirect()->route('admin.industries.index')
            ->with('success', 'Industry deleted successfully');
    }
}
