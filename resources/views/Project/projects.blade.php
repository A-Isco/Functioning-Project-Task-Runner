<?php 

    use App\Models\Task;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<!--Bootstrap 3.4.1-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>All Projects</h1>

    @foreach ($projects as $project)

        <h3>{{$project->project_id}}</h3>
        <h4>

        <?php $last5_count_lines = Task::where('project_id', $project->project_id)->where('task_type', 'Count lines')
            ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

        @foreach ($last5_count_lines as $task)
        
        <div class=<?php if($task->result == 100) echo "green-dot" ; 
        if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
        if($task->result !== 100 && $task->result !== 0) echo "loader";
        
        ?>></div> 
      




 
                
        @endforeach
        </h4>
        <h4>{{$project->running}}</h4>
        <a href="{{route('projects.single',$project->project_id)}}">Project page</a>
        <hr>
   
    @endforeach

    {{$projects->render()}}
    
</body>
</html>


<style>
    .green-dot {
  height: 25px;
  width: 25px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}

.red-dot {
  height: 25px;
  width: 25px;
  background-color: red;
  border-radius: 50%;
  display: inline-block;

  
}

.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 15px;
  height: 15px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}


</style>



