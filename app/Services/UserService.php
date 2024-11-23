<?php


namespace App\Services;


use App\Helpers\ApiHelper;
use App\Repositories\Abstracts\PersonelRepositoryAbstract;
use App\Repositories\Abstracts\UserRepositoryAbstract;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class UserService implements Interfaces\UserServiceInterface
{
    protected $userRepository;
    /**
     * @var PersonelRepositoryAbstract
     */
    private $personelRepository;

    /**
     * AgamaService constructor.
     * @param UserRepositoryAbstract $userRepository
     */
    public function __construct(UserRepositoryAbstract $userRepository, PersonelRepositoryAbstract $personelRepository)
    {
        $this->userRepository = $userRepository;
        $this->personelRepository = $personelRepository;
    }

    public function store(array $data, array $roles)
    {
        if (role('operator_bhabinkamtibmas_polda')) {
            try {
                ApiHelper::getBhabinByNrp($data['nrp']);
            } catch (\Throwable $throwable) {
                throw $throwable;
            }
        }

        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->userRepository->create($data);
            $user->roles()->sync($roles);
            if (Arr::has($data, 'nrp') && empty($user->personel)) {
                $personel = ApiHelper::getBhabinByNrp($data['nrp']);
                if (is_array($personel)) {
                    $this->personelRepository->create(array_merge((array)$personel, ['user_id' => $user->id]));
                }
            }
            return $user;
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function update(array $data, $id, array $roles = [])
    {
        try {
            if (Arr::has($data, 'password')) {
                $data['password'] = bcrypt($data['password']);
            }
            $this->userRepository->update($data, $id);
            if (count($roles) != 0) {
                $this->userRepository->find($id, ['id'])->roles()->sync($roles);
            }
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function findBy($attribute, $value, $otherAttribute = null, $otherValue = null)
    {
        try {
            return $this->userRepository->findBy($attribute, $value, array('*'), $otherAttribute, $otherValue);
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }

    public function getDatatable()
    {
        $query = $this->userRepository
            ->getFilterWithQuery(request()->all())
            ->orderBy('last_login_at');

        return DataTables::eloquent($query->with('roles:id,alias'))
            ->addColumn('action', function ($collection) {
                $button = '<a href="' . route('user.show', $collection->id) . '" class="btn btn-sm btn-primary m-1"><i class="fa fa-eye"></i></a>';
                $button .= '<a href="' . route('ubah-role.index', ['nrp' => $collection->nrp ?? $collection->email]) . '" class="btn btn-sm btn-primary m-1"><i class="fa fa-sync"></i></a>';
                $button .= '<a href="' . route('akun.password-reset', ['nrp' => $collection->nrp ?? $collection->email]) . '" class="btn btn-sm btn-primary m-1"><i class="fa fa-key"></i></a>';
                return $button;
            })
            ->addColumn('username', function ($collection) {
                return empty($collection->nrp) ? $collection->email : ($collection->nrp . '/' . $collection->email);
            })
            ->addColumn('nama', function ($collection) {
                return $this->getNamaAttribute($collection);
            })
            ->addColumn('pangkat', function ($collection) {
                return $collection?->personel?->pangkat ?? "-";
            })
            ->addColumn('polda', function ($collection) {
                return $collection?->personel?->polda ?? "-";
            })
            ->addColumn('jabatan', function ($collection) {
                return $collection?->personel?->jabatan ?? "-";
            })
            ->addColumn('last_login', function ($collection){
                return $collection->last_login_at ?
                    $collection->last_login_at->translatedFormat(config('app.long_datetime_format')) :
                    $this->renderPill('Belum Login', 'warning');
            })
            ->addColumn('hak_akses', function ($collection){
                $roles = "";
                foreach ($collection->roles as $role) {
                    $roles .= $this->renderPill($role->alias);
                }
                return $roles;
            })
            ->rawColumns(['action', 'last_login', 'hak_akses'])
            ->toJson();
    }

    private function renderPill(string $name, $color = 'primary')
    {
        return '<span class="badge bg-'.$color.'">'.$name.'</span>';
    }

    public function export(array $request)
    {
        $this->userRepository->limit = 0;
        return $this->userRepository->getFilterWithAllData($request)->load('roles');
    }

    public function getNamaAttribute($data)
    {
        if($data?->personel)
        {
            return $data->personel->nama == "Tidak terdaftar pada SIPP 2.0" ? "-" : $data->personel->nama;
        }
        else if($data?->publik)
        {
            return $data->publik->nama == "Tidak terdaftar pada SIPP 2.0" ? "-" : $data->publik->nama;
        }
        else if($data?->satpam)
        {
            return $data->satpam->nama == "Tidak terdaftar pada SIPP 2.0" ? "-" : $data->satpam->nama;
        }
        else if($data?->bujp)
        {
            return $data->bujp->nama == "Tidak terdaftar pada SIPP 2.0" ? "-" : $data->bujp->nama;
        }
        else
        {
            return "-";
        }
    }

    public function getNoHandphoneAttribute($data)
    {
        if($data?->personel)
        {
            return $data->personel->handphone;
        }
        else if($data?->satpam)
        {
            return $data->satpam->no_hp;
        }
        else if($data?->bujp)
        {
            return $data->bujp->no_telepon;
        }
        else
        {
            return "-";
        }
    }

    public function getSelectData()
    {
        return $this->userRepository
        ->getFilterWithAllData(array_merge(request()->all(), ['level' => 5]))
        ->map(function ($item){
            $username = empty($item['nrp']) ? $item['email'] : $item['nrp'];
            return [
                'id' => $item['id'],
                'text' => $username . '/' . $this->getNamaAttribute($item)
            ];
        });
    }

}
