<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Inquiry;
use App\Models\NewsletterSubscriber;
use App\Models\Collection;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function collaborations()
    {
        $collabCollection = Collection::where('slug', 'collaborations')->first();
        $collabProducts = Product::where('is_collaboration', true)->active()->get();
        return view('pages.collaborations', compact('collabCollection', 'collabProducts'));
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function privacyPolicy()
    {
        return view('pages.policies.privacy');
    }

    public function termsOfService()
    {
        return view('pages.policies.terms');
    }

    public function refundPolicy()
    {
        return view('pages.policies.refund');
    }

    public function shippingPolicy()
    {
        return view('pages.policies.shipping');
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $products = collect();

        if (strlen($q) >= 2) {
            $searchTerm = '%' . $q . '%';
            $products = Product::active()
                ->where(function($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                          ->orWhere('description', 'like', $searchTerm)
                          ->orWhere('top_notes_summary', 'like', $searchTerm)
                          ->orWhere('heart_notes_summary', 'like', $searchTerm)
                          ->orWhere('base_notes_summary', 'like', $searchTerm);
                })
                ->paginate(12)
                ->withQueryString();
        }

        return view('pages.search', compact('q', 'products'));
    }

    public function storeInquiry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:120',
            'city' => 'nullable|string|max:60',
            'inquiry_type' => 'required|string',
            'message' => 'required|string|min:10|max:2000',
        ]);

        Inquiry::create($request->all());

        return back()->with('success', 'Your royal consultation request has been received. Our Master Parfumeur will contact you via WhatsApp / Phone shortly.');
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        NewsletterSubscriber::create([
            'email' => $request->email,
            'source' => $request->get('source', 'footer'),
            'is_active' => true,
        ]);

        return back()->with('success', 'Welcome to the Private Circle. Use code ROYAL10 for 10% off your inaugural order.');
    }
}
