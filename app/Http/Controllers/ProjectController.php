<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{

    
    // get all projects
    public function get_projects () {

        $user_id = Auth::user()->id ;
        // Return only user's projects
         $projects = Project::where('user_id', $user_id)->paginate(2);

        foreach ($projects as $project) {
            $last5_count_lines = Task::where('project_id', $project->project_id)->where('task_type', 'Count lines')
            ->orderBy('created_at', 'DESC')->get();
        }

         return view('Project.projects', compact('projects' , 'last5_count_lines'));
        // dd($projects) ; 
      
    }


    // get a tasks of a single project
    public function get_single_project ($project_id) {

        $tasks = Task::where('project_id','=',$project_id)->get();
        // dd($project) ; 
        return view('Project.singleproject', compact('tasks','project_id'))->render();
        // return "Hello" ;
    }
}
