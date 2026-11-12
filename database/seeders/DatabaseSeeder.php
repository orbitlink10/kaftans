<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Provider;
use App\Models\Review;
use App\Models\Role;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect([
            ['name' => 'admin', 'label' => 'Admin'],
            ['name' => 'customer', 'label' => 'Customer'],
            ['name' => 'provider', 'label' => 'Service Provider'],
            ['name' => 'dispatcher', 'label' => 'Staff/Dispatcher'],
        ])->mapWithKeys(fn ($role) => [$role['name'] => Role::updateOrCreate(['name' => $role['name']], $role)]);

        $admin = User::updateOrCreate(['email' => 'admin@lasafi.co.ke'], [
            'role_id' => $roles['admin']->id,
            'name' => 'Lasafi Admin',
            'phone' => '0711000000',
            'county' => 'Nairobi',
            'location' => 'Westlands',
            'password' => Hash::make('password'),
        ]);

        User::updateOrCreate(['email' => 'dispatcher@lasafi.co.ke'], [
            'role_id' => $roles['dispatcher']->id,
            'name' => 'Operations Dispatcher',
            'phone' => '0711000001',
            'county' => 'Nairobi',
            'location' => 'CBD',
            'password' => Hash::make('password'),
        ]);

        $customer = User::updateOrCreate(['email' => 'customer@example.com'], [
            'role_id' => $roles['customer']->id,
            'name' => 'Amina Otieno',
            'phone' => '0712345678',
            'county' => 'Nairobi',
            'location' => 'Kilimani',
            'password' => Hash::make('password'),
        ]);

        $providerUser = User::updateOrCreate(['email' => 'provider@example.com'], [
            'role_id' => $roles['provider']->id,
            'name' => 'Kamau Home Pros',
            'phone' => '0722000000',
            'county' => 'Nairobi',
            'location' => 'Roysambu',
            'password' => Hash::make('password'),
        ]);

        $categoryNames = [
            'Cleaning', 'Movers', 'Handyman', 'Pest Control', 'Laundry', 'Gardening',
            'Appliance Repair', 'Security & CCTV', 'Wi-Fi & Networking', 'Office Maintenance',
        ];

        $categories = collect($categoryNames)->mapWithKeys(function ($name) {
            return [$name => Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $name.' services across Nairobi and major Kenyan towns.', 'is_active' => true]
            )];
        });

        $services = [
            ['Cleaning', 'Deep House Cleaning', 3500, 'fixed'],
            ['Cleaning', 'Post Construction Cleaning', 6500, 'fixed'],
            ['Movers', 'Apartment Moving', 5000, 'per km'],
            ['Handyman', 'General Repairs', 1800, 'hourly'],
            ['Pest Control', 'Cockroach and Bedbug Control', 4500, 'fixed'],
            ['Laundry', 'Wash and Fold', 700, 'per item'],
            ['Gardening', 'Lawn Care Visit', 2500, 'fixed'],
            ['Appliance Repair', 'Fridge and Cooker Repair', 2500, 'fixed'],
            ['Security & CCTV', 'CCTV Installation', 12000, 'per item'],
            ['Wi-Fi & Networking', 'Home Wi-Fi Setup', 3500, 'fixed'],
            ['Office Maintenance', 'Monthly Office Maintenance', 15000, 'fixed'],
        ];

        $serviceModels = collect($services)->map(function ($service) use ($categories) {
            [$category, $name, $price, $unit] = $service;

            return Service::updateOrCreate(['slug' => Str::slug($name)], [
                'category_id' => $categories[$category]->id,
                'name' => $name,
                'description' => 'Reliable '.$name.' by vetted Lasafi professionals.',
                'base_price' => $price,
                'unit_type' => $unit,
                'is_active' => true,
            ]);
        });

        $provider = Provider::updateOrCreate(['email' => 'provider@example.com'], [
            'user_id' => $providerUser->id,
            'category_id' => $categories['Cleaning']->id,
            'name' => 'Kamau Home Pros',
            'phone' => '0722000000',
            'county' => 'Nairobi',
            'location' => 'Roysambu',
            'availability_status' => 'available',
            'rating' => 4.8,
            'verification_status' => 'approved',
        ]);
        $provider->services()->sync($serviceModels->take(4)->pluck('id'));

        $booking = Booking::updateOrCreate(['booking_number' => 'LAS-DEMO-001'], [
            'customer_id' => $customer->id,
            'category_id' => $categories['Cleaning']->id,
            'service_id' => $serviceModels->first()->id,
            'provider_id' => $provider->id,
            'location' => 'Kilimani, Nairobi',
            'preferred_date' => now()->addDay()->toDateString(),
            'preferred_time' => '09:00',
            'description' => 'Two-bedroom apartment deep clean.',
            'urgency' => 'normal',
            'estimated_price' => 3500,
            'status' => 'assigned',
            'provider_status' => 'accepted',
            'assigned_at' => now(),
        ]);

        Payment::updateOrCreate(['booking_id' => $booking->id], [
            'customer_id' => $customer->id,
            'phone_number' => '254712345678',
            'amount' => 3500,
            'status' => 'pending',
        ]);

        Review::updateOrCreate(['booking_id' => $booking->id, 'customer_id' => $customer->id], [
            'provider_id' => $provider->id,
            'rating' => 5,
            'comment' => 'Fast, professional and easy to book.',
        ]);

        Setting::updateOrCreate(['key' => 'support_phone'], ['value' => '+254 711 000 000']);
        Setting::updateOrCreate(['key' => 'support_whatsapp'], ['value' => '254711000000']);
        Setting::updateOrCreate(['key' => 'service_areas'], ['value' => 'Nairobi, Kiambu, Machakos, Kajiado, Mombasa, Nakuru, Kisumu, Eldoret']);
    }
}
