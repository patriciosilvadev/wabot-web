<?php

namespace App\Models;

use App\Support\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:06
 */
class QueueModel extends BaseModel
{
    public function getNumberInQueue($today = true)
    {
        $sqlToday = "";

        if ($today) {
            $sqlToday = " AND send_date = curdate()";
        }

        $res = $this->raw("SELECT count(id) Qtd FROM wabot_queue WHERE active=1 {$sqlToday}");
        return $this->rawAsArray($res, true)["Qtd"];
    }

    public function getQueue($date)
    {
        $res = $this->raw("SELECT q.* , proj.label projectName
FROM wabot_queue q 
INNER JOIN wabot_project proj ON proj.license_id=q.license_id 
WHERE q.send_date=?", [$date]);

        return $this->rawAsArray($res);
    }
}