<?php

namespace App\Http\Controllers\Tagging;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\TagServiceInterface;

class TagController extends Controller
{

    /**
     * @var TagServiceInterface
     */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        //
    }

    public function getSelect2()
    {
        return $this->tagService->getSelectData();
    }
}
