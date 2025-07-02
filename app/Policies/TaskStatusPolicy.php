<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaskStatus;

class TaskStatusPolicy
{
    public function viewAny(?User $user): bool
{
    return true;
}

public function view(?User $user, TaskStatus $taskStatus): bool
{
    return true;
}

    public function create(?User $user): bool
    {
        return true;
    }

    public function update(User $user, TaskStatus $taskStatus): bool
    {
        return true;
    }

    public function delete(User $user, TaskStatus $taskStatus): bool
    {
        // Можно запретить удаление, если статус используется в задачах
       // return !$taskStatus->tasks()->exists();
       return true;
    }
}
