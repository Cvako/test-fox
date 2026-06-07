<?php

namespace App\Providers;

use App;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Submission;
use App\Models\Setting;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    public function boot(Dispatcher $events)
    {
        $this->app->singleton('site_lang', function () {

            // Retrieve settings
            $site_settings = Setting::get();

            foreach ($site_settings as $setting) {
                $settings[$setting->name] = $setting->value;
            }

            return $settings['site_language'];

        });

        // Set default site language
        App::setLocale(app('site_lang'));

        Paginator::useBootstrap();
        $this->loadViewsFrom(__DIR__ . '/views/vendor/frontend', 'frontend');
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $event->menu->addAfter('fullscreen-widget', [
                'key' => 'stations',
                'text' => __('admin.stations'),
                'icon' => 'fas fa-fw fa-headphones mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.stations'),
                        'active' => [env('ADMIN_URL'), env('ADMIN_URL') . '/stations/*/edit', env('ADMIN_URL') . '/stations/sort'],
                        'url' => env('ADMIN_URL') . '/stations',
                    ],
                    [
                        'text' => __('admin.create_station'),
                        'url' => env('ADMIN_URL') . '/stations/create',
                    ],
                ],
            ]);
            
        $event->menu->addAfter('stations', [
                'key' => 'api',
                'text' => __('admin.api'),
                'icon' => 'fas fa-fw fa-cloud mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.api'),
                        'active' => [env('ADMIN_URL') . '/api/*'],
                        'url' => env('ADMIN_URL') . '/api',
                    ],
                ],
            ]);

            $event->menu->addAfter('api', [
                'key' => 'genres',
                'text' => __('admin.genres'),
                'icon' => 'fas fa-fw fa-music mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.genres'),
                        'active' => [env('ADMIN_URL') . '/genres/*/edit', env('ADMIN_URL') . '/genres/sort', env('ADMIN_URL') . '/genres/sort_home'],
                        'url' => env('ADMIN_URL') . '/genres',
                    ],
                    [
                        'text' => __('admin.create_genre'),
                        'url' => env('ADMIN_URL') . '/genres/create',
                    ],
                ],
            ]);

            $event->menu->addAfter('genres', [
                'key' => 'countries',
                'text' => __('admin.countries'),
                'icon' => 'fas fa-fw fa-flag mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.countries'),
                        'active' => [env('ADMIN_URL') . '/countries/*/edit', env('ADMIN_URL') . '/countries/sort'],
                        'url' => env('ADMIN_URL') . '/countries',
                    ],
                    [
                        'text' => __('admin.create_country'),
                        'url' => env('ADMIN_URL') . '/countries/create',
                    ],
                ],
            ]);

            $event->menu->addAfter('countries', [
                'key' => 'languages',
                'text' => __('admin.languages'),
                'icon' => 'fas fa-fw fa-language mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.languages'),
                        'active' => [env('ADMIN_URL') . '/languages/*/edit', env('ADMIN_URL') . '/languages/sort'],
                        'url' => env('ADMIN_URL') . '/languages',
                    ],
                    [
                        'text' => __('admin.create_language'),
                        'url' => env('ADMIN_URL') . '/languages/create',
                    ],
                ],
            ]);

            $event->menu->addAfter('languages', [
                'key' => 'pages',
                'text' => __('admin.pages'),
                'icon' => 'fas fa-fw fa-file mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.pages'),
                        'active' => [env('ADMIN_URL') . '/pages/*/edit'],
                        'url' => env('ADMIN_URL') . '/pages',
                    ],
                    [
                        'text' => __('admin.create_page'),
                        'url' => env('ADMIN_URL') . '/pages/create',
                    ],
                ],
            ]);

            $event->menu->addAfter('pages', [
                'key' => 'faqs',
                'text' => __('admin.faqs'),
                'icon' => 'fas fa-fw fa-question-circle mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.faqs'),
                        'active' => [env('ADMIN_URL') . '/faqs/*/edit'],
                        'url' => env('ADMIN_URL') . '/faqs',
                    ],
                    [
                        'text' => __('admin.create_faq'),
                        'url' => env('ADMIN_URL') . '/faqs/create',
                    ],
                ],
            ]);

            $event->menu->addAfter('faqs', [
                'key' => 'ads',
                'text' => __('admin.ads'),
                'active' => [env('ADMIN_URL') . '/ads/*/edit'],
                'url' => env('ADMIN_URL') . '/ads',
                'icon' => 'fas fa-fw fa-flag mr-1',
            ]);
            
              $pending_submissions = Submission::count('id');

            if ($pending_submissions >= 1) {
                $event->menu->addAfter('ads', [
                    'key' => 'submissions',
                    'text' => __('admin.submissions'),
                    'active' => [env('ADMIN_URL') . '/submissions/*'],
                    'url' => env('ADMIN_URL') . '/submissions',
                    'icon' => 'fas fa-fw fa-file-import mr-1',
                    'label' => $pending_submissions,
                    'label_color' => 'success',
                ]);
            } else {
                $event->menu->addAfter('ads', [
                    'key' => 'submissions',
                    'text' => __('admin.submissions'),
                    'url' => env('ADMIN_URL') . '/submissions',
                    'icon' => 'fas fa-fw fa-file-import mr-1',
                ]);
            }
            
               $pending_comments = Comment::where('approval', '0')->count('id');

            if ($pending_comments >= 1) {
                $event->menu->addAfter('submissions', [
                    'key' => 'comments',
                    'text' => __('admin.comments'),
                    'url' => env('ADMIN_URL') . '/comments',
                    'icon' => 'fas fa-fw fa-comments mr-1',
                    'label' => $pending_comments,
                    'label_color' => 'warning',
                ]);
            } else {
                $event->menu->addAfter('submissions', [
                    'key' => 'comments',
                    'text' => __('admin.comments'),
                    'url' => env('ADMIN_URL') . '/comments',
                    'icon' => 'fas fa-fw fa-comments mr-1',
                ]);
            }

            $event->menu->addAfter('comments', [
                'key' => 'settings',
                'text' => __('admin.settings'),
                'icon' => 'fas fa-fw fa-cog mr-1',
                'submenu' => [
                    [
                        'text' => __('admin.general_settings'),
                        'url' => env('ADMIN_URL') . '/general_settings',
                    ],
                    [
                        'text' => __('admin.seo_settings'),
                        'url' => env('ADMIN_URL') . '/seo_settings',
                    ],
                    [
                        'text' => __('admin.pwa_settings'),
                        'url' => env('ADMIN_URL') . '/pwa_settings',
                    ],
                    [
                    'active' => [env('ADMIN_URL') . '/error_handling/*'],
                        'text' => __('admin.error_handling'),
                        'url' => env('ADMIN_URL') . '/error_handling',
                    ],
                    [
                        'active' => [env('ADMIN_URL') . '/translations/*/edit', env('ADMIN_URL') . '/translations/create'],
                        'text' => __('admin.translations'),
                        'url' => env('ADMIN_URL') . '/translations',
                    ],
                ],
            ]);

            $pending_reports = Report::where('solved', '0')->count('id');

            if ($pending_reports >= 1) {
                $event->menu->addAfter('settings', [
                    'key' => 'reports',
                    'text' => __('admin.reports'),
                    'url' => env('ADMIN_URL') . '/reports',
                    'icon' => 'fas fa-fw fa-exclamation-triangle mr-1',
                    'label' => $pending_reports,
                    'label_color' => 'danger',
                ]);
            } else {
                $event->menu->addAfter('settings', [
                    'key' => 'reports',
                    'text' => __('admin.reports'),
                    'url' => env('ADMIN_URL') . '/reports',
                    'icon' => 'fas fa-fw fa-exclamation-triangle mr-1',
                ]);
            }

            $event->menu->addAfter('reports', [
                'key' => 'account_settings',
                'text' => __('admin.account_settings'),
                'url' => env('ADMIN_URL') . '/account_settings',
                'icon' => 'fas fa-fw fa-lock',
            ]);

            $event->menu->addAfter('account_settings', [
                'type' => 'link',
                'id' => 'clear_cache',
                'text' => __('admin.clear_cache'),
                'icon' => 'fas fa-fw fa-bolt',
                'url' => asset(env('ADMIN_URL') . '/general_settings/clear_cache'),
            ]);

            $event->menu->addBefore('app_ver', [
                'type' => 'link',
                'id' => 'documentation',
                'text' => __('admin.documentation'),
                'icon' => 'fas fa-fw fa-book',
                'target' => '_blank',
                'url' => 'https://docs-radio-portal.foxart.co',
          ]);

            $event->menu->addBefore('fullscreen-widget', [
                'key' => 'navbar_search',
                'type' => 'navbar-search',
                'text' => 'search',
                'topnav_right' => true,
            ]);

            $event->menu->addBefore('navbar_search', [
                'key' => 'browse_site',
                'type' => 'link',
                'text' => __('admin.browse_site'),
                'url' => '/',
                'target' => '_blank',
                'icon' => 'fas fa-external-link-alt mr-1',
                'topnav_right' => true,
            ]);
  

        });
    }
}
