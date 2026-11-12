<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Review;
use App\Models\Service;
use App\Models\Setting;

class HomeController extends Controller
{
    public function __invoke()
    {
        $defaults = [
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

        $content = collect($defaults)->mapWithKeys(fn ($default, $key) => [$key => Setting::valueFor($key, $default)]);

        return view('home', [
            'categories' => Category::where('is_active', true)->with('services')->take(10)->get(),
            'popularServices' => Service::where('is_active', true)->with('category')->take(6)->get(),
            'testimonials' => Review::with(['customer', 'provider'])->latest()->take(3)->get(),
            'content' => $content,
            'homeVideoEmbedUrl' => $this->youtubeEmbedUrl($content['home_video_url']),
        ]);
    }

    private function youtubeEmbedUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $value)) {
            return 'https://www.youtube.com/embed/'.$value;
        }

        $patterns = [
            '/youtu\.be\/([A-Za-z0-9_-]{11})/',
            '/youtube\.com\/watch\?v=([A-Za-z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([A-Za-z0-9_-]{11})/',
            '/youtube\.com\/embed\/([A-Za-z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value, $matches)) {
                return 'https://www.youtube.com/embed/'.$matches[1];
            }
        }

        return null;
    }
}
