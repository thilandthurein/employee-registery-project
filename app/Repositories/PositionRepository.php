<?php

namespace App\Repositories;

use App\Position;
use App\Repositories\Interfaces\PositionRepositoryInterface;
//use Your Model

/**
 * Class EmployeeRepository.
 */
class PositionRepository implements PositionRepositoryInterface
{
    /**
     * @return string
     *  Return the model
     */
    public function savePosition($request)
    {
        $position = new Position();
        $position->position_name = $request['position_name'];
        $position->position_rank = $request['position_rank'];
        $position->save();
    }
}
