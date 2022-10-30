<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use Plugins\Notes;

class SingleService
{
    public function get(CrudInterface $repository, $code, $relation = false)
    {
        if(request()->wantsJson()){
            return Notes::single($repository->singleRepository($code, $relation));
        }
        return $repository->singleRepository($code, $relation);
    }
}
