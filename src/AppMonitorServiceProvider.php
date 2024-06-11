<?php

namespace Tarique\LaravelAppMonitor;

use App\Jobs\SendMonitorErrorNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppMonitorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/appmonitor.php', 'appmonitor');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/appmonitor.php' => config_path('appmonitor.php'),
            __DIR__ . '/Jobs/SendMonitorErrorNotification.php' => app_path('Jobs/SendMonitorErrorNotification.php'),
        ],'config');
        $this->publishes([
            __DIR__ . '/Resources/views/error_email.blade.php' => resource_path('views/vendor/appmonitor/error_email.blade.php'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'appmonitor');
        if (config('appmonitor.notify_on_error')) {
            $this->registerHttpErrorHandling();
        }
    }

    protected function registerHttpErrorHandling()
    {
        Event::listen('Illuminate\Foundation\Http\Events\RequestHandled', function ($event) {
            $statusCode = $event->response->getStatusCode();

            if (in_array($statusCode, [500, 502, 503, 504, 401, 404, 413])) {
                $message = "An HTTP error occurred: $statusCode";

                if (config('appmonitor.notify_on_error')) {
                    $this->notifyAdmin(
                        $message,
                        $statusCode
                    );
                }
            }
        });
    }
    protected function notifyAdmin($message, $statusCode)
    {
        $email = config('appmonitor.admin_email');
        if ($email) {
            $data = [
                'message' => $message ?: 'An unspecified error occurred.',
                'status' => $statusCode,
            ];

            SendMonitorErrorNotification::dispatch($data);
        }
    }
}
