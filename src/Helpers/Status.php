<?php

namespace TaskManager\Helpers;
// Enum utilizada para representar o status da tarefa 
enum Status: string
{
    case Pending = 'pending';
    case Concluded = 'concluded';
	case Expired = 'expired';
}