<?php

namespace TaskManager\Helpers;

use DateTime;
use TaskManager\Model\Entity\Task;

class TaskViewHelper
{
	public static function renderStatus(Status $status): string
	{
		return match ($status) {
			Status::Pending => "<span class='status pending'>Pendente</span>",
			Status::Concluded => "<span class='status concluded'>Concluída</span>",
			Status::Expired => "<span class='status expired'>Expirada</span>"
		};
	}

	public static function formattedDate(string $date): string
	{
		$date = new DateTime($date);
		return $date->format("d/m H:i");
	}
}