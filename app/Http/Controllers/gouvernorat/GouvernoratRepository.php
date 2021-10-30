<?php
namespace App\Http\Controllers\gouvernorat;

use App\Models\Gouvernorat;
use Illuminate\Database\Query\Builder;

class GouvernoratRepository
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
        $criteria['notGouvernorat']='autre';

        /** @var Builder $qr */
        $qr = Gouvernorat::orderBy('nom');
        foreach ($criteria as $key => $value) {
            if ($value != null) {
                switch ($key) {
                    case 'nom':
                        $qr->where('nom', 'like', '%' . $value . '%');
                        break;
                    case 'nomExacte':
                        $qr->where('nom', '=', $value);
                        break;
                    case 'notGouvernorat':
                        $qr->where('nom', '!=', $value );
                        break;
                }

            }
        }
        return $qr->offset($this->offset)->limit($this->limit)->get()
            ->map->formatSearch();
    }
}
