<?php
namespace App\Services\Subtask\RemoveLabelSubtask;

use App\DTO\Subtask\Request\RequestRemoveLabelSubtaskDTO;
use App\DTO\Subtask\SubtaskDTO;


interface RemoveLabelSubtaskServiceInterface
{
    public function remove_label(RequestRemoveLabelSubtaskDTO $removeLabelSubtaskDTO):SubtaskDTO;
}
