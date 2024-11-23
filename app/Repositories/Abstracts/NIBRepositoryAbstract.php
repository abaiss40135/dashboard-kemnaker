<?php


namespace App\Repositories\Abstracts;


abstract class NIBRepositoryAbstract extends BaseRepositoryAbstract
{
    public function findNomorIndukBerusahaWithAllRelation($nib)
    {
        return $this->getQuery()
            ->where('nib', $nib)
            ->with([
                'pemegangSahams', 'penanggungJawabs', 'legalitas',
                'rptkas.rptkaJabatans.rptkaTkiPendampings',
                'rptkas.rptkaNegaras', 'rptkas.rptkaLokasis',
                'proyeks.lokasiProyeks.posisiProyeks','proyeks.proyekProduks',
                'dnis', 'checklists.persyaratans'
            ])->first();
    }
}
