<?php

namespace App\Nova;

use App\Models\User as ModelUser;
use Illuminate\Http\Request;
use Laravel\Nova\Resource as NovaResource;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class Resource extends NovaResource
{
    public static $perPageOptions = [5, 25, 50, 100, 200, 500, 1000];
    public static $showColumnBorders = true;
    public static $tableStyle = 'tight';
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public function authorizedToDelete(Request $request)
    {
        $valid = [
            User::uriKey(),
            Role::uriKey(),
        ];

        if (in_array(self::uriKey(), $valid)) {
            return true;
        }

        return !auth()->user()->hasRole(\App\Models\Role::SUPERADMIN);
    }

    public function authorizedToUpdate(Request $request)
    {
        $valid = [
            User::uriKey(),
            Role::uriKey(),
        ];

        if (in_array(self::uriKey(), $valid)) {
            return true;
        }

        return !auth()->user()->hasRole(\App\Models\Role::SUPERADMIN);
    }
}
