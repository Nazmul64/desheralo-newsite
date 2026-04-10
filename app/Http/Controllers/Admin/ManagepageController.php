<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Managepage;
use Illuminate\Http\Request;

class ManagepageController extends Controller
{
    /**
     * Show the settings overview page.
     */
    public function index()
    {
        $page = Managepage::first();
        return view('admin.managepage.index', compact('page'));
    }

    /**
     * Show the create form.
     * Only accessible when no record exists yet.
     */
    public function create()
    {
        if (Managepage::exists()) {
            return redirect()->route('managepage.index')
                ->with('success', 'Settings already exist. You can edit them here.');
        }

        return view('admin.managepage.create');
    }

    /**
     * Store a brand-new settings record.
     */
    public function store(Request $request)
    {
        if (Managepage::exists()) {
            return redirect()->route('managepage.index')
                ->with('success', 'Settings already exist.');
        }

        $validated = $request->validate([
            // Home One
            'top_category'         => 'required|string|max:255',
            'most_popular_title'   => 'required|string|max:255',
            'stay_connected_title' => 'required|string|max:255',
            'follower_text_one'    => 'required|string|max:255',
            'follower_text_two'    => 'required|string|max:255',
            'follower_text_three'  => 'required|string|max:255',
            'follower_text_four'   => 'required|string|max:255',
            'dont_miss_title'      => 'required|string|max:255',
            // Home Two
            'breaking_news_title'  => 'required|string|max:255',
            'trending_news_title'  => 'required|string|max:255',
            'weekly_reviews'       => 'required|string|max:255',
            'editors_picks'        => 'required|string|max:255',
            'button_text'          => 'required|string|max:255',
            'feature_post'         => 'required|string|max:255',
            'feature_video_title'  => 'required|string|max:255',
            // Menu Title
            'menu_title_one'       => 'required|string|max:255',
            'menu_title_two'       => 'required|string|max:255',
            // All Pages
            'home_title'           => 'required|string|max:255',
            'popular_post_title'   => 'required|string|max:255',
            'gallery_title'        => 'required|string|max:255',
            'recent_post_title'    => 'required|string|max:255',
            'tag_title'            => 'required|string|max:255',
            // Contact Us
            'get_in_touch'         => 'required|string|max:255',
            'address'              => 'required|string|max:255',
            'phone_text'           => 'required|string|max:255',
            'email_text'           => 'required|string|max:255',
            'form_button_text'     => 'required|string|max:255',
            // Footer Section
            'post_title'           => 'required|string|max:255',
            'news'                 => 'required|string|max:255',
            'about'                => 'required|string|max:255',
            'news_tags_title'      => 'required|string|max:255',
            'subscribe_text'       => 'required|string|max:255',
        ]);

        Managepage::create($validated);

        return redirect()->route('managepage.index')
            ->with('success', 'Page settings created successfully!');
    }

    /**
     * Show the edit form for a specific record.
     */
    public function edit(string $id)
    {
        $page = Managepage::findOrFail($id);
        $section = request('section', 'home_one');

        return view('admin.managepage.edit', compact('page', 'section'));
    }

    /**
     * Update a specific section of the settings record.
     */
    public function update(Request $request, string $id)
    {
        $page    = Managepage::findOrFail($id);
        $section = $request->query('section', 'home_one');

        $rules = match ($section) {
            'home_one' => [
                'top_category'         => 'required|string|max:255',
                'most_popular_title'   => 'required|string|max:255',
                'stay_connected_title' => 'required|string|max:255',
                'follower_text_one'    => 'required|string|max:255',
                'follower_text_two'    => 'required|string|max:255',
                'follower_text_three'  => 'required|string|max:255',
                'follower_text_four'   => 'required|string|max:255',
                'dont_miss_title'      => 'required|string|max:255',
            ],
            'home_two' => [
                'breaking_news_title'  => 'required|string|max:255',
                'trending_news_title'  => 'required|string|max:255',
                'weekly_reviews'       => 'required|string|max:255',
                'editors_picks'        => 'required|string|max:255',
                'button_text'          => 'required|string|max:255',
                'feature_post'         => 'required|string|max:255',
                'feature_video_title'  => 'required|string|max:255',
            ],
            'menu_title' => [
                'menu_title_one' => 'required|string|max:255',
                'menu_title_two' => 'required|string|max:255',
            ],
            'all_pages' => [
                'home_title'           => 'required|string|max:255',
                'popular_post_title'   => 'required|string|max:255',
                'gallery_title'        => 'required|string|max:255',
                'recent_post_title'    => 'required|string|max:255',
                'tag_title'            => 'required|string|max:255',
            ],
            'contact_us' => [
                'get_in_touch'         => 'required|string|max:255',
                'address'              => 'required|string|max:255',
                'phone_text'           => 'required|string|max:255',
                'email_text'           => 'required|string|max:255',
                'form_button_text'     => 'required|string|max:255',
            ],
            'footer_section' => [
                'post_title'           => 'required|string|max:255',
                'news'                 => 'required|string|max:255',
                'about'                => 'required|string|max:255',
                'news_tags_title'      => 'required|string|max:255',
                'subscribe_text'       => 'required|string|max:255',
            ],
            default => [],
        };

        $validated = $request->validate($rules);
        $page->update($validated);

        return redirect()
            ->route('managepage.edit', ['managepage' => $page->id, 'section' => $section])
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Unused resource methods — kept to satisfy the resource route contract.
     */
    public function show(string $id)
    {
        return redirect()->route('managepage.index');
    }

    public function destroy(string $id)
    {
        return redirect()->route('managepage.index');
    }
}
