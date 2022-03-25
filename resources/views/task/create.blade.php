<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>

<body>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
     <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <!-- <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div> -->
            </div>

            <div class="mt-3 space-y-1">
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
</nav>

    <form method="POST" action="{{ route('task.store') }}">
   
        @csrf
        
        <label for="project-id">Project Id:</label><br>
        <input type="text" id="project-id"  name="project_id"><br><br>
        <label for="fname">Task Type:  
        </label><br>
        <label for="">
            <input type="radio" id="task_type" name="task_type" value="Count words" >
            Count Words
        </label>
        <label for="">
            <input type="radio" id="task_type" name="task_type" value="Count lines" >
            Count Lines
        </label>
        <label for="">
            <input type="radio" id="task_type" name="task_type" value="Count characters" >
            Count Characters
        </label><br><br>
        <label for="file">Input File :</label><br>
        <input type="file" name="file"><br><br>
        <input type="submit" value="Submit">
    </form>
    <div>
    <span style="color : red">@error("project_id"){{$message}}@enderror</span><br>
    <span style="color : red">@error("task_type"){{$message}}@enderror</span><br>
    <span style="color : red">@error("file"){{$message}}@enderror</span><br>

    </div>
</body>
</html>