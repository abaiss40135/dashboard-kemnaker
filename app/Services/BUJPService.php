<?php


namespace App\Services;



use App\Repositories\Abstracts\BUJPRepositoryAbstract;
use Illuminate\Support\Arr;

class BUJPService implements Interfaces\BUJPServiceInterface
{
    /**
     * @var BUJPRepositoryAbstract
     */
    private $bujpRepository;

    /**
     * AgamaService constructor.
     * @param BUJPRepositoryAbstract $bujpRepository
     */
    public function __construct(BUJPRepositoryAbstract $bujpRepository)
    {
        $this->bujpRepository = $bujpRepository;
    }

    public function getSelectData()
    {
        $bujp = $this->bujpRepository
            ->getFilterWithAllData(request()->all())
            ->map(function ($item){
                return [
                    'id'=> (request()->has('id')) ? $item[request('id')] : $item['id'],
                    'text' => (request()->has('text')) ? $item[request('text')] : ($item['nama_badan_usaha'] . ' ('. $item['provinsi'] .')'),
                ];
            })->all();
        return Arr::prepend($bujp, ['id' => 'NON', 'text' => 'Non BUJP']);
    }

    public function getSelect2Wilayah()
    {
        return $this->bujpRepository
            ->getFilterWithAllData(request()->all(), ['provinsi'])
            ->unique('provinsi')->values()
            ->map(function ($item){
                return [
                    'id'=> $item['provinsi'],
                    'text' => $item['provinsi'],
                ];
            });
    }

    public function export(array $request)
    {
        return $this->bujpRepository->getFilterWithExportData($request);
    }

    public function update($request, $id)
    {
        return $this->bujpRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->bujpRepository->delete($id);
    }

}
