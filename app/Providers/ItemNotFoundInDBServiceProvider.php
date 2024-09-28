<?php

namespace App\Providers;

use App\Services\Messages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class ItemNotFoundInDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        Builder::macro('IfNotFound', function ($error = '') {
//            $result = $this->first();
//
//            if ($result === null) {
////                dd(Messages::error($error));
//                return Messages::error($error,404);
////                return null;
//            }
//            return $result;
//        });
        Builder::macro('IfNotFound', function () {
            $result = $this->first();

            if ($result === null) {
                // Return a JSON response and stop further code execution
                abort(response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404));
            }

            return $result;
        });
    }
}
