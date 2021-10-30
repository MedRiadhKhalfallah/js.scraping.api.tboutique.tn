<?php


namespace App\Http\Controllers\modele;


use App\Models\Modele;
use Illuminate\Database\Query\Builder;

class ModeleRepository
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
        /** @var Builder $qr */
        $qr = Modele::orderBy('nom');
        foreach ($criteria as $key => $value) {
            if ($value != null) {
                switch ($key) {
                    case 'nom':
                        $qr->where('nom', 'like', '%' . $value . '%');
                        break;
                    case 'nomExacte':
                        $qr->where('nom', '=', $value);
                        break;
                }

            }
        }
        return $qr->offset($this->offset)->limit($this->limit)->get()
            ->map->formatSearch();
    }
}
