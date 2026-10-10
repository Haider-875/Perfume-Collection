@extends('layouts.app')

@section('title', 'Delivery Destinations — Perfumes Collection')

@section('content')
<div class="py-5 min-vh-100" style="background-color: #F7F3EE;"
     x-data="{
        showModal: false,
        province: 'Punjab',
        city: 'Lahore',
        provincesData: {{ json_encode($provinces) }},
        getCities() {
            return this.provincesData[this.province] || [];
        }
     }">
    <div class="container" style="max-width: 1280px;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-4 mb-4" style="border-bottom: 1px solid #E8E0DA;">
            <div>
                <span class="d-inline-block fw-semibold px-3 py-1 rounded-pill mb-2 text-uppercase" style="font-size: 10px; letter-spacing: 0.3em; background-color: #FAF7F2; border: 1px solid #E8E0DA; color: #541B29;">
                    Private Logistics Book
                </span>
                <h1 class="font-serif fs-2 fs-md-1 fw-normal mb-0" style="color: #211D1E;">Saved Delivery Addresses</h1>
            </div>
            <button @click="showModal = true" class="btn text-uppercase fw-semibold tracking-wider d-inline-flex align-items-center gap-2 text-white shadow-sm" style="background-color: #541B29; border-radius: 8px; font-size: 0.8rem; padding: 10px 18px;">
                <svg class="bi" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Address</span>
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success border border-success-subtle text-success-emphasis p-3 rounded-3 mb-4 fs-7 shadow-sm" style="background-color: #FAF7F2;">
                {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-12 col-lg-3">
                <nav class="p-2 rounded-3 d-flex flex-column gap-1 fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA;">
                    <a href="{{ route('account.dashboard') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded fw-semibold text-decoration-none" style="background-color: #FAF7F2; color: #541B29; border-left: 3px solid #541B29;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="d-flex align-items-center gap-3 px-3 py-2 rounded text-decoration-none transition" style="color: #6B605B;">
                        <svg class="bi flex-shrink-0" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Addresses List -->
            <div class="col-12 col-lg-9">
                @if($addresses->isNotEmpty())
                    <div class="row g-4">
                        @foreach($addresses as $address)
                            <div class="col-12 col-md-6">
                                <div class="rounded-3 p-4 h-100 position-relative d-flex flex-column justify-content-between fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid {{ $address->is_default ? '#541B29' : '#E8E0DA' }};">
                                    <div>
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h3 class="font-serif fs-6 fw-bold mb-0" style="color: #211D1E;">{{ $address->recipient_name }}</h3>
                                            @if($address->is_default)
                                                <span class="badge text-uppercase tracking-wider fw-semibold px-2 py-1 fs-8" style="background-color: #FAF7F2; border: 1px solid #541B29; color: #541B29;">
                                                    Primary Destination
                                                </span>
                                            @endif
                                        </div>
                                        <p class="mb-1 lh-base" style="color: #514744;">{{ $address->street_address }}</p>
                                        <p class="fw-semibold mb-1" style="color: #211D1E;">{{ $address->city }}, {{ $address->province }} @if($address->postal_code)({{ $address->postal_code }})@endif</p>
                                        <p class="font-mono mt-2 mb-0" style="color: #786C67;">Mobile: {{ $address->phone }}</p>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between pt-3 mt-3 fs-8" style="border-top: 1px solid #E8E0DA;">
                                        @if(!$address->is_default)
                                            <form action="{{ route('account.address.default', $address->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-decoration-none text-uppercase tracking-wider fw-semibold" style="color: #541B29;">
                                                    Set as Primary
                                                </button>
                                            </form>
                                        @else
                                            <span class="fst-italic" style="color: #786C67;">Default</span>
                                        @endif

                                        <form action="{{ route('account.address.delete', $address->id) }}" method="POST" onsubmit="return confirm('Remove this destination address?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 text-decoration-underline text-uppercase tracking-wider" style="color: #9E2A2B;">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 rounded-3 text-center fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; color: #786C67;">
                        <p class="mb-4">No delivery addresses saved to your patron book.</p>
                        <button @click="showModal = true" class="btn btn-sm text-uppercase fw-semibold tracking-wider text-white shadow-sm" style="background-color: #541B29; border-radius: 8px;">
                            Add First Destination
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Add Address Modal -->
        <div x-show="showModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center p-3 z-modal" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
            <div @click.away="showModal = false" class="p-4 p-md-4 rounded-3 w-100 shadow-xl d-flex flex-column gap-3" style="background-color: #FFFFFF; border: 1px solid #E8E0DA; max-width: 520px; max-height: 90vh; overflow-y: auto;">
                <div class="d-flex justify-content-between align-items-center pb-3" style="border-bottom: 1px solid #E8E0DA;">
                    <h3 class="font-serif fs-5 fw-semibold mb-0" style="color: #211D1E;">Add Delivery Destination</h3>
                    <button type="button" @click="showModal = false" class="btn-close" aria-label="Close"></button>
                </div>

                <form action="{{ route('account.address.store') }}" method="POST" class="d-flex flex-column gap-3">
                    @csrf
                    <div>
                        <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Recipient Name *</label>
                        <input type="text" name="recipient_name" required placeholder="e.g. Daniyal Khan"
                               class="form-control form-control-luxury fs-7">
                    </div>

                    <div>
                        <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Pakistani Mobile Contact *</label>
                        <input type="tel" name="phone" required placeholder="0300 1234567"
                               class="form-control form-control-luxury fs-7 font-mono">
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Province *</label>
                            <select name="province" x-model="province" required class="form-select form-control-luxury fs-7">
                                @foreach($provinces as $prov => $cities)
                                    <option value="{{ $prov }}">{{ $prov }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">City *</label>
                            <select name="city" x-model="city" required class="form-select form-control-luxury fs-7">
                                <template x-for="c in getCities()" :key="c">
                                    <option :value="c.split(' (')[0]" x-text="c"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Street Address / House / Flat *</label>
                        <textarea name="street_address" required rows="2" placeholder="e.g. House 42, Street 8, Phase 5 DHA"
                                  class="form-control form-control-luxury fs-7"></textarea>
                    </div>

                    <div>
                        <label class="form-label text-uppercase tracking-wider mb-1 fw-semibold fs-8" style="color: #541B29;">Postal Code</label>
                        <input type="text" name="postal_code" placeholder="54000"
                               class="form-control form-control-luxury fs-7 font-mono">
                    </div>

                    <div class="form-check d-flex align-items-center gap-2 pt-1 mb-0">
                        <input type="checkbox" id="is_default" name="is_default" value="1" class="form-check-input mt-0">
                        <label for="is_default" class="form-check-label fs-7 cursor-pointer" style="color: #514744;">Set as primary delivery address</label>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn flex-grow-1 py-2 fw-semibold text-uppercase tracking-wider fs-7 text-white shadow-sm" style="background-color: #541B29; border-radius: 8px;">
                            Save Address
                        </button>
                        <button type="button" @click="showModal = false" class="btn py-2 px-4 fs-7 shadow-sm" style="background-color: #FFFFFF; border: 1px solid #541B29; color: #541B29; border-radius: 8px;">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
