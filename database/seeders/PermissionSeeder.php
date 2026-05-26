<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * প্রতিটি group = Admin sidebar & Staff panel-এর একটি section。
     * শুধুমাত্র সক্রিয় লোন ম্যানেজমেন্ট ও HRM সিস্টেমের পারমিশন থাকবে。
     * ই-কমার্স বা প্রোডাক্ট সংক্রান্ত সব পারমিশন বাদ দেওয়া হয়েছে。
     */
    private array $permissions = [
        // ── Chat ─────────────────────────────────────────────────────
        'chat' => [
            ['name' => 'View Live Chat', 'slug' => 'view-chat'],
            ['name' => 'Manage Live Chat', 'slug' => 'manage-chat'],
        ],

        // ── Configuration ─────────────────────────────────────────
        'configuration' => [
            ['name' => 'View Settings', 'slug' => 'view-settings'],
            ['name' => 'Edit General Settings', 'slug' => 'edit-settings'],
            ['name' => 'Manage Favicon', 'slug' => 'manage-favicon'],
            ['name' => 'Manage Footer', 'slug' => 'manage-footer'],
            ['name' => 'Manage Contact Info', 'slug' => 'manage-contact'],
            ['name' => 'Manage Mail Config', 'slug' => 'manage-mail'],
        ],

        // ── Dashboard ─────────────────────────────────────────────────────
        'dashboard' => [
            ['name' => 'View Dashboard', 'slug' => 'view-dashboard'],
            ['name' => 'View Dashboard Analytics', 'slug' => 'view-dashboard-analytics'],
            ['name' => 'View Profile', 'slug' => 'view-profile'],
        ],

        // ── HRM Management ────────────────────────────────────────────────
        'hrm' => [
            ['name' => 'ID Card Create / আইডি কার্ড ক্রিয়েট', 'slug' => 'manage-id-cards'],
            ['name' => 'View Employees', 'slug' => 'view-employees'],
            ['name' => 'Create Employees', 'slug' => 'create-employees'],
            ['name' => 'Edit Employees', 'slug' => 'edit-employees'],
            ['name' => 'Delete Employees', 'slug' => 'delete-employees'],
            ['name' => 'Manage Attendance', 'slug' => 'manage-attendance'],
            ['name' => 'Manage Leaves / ছুটি', 'slug' => 'manage-leaves'],
            ['name' => 'Manage Payroll / পে-রোল', 'slug' => 'manage-payroll'],
            ['name' => 'Manage Expenses', 'slug' => 'manage-expenses'],
            ['name' => 'Manage Salary Advance', 'slug' => 'manage-salary-advance'],
        ],

        // ── Loan Management ───────────────────────────────────────────────
        'loans' => [
            ['name' => 'Bank Check Approvals', 'slug' => 'manage-bank-check-approvals'],
            ['name' => 'Loan Applications', 'slug' => 'manage-loan-applications'],
            ['name' => 'Loan Approvals', 'slug' => 'manage-loan-approvals'],
            ['name' => 'Loan Requests List', 'slug' => 'manage-loans'],
            ['name' => 'Withdraw Screenshots / উইথড্র স্ক্রিনশট', 'slug' => 'view-withdraw-screenshots'],
            ['name' => 'Loan Contracts / চুক্তি', 'slug' => 'manage-loan-contracts'],
            ['name' => 'Certificate Stamps', 'slug' => 'manage-certificate-stamps'],
            ['name' => 'Bank Setup / ব্যাংক', 'slug' => 'manage-banks'],
            ['name' => 'Withdraw Payment Setup', 'slug' => 'manage-withdraw-payments'],
            ['name' => 'View Documentation', 'slug' => 'view-documentation'],
        ],

        // ── Permissions ─────────────────────────────────────────────────────
        'permissions' => [
            ['name' => 'View Permissions', 'slug' => 'view-permissions'],
            ['name' => 'Create Permissions', 'slug' => 'create-permissions'],
            ['name' => 'Edit Permissions', 'slug' => 'edit-permissions'],
            ['name' => 'Delete Permissions', 'slug' => 'delete-permissions'],
        ],

        // ── Access Control (Roles & Permissions) ──────────────────────────
        'roles' => [
            ['name' => 'View Roles', 'slug' => 'view-roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles'],
        ],

        // ── Administrators & Users ─────────────────────────────────────────
        'users' => [
            ['name' => 'View Users', 'slug' => 'view-users'],
            ['name' => 'Create Users', 'slug' => 'create-users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users'],
        ],
    ];

    public function run(): void
    {
        // Truncate permissions tables to cleanly remove e-commerce items
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permission')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $total = 0;
        foreach ($this->permissions as $group => $items) {
            foreach ($items as $item) {
                Permission::create([
                    'name'  => $item['name'],
                    'slug'  => $item['slug'],
                    'group' => $group,
                ]);
                $total++;
            }
        }
        $this->command->info("✅ PermissionSeeder: Cleaned and seeded {$total} active permissions.");
        $this->command->newLine();
    }
}
?>
