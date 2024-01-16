<?php

namespace App\Policies;


use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function show(User $user, Project $project): bool
    {
        $project_user =$project->owner();
        if($project_user){
            return $user->id === $project_user->user_id;
        }
        return false;
    }

    public function update(User $user , Project $project): bool
    {
        $project_user =$project->owner();
        if($project_user){
            return $user->id === $project_user->user_id;
        }
        return false;
    }

    public function delete(User $user , Project $project): bool
    {
        $project_user =$project->owner();
        if($project_user){
            return $user->id === $project_user->user_id;
        }
        return false;
    }

    public function createInvitation(User $user , Project $project): bool
    {
        $project_user =$project->owner();
        if($project_user){
            return $user->id === $project_user->user_id;
        }
        return false;
    }

    public function showInvitation(User $user , Project $project): bool
    {
        $project_user =$project->owner();
        if($project_user){
            return $user->id === $project_user->user_id;
        }
        return false;
    }

    public function checkOwner(User $user , Project $project): bool
    {
        $project_user =$project->owner();
        if($project_user){
            return $user->id === $project_user->user_id;
        }
        return false;
    }

    public function IsThereUserInProject(User $user , Project $project):bool
    {
        return $project->project_users()->pluck('user_id')->contains($user->id);
    }
}
