<?php


namespace App\Services;


use App\Helpers\CollectionHelper;
use App\Models\PusatInformasi;
use Carbon\Carbon;

class PencarianUmumService implements Interfaces\PencarianUmumServiceInterface
{
    public function search(string $query)
    {
        return $this->query($query)->paginate(10);
    }

    public function grouped(string $query, string $type = null)
    {
        $query = $this->query($query);
        if (!is_null($type)) {
            $query->where('body->type', $type);
        }
        if (!request('all_type')){
            $query->whereIn('body->type', ['video', 'infografis', 'meme', 'paparan']);
        }

        $data = $query->get()
            ->groupBy('body.type')
            ->map(function ($value, $key) {
                $value->each(function($body, $key){
                    return $body->translated_date = Carbon::parse($body->body['created_at'])->translatedFormat(config('app.long_date_format'));
                });
                return CollectionHelper::paginate(request('latest') ? $value->sortByDesc('body.created_at') : $value, request('paginate') ?? 3);
            })->sort();
        return request('first') && $data->first() ? $data->first() : $data;
    }

    public function query(string $query)
    {
        return PusatInformasi::search($query);
    }
}
