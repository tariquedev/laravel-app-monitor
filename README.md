### Laravel App Monitor

Laravel App Monitor is a package designed to monitor specific HTTP errors in your Laravel application and notify administrators via email. It helps ensure that critical errors (like 500, 502, 503, 504, 413) are promptly reported, allowing administrators to take appropriate action.

### Installation

You can install the Laravel App Monitor package via Composer. Run the following command in your terminal:

```bash
composer require tarique/laravel-app-monitor
```

### Publish Configuration

To customize settings such as email recipients or error notifications, publish the configuration file:

```bash
php artisan vendor:publish --provider="Tarique\\LaravelAppMonitor\\AppMonitorServiceProvider" --tag=config
```

This will copy the configuration file to `config/appmonitor.php`.

### Environment Configuration

Set the email address where notifications should be sent in your `.env` file:

```dotenv
ADMIN_EMAIL=admin@example.com
```

Make sure to replace `admin@example.com` with the appropriate email address.

## Usage

Laravel App Monitor automatically detects and handles specific HTTP errors. Here's how you can use it effectively:

### Enable Error Notifications

Ensure that error notifications are enabled in the `config/appmonitor.php` file:

```php
return [
    'admin_email' => env('ADMIN_EMAIL'),
    'notify_on_error' => true,
];
```

### Customize Email Template (Optional)

If you want to customize the email template used for error notifications, you can publish the default template:

```bash
php artisan vendor:publish --provider="Tarique\\LaravelAppMonitor\\AppMonitorServiceProvider" --tag=views
```

This will copy the default email template to `resources/views/vendor/appmonitor/error_email.blade.php`, where you can modify it to suit your needs.

### Configure Queue (Optional)

To avoid delaying frontend responses due to email sending, you can configure Laravel queues. Set the queue connection in your `.env` file:

```dotenv
QUEUE_CONNECTION=sync
```

If you are using QUEUE_CONNECTION as a database you should

```dotenv
QUEUE_CONNECTION=database
```

Run the migration to create the jobs table:

```bash
php artisan queue:table
php artisan migrate
```

Start the queue worker to process jobs asynchronously:

```bash
php artisan queue:work
```

## Support

If you encounter any issues or have questions about using Laravel App Monitor, please [open an issue on GitHub](https://github.com/tarique/laravel-app-monitor) or contact the package maintainer directly.

## License

Laravel App Monitor is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
