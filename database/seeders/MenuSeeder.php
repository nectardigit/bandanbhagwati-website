<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        /* ---- Header nav ---- */
        $header = [
            ['Home', '/'],
            ['About Us', '/about'],
            ['Services', '/service'],
            ['Equipment', '/equipment'],
            ['Project', '/project'],
            ['Team', '/team'],
            ['Blog', '/blog'],      // parent (dropdown)
            ['Connect', '/contact'],
        ];
        $blogParent = null;
        foreach ($header as $i => [$label, $url]) {
            $item = MenuItem::updateOrCreate(
                ['label' => $label, 'location' => 'header', 'parent_id' => null],
                ['url' => $url, 'sort' => $i],
            );
            if ($label === 'Blog') {
                $blogParent = $item;
            }
        }

        /* ---- Blog dropdown children ---- */
        if ($blogParent) {
            foreach ([['Blog', '/blog'], ['Blog Detail', '/blog-detail']] as $i => [$label, $url]) {
                MenuItem::updateOrCreate(
                    ['label' => $label, 'location' => 'header', 'parent_id' => $blogParent->id],
                    ['url' => $url, 'sort' => $i],
                );
            }
        }

        /* ---- Footer: Company column ---- */
        $company = [
            ['About us', '/about'],
            ['Our Services', '/service'],
            ['Contact us', '/contact'],
            ['Meet the Team', '/team'],
            ['Blog / News', '/blog'],
            ['Our Project', '/project'],
        ];
        foreach ($company as $i => [$label, $url]) {
            MenuItem::updateOrCreate(
                ['label' => $label, 'location' => 'footer_company', 'parent_id' => null],
                ['url' => $url, 'sort' => $i],
            );
        }

        /* ---- Footer: Quick Links column ---- */
        $quick = [
            ['Terms & Conditions', '#'],
            ['Customer Support', '/contact'],
            ['FAQ', '#'],
            ['Privacy Policy', '#'],
            ['Projects / Portfolio', '/project'],
        ];
        foreach ($quick as $i => [$label, $url]) {
            MenuItem::updateOrCreate(
                ['label' => $label, 'location' => 'footer_quick', 'parent_id' => null],
                ['url' => $url, 'sort' => $i],
            );
        }
    }
}
