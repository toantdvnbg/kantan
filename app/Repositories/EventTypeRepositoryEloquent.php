<?php

namespace App\Repositories;

use App\Entities\EventType;
use App\Repositories\EventTypeRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class GameRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EventTypeRepositoryEloquent extends BaseRepository implements EventTypeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EventType::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
