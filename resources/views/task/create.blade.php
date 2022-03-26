<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
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
       <label for="project-id" class="title">Project Id:</label>
       <input type="text" id="project-id"  name="project_id" placeholder="Example : PRJ_ABCDEF">
   </div>

   <div class="row">
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
       <label for="file" class="title">Input File :</label>
   <input type="file" name="file">
   </div>
   
   
<div class="btn-cont">

    <input type="submit" value="Create Task">
</div>
</form>
<div>
<span style="color : red">@error("project_id"){{$message}}@enderror</span><br>
<span style="color : red">@error("task_type"){{$message}}@enderror</span><br>
<span style="color : red">@error("file"){{$message}}@enderror</span><br>

</div>



</div>
   
</body>
</html>


<style>

body {
  /* background-color: lightblue; */
  /* background: rgba(0, 128, 0, 0.2) Green background with 30% opacity */

}

.nav-container {
    display: flex;
    flex-direction: row;
    justify-content: right;
    padding: 5px;

}

.li {
    margin: 10px;
font-size: 20px;}



.container {
  margin: 10px auto;
  padding: 15px 36px;
  width: 500px;
  font-size: 16px;
  border: 1px solid #e3e3e3;
  border-radius: 16px;
  box-shadow: 4px 4px 5px #0e62788c;
  background: #efefef;
  z-index: 999;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  display: flex;
    /* justify-content: center; */
}

.main-title {
    display: flex;
    justify-content: center;
}
.title {
    font-size: 20px;
    font-weight:300;
}
.types-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.row {
    margin: 20px;
}

.btn-cont {
    display: flex;
    justify-content: center;
}

.type {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-right: 10px;
}


input {
  display: block;
  margin-top: 10px;
}
label {
  color: black;
  font-size: 18px;
  margin-top: 10px;

  margin-left: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  font-size: 16px !important;
  border: 1px solid #ddd;
  padding: 6px;
  border-radius: 10px;
  width: 100%;
}

input[type="submit"] {
  margin: 15px 15px 10px;
  font-size: 16px;
  background: #04aa6d;
  color: #fff;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
}

</style>