<?php

namespace App\Providers;

use App\Http\Middleware\RestrictIpAddressMiddleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(function (IncomingEntry $entry) {
            $middleware = new RestrictIpAddressMiddleware();

            /**
             * if local or request coming from specific ip address, then allow
             */
            if ($this->app->environment('local') || in_array(request()->ip(), $middleware->restrictedIp)) {
                return true;
            }

            return $entry->isReportableException() ||
                ($entry->isRequest() && Str::startsWith($entry->content['uri'], '/api')) ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag() ||
                ($entry->type === EntryType::LOG && $entry->content['level'] !== 'warning') ||
                $entry->type === EntryType::JOB ||
                $entry->type === EntryType::QUERY ||
                $entry->type === EntryType::CLIENT_REQUEST;
        });

        Telescope::tag(function (IncomingEntry $entry) {
            return $entry->type === 'request'
                ? ['status:' . $entry->content['response_status']]
                : [];
        });

        Telescope::tag(function (IncomingEntry $entry) {
            if ($entry->type === 'request') {
                $customTag = Str::startsWith($entry->content['uri'], '/api') ? ['request:api'] : [];
                if (Str::startsWith($entry->content['uri'], '/api/oss')) {
                    $customTag = array_merge($customTag, ['api:oss']);
                }
                if (Str::startsWith($entry->content['uri'], '/api/oss/sso')) {
                    $customTag = array_merge($customTag, ['api:oss-sso']);
                }
                if (Str::startsWith($entry->content['uri'], '/api/twitter')) {
                    $customTag = array_merge($customTag, ['api:twitter']);
                }
                if (Str::startsWith($entry->content['uri'], '/api/sislap')) {
                    $customTag = array_merge($customTag, ['api:sislap']);
                }
                return array_merge($customTag, [request()->ip()]);
            }
        });

        Telescope::tag(function (IncomingEntry $entry) {
            //$filteredLog = in_array($entry->content['message'], ['OSSAPI', 'BIGDATA', 'BIGDATA_SCHEDULER']);
            if (($entry->type === EntryType::LOG && $entry->content['level'] !== 'warning')){
                $customTag = ['log:' . $entry->content['message']];
                if ($entry->content['message'] === 'OSSAPI'){
                    if(isset($entry->content['context']['nib']) && strlen($entry->content['context']['nib']) === 13) $customTag = array_merge($customTag, ['nib:' . $entry->content['context']['nib']]);
                    if(isset($entry->content['context']['type'])) $customTag = array_merge($customTag, ['type:' . $entry->content['context']['type']]);
                }
                return array_merge($customTag, [request()->ip()]);
            }
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails()
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                'admin@bospolri.go.id'
            ]);
        });
    }

    protected function authorization()
    {
        Telescope::auth(fn ($req) => app()->environment('local') || $req->user()?->haveRole('administrator'));
    }
}
