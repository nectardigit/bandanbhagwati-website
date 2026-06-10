<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchThemedImages extends Command
{
    protected $signature = 'images:fetch-themed';

    protected $description = 'Download themed construction images (loremflickr / Flickr CC) into the file manager and assign them to the hero, team, projects and galleries.';

    private int $count = 0;

    /** Download a keyword-themed image into photos/1/<folder>/<name>.jpg, return its /storage path. */
    private function fetch(string $keywords, int $w, int $h, int $lock, string $folder, string $name): ?string
    {
        $url = "https://loremflickr.com/{$w}/{$h}/{$keywords}?lock={$lock}";
        $rel = "photos/1/{$folder}/{$name}.jpg";

        try {
            $res = Http::withoutVerifying()->timeout(45)->get($url);
            if (! $res->successful() || strlen($res->body()) < 2000) {
                $this->warn("  ✗ {$keywords} (lock {$lock})");

                return null;
            }
            Storage::disk('public')->put($rel, $res->body());
            $this->count++;
            $this->line("  ✓ {$folder}/{$name}.jpg");

            return '/storage/'.$rel;
        } catch (\Throwable $e) {
            $this->warn("  ✗ {$keywords}: {$e->getMessage()}");

            return null;
        }
    }

    public function handle(): int
    {
        /* ---- Hero banner ---- */
        $this->line('→ Hero banner');
        if ($hero = $this->fetch('construction,skyline,sunset', 1920, 1000, 50, 'hero', 'hero')) {
            SiteSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $hero]);
        }

        /* ---- Team / worker photos ---- */
        $this->line('→ Team photos');
        foreach (TeamMember::orderBy('sort')->get()->values() as $i => $member) {
            if ($p = $this->fetch('construction,worker,engineer', 600, 720, $i + 1, 'team', 'team-'.($i + 1))) {
                $member->update(['photo' => $p]);
            }
        }

        /* ---- "Showcasing Our Work" — completed project covers ---- */
        $this->line('→ Completed project covers');
        foreach (Project::where('status', 'completed')->orderBy('sort')->get()->values() as $i => $project) {
            if ($p = $this->fetch('building,architecture,modern', 900, 680, 11 + $i, 'projects', 'showcase-'.($i + 1))) {
                $project->update(['cover_image' => $p]);
            }
        }

        /* ---- "Work in Action" — ongoing project covers ---- */
        $this->line('→ Ongoing project covers');
        foreach (Project::where('status', 'ongoing')->orderBy('sort')->get()->values() as $i => $project) {
            if ($p = $this->fetch('construction,site,crane', 900, 680, 21 + $i, 'projects', 'ongoing-'.($i + 1))) {
                $project->update(['cover_image' => $p]);
            }
        }

        /* ---- Shared project gallery (project-detail "Work in Pictures") ---- */
        $this->line('→ Project gallery set');
        $gallery = [];
        foreach (range(1, 8) as $n) {
            if ($g = $this->fetch('construction,site,building', 700, 520, 30 + $n, 'projects/gallery', 'gallery-'.$n)) {
                $gallery[] = $g;
            }
        }
        if ($gallery) {
            foreach (Project::all() as $project) {
                $project->update(['gallery' => $gallery]);
            }
        }

        $this->newLine();
        $this->info("Done. {$this->count} themed images downloaded into the file manager (photos/1/…).");

        return self::SUCCESS;
    }
}
