<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seooptimization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SeooptimizationController extends Controller
{
    /**
     * Display the SEO settings + Sitemap page.
     */
    public function index()
    {
        $seos = Seooptimization::latest()->get();
        return view('admin.seooptimization.index', compact('seos'));
    }

    /**
     * Store a new SEO record.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keywords'         => 'nullable|string|max:1000',
            'author'           => 'nullable|string|max:255',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'google_analytics' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('seooptimization.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        Seooptimization::create($validator->validated());

        return redirect()
            ->route('seooptimization.index')
            ->with('success', 'SEO record created successfully.');
    }

    /**
     * Update an existing SEO record.
     */
    public function update(Request $request, $id)
    {
        $seo = Seooptimization::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'keywords'         => 'nullable|string|max:1000',
            'author'           => 'nullable|string|max:255',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'google_analytics' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('seooptimization.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the validation errors.');
        }

        $seo->update($validator->validated());

        return redirect()
            ->route('seooptimization.index')
            ->with('success', 'SEO record updated successfully.');
    }

    /**
     * Delete an SEO record.
     */
    public function destroy($id)
    {
        Seooptimization::findOrFail($id)->delete();

        return redirect()
            ->route('seooptimization.index')
            ->with('success', 'SEO record deleted successfully.');
    }

    /**
     * Generate the XML sitemap.
     * ⚠️  Returns JSON — called via AJAX fetch() from blade.
     *     Must NOT use redirect(). Always return response()->json().
     */
    public function generateSitemap(Request $request)
    {
        try {
            $path = public_path('sitemap.xml');

            // Check write permission on public/ folder
            if (! is_writable(public_path())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot write to /public directory. Run: chmod 755 public/',
                ], 500);
            }

            $urls    = $this->collectSitemapUrls();
            $xml     = $this->buildSitemapXml($urls);
            $written = file_put_contents($path, $xml);

            if ($written === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to write sitemap.xml. Check server file permissions.',
                ], 500);
            }

            return response()->json([
                'success'   => true,
                'message'   => 'Sitemap generated successfully with ' . count($urls) . ' URLs.',
                'url_count' => count($urls),
                'size'      => number_format(filesize($path) / 1024, 1),
                'modified'  => Carbon::createFromTimestamp(filemtime($path))->format('d M Y, h:i A'),
                'url'       => url('/sitemap.xml'),
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download the sitemap.xml file.
     */
    public function downloadSitemap()
    {
        $path = public_path('sitemap.xml');

        if (! file_exists($path)) {
            return redirect()
                ->route('seooptimization.index', ['tab' => 'sitemap'])
                ->with('error', 'Sitemap not found. Please generate it first.');
        }

        return response()->download($path, 'sitemap.xml', [
            'Content-Type' => 'application/xml',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Private Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Collect all public URLs for the sitemap.
     * Customise: uncomment / add entries for your own routes and models.
     *
     * @return array<array{loc:string, lastmod:string, changefreq:string, priority:string}>
     */
    private function collectSitemapUrls(): array
    {
        $now  = now()->toAtomString();
        $base = rtrim(config('app.url'), '/');

        $urls = [
            [
                'loc'        => $base . '/',
                'lastmod'    => $now,
                'changefreq' => 'daily',
                'priority'   => '1.0',
            ],
        ];

        // ── Static pages ──────────────────────────────────────────────────
        // $pages = ['about', 'contact', 'privacy-policy', 'terms'];
        // foreach ($pages as $slug) {
        //     $urls[] = [
        //         'loc'        => $base . '/' . $slug,
        //         'lastmod'    => $now,
        //         'changefreq' => 'monthly',
        //         'priority'   => '0.6',
        //     ];
        // }

        // ── Dynamic model pages ───────────────────────────────────────────
        // $posts = \App\Models\Post::select('slug', 'updated_at')
        //              ->where('status', 'published')->get();
        // foreach ($posts as $post) {
        //     $urls[] = [
        //         'loc'        => $base . '/blog/' . $post->slug,
        //         'lastmod'    => $post->updated_at->toAtomString(),
        //         'changefreq' => 'weekly',
        //         'priority'   => '0.8',
        //     ];
        // }

        return $urls;
    }

    /**
     * Build a valid XML sitemap string from URL entries.
     */
    private function buildSitemapXml(array $urls): string
    {
        $lines   = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
        $lines[] = '        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $lines[] = '        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9';
        $lines[] = '        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        $lines[] = '';
        $lines[] = '    <!-- Generated by ' . config('app.name', 'Laravel') . ' on ' . now()->format('Y-m-d H:i:s T') . ' -->';
        $lines[] = '';

        foreach ($urls as $entry) {
            $loc        = htmlspecialchars($entry['loc'],        ENT_XML1, 'UTF-8');
            $lastmod    = htmlspecialchars($entry['lastmod'],    ENT_XML1, 'UTF-8');
            $changefreq = htmlspecialchars($entry['changefreq'], ENT_XML1, 'UTF-8');
            $priority   = htmlspecialchars($entry['priority'],   ENT_XML1, 'UTF-8');

            $lines[] = '    <url>';
            $lines[] = "        <loc>{$loc}</loc>";
            $lines[] = "        <lastmod>{$lastmod}</lastmod>";
            $lines[] = "        <changefreq>{$changefreq}</changefreq>";
            $lines[] = "        <priority>{$priority}</priority>";
            $lines[] = '    </url>';
            $lines[] = '';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }
}
