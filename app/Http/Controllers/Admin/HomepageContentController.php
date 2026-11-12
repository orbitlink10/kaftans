<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomepageContentController extends Controller
{
    private array $fields = [
        'home_hero_title' => 'Lasafi',
        'home_hero_description' => 'Book vetted cleaners, movers, handymen, pest control, laundry, appliance repair, gardening, CCTV, Wi-Fi and office maintenance teams across Kenya.',
        'home_primary_cta' => 'Book a Service',
        'home_provider_cta' => 'Become a Service Provider',
        'home_whatsapp_cta' => 'Call/WhatsApp Us',
        'home_whatsapp_url' => 'https://wa.me/254711000000',
        'home_services_title' => 'Popular Services',
        'home_services_subtitle' => 'Transparent starting prices in KES.',
        'home_how_title_1' => '1. Choose',
        'home_how_text_1' => 'Select a service, location and preferred time.',
        'home_how_title_2' => '2. Match',
        'home_how_text_2' => 'Dispatch assigns a verified provider for the job.',
        'home_how_title_3' => '3. Pay & Review',
        'home_how_text_3' => 'Pay via M-Pesa STK Push and rate the provider.',
        'home_why_title' => 'Why Choose Us',
        'home_why_text' => 'Verified providers, dispatch support, same-day options, M-Pesa-ready payments, and coverage for homes and businesses.',
        'home_video_url' => '',
        'home_areas_title' => 'Service Areas',
        'home_areas_text' => 'Nairobi, Kiambu, Machakos, Kajiado, Mombasa, Nakuru, Kisumu and Eldoret.',
        'home_testimonials_title' => 'Customer Testimonials',
        'home_empty_testimonials' => 'Customer testimonials will appear here after completed jobs are reviewed.',
        'home_hero_image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=1800&q=80',
    ];

    public function edit()
    {
        $content = collect($this->fields)->mapWithKeys(fn ($default, $key) => [
            $key => Setting::valueFor($key, $default),
        ]);

        return view('admin.homepage.edit', ['content' => $content]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'home_hero_title' => ['required', 'string', 'max:120'],
            'home_hero_description' => ['required', 'string', 'max:500'],
            'home_primary_cta' => ['required', 'string', 'max:80'],
            'home_provider_cta' => ['required', 'string', 'max:80'],
            'home_whatsapp_cta' => ['required', 'string', 'max:80'],
            'home_whatsapp_url' => ['required', 'string', 'max:255'],
            'home_services_title' => ['required', 'string', 'max:120'],
            'home_services_subtitle' => ['nullable', 'string', 'max:255'],
            'home_how_title_1' => ['required', 'string', 'max:80'],
            'home_how_text_1' => ['required', 'string', 'max:255'],
            'home_how_title_2' => ['required', 'string', 'max:80'],
            'home_how_text_2' => ['required', 'string', 'max:255'],
            'home_how_title_3' => ['required', 'string', 'max:80'],
            'home_how_text_3' => ['required', 'string', 'max:255'],
            'home_why_title' => ['required', 'string', 'max:120'],
            'home_why_text' => ['required', 'string', 'max:500'],
            'home_video_url' => ['nullable', 'string', 'max:500'],
            'home_areas_title' => ['required', 'string', 'max:120'],
            'home_areas_text' => ['required', 'string', 'max:500'],
            'home_testimonials_title' => ['required', 'string', 'max:120'],
            'home_empty_testimonials' => ['required', 'string', 'max:255'],
            'home_hero_image' => ['nullable', 'image', 'max:4096'],
            'home_hero_image_url' => ['nullable', 'string', 'max:500'],
        ]);

        foreach (array_keys($this->fields) as $key) {
            if ($key === 'home_hero_image') {
                continue;
            }

            Setting::putValue($key, $data[$key] ?? '');
        }

        if ($request->hasFile('home_hero_image')) {
            Setting::putValue('home_hero_image', $request->file('home_hero_image')->store('homepage', 'public'));
        } elseif (! empty($data['home_hero_image_url'])) {
            Setting::putValue('home_hero_image', $data['home_hero_image_url']);
        }

        return back()->with('success', 'Homepage content updated.');
    }
}
