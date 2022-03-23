<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Bus\Batchable;

class TaskProcess implements ShouldQueue
{
    use  Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    // $line ;

    public $task_id ;

   
    
    

    public function __construct($task_id)
    {
        
        // this->$line = $line ;
        $this->task_id = $task_id ; 
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
        
    public function handle()
    {
        
        self::lineCountToDb() ;

    }

    
    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }








    public function lineCountToDb()
    {
        $taskID = $this->task_id ;
        $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
        $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + 1;
        Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
        // $taskID = "OUQyfUYzrNbltOHe10ajgjH6I8ugh0" ;
        // $cureent_occurence = 8 ;
        // $cureent_occurence = Task::select('occurrences')->where('task_id', '=',$taskID ) ;
        // $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
        // $updatedvalue = $cureent_occurence + 1 ;
        // Task::where('task_id', $taskID)->update(array('result' => "wo"));
        // Task::where('project_id', 'qq')->update(['result' => 'worked']);
        // Project::create([
        //     'project_id' => "test4" ,
        // ]);


   }
        
  }






