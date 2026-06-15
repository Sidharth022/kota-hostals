<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h2>About KotaHostel</h2><p>KotaHostel is Kota\'s premier accommodation directory, designed specifically to help coaching students find clean, safe, and study-conducive hostels and PGs near their respective institutes.</p><p>We inspect properties physically before listing, ensuring verified information on distance, rent, food hygiene, and security protocols.</p>',
                'seo_title' => 'About KotaHostel - Premium Student Lodging in Kota',
                'seo_description' => 'Learn about our mission to help students find clean, safe, and verified hostels in Kota near major coaching institutes.',
                'status' => true,
            ],
            [
                'title' => 'Frequently Asked Questions',
                'slug' => 'faq',
                'content' => '<h2>Frequently Asked Questions</h2><h3>How do I book a hostel?</h3><p>You can send an inquiry directly to the hostel owner from their details page. The owner will contact you on your registered mobile number to confirm availability and discuss booking payments.</p><h3>Are the rents listed correct?</h3><p>Yes, all rents are verified by our team during property audits. There are no middle-men charges or broker commissions.</p><h3>What is the verification process?</h3><p>Our Kota team visits each hostel to confirm building security, fire exits, food hygiene, study environment, and distances to coaching classes.</p>',
                'seo_title' => 'FAQs - Common Questions about shortlisting hostels in Kota',
                'seo_description' => 'Find answers to common questions about booking, amenities, rules, and verifications on KotaHostel.',
                'status' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '<h2>Privacy Policy</h2><p>At KotaHostel, we respect your privacy. This policy outlines how we collect, store, and share your personal data when you use our inquiry and registration forms.</p><p>We share inquiry information (name, mobile) directly with the relevant hostel owners so they can contact you. We do not sell your personal data to third-party advertisers.</p>',
                'seo_title' => 'Privacy Policy - KotaHostel',
                'seo_description' => 'Read our policy on user data safety, sharing, cookies, and privacy standards at KotaHostel.',
                'status' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms',
                'content' => '<h2>Terms of Service</h2><p>Welcome to KotaHostel. By browsing our platform, sending inquiries, or registering as an owner, you agree to comply with our terms and guidelines.</p><p>All users must provide accurate names and mobile numbers. Owners must upload real property photographs and correct rent metrics. We reserve the right to suspend accounts violating these standards.</p>',
                'seo_title' => 'Terms of Service - KotaHostel guidelines',
                'seo_description' => 'Review legal terms, guidelines, user agreements, and disclaimer protocols of KotaHostel.',
                'status' => true,
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<h2>Contact Support</h2><p>Have questions or need assistance? Reach out to our Kota support desk.</p><p>Email: support@kotahostel.com<br>Support Helpline: +91 98765 43210 (9:00 AM - 6:00 PM)</p>',
                'seo_title' => 'Contact Us - Get Support on KotaHostel',
                'seo_description' => 'Get in touch with our team for questions about lodging, list placements, or partner options.',
                'status' => true,
            ],
        ];

        foreach ($pages as $p) {
            Page::create($p);
        }
    }
}
