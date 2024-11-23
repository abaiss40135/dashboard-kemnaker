<?php


namespace App\Http\Traits;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

trait PermissionTrait
{
    public function checkPermission($permission){
        abort_if(Gate::denies($permission), Response::HTTP_FORBIDDEN, 'Anda tidak memiliki otoritas untuk akses layanan ini.');
    }
}
