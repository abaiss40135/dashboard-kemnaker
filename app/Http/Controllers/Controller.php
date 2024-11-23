<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\PermissionTrait;
use App\Http\Traits\PropertyTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\SweetAlertTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SweetAlertTrait, ResponseTrait, PropertyTrait, FileUploadTrait, PermissionTrait;
}
