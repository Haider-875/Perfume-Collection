@extends('layouts.app')

@section('title', 'Delivery Destinations — Perfumes Collection')

@section('content')
<div class="py-10 md:py-16 bg-[#080304] text-brand-ivory min-h-screen"
     x-data="{
        showModal: false,
        province: 'Punjab',
        city: 'Lahore',
        provincesData: {{ json_encode($provinces) }},
        getCities() {
            return this.provincesData[this.province] || [];
        }
     }">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-8 mb-10 border-b border-white/10">
            <div>
                <span class="text-[10px] uppercase tracking-[0.3em] text-brand-gold px-3 py-1 bg-brand-maroon/20 border border-brand-gold/30 rounded-full inline-block mb-2">
                    Private Logistics Book
                </span>
                <h1 class="font-serif text-3xl md:text-4xl text-brand-gold font-light">Saved Delivery Addresses</h1>
            </div>
            <button @click="showModal = true" class="px-5 py-2.5 bg-brand-gold text-black font-semibold text-xs uppercase tracking-[0.2em] rounded-sm hover:brightness-110 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Add New Address</span>
            </button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-950/60 border border-green-500/40 text-green-300 text-xs rounded-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-3">
                <nav class="bg-[#0d0608] border border-brand-gold/20 p-3 rounded-sm space-y-1 text-xs">
                    <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Patron Overview</span>
                    </a>
                    <a href="{{ route('account.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>Order Dossiers</span>
                    </a>
                    <a href="{{ route('account.addresses') }}" class="flex items-center gap-3 px-4 py-3 rounded bg-brand-maroon/30 text-brand-gold font-semibold border-l-2 border-brand-gold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Delivery Addresses</span>
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span>Wishlist Vault</span>
                    </a>
                    <a href="{{ route('account.reviews') }}" class="flex items-center gap-3 px-4 py-3 rounded text-brand-ivory/70 hover:text-brand-gold hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <span>Olfactory Reviews</span>
                    </a>
                </nav>
            </div>

            <!-- Addresses Grid -->
            <div class="lg:col-span-9">
                @if($addresses->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($addresses as $address)
                            <div class="bg-[#0d0608] border rounded-sm p-6 relative flex flex-col justify-between text-xs space-y-4 shadow-xl {{ $address->is_default ? 'border-brand-gold ring-1 ring-brand-gold/30' : 'border-white/10' }}">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-serif text-base text-brand-gold font-semibold">{{ $address->recipient_name }}</h3>
                                        @if($address->is_default)
                                            <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 bg-brand-gold/20 text-brand-gold border border-brand-gold/40 rounded font-semibold">
                                                Primary Destination
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-brand-ivory/80 leading-relaxed">{{ $address->street_address }}</p>
                                    <p class="text-brand-ivory/70 font-semibold">{{ $address->city }}, {{ $address->province }} @if($address->postal_code)({{ $address->postal_code }})@endif</p>
                                    <p class="text-brand-ivory/50 font-mono mt-2">Mobile: {{ $address->phone }}</p>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-white/10 text-[11px]">
                                    @if(!$address->is_default)
                                        <form action="{{ route('account.address.default', $address->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-brand-gold hover:underline uppercase tracking-wider font-semibold">
                                                Set as Primary
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-brand-ivory/40 italic">Default</span>
                                    @endif

                                    <form action="{{ route('account.address.delete', $address->id) }}" method="POST" onsubmit="return confirm('Remove this destination address?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 underline uppercase tracking-wider">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#0d0608] border border-brand-gold/20 p-12 rounded-sm text-center text-xs text-brand-ivory/50 shadow-xl">
                        <p class="mb-4">No delivery addresses saved to your patron book.</p>
                        <button @click="showModal = true" class="px-5 py-2.5 bg-brand-gold text-black font-semibold uppercase tracking-wider rounded inline-block">
                            Add First Destination
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Add Address Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div @click.away="showModal = false" class="bg-[#0d0608] border border-brand-gold/40 p-6 md:p-8 rounded-sm max-w-lg w-full text-xs shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center pb-3 border-b border-white/10">
                    <h3 class="font-serif text-lg text-brand-gold font-semibold">Add Delivery Destination</h3>
                    <button @click="showModal = false" class="text-brand-ivory/40 hover:text-white text-base">&times;</button>
                </div>

                <form action="{{ route('account.address.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Recipient Name *</label>
                        <input type="text" name="recipient_name" required placeholder="e.g. Daniyal Khan"
                               class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none">
                    </div>

                    <div>
                        <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Pakistani Mobile Contact *</label>
                        <input type="tel" name="phone" required placeholder="0300 1234567"
                               class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none font-mono">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Province *</label>
                            <select name="province" x-model="province" required class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none">
                                @foreach($provinces as $prov => $cities)
                                    <option value="{{ $prov }}">{{ $prov }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">City *</label>
                            <select name="city" x-model="city" required class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none">
                                <template x-for="c in getCities()" :key="c">
                                    <option :value="c.split(' (')[0]" x-text="c"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Street Address / House / Flat *</label>
                        <textarea name="street_address" required rows="2" placeholder="e.g. House 42, Street 8, Phase 5 DHA"
                                  class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block uppercase tracking-[0.15em] text-brand-gold/90 mb-1 font-medium">Postal Code</label>
                        <input type="text" name="postal_code" placeholder="54000"
                               class="w-full bg-black/60 border border-brand-gold/30 px-3 py-2 text-brand-ivory rounded focus:border-brand-gold focus:outline-none font-mono">
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input type="checkbox" id="is_default" name="is_default" value="1" class="accent-brand-gold w-4 h-4">
                        <label for="is_default" class="text-brand-ivory/80 cursor-pointer">Set as primary delivery address</label>
                    </div>

                    <div class="flex gap-3 pt-3">
                        <button type="submit" class="flex-1 py-3 bg-brand-gold text-black font-semibold uppercase tracking-wider rounded hover:brightness-110">
                            Save Address
                        </button>
                        <button type="button" @click="showModal = false" class="px-5 py-3 bg-black/60 border border-white/20 text-brand-ivory rounded">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
