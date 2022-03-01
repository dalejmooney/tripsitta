<?php

namespace App\Providers;

use A17\Twill\Models\Feature;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer(['layouts.app', 'layouts.app_home', 'layouts.app_full_hero'], function($view)
        {
            $primary_navigation = Feature::where('bucket_key', 'primary_menu')->with('featured.slugs')->get()->map(function ($feature) {
                if(is_null($feature->featured)) return [];

                return [
                    'title' => $feature->featured->title,
                    'slug'  => $feature->featured->slug
                ];
            });
            $view->with('primary_navigation', $primary_navigation);

            $post = Post::where('published', 1)->orderBy('created_at')->first();
            $view->with('recent_post', $post);

            $mega_menu = Feature::whereIn('bucket_key', ['ex_1', 'ex_2', 'ex_3'])->with('featured.slugs')->get()->map(function ($feature) {
                if(is_null($feature->featured)) return [];

                return collect([
                    'bucket' => $feature->bucket_key,
                    'title' => $feature->featured->title,
                    'slug'  => $feature->featured->slug
                ]);
            });
            $view->with('mega_menu', collect($mega_menu));
        });

        Relation::morphMap([
            'pages' => 'App\Models\Page',
        ]);
    }
}
