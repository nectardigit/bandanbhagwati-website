<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use App\Models\Equipment;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LocalizeImages extends Command
{
    protected $signature = 'images:localize';

    protected $description = 'Download remote (Unsplash) frontend images into the file manager (storage/app/public/photos/1/<folder>) and repoint records to the local copies.';

    /** url => /storage path (so shared images are downloaded only once) */
    private array $cache = [];

    private int $downloaded = 0;

    public function handle(): int
    {
        $this->localizeField(Equipment::all(), 'image', 'equipment');
        $this->localizeField(Project::all(), 'cover_image', 'projects');
        $this->localizeArray(Project::all(), 'gallery', 'projects/gallery');
        $this->localizeField(TeamMember::all(), 'photo', 'team');
        $this->localizeField(BlogPost::all(), 'cover_image', 'blog');
        $this->localizeField(Testimonial::all(), 'photo', 'testimonials');
        $this->localizeField(Service::all(), 'image', 'services');

        $this->newLine();
        $this->info("Done. {$this->downloaded} image(s) downloaded into the file manager (photos/1/...).");

        return self::SUCCESS;
    }

    private function isRemote($v): bool
    {
        return is_string($v) && Str::startsWith($v, ['http://', 'https://']);
    }

    private function filename(string $url): string
    {
        $base = preg_replace('/[^A-Za-z0-9\-_]/', '', basename((string) parse_url($url, PHP_URL_PATH)));

        return ($base ?: 'img-'.substr(md5($url), 0, 8)).'.jpg';
    }

    private function download(string $url, string $folder): ?string
    {
        if (isset($this->cache[$url])) {
            return $this->cache[$url];
        }

        $rel = "photos/1/{$folder}/".$this->filename($url);

        if (! Storage::disk('public')->exists($rel)) {
            try {
                $res = Http::withoutVerifying()->timeout(40)->get($url);
                if (! $res->successful()) {
                    $this->warn("  ✗ {$url} (HTTP {$res->status()})");

                    return null;
                }
                Storage::disk('public')->put($rel, $res->body());
                $this->downloaded++;
            } catch (\Throwable $e) {
                $this->warn("  ✗ {$url} ({$e->getMessage()})");

                return null;
            }
        }

        return $this->cache[$url] = '/storage/'.$rel;
    }

    private function localizeField($items, string $field, string $folder): void
    {
        $this->line("→ {$folder} ({$field})");
        foreach ($items as $m) {
            if ($this->isRemote($m->{$field})) {
                if ($local = $this->download($m->{$field}, $folder)) {
                    $m->{$field} = $local;
                    $m->save();
                    $this->line('  ✓ '.basename($local));
                }
            }
        }
    }

    private function localizeArray($items, string $field, string $folder): void
    {
        $this->line("→ {$folder} ({$field})");
        foreach ($items as $m) {
            $arr = $m->{$field};
            if (! is_array($arr) || empty($arr)) {
                continue;
            }
            $changed = false;
            $new = [];
            foreach ($arr as $v) {
                if ($this->isRemote($v) && ($local = $this->download($v, $folder))) {
                    $new[] = $local;
                    $changed = true;
                } else {
                    $new[] = $v;
                }
            }
            if ($changed) {
                $m->{$field} = $new;
                $m->save();
            }
        }
    }
}
