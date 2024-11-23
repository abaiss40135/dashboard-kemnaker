<?php


namespace App\Services;

use App\Repositories\Abstracts\TagRepositoryAbstract;

class TagService implements Interfaces\TagServiceInterface
{

    /**
     * @var TagRepositoryAbstract
     */
    private $tagRepository;

    public function __construct(TagRepositoryAbstract $tagRepositoryAbstract)
    {
        $this->tagRepository = $tagRepositoryAbstract;
    }

    public function getSelectData()
    {
        return $this->tagRepository
            ->getFilterWithAllData(request()->all())
            ->map(function ($item){
                return [
                    'id'=> $item['slug'],
                    'text' => $item['name']
                ];
            });
    }
}
