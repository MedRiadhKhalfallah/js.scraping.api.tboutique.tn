<?php


namespace App\Http\Controllers\marque;


use App\Models\Marque;
use Illuminate\Database\Query\Builder;

class MarqueRepository
{
    private $offset = 0;
    private $limit = 50;

    public function searchWithCriteria($criteria)
    {
        if (isset($criteria['offset'])) {
            $this->offset = $criteria['offset'];
        }
        if (isset($criteria['limit']) && $criteria['limit'] < 50) {
            $this->limit = $criteria['limit'];
        }
        $criteria['notMarque']='autre';
        /** @var Builder $qr */
        $qr = Marque::orderBy('id');
//        return $criteria;
        foreach ($criteria as $key => $value) {
            if ($value != null) {
                switch ($key) {
                    case 'nom':
                        $qr->where('nom', 'like', '%' . $value . '%');
                        break;
                    case 'notMarque':
                        $qr->where('nom', '!=', $value );
                        break;
                    case 'nomExacte':
                        $qr->where('nom', '=', $value);
                        break;
                }

            }
        }
        return $qr->offset($this->offset)->limit($this->limit)->get()
            ->map->formatSearch();
        /*        $marques = $qr->get()
                    ->map(function ($marque) {
                        return  $marque->format();
                    });*/

        /*        ->map(function ($marque){
                    return[
                        'marque_id'=>$marque->id,
                        'marque_name'=>$marque->name,
                        'modele_id'=>$marque->model->id,
                        'modele_nale'=>$marque->model->name
                    ];
                });*/

    }

    /*    protected function format($marque)
        {
            return [
                'marque_id' => $marque->id,
                'marque_name' => $marque->name
            ];

        }*/
}
