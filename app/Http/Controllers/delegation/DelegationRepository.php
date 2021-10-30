<?php
namespace App\Http\Controllers\delegation;

use App\Models\Delegation;
use Illuminate\Database\Query\Builder;

class DelegationRepository
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
        $qr = Delegation::orderBy('nom');
        foreach ($criteria as $key => $value) {
            if ($value != null) {
                switch ($key) {
                    case 'nom':
                        $qr->where('nom', 'like', '%' . $value . '%');
                        break;
                    case 'nomExacte':
                        $qr->where('nom', '=', $value);
                        break;
                    case 'gouvernorat_id':
                        $qr->where('gouvernorat_id', '=', $value);
                        break;
                }

            }
        }
        return $qr->offset($this->offset)->limit($this->limit)->get()
            ->map->formatSearch();
    }
}
