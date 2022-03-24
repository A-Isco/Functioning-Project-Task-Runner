<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;


class ProjectController extends Controller
{


    // get all projects
    public function get_projects () {

         $projects = Project::paginate(2);

         return view('Project.projects', compact('projects'));
        // dd($projects) ; 
    }


    // get a single project
    public function get_single_project ($project_id) {

        $project = Task::where('project_id','=',$project_id)->get();
        // dd($project) ; 
        return view('Project.singleproject', compact('project','project_id'))->render();
        // return "Hello" ;
    }
}