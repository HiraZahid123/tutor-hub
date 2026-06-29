<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subject;
use App\Models\SubjectCategory;
use Illuminate\Support\Str;

class SubjectController extends Controller
{
    public function index()
    {
        $categories = SubjectCategory::with('subjects')->orderBy('order')->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get(); // For any legacy use
        return view('admin.subjects.index', compact('categories', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:subject_categories,id',
            'name' => 'required|string|max:255|unique:subjects,name',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        Subject::create(array_merge($validated, [
            'slug' => Str::slug($validated['name'])
        ]));

        return back()->with('success', 'Subject created successfully!');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:subject_categories,id',
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $subject->update(array_merge($validated, [
            'slug' => Str::slug($validated['name'])
        ]));

        return response()->json(['success' => true, 'message' => 'Subject updated successfully!']);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject deleted successfully!');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subject_categories,name',
            'icon' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        SubjectCategory::create(array_merge($validated, [
            'slug' => Str::slug($validated['name'])
        ]));

        return back()->with('success', 'Category created successfully!');
    }

    public function destroyCategory(SubjectCategory $category)
    {
        // Check if has subjects
        if ($category->subjects()->exists()) {
            return back()->with('error', 'Cannot delete category that has subjects. Delete subjects first.');
        }
        
        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}
