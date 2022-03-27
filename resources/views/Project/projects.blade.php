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
    <link rel="stylesheet" href="{{asset('css/projects.css')}}">

</head>
<body>


<div class="nav-container">
        <div class="li">
                <div class="font-medium text-base text-gray-800">Welcome {{ Auth::user()->name }}</div>
            </div>
            <div class="li">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>      
    </div>
  
  
  <div class="container">
          <h1>All Projects</h1>


        <div class="table-container">
        <table>
          <thead>
            <tr class="header">
              <th>Project</th>
              <th>Tasks type</th>
              <th>Recent 5 tasks</th>
              <th>Running</th>
              <th>Link</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($projects as $project)
            <tr>
              <td rowspan="3">{{$project->project_id}}</td>
              <td>Count Words</td>
              <td>
                <!-- ----------- Showing last 5 statuses for " Count Words " tasks ----------------- -->

                <?php $last5_count_words = Task::where('project_id', $project->project_id)->where('task_type', 'Count words')
                    ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

                @foreach ($last5_count_words as $task)
                
                <div class=<?php if($task->result == 100) echo "green-dot" ; 
                if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
                if($task->result !== 100 && $task->result !== 0) echo "blue-dot"; // running
                if($task->started_at == null) echo "yellow-dot" ; // didn't start yet
                ?>></div> 
              
                @endforeach
              </td>
              <td rowspan="3">{{$project->running}}</td>
              <td rowspan="3"><a href="{{route('projects.single',$project->project_id)}}">Project page</a></td>
            </tr>
            <tr>
              <td>Count Lines</td>
              <td>
              
                <!-- ----------- Showing last 5 statuses for " Count Lines " tasks ----------------- -->
                    
            <?php $last5_count_lines = Task::where('project_id', $project->project_id)->where('task_type', 'Count lines')
                        ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

                    @foreach ($last5_count_lines as $task)
                    
                    <div class=<?php if($task->result == 100) echo "green-dot" ; 
                    if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
                    if($task->result !== 100 && $task->result !== 0) echo "blue-dot"; // running
                    if($task->started_at == null) echo "yellow-dot" ; // have not start yet
                    ?>></div> 
                  
                    @endforeach
              </td>
            </tr>
            <tr>
              <td>Count Characters</td>
              <td>
                <!-- ----------- Showing last 5 statuses for " Count Characters " tasks ----------------- -->
                <?php $last5_count_characters = Task::where('project_id', $project->project_id)->where('task_type', 'Count characters')
                    ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

                @foreach ($last5_count_characters as $task)
                
                <div class=<?php if($task->result == 100) echo "green-dot" ; 
                if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
                if($task->result !== 100 && $task->result !== 0) echo "blue-dot"; // running
                if($task->started_at == null) echo "yellow-dot" ; // didn't start yet
                ?>></div> 
              
                @endforeach

              </td>
            </tr>
            

            @endforeach

          </tbody>
        </table>
        </div>

        <br>
      
        {{$projects->render()}}
        <a href="{{ route('task.create') }}" class="create-task">Create Task</a>
      

        </div>

        <div class="map" style="display: flex;justify-content: center; margin-top: 30px; ">
          <div class="item" style="display: flex; margin: 20px;" >
            <div class="green-dot"></div>
            <div style="margin-left: 10px ;">Task Success</div>
          </div>
          <div class="item" style="display: flex; margin: 20px;">
            <div class="red-dot"></div>
            <div style="margin-left: 10px ;">Task Failed</div>
          </div>
          <div class="item" style="display: flex; margin: 20px;">
            <div class="blue-dot"></div>
            <div style="margin-left: 10px ;" >Task is running</div>
          </div>
          <div class="item" style="display: flex; margin: 20px;">
            <div class="yellow-dot"></div>
            <div style="margin-left: 10px ;">Task is not running yet </div>
          </div>
        </div>


    
</body>
</html>




