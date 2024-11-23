<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\RoleServiceInterface;

class RoleController extends Controller
{

    /**
     * @var RoleServiceInterface
     */
    private $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function getSelect2()
    {
        return $this->roleService->getSelectData();
    }
}
