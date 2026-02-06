<?php

namespace TaskManager\Model\Entity;

use Cassandra\Date;
use DateTime;
use TaskManager\Helpers\Status;

class Task
{
    public readonly int $id;
    public readonly string $date;

    public function __construct(
        public readonly string $title,
        public readonly string $description,
        string $date,
        private Status $status = Status::Pending
    )
    {
        $this->date = $this->sanitizeDate($date);
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    private function sanitizeDate($date): string
    {
        return str_replace("T", " ", $date);
    }

	public function getStatus(): Status
	{
		return $this->status;
	}

	public function displayStatus(): Status
	{
		if($this->status->value === 'concluded') {
			return Status::Concluded;
		}

		if($this->status->value === 'expired') {
			return Status::Expired;
		}

		return Status::Pending;
	}

	public function recalculateStatus(): void
	{
		if($this->getStatus() === Status::Concluded) {
			return;
		}

		$now = new Datetime('now');
		$taskDate = new DateTime($this->date);

		$this->status = $taskDate < $now ? Status::Expired : Status::Pending;
	}
}