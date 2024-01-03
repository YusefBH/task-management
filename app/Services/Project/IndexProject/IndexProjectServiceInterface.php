<?php

namespace App\Services\Project\IndexProject;



use App\Http\Requests\Project\IndexProjectRequest;
use Illuminate\Http\Request;

interface IndexProjectServiceInterface
{
    public function index(IndexProjectRequest $request);
}
