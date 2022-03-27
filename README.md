
# Full-stack Exercise

A functioning project task runner , where useres can creat projects and run tasks .




## Features

- Register/Loggin for Users .
- Creating projects and tasks . 
- Retrieve user's projects . 
- Retrieve user's tasks of a specific project .


## Deployment

To deploy this project :

``` Data base
  - You need a database with required tables , the details about the tables are in a sql database file attached in the git hub repo .
  - Use the database file attached in the repo you , can import it in php myadmin forexample or any other sql dms .
  - Then link the application to it using the .env file in the project .

  Note : Don't use the migration files to create the database , instead there's a database file in the repo which you can use .

```


## Documentation

-> Main Code is written in These files :
      - routes/web.php 
      - Models folder 'app/Models'
         (Project.php , Task.php , User.php) 
      - Controllers folder  'app/Http/Controllers'
        (ProjectController.php , TaskController.php , Auth folder) 
      - Views folder "resources/views"
        (projects.blade.php , singleproject.blade.php , create.blade.php)
      - Job Handling : TaskProcecess.php "/app/Jobs/TaskProcecess.php"

-> Main Routes "Api details in the API Reference section"

-> User's journy : 
    - User register and then loggin with username and password .
	- http://localhost/Full-stack-exercise/public/login .
	- http://localhost/Full-stack-exercise/public/register .
    - After loggin user will directed to the creat task view .
    - In create task view user can input 
      (project name , task type , uploaded file) 
      There are three types of tasks : Count lines - Count words - Count characters
    - After submitting the task User will redirected to all projects view page .
    - In projects view page user can see all his projects and their status ,
      and also he can go to project details by click on project's details link . 
    - In project details view user can see all tasks from that project in a descending order by created date .
      and can see the details of each task . 

-> How functionality works :
    - After submitting the task :
          - Project will be stored in the projects table if it's a new one .
          - Task will be stored in the tasks table .
    - Task handling : (Using Job Queue & Job Batching)
          - The input file is recieved in the backend to work on it .
          - Then we will check if the file is empty so it's a failed task if it's not will go to the next step .
          - A job batch will be dispatche .
          - Then a while loop will loop through the file line by line .
          - In each loop "line" it will send it as a job to the job queue in the batch .
          - After finishing reading from the file it will be closed .
          - Now we have a batch including jobs for a specific task .
          - In Job handle :
            - Each job is working on a single line of the whole task . 
            - So we apply a procedure of methods that handles each job .
            - when first job in the batch is started a method used to update the starting date of the task .
            - For each job and depending on the task type a suitable method is invoked to do the count logic for this job "line" .
            - The another methode is used to update the progress of the task in the db . 
            - While the tasks in the batch are running a method is used to update the project status .
            - after the task "batch" is done a method is used to update finished at column in the database .
            
            
 /login

## API Reference


#### GET Login view
```http
  GET /login
  http://localhost/Full-stack-exercise/public/login	
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |

#### GET Register view
```http
  GET /register
  http://localhost/Full-stack-exercise/public/register	
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |



#### GET Create task view
```http
  GET /task/create
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |


#### Post task inputs to the backend

```http
  POST /task/store
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |

#### Get All user's projects

```http
  GET /projects
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |


#### Get All Tasks for a specific project

```http
  GET /projects/show/{project_id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |



-> (auth) middlware  is used to deal with authentication and authorization 



