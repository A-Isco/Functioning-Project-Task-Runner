<?php

namespace App\Http\Controllers;

use App\Jobs\TaskProcess;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class TaskController extends Controller
{

    // go to create task view
    public function create() {
        return view("task.create");
    }

    // store task in db
    public function store(Request $request) {
        $project_id = $request->project_id ;
        $task_type = $request->task_type ; 
        $file = 'file.txt';
        // $file_uploaded = $request->file('file')->store('public');
   
        // ---------- store in Project table -----------------
        self::storeProject($project_id) ;

        // ----------------- store in Task table -----------------
        $task_id = self::storeTask($project_id , $task_type) ;

        // ----------------- store in Task table -----------------
         self::countLines($file,$task_id) ;
        // $taskID = "OUQyfUYzrNbltOHe10ajgjH6I8ugh0" ;
        // $value = Task::where('task_id', $taskID)->get('occurrences');
        // // $new_value = 
        // echo gettype($value[0]->{'occurrences'});
    
    }

    

    // ------------- Store in Project table -------------
    private function storeProject($project_id) {

        $project = Project::where('project_id',$project_id )->exists() ;
         
        if (!$project) {
        Project::create([
                 'project_id' => $project_id ,
             ]);
        }

    }

    // ------------- Store in Task table -------------
    private function storeTask($project_id , $task_type) {
        $task_id = Str::random(30);
        Task::create([
                    'project_id' => $project_id ,
                    'task_type' => $task_type ,
                     'task_id' => $task_id ,
                 ])  ;

                 return $task_id ;
    }

    // ------------- read file line by line -------------
    public function countLines($file,$task_id) {
        // $count_line = 0 ; 
        // Open file handler
        $fh = fopen($file, "r");
        // Read line by line
        while(($line=fgets($fh))!==false) {
            TaskProcess::dispatch($task_id) ;
            // $count_line ++ ;
            
        }
        // Close file handler
        
        fclose($fh) ;
        // echo $count_line ;
    }

    // OG Copy of the fn
    // public function countLines($file) {
    //     $count_line = 0 ; 
    //     // Open file handler
    //     $fh = fopen($file, "r");
    //     // Read line by line
    //     while(($line=fgets($fh))!==false) {
    //         $count_line ++ ;
    //         // dispatch job (reading line and update progress and dbis a single job )
    //         // we will pass the line as a parameter to the job 
    //         // maybe we will need also to pas the task_id to be able to update that specefic task in the db
    //     }
    //     // Close file handler
    //     fclose($fh) ;

    //     echo $count_line ;
    // }

    // ------------- read file line by line -------------
    
    public function countWords($file) {
        $count_words = 0 ; 
        // Open file handler
        $fh = fopen($file, "r");
        // Read line by line
        while(($line=fgets($fh))!==false) {
            echo str_word_count($line);
            $count_words += str_word_count($line) ;
        }
        // Close file handler
        fclose($fh) ;
        echo $count_words ;

        // return $count_words  ;

        // pass the file to the task job
    }


}












      /* 
        $this->output->progressStart(countLne(file.txt));
        foreach ($users as $user) {
    print "$user->name\n";

    $this->output->progressAdvance();
}

$this->output->progressFinish();

        countLne() {
            for(parseLine())
            {
                countedLines ++
                updateprocesstodb(countedLines)
            }
        } -> parse lines
       sentprocesstodb() 
       
       */ 