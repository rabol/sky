<?php

namespace LaraZeus\Sky\Http\Livewire;

use LaraZeus\Sky\SkyPlugin;
use Livewire\Component;

class Posts extends Component
{
    use SearchHelpers;

    public function render()
    {
        $search = request('search');
        $category = request('category');

        $posts = SkyPlugin::get()->getPostModel()::NotSticky()
            ->search($search)
            ->forCategory($category)
            ->published()
            ->orderBy('published_at', 'desc')
            ->get();

        $pages = SkyPlugin::get()->getPostModel()::page()
            ->search($search)
            ->forCategory($category)
            ->orderBy('published_at', 'desc')
            ->whereNull('parent_id')
            ->get();

        $pages = $this->highlightSearchResults($pages, $search);
        $posts = $this->highlightSearchResults($posts, $search);

        $recent = SkyPlugin::get()->getPostModel()::posts()
            ->published()
            ->limit(SkyPlugin::get()->getRecentPostsLimit())
            ->orderBy('published_at', 'desc')
            ->get();

        seo()
            ->site(config('zeus.site_title', 'Laravel'))
            ->title(__('Posts') . ' - ' . config('zeus.site_title'))
            ->description(__('Posts') . ' - ' . config('zeus.site_description') . ' ' . config('zeus.site_title'))
            ->rawTag('favicon', '<link rel="icon" type="image/x-icon" href="' . asset('favicon/favicon.ico') . '">')
            ->rawTag('<meta name="theme-color" content="' . config('zeus.site_color') . '" />')
            ->withUrl()
            ->twitter();

        return view(app('skyTheme') . '.home')->with([
            'posts' => $posts,
            'pages' => $pages,
            'recent' => $recent,
            'tags' => SkyPlugin::get()->getTagModel()::withCount('postsPublished')->where('type', 'category')->get(),
            'stickies' => SkyPlugin::get()->getPostModel()::sticky()->published()->get(),
        ])
            ->layout(config('zeus.layout'));
    }
}
