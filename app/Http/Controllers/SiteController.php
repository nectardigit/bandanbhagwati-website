<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Client;
use App\Models\Category;
use App\Models\ContactSubmission;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{
    public function home()
    {
        return view('index', [
            'equipment'    => Equipment::where('is_active', true)->orderBy('sort')->take(12)->get(),
            'categories'   => Category::where('is_active', true)->orderBy('sort')->take(8)->get(),
            'services'     => Service::where('is_active', true)->where('show_in_accordion', true)->orderBy('sort')->get(),
            'projects'     => Project::where('is_active', true)->where('status', 'completed')->orderBy('sort')->take(12)->get(),
            'ongoing'      => Project::where('is_active', true)->where('status', 'ongoing')->orderBy('sort')->take(12)->get(),
            'testimonials' => Testimonial::where('is_active', true)->orderBy('sort')->get(),
            'faqs'         => Faq::where('is_active', true)->orderBy('sort')->get(),
            'posts'        => BlogPost::published()->latest('published_at')->take(8)->get(),
            'clients'      => Client::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function about()
    {
        return view('about', [
            'services' => Service::where('is_active', true)->where('show_in_accordion', true)->orderBy('sort')->get(),
            'faqs'     => Faq::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function services()
    {
        return view('service', [
            'solutions' => Service::where('is_active', true)->where('show_in_solutions', true)->orderBy('sort')->get(),
            'services'  => Service::where('is_active', true)->where('show_in_accordion', true)->orderBy('sort')->get(),
            'faqs'      => Faq::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function serviceShow(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('service-detail', [
            'service'     => $service,
            'more'        => Service::where('is_active', true)->where('id', '!=', $service->id)->orderBy('sort')->take(6)->get(),
            'faqs'        => Faq::where('is_active', true)->orderBy('sort')->get(),
            'reviewers'   => Testimonial::where('is_active', true)->whereNotNull('photo')->where('photo', '!=', '')->orderBy('sort')->take(5)->get(),
            'clientCount' => Testimonial::where('is_active', true)->count(),
        ]);
    }

    public function equipment(Request $request)
    {
        $items = Equipment::with('category')->where('is_active', true)->orderBy('sort')->get();

        $activeCat = null;
        if ($slug = $request->query('category')) {
            $activeCat = Category::where('slug', $slug)->value('id');
        }

        return view('equipment', [
            'items'      => $items,
            'activeCat'  => $activeCat,
            'categories' => Category::where('is_active', true)
                ->whereIn('id', $items->pluck('category_id')->filter()->unique())
                ->orderBy('sort')->get(),
        ]);
    }

    public function equipmentShow(Equipment $equipment)
    {
        abort_unless($equipment->is_active, 404);

        return view('equipment-detail', [
            'equipment'   => $equipment,
            'more'        => Equipment::where('is_active', true)->where('id', '!=', $equipment->id)->orderBy('sort')->take(6)->get(),
            'faqs'        => Faq::where('is_active', true)->orderBy('sort')->get(),
            'reviewers'   => Testimonial::where('is_active', true)->whereNotNull('photo')->where('photo', '!=', '')->orderBy('sort')->take(5)->get(),
            'clientCount' => Testimonial::where('is_active', true)->count(),
        ]);
    }

    public function equipmentEnquiry(Request $request, Equipment $equipment)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:5000'],
            'captcha' => ['required', $this->captchaRule($request)],
        ]);

        $submission = ContactSubmission::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'] ?? null,
            'subject' => 'Rental enquiry: '.$equipment->name,
            'message' => $data['message'] ?: ('Rental enquiry for '.$equipment->name.'.'),
        ]);

        $to = \App\Models\SiteSetting::get('notify_email', env('MAIL_ADMIN_ADDRESS', 'admin@nectardigit.com'));
        try {
            Mail::raw(
                "New rental enquiry for {$equipment->name}:\n\nName: {$submission->name}\nEmail: {$submission->email}\nPhone: {$submission->phone}\n\n{$submission->message}",
                fn ($m) => $m->to($to)->subject('Rental enquiry — '.$equipment->name)
            );
        } catch (\Throwable $e) {
            // mail transport not configured — enquiry is still stored.
        }

        return back()->with('enquiry_success', 'Thank you! We will contact you about renting '.$equipment->name.'.');
    }

    public function projects()
    {
        return view('project', [
            'ongoing'   => Project::where('is_active', true)->where('status', 'ongoing')->orderBy('sort')->get(),
            'completed' => Project::where('is_active', true)->where('status', 'completed')->orderBy('sort')->get(),
        ]);
    }

    public function projectShow(Project $project)
    {
        abort_unless($project->is_active, 404);

        return view('project-detail', [
            'project' => $project,
            'team'    => TeamMember::where('is_active', true)->orderBy('sort')->take(5)->get(),
        ]);
    }

    public function team()
    {
        return view('team', [
            'members' => TeamMember::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function clients()
    {
        return view('clients', [
            'clients' => Client::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function gallery()
    {
        return view('gallery', [
            'albums' => \App\Models\Album::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function albumShow(\App\Models\Album $album)
    {
        abort_unless($album->is_active, 404);

        return view('album', ['album' => $album]);
    }

    public function blog()
    {
        return view('blog', [
            'posts' => BlogPost::published()->latest('published_at')->paginate(8),
        ]);
    }

    public function blogShow(BlogPost $blogPost)
    {
        abort_unless($blogPost->is_published, 404);

        return view('blog-detail', [
            'post'    => $blogPost,
            'related' => BlogPost::published()->where('id', '!=', $blogPost->id)->latest('published_at')->take(5)->get(),
        ]);
    }

    public function page(Page $page)
    {
        abort_unless($page->is_published, 404);

        return view('page', ['page' => $page]);
    }

    /** Clean URLs: any unmatched single path is tried as a Page slug, else 404. */
    public function fallbackPage(Request $request)
    {
        $page = Page::where('slug', trim($request->path(), '/'))
            ->where('is_published', true)
            ->first();

        abort_unless($page, 404);

        return view('page', ['page' => $page]);
    }

    public function sitemap()
    {
        $base = rtrim(config('app.site_url'), '/');
        $now = now()->toAtomString();
        $urls = [];
        $add = function (string $path, ?string $lastmod, string $freq, string $priority) use (&$urls, $base, $now) {
            $urls[] = ['loc' => $base.$path, 'lastmod' => $lastmod ?: $now, 'freq' => $freq, 'priority' => $priority];
        };

        // Static pages
        $add('/', $now, 'daily', '1.0');
        foreach (['/about' => 'monthly', '/service' => 'weekly', '/equipment' => 'weekly', '/project' => 'weekly', '/team' => 'monthly', '/blog' => 'daily', '/faq' => 'monthly', '/contact' => 'yearly'] as $path => $freq) {
            $add($path, $now, $freq, '0.8');
        }

        // Dynamic detail pages
        foreach (Service::where('is_active', true)->get() as $s) {
            $add('/services/'.$s->slug, optional($s->updated_at)->toAtomString(), 'monthly', '0.7');
        }
        foreach (Equipment::where('is_active', true)->get() as $e) {
            $add('/equipment/'.$e->id, optional($e->updated_at)->toAtomString(), 'monthly', '0.7');
        }
        foreach (Project::where('is_active', true)->get() as $p) {
            $add('/projects/'.$p->slug, optional($p->updated_at)->toAtomString(), 'monthly', '0.7');
        }
        foreach (BlogPost::published()->get() as $b) {
            $add('/blog/'.$b->slug, optional($b->updated_at)->toAtomString(), 'weekly', '0.6');
        }
        foreach (Page::where('is_published', true)->get() as $pg) {
            $add('/'.$pg->slug, optional($pg->updated_at)->toAtomString(), 'monthly', '0.6');
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    public function faqs()
    {
        return view('faq', [
            'faqs' => Faq::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSubmit(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'city'    => ['nullable', 'string', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'captcha' => ['required', $this->captchaRule($request)],
        ]);

        unset($data['captcha']);
        $submission = ContactSubmission::create($data);

        $to = \App\Models\SiteSetting::get('notify_email', env('MAIL_ADMIN_ADDRESS', 'admin@nectardigit.com'));
        try {
            Mail::raw(
                "New contact submission:\n\nName: {$submission->name}\nEmail: {$submission->email}\nCity: {$submission->city}\nPhone: {$submission->phone}\nSubject: {$submission->subject}\n\n{$submission->message}",
                fn ($m) => $m->to($to)->subject('New contact submission — '.($submission->subject ?: 'Website'))
            );
        } catch (\Throwable $e) {
            // Mail transport not configured — submission is still stored.
        }

        return back()->with('contact_success', 'Thank you! Your message has been sent.');
    }

    /** Stateless math-captcha rule: the expected answer is encrypted into a hidden field. */
    private function captchaRule(Request $request): \Closure
    {
        return function ($attribute, $value, $fail) use ($request) {
            try {
                $expected = (int) decrypt($request->input('captcha_token'));
            } catch (\Throwable $e) {
                $fail('The security check expired — please answer the new question.');

                return;
            }
            if ((int) $value !== $expected) {
                $fail('The answer to the security question is incorrect.');
            }
        };
    }

    public function newsletterSubmit(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        Newsletter::firstOrCreate(['email' => $data['email']]);

        return back()->with('newsletter_success', 'Subscribed! Thank you.');
    }
}
