@extends('admin.layouts.admin')

@section('title', 'Edit Staff Member')
@section('page_title', 'Edit Staff Member: ' . $user->name)
@section('page_subtitle', 'Adjust role elevation, toggle account status, and calibrate granular permission grants')

@section('header_actions')
<a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg text-xs bg-brand-card hover:bg-brand-border text-brand-text border border-brand-border/60 flex items-center gap-2 transition">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back to Staff Directory</span>
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6 max-w-4xl">
    @csrf
    @method('PUT')

    <!-- Credentials & Identity -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
        <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
            <i class="fa-solid fa-id-badge text-brand-gold text-xs"></i>
            <span>Team Member Profile</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Full Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
                @error('name') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Email Address (Login Username) *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold font-mono">
                @error('email') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Reset Password (Leave blank to keep current)</label>
                <input type="password" name="password" placeholder="Enter new password to reset"
                       class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text placeholder-brand-muted/40 focus:outline-none focus:border-brand-gold">
                @error('password') <span class="text-rose-400 text-[11px] mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">Direct Phone / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 0300-1234567"
                       class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
            </div>

            <div>
                <label class="block text-xs uppercase tracking-wider text-brand-muted mb-1 font-medium">City / Office Branch</label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="e.g. Lahore / Karachi"
                       class="w-full bg-brand-black/60 border border-brand-border/60 rounded-lg px-3.5 py-2.5 text-xs text-brand-text focus:outline-none focus:border-brand-gold">
            </div>

            <div class="flex items-center pt-5">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active !== false) ? 'checked' : '' }}
                           class="rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                    <div>
                        <span class="text-xs text-brand-text font-medium block">Account Enabled & Active</span>
                        <span class="text-[10px] text-brand-muted block">Uncheck to instantly suspend access to the administrative suite</span>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <!-- Role Selection -->
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
        <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2 border-b border-brand-border/40 pb-3">
            <i class="fa-solid fa-shield-halved text-brand-gold text-xs"></i>
            <span>Administrative Role</span>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($roles as $key => $r)
                <label class="relative p-4 rounded-xl border {{ $user->role === $key ? 'border-brand-gold bg-brand-gold/10' : 'border-brand-border/60 bg-brand-card/40' }} hover:border-brand-gold/60 cursor-pointer transition block group">
                    <div class="flex items-start gap-3">
                        <input type="radio" name="role" value="{{ $key }}" {{ old('role', $user->role) === $key ? 'checked' : '' }}
                               class="mt-1 text-brand-gold focus:ring-0 bg-brand-black border-brand-border">
                        <div>
                            <div class="font-semibold text-xs text-brand-text group-hover:text-brand-gold transition">{{ $r['label'] }}</div>
                            <div class="text-[11px] text-brand-muted mt-1 leading-relaxed">{{ $r['description'] }}</div>
                        </div>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Granular Permissions Matrix -->
    @php
        $userPerms = is_array($user->permissions) ? $user->permissions : (json_decode($user->permissions ?? '[]', true) ?: []);
    @endphp
    <div class="bg-brand-surface border border-brand-border/60 rounded-xl p-6 space-y-4">
        <div class="border-b border-brand-border/40 pb-3">
            <h3 class="font-serif text-base font-semibold text-brand-text flex items-center gap-2">
                <i class="fa-solid fa-key text-brand-gold text-xs"></i>
                <span>Explicit Granular Permissions</span>
            </h3>
            <p class="text-[11px] text-brand-muted mt-0.5">Customize individual capabilities (Super Admins inherently possess all permissions).</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($availablePermissions as $pKey => $pMeta)
                <label class="p-3 bg-brand-card/30 border border-brand-border/40 rounded-lg flex items-start gap-3 hover:bg-brand-card/60 transition cursor-pointer">
                    <input type="checkbox" name="permissions[]" value="{{ $pKey }}"
                           {{ in_array($pKey, old('permissions', $userPerms)) ? 'checked' : '' }}
                           class="mt-0.5 rounded bg-brand-black border-brand-border text-brand-gold focus:ring-0">
                    <div>
                        <span class="text-xs font-medium text-brand-text block">{{ $pMeta['label'] }}</span>
                        <span class="text-[10px] text-brand-muted block leading-snug">{{ $pMeta['description'] }}</span>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-lg text-xs text-brand-muted hover:text-brand-text border border-brand-border/60 bg-brand-card transition">
            Cancel
        </a>
        <button type="submit" class="gold-btn px-6 py-2.5 rounded-lg text-xs shadow-lg flex items-center gap-2">
            <i class="fa-solid fa-check"></i>
            <span>Save Staff Changes</span>
        </button>
    </div>
</form>
@endsection
