<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    private function img(string $id, int $w = 800): string
    {
        return "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w={$w}&q=80";
    }

    public function run(): void
    {
        $lorem = 'Magna reprehenderit tempor do elit mollit officia fugiat ullamco duis ex aute quis. Est excepteur velit incididunt laborum nulla minim.';
        $faqAnswer = 'Fusce lacinia nulla consequat porta et viverra velit etiam, varius per condimentum lacus ultricies a placerat venatis semper donec id accumsan augue eleifend facili sis. Lectus arcu odio erat congue sociosqu ultricies';

        /* ---------- Categories ---------- */
        $cats = [
            ['🚜', 'Earthmoving', 'Machines for digging, grading, and moving soil.'],
            ['📦', 'Material Handling', 'Tools and machines for lifting, moving, and storing materials.'],
            ['🛠️', 'Concrete', 'Machines for mixing, transporting, and placing concrete.'],
            ['🏗️', 'Drilling & Piling', 'Equipment for drilling holes and driving piles into the ground.'],
            ['⛏️', 'Tunneling', 'Machines used to excavate and construct tunnels underground.'],
            ['📐', 'Surveying Instruments', 'Tools for measuring land, distance, and site levels accurately.'],
            ['🧱', 'Scaffolding & Formwork', 'Support structures for workers and concrete shaping.'],
            ['🏗️', 'Cranes & Hoists', 'Equipment for lifting and moving heavy loads.'],
        ];
        foreach ($cats as $i => $c) {
            Category::updateOrCreate(['slug' => Str::slug($c[1]).'-'.$i], [
                'name' => $c[1], 'icon' => $c[0], 'description' => $c[2], 'sort' => $i,
            ]);
        }

        /* ---------- Equipment ---------- */
        $equipment = [
            ['TATA Tipper Truck', '1581094794329-c8112a89af12'],
            ['Caterpillar Mobile Crane', '1599058917765-a780eda07a3e'],
            ['JCB Excavator', '1530124566582-a618bc2615dc'],
            ['Doosan Wheel Loader', '1567789884554-0b844b597180'],
        ];
        foreach ($equipment as $i => $e) {
            Equipment::updateOrCreate(['name' => $e[0]], [
                'title' => $e[0],
                'description' => 'Heavy-duty equipment for large construction projects.',
                'image' => $this->img($e[1], 700),
                'sort' => $i,
            ]);
        }

        /* ---------- Services: solutions grid ---------- */
        $solutions = [
            ['building', 'Building Construction'],
            ['renovate', 'Commercial Renovate'],
            ['robot', 'Automation & Robotics'],
            ['home', 'Residential Construction'],
            ['blueprint', 'Architecture Design'],
            ['crane', 'Structural Engineering'],
            ['tower', 'High-Rise Construction'],
            ['building', 'Renovation Planning'],
        ];
        foreach ($solutions as $i => $s) {
            Service::updateOrCreate(['slug' => Str::slug($s[1])], [
                'title' => $s[1],
                'icon' => $s[0],
                'short_description' => 'After more than twenty years of success in the wood products industry.',
                'body' => "<p>{$lorem}</p>",
                'show_in_solutions' => true,
                'show_in_accordion' => false,
                'sort' => $i,
            ]);
        }

        /* ---------- Services: accordion list ---------- */
        $accordion = [
            'Road Works',
            'Irrigation and water supply',
            'Government Building Construction',
            'Privat Commercial Building',
            'Industrial / Bridge Construction',
        ];
        foreach ($accordion as $i => $title) {
            Service::updateOrCreate(['slug' => Str::slug($title)], [
                'title' => $title,
                'short_description' => 'Delivering reliable, innovative, and high-quality construction solutions.',
                'body' => "<p>{$lorem}</p>",
                'show_in_solutions' => false,
                'show_in_accordion' => true,
                'sort' => 100 + $i,
            ]);
        }

        /* ---------- Projects ---------- */
        $specs = [
            ['label' => 'Total Floor Area', 'value' => '1.2m sq ft'],
            ['label' => 'Number of Floors', 'value' => '15 Floors'],
            ['label' => 'Parking Spaces', 'value' => '500 Spaces'],
            ['label' => 'Office Units', 'value' => '200 Units'],
            ['label' => 'Green Certification', 'value' => 'LEED Gold'],
        ];
        $features = [
            ['icon' => '🏛️', 'title' => 'Modern Architecture'],
            ['icon' => '🏢', 'title' => 'Smart Building'],
            ['icon' => '♻️', 'title' => 'Sustainable Design'],
            ['icon' => '🛡️', 'title' => 'Advanced Security'],
            ['icon' => '📶', 'title' => 'High-Speed Connectivity'],
            ['icon' => '🅿️', 'title' => 'Smart Parking'],
        ];
        $features = array_map(fn ($f) => $f + ['text' => 'Contemporary design with glass facade and steel structure'], $features);
        $gallery = array_map(fn ($id) => $this->img($id, 600), [
            '1503387762-592deb58ef4e', '1541888946425-d81bb19240f5', '1504307651254-35680f356dfd', '1473341304170-971dccb5ac1e',
            '1581094794329-c8112a89af12', '1486718448742-163732cd1544', '1521791136064-7986c2920216', '1454165804606-c3d57bc86b40',
        ]);

        $ongoingImgs = ['1545324418-cc1a3fa10c00', '1486718448742-163732cd1544', '1529655683826-aba9b3e77383', '1496307653780-42ee777d4833'];
        $completedImgs = ['1564013799919-ab600027ffc6', '1480714378408-67cf0d13bc1b', '1487958449943-2429e8be8625', '1503387762-592deb58ef4e', '1494891848038-7bd202a2afeb', '1460472178825-e5240623afd5'];

        $bodyHtml = "<p>{$lorem}</p><p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>";

        foreach ($ongoingImgs as $i => $id) {
            Project::updateOrCreate(['slug' => 'ongoing-project-'.($i + 1)], [
                'title' => 'Ongoing Project '.($i + 1), 'caption' => 'Building', 'client' => 'Google Company',
                'status' => 'ongoing', 'cover_image' => $this->img($id, 600), 'body' => $bodyHtml,
                'progress' => 85, 'specs' => $specs, 'features' => $features, 'gallery' => $gallery,
                'is_featured' => true, 'sort' => $i,
            ]);
        }
        foreach ($completedImgs as $i => $id) {
            Project::updateOrCreate(['slug' => 'completed-project-'.($i + 1)], [
                'title' => 'Completed Project '.($i + 1), 'caption' => 'Building', 'client' => 'Google Company',
                'status' => 'completed', 'cover_image' => $this->img($id, 600), 'body' => $bodyHtml,
                'progress' => 100, 'specs' => $specs, 'features' => $features, 'gallery' => $gallery,
                'is_featured' => true, 'sort' => $i,
            ]);
        }

        /* ---------- Team ---------- */
        $team = [
            ['1573496359142-b8d87734a5a2', 'Vincent smith', 'Industrial Engineer and CEO'],
            ['1500648767791-00dcc994a43e', 'Aarav Sharma', 'Project Manager'],
            ['1438761681033-6461ffad8d80', 'Sita Gurung', 'Site Engineer'],
            ['1507003211169-0a1dd7228f2d', 'Bikash Thapa', 'Civil Engineer'],
            ['1494790108377-be9c29b29330', 'Maya Rai', 'Architect'],
            ['1517841905240-472988babdf9', 'Anjali Karki', 'Safety Officer'],
            ['1573497019940-1c28c88b4f3e', 'Priya Lama', 'Structural Engineer'],
            ['1519085360753-af0119f7cbe7', 'Rohan Magar', 'Surveyor'],
            ['1487412720507-e7ab37603c6f', 'Nisha Shah', 'Design Lead'],
            ['1463453091185-61582044d556', 'Kiran Adhikari', 'Foreman'],
        ];
        foreach ($team as $i => $t) {
            TeamMember::updateOrCreate(['name' => $t[1]], [
                'role' => $t[2], 'photo' => $this->img($t[0], 500),
                'facebook' => '#', 'instagram' => '#', 'twitter' => '#', 'linkedin' => '#', 'youtube' => '#',
                'sort' => $i,
            ]);
        }

        /* ---------- Blog ---------- */
        $blogImgs = ['1504307651254-35680f356dfd', '1503387762-592deb58ef4e', '1521791136064-7986c2920216', '1454165804606-c3d57bc86b40', '1581094794329-c8112a89af12', '1486718448742-163732cd1544', '1531297484001-80022131f5a1', '1567016432779-094069958ea5'];
        $blogBody = "<p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin.</p><p>{$lorem}</p>";
        foreach ($blogImgs as $i => $id) {
            BlogPost::updateOrCreate(['slug' => 'good-buildings-come-from-good-people-'.($i + 1)], [
                'title' => 'A Guide To Hassle-Free Cross-Border Shipping',
                'author' => 'Bandhan Nirman',
                'cover_image' => $this->img($id, 800),
                'excerpt' => 'Good buildings come from good people.',
                'body' => $blogBody,
                'published_at' => '2025-08-20',
                'is_published' => true,
            ]);
        }

        /* ---------- Testimonials ---------- */
        Testimonial::updateOrCreate(['name' => 'Williams smith'], [
            'role' => 'CEO', 'photo' => $this->img('1494790108377-be9c29b29330', 300),
            'quote' => 'Bauer X did an excellent job from the conceptual stage through the finished construction of our new office. Our FAQ section is designed to provide clear answers to the most common questions our clients have about our construction services.',
            'rating' => 5, 'brand' => 'ISHPAT', 'sort' => 0,
        ]);

        /* ---------- FAQs ---------- */
        for ($i = 0; $i < 5; $i++) {
            Faq::updateOrCreate(['question' => 'What construction services do you provide?', 'sort' => $i], [
                'answer' => $faqAnswer,
            ]);
        }

        /* ---------- About page ---------- */
        AboutContent::updateOrCreate(['id' => 1], [
            'banner_title' => 'About Us',
            'eyebrow'      => 'About',
            'heading'      => 'Turning Your Vision into Reality, Starting with the Basics',
            'features'     => [
                ['title' => "Validate your manufacturer's warranty", 'text' => $lorem],
                ['title' => "Validate your manufacturer's warranty", 'text' => $lorem],
            ],
            'card_one'     => 'Building quality standards',
            'card_two'     => "Certified engineer's team",
            'years_label'  => '10+ years',
            'years_sub'    => 'of experience',
            'explore_url'  => '/service',
            'cta_eyebrow'  => 'Contactat Us Anytime',
            'cta_heading'  => "Have a Project in Mind? Let's Talk.",
            'cta_text'     => 'Bandan Bhagwato is a sacred expression of devotion and cultural unity. It represents the deep bond between faith, tradition, and community, bringing people together in reverence and shared belief. Rooted in spiritual values, Bandan Bhagwato stands as a meaningful symbol of harmony and purpose.',
        ]);

        /* ---------- Site settings ---------- */
        $settings = [
            'company_name'  => 'BANDAN BHAGWATI',
            'company_sub'   => 'NIRMAN SEWA PVT. LTD.',
            'address'       => 'Sundhara kathmandu, nepal',
            'email'         => 'bandanbhagwati@gmail.com',
            'phone'         => '+977-9825252525',
            'phone2'        => '98262622626',
            'social_facebook'  => '#',
            'social_instagram' => '#',
            'social_twitter'   => '#',
            'social_linkedin'  => '#',
            'social_youtube'   => '#',
            'language_label' => 'English',
            'support_label'  => 'Support',
            'support_url'    => '#',
            'talk_label'     => "Let's Talk",
            'talk_url'       => '/contact',
            'favicon'       => '',
            'hero_video'    => '',
            'hero_image'    => '',
            'hero_kicker'   => 'We Developed Landmark Real Estate Projects.',
            'hero_title'    => 'We Your Trusted Construction Partner',
            'hero_subtitle' => 'We turn complex challenges into simple, effective solutions. Delivering every project on time, across Nepal.',
            'stat_awards'   => '40+',
            'stat_projects' => '80+',
            'stat_team'     => '60+',
            'stat_clients'  => '99+',
            'footer_about'  => 'Bandan Bhagwati is a sacred celebration symbolizing unity, devotion, and cultural heritage.',
            'notify_email'  => 'admin@nectardigit.com',
        ];
        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
