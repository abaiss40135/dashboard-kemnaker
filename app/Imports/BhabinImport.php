<?php

namespace App\Imports;

use App\Http\Traits\SweetAlertTrait;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BhabinImport implements ToCollection, WithHeadingRow, WithValidation
{
    private $role;
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(array $role, UserServiceInterface $userService)
    {
        $this->role = $role;
        $this->userService = $userService;
    }

    /**
     * @param Collection $rows
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $this->userService->store($row->toArray(),$this->role);
        }
    }

    public function prepareForValidation($data, $index)
    {
        $data['email']      = $data['nrp'] . '@polri.go.id';
        $data['password']   = $data['nrp'];
        return $data;
    }

    public function rules(): array
    {
        return [
            'nrp' => ['required', 'digits:8'],
        ];
    }
}
