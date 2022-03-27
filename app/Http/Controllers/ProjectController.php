<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{

    
    // get all projects for the user
    public function get_projects () {

        // getting user id -> to show only the projects he is authorized to view
        $user_id = Auth::user()->id ;

        // Retrieving only user's projects from newer to older projects
         $projects = Project::where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(2);

         // return to projects view 
         return view('Project.projects', compact('projects'));
      
    }


    // get all tasks of a single project
    public function get_single_project ($project_id) {

        // getting user id -> to show only the projects he is authorized to view
        $user_id = Auth::user()->id ;

        // getting user id for required project tasks
        $user_id_for_required_project = 
            Project::where('project_id', $project_id)->first(['user_id'])->user_id;
            

        // check if authorized user
        if($user_id !== $user_id_for_required_project ) {
            // if not authorized redirect to 'projects.all'
            return redirect()->route('projects.all') ;
        }

        // retrieving all tasks for a specific project ordered from latest to older tasks 
        $tasks = Task::where('project_id','=',$project_id)->orderBy('created_at', 'DESC')->get();

        // return to tasks view
        return view('Project.singleproject', compact('tasks','project_id'))->render();
    }
}
