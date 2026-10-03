<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminHeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'badge_text' => 'nullable|string|max:100',
            'cta_text' => 'nullable|string|max:50',
            'cta_url' => 'nullable|string|max:255',
            'secondary_cta_text' => 'nullable|string|max:50',
            'secondary_cta_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
        ]);

        $imagePath = 'assets/images/perfumes/hero_parfum.svg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'slide_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/slides');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/slides/' . $filename;
        }

        $slide = HeroSlide::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'badge_text' => $request->badge_text,
            'cta_text' => $request->cta_text ?? 'DISCOVER COLLECTION',
            'cta_url' => $request->cta_url ?? '/collections',
            'secondary_cta_text' => $request->secondary_cta_text,
            'secondary_cta_url' => $request->secondary_cta_url,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('slide_created', "Added homepage showcase slide '{$slide->title}'", $slide);

        return redirect()->route('admin.hero-slides.index')->with('success', "Slide '{$slide->title}' crafted.");
    }

    public function update(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'badge_text' => 'nullable|string|max:100',
            'cta_text' => 'nullable|string|max:50',
            'cta_url' => 'nullable|string|max:255',
            'secondary_cta_text' => 'nullable|string|max:50',
            'secondary_cta_url' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,webp,svg|max:2048',
        ]);

        $imagePath = $slide->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'slide_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/slides');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/slides/' . $filename;
        }

        $slide->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'badge_text' => $request->badge_text,
            'cta_text' => $request->cta_text,
            'cta_url' => $request->cta_url,
            'secondary_cta_text' => $request->secondary_cta_text,
            'secondary_cta_url' => $request->secondary_cta_url,
            'sort_order' => $request->sort_order ?? 0,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('slide_updated', "Updated homepage slide '{$slide->title}'", $slide);

        return redirect()->route('admin.hero-slides.index')->with('success', "Slide '{$slide->title}' updated.");
    }

    public function destroy($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $title = $slide->title;
        $slide->delete();

        ActivityLog::record('slide_deleted', "Deleted slide '{$title}'");

        return redirect()->route('admin.hero-slides.index')->with('success', "Slide '{$title}' deleted.");
    }
}
