<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $adminRoles = ['super_admin', 'admin', 'order_manager', 'catalog_manager'];
        
        $query = User::whereIn('role', $adminRoles)->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $staffUsers = $query->paginate(15)->withQueryString();

        $availablePermissions = $this->getAvailablePermissions();

        return view('admin.users.index', compact('staffUsers', 'availablePermissions'));
    }

    public function create()
    {
        $availablePermissions = $this->getAvailablePermissions();
        $roles = $this->getAvailableRoles();

        return view('admin.users.create', compact('availablePermissions', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:super_admin,admin,order_manager,catalog_manager'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
            'permissions' => ['nullable', 'array'],
            'is_active' => ['nullable'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'city' => $request->city ?? 'Lahore',
            'permissions' => $request->permissions ?? [],
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::record('staff_created', "Created staff member [{$user->name}] with role '{$user->role}'", $user);

        return redirect()->route('admin.users.index')->with('success', "Staff account for [{$user->name}] provisioned successfully.");
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $availablePermissions = $this->getAvailablePermissions();
        $roles = $this->getAvailableRoles();

        return view('admin.users.edit', compact('user', 'availablePermissions', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:super_admin,admin,order_manager,catalog_manager'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
            'permissions' => ['nullable', 'array'],
            'is_active' => ['nullable'],
        ]);

        // Guard against super admin removing their own super admin role
        if ($user->id === Auth::id() && $user->role === 'super_admin' && $request->role !== 'super_admin') {
            return back()->with('error', 'You cannot demote yourself from Super Administrator.');
        }

        $user->name = $request->name;
        $user->email = strtolower(trim($request->email));
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->permissions = $request->permissions ?? [];
        $user->is_active = $request->has('is_active');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        ActivityLog::record('staff_updated', "Updated permissions and credentials for [{$user->name}]", $user);

        return redirect()->route('admin.users.index')->with('success', "Staff account for [{$user->name}] updated successfully.");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own administrative account.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::record('staff_deleted', "Revoked and deleted staff account [{$name}]");

        return redirect()->route('admin.users.index')->with('success', "Staff member [{$name}] removed.");
    }

    private function getAvailableRoles(): array
    {
        return [
            'super_admin' => [
                'label' => 'Super Administrator',
                'description' => 'Full uninhibited access to all systems, settings, staff credentials, financials, and logs.',
                'badge_color' => 'amber',
            ],
            'admin' => [
                'label' => 'Store Administrator',
                'description' => 'Manage products, orders, customers, reviews, marketing, blogs, and view analytics.',
                'badge_color' => 'blue',
            ],
            'order_manager' => [
                'label' => 'Order Specialist & Logistics',
                'description' => 'Process orders, verify bank slips, assign courier waybills, and update fulfillment.',
                'badge_color' => 'emerald',
            ],
            'catalog_manager' => [
                'label' => 'Catalog & Inventory Manager',
                'description' => 'Add fragrances, modify pricing tiers, adjust stock levels, and organize collections.',
                'badge_color' => 'purple',
            ],
        ];
    }

    private function getAvailablePermissions(): array
    {
        return [
            'manage_products' => [
                'label' => 'Fragrances Vault & Formulations',
                'description' => 'Create, edit, archive products, price tiers, and olfactory pyramids',
            ],
            'manage_orders' => [
                'label' => 'Patron Orders & Receipts',
                'description' => 'View all orders, verify bank slips, assign courier tracking numbers',
            ],
            'manage_categories' => [
                'label' => 'Collections & Olfactory Families',
                'description' => 'Manage collections, categories, and fragrance notes',
            ],
            'manage_coupons' => [
                'label' => 'Privilege Coupons & Vouchers',
                'description' => 'Create discount codes, configure minimum spend limits',
            ],
            'manage_slides' => [
                'label' => 'Homepage Showcase Banners',
                'description' => 'Manage hero carousel slides and call-to-actions',
            ],
            'manage_blogs' => [
                'label' => 'Fragrance Chronicles & Journal',
                'description' => 'Publish and edit articles in the brand olfactory journal',
            ],
            'manage_settings' => [
                'label' => 'Maison Settings & Payment Gateways',
                'description' => 'Configure store identity, delivery rules, and payment credentials',
            ],
            'manage_customers' => [
                'label' => 'Patron Intelligence',
                'description' => 'View customer profiles, purchase history, and contact numbers',
            ],
            'view_analytics' => [
                'label' => 'Executive Analytics & Telemetry',
                'description' => 'Access revenue charts, visitor metrics, and AOV stats',
            ],
            'manage_staff' => [
                'label' => 'Staff Roles & Access Delegation',
                'description' => 'Provision team members and grant permissions',
            ],
        ];
    }
}
