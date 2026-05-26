<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * প্রতিটি role-এর জন্য কোন permissions দেওয়া হবে তা নির্ধারণ করা হয়েছে।
     * ই-কমার্স সম্পূর্ণ বাদ দিয়ে শুধুমাত্র একটিভ অ্যাডমিন সাইডবার এবং HRM সেকশন রাখা হয়েছে।
     */
    private array $roleConfig = [
        [
            'slug'        => 'super-admin',
            'name'        => 'Super Admin',
            'description' => 'সর্বোচ্চ ক্ষমতা — সব পারমিশন আছে',
            'is_default'  => false,
            'all'         => true, // সব permission পাবে
        ],
        [
            'slug'        => 'admin',
            'name'        => 'Admin',
            'description' => 'প্রশাসক — পূর্ণ সিস্টেম অ্যাক্সেস',
            'is_default'  => false,
            'all'         => true,
        ],
        [
            'slug'        => 'sub-admin',
            'name'        => 'Sub Admin',
            'description' => 'সীমিত অ্যাডমিন অ্যাক্সেস — লোন ও HRM সিস্টেম',
            'is_default'  => false,
            'slugs'       => [
                'view-dashboard',
                'view-profile',
                'view-chat',
                'manage-chat',
                'manage-bank-check-approvals',
                'manage-loan-applications',
                'manage-loan-approvals',
                'manage-loans',
                'view-withdraw-screenshots',
                'manage-loan-contracts',
                'manage-certificate-stamps',
                'manage-banks',
                'manage-withdraw-payments',
                'view-documentation',
                'manage-id-cards',
                'view-employees',
                'create-employees',
                'edit-employees',
                'manage-attendance',
                'manage-leaves',
                'manage-payroll',
                'manage-expenses',
                'manage-salary-advance',
                'view-users',
            ],
        ],
        [
            'slug'        => 'manager',
            'name'        => 'Manager',
            'description' => 'ম্যানেজার — চ্যাট এবং HRM পরিচালনা',
            'is_default'  => false,
            'slugs'       => [
                'view-dashboard',
                'view-profile',
                'view-chat',
                'manage-chat',
                'view-employees',
                'manage-attendance',
                'manage-expenses',
                'manage-salary-advance',
            ],
        ],
        [
            'slug'        => 'employee',
            'name'        => 'Employee',
            'description' => 'স্টাফ কর্মচারী — সীমিত স্টাফ ড্যাশবোর্ড অ্যাক্সেস',
            'is_default'  => false,
            'slugs'       => [
                'view-dashboard',
                'view-profile',
            ],
        ],
        [
            'slug'        => 'seller',
            'name'        => 'Seller',
            'description' => 'সেলার — কোনো অ্যাডমিন প্যানেল অ্যাক্সেস নেই',
            'is_default'  => false,
            'slugs'       => [],
        ],
        [
            'slug'        => 'customer',
            'name'        => 'Customer',
            'description' => 'গ্রাহক — কোনো অ্যাডমিন প্যানেল অ্যাক্সেস নেই',
            'is_default'  => true,
            'slugs'       => [],
        ],
    ];

    public function run(): void
    {
        $allPermissionIds = Permission::pluck('id');

        foreach ($this->roleConfig as $config) {
            $role = Role::updateOrCreate(
                ['slug' => $config['slug']],
                [
                    'name'        => $config['name'],
                    'description' => $config['description'],
                    'is_active'   => true,
                    'is_default'  => $config['is_default'],
                ]
            );

            if ($config['all'] ?? false) {
                $role->permissions()->sync($allPermissionIds);
            } else {
                $ids = Permission::whereIn('slug', $config['slugs'] ?? [])->pluck('id');
                $role->permissions()->sync($ids);
            }
        }

        $this->command->info('✅ Roles: ' . Role::count() . ' টি তৈরি এবং পারমিশন অ্যাসাইন করা হয়েছে।');
    }
}
