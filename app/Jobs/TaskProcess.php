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
use Illuminate\Support\Facades\Bus;
use Carbon\Carbon ;


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
    public $batch_id ;
    public $line ;
    public $task_type ;

   
    
    

    public function __construct($task_id,$batch_id,$line,$task_type)
    {
        
        // this->$line = $line ;
        $this->task_id = $task_id ; 
        $this->batch_id= $batch_id ; 
        $this->line= $line ; 
        $this->task_type= $task_type ; 
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
        
    public function handle()
    {
        $task_type = $this->task_type;

        if($task_type == "Count lines") {
        self::updateStartedDateToDb();
        self::lineCountToDb() ;
        // self::wordsCountToDb() ;
        self::updateProgressToDb();
        self::updateFinishedDateToDb();
        }

        if($task_type == "Count words") {
            self::updateStartedDateToDb();
            // self::lineCountToDb() ;
            self::wordsCountToDb() ;
            self::updateProgressToDb();
            self::updateFinishedDateToDb();
            }

        // self::updateStartedDateToDb();
        // // self::lineCountToDb() ;
        // self::wordsCountToDb() ;
        // self::updateProgressToDb();
        // self::updateFinishedDateToDb();

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
   }


   public function wordsCountToDb()
   {
       $taskID = $this->task_id ;
       $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
       $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + str_word_count($this->line);
       Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
  }







   public function updateProgressToDb() {

    $taskID = $this->task_id ;
    $batch_id = $this->batch_id ;
    $batch = Bus::findBatch($batch_id);
    $progress = $batch->progress();
    
    Task::where('task_id', $taskID)->update(['result' => intval($progress)]);

 }

 public function updateFinishedDateToDb() {

    $taskID = $this->task_id ;
    $batch_id = $this->batch_id ;
    $batch = Bus::findBatch($batch_id); 
    $finished_at = $batch->{'finishedAt'} ;
    $progress = $batch->progress();

    if($progress == 100) {
        Task::where('task_id', $taskID)->update(['ended_at' => Carbon::now() ]);
    }
}

public function updateStartedDateToDb() {

    $taskID = $this->task_id ;
    $batch_id = $this->batch_id ;
    $batch = Bus::findBatch($batch_id); 
    $processedJobs = $batch->processedJobs();

    if($processedJobs == 1) {
        Task::where('task_id', $taskID)->update(['started_at' => Carbon::now() ]);
    }
}








        
  }






