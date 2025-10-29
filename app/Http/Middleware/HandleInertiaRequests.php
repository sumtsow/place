<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;
use App\Models\User;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
				'isAdmin' => $request->user() ? $request->user()->can('admin', User::class) : false,
				'isOperator' => $request->user() ? $request->user()->can('operator', User::class) : false,
            ],
			'locale' => self::setLang($request),
			'locales' => config('app.lang'),
			'csrf_token' => csrf_token(),
			'modal' => config('app.modalMode'),
        ];
    }

	private static function setLang(Request $request) {
		$locale = $request->cookie('locale');
		
		if (!isset($locale)) {
			$locale = substr($request->server('HTTP_ACCEPT_LANGUAGE') ?? config('app.lang'), 0, 2);
		}
		if ( in_array( $locale, config('app.lang') ) ) App::setLocale($locale);
		syncLangFiles( config('app.langFiles') );
		return $locale;
	}
}
