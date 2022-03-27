<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link rel="stylesheet" href="{{asset('css/createTask.css')}}">
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
    
    <form method="POST" action="{{ route('task.store') }}" enctype="multipart/form-data">
        <div class="main-title">
            <h1>Create Task</h1>
        </div>
   
   @csrf
   
   <div class="row">
       <span style="color : red">@error("project_id"){{$message}}@enderror</span><br>
       <label for="project-id" class="title">Project Id:</label>
       <input type="text" id="project-id"  name="project_id" placeholder="Example : PRJ_ABCDEF">
   </div>

   <div class="row">
   <span style="color : red">@error("task_type"){{$message}}@enderror</span><br>

 <label for="fname" class="title">Task Type:</label>
   <div class="types-container">
       <div class="type"> <input type="radio" id="task_type" name="task_type" value="Count words" > 
   <label for="">Count Words</label></div>
   
   <div class="type">
       <input type="radio" id="task_type" name="task_type" value="Count lines" >
   <label for="">Count Lines</label>
   </div>
   
   <div class="type">
    <input type="radio" id="task_type" name="task_type" value="Count characters" >
   <label for="">Count Characters</label>
   </div>
  

   </div>

   </div>
  
   <div class="row">
   <span style="color : red">@error("file"){{$message}}@enderror</span><br>

       <label for="file" class="title">Input File :</label>
   <input type="file" name="file">
   </div>
   
   
    <div class="btn-cont">

        <input class="view-projects" type="submit" value="Create Task">
    </div>

    <div  class="btn-cont">
        <a class="view-projects" href="{{route('projects.all')}}">View My Projects</a>
    </div>
    </form>
    <div>

</div>

</div>
   
</body>
</html>


