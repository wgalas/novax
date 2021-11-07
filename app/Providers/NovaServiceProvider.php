<?php

namespace App\Providers;

use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Spatie\BackupTool\BackupTool;
use Illuminate\Support\Facades\Gate;
use Runline\ProfileTool\ProfileTool;
use OptimistDigital\NovaSettings\NovaSettings;
use Laravel\Nova\NovaApplicationServiceProvider;
use DigitalCreative\CollapsibleResourceManager\Resources\Group;
use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\ExternalLink;
use DigitalCreative\CollapsibleResourceManager\Resources\NovaResource;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Laravel\Nova\Fields\Date;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        NovaSettings::addSettingsFields([
            Image::make('Logo'),
            Text::make('Footer Text'),
            Text::make('Company Name'),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array`
     */
    protected function cards()
    {
        return [
            (new \Richardkeep\NovaTimenow\NovaTimenow)->timezones([
                'Africa/Nairobi',
                'America/Mexico_City',
                'Australia/Sydney',
                'Europe/Paris',
                'Asia/Manila',
                'Asia/Tokyo',
            ])->defaultTimezone('Africa/Manila'),
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new CollapsibleResourceManager([
                'navigation' => [
                    TopLevelResource::make([
                        'label'=>'RECORDS',
                        'icon' => null,
                        'resources'=>[
                            \App\Nova\Asset::class,
                            Group::make([
                                'label'=>'Stock Reconciliation',
                                'expanded'=>true,
                                'resources'=>[
                                    \App\Nova\Product::class,
                                    \App\Nova\StockTake::class,
                                    \App\Nova\StockReport::class,
                                ]
                            ]),
                        ]
                        ])->canSee(function($request){
                            return !$request->user()->hasRole(\App\Models\Role::SUPERADMIN);
                        }),
                    TopLevelResource::make([
                        'label'=>'ANALYSIS AND EVALUATION',
                        'icon' => null,
                        'resources'=>[
                            \App\Nova\GeneralJournalRemark::class,
                            ExternalLink::make([
                                'label' => 'T Accounts',
                                'badge' => null,
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>',
                                'target' => '_blank',
                                'url' => '/t-accounts',
                            ]),
                            ExternalLink::make([
                                'label' => 'Trial balance',
                                'badge' => null,
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>',
                                'target' => '_blank',
                                'url' => '/trial-balance',
                            ])
                        ]
                    ])->canSee(function($request){
                        return !$request->user()->hasRole(\App\Models\Role::SUPERADMIN);
                    }),
                    TopLevelResource::make([
                        'label'=> 'Settings',
                        'icon'=>null,
                        'resources'=>[
                            \App\Nova\User::class,
                            \App\Nova\Location::class,
                            \App\Nova\Account::class,
                            \App\Nova\AccountingPeriod::class,
                        ]
                        ]),
                        TopLevelResource::make([
                            'label'=> 'Access',
                            'icon'=>null,
                            'resources'=>[
                                \App\Nova\Role::class,
                            ]
                        ])
                ]
                ]),
            new ProfileTool,
            (new BackupTool)->canSee(function ($request) {
                return $request->user()->hasRole(\App\Models\Role::SUPERADMIN);
            }),
            (new NovaSettings)->canSee(function ($request) {
                return $request->user()->hasRole(\App\Models\Role::SUPERADMIN);
            }),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
