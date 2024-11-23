<?php

declare(strict_types=1);

namespace App\Telescope\Watchers;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Illuminate\Foundation\Application;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\Watchers\FetchesStackTrace;
use Laravel\Telescope\Watchers\Watcher;

final class GuzzleRequestWatcher extends Watcher
{
    use FetchesStackTrace;

    public function register($app): void
    {
        $app->bind(
            abstract: Client::class,
            concrete: $this->buildClient(
                app: $app,
            ),
        );
    }

    private function buildClient(Application $app): Closure
    {
        return static function (Application $app): Client {
            $config = $app['config']['guzzle'] ?? [];

            if (Telescope::isRecording()) {
                $config['on_stats'] = function (TransferStats $stats) {
                    $caller = $this->getCallerFromStackTrace();
                    Telescope::recordQuery(
                        entry: IncomingEntry::make([
                            'connection' => 'guzzle',
                            'bindings' => [],
                            'sql' => (string) $stats->getEffectiveUri(),
                            'time' => number_format(
                                num: $stats->getTransferTime() * 1000,
                                decimals: 2,
                                thousands_separator: '',
                            ),
                            'slow' => $stats->getTransferTime() > 1,
                            'file' => $caller['file'],
                            'line' => $caller['line'],
                            'hash' => md5((string) $stats->getEffectiveUri()),
                        ]),
                    );
                };
            }

            return new Client(
                config: $config,
            );
        };
    }
}
