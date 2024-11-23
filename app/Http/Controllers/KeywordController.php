<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\KeywordServiceInterface;

class KeywordController extends Controller
{

    /**
     * @var KeywordServiceInterface
     */
    private $keywordService;

    public function __construct(KeywordServiceInterface $keywordService)
    {
        $this->keywordService = $keywordService;
    }

    public function getSelect2()
    {
        return $this->keywordService->getSelectData();
    }
}
