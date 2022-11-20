<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $cb = new Carbon(); // Carbon init
        $date = $cb->subDays($request->subdays);

        $taskList = DB::table('tasks')
            ->join('staff','tasks.staff_id','staff.id')
            ->select('tasks.id','tasks.title','tasks.date','tasks.status','staff.name as staff_name', 'staff.id as staff_id')
            ->where('tasks.date','>',$date)
            ->orderBy('tasks.date','asc')
            ->get();

        $days = [
            'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
            'Четверг', 'Пятница', 'Суббота'
        ];

        //grouping by date & staff
        $taskGroup = [];
        foreach ($taskList as $task){

                $cssName = 'old_day';
                if ($task->date == Carbon::now()->toDateString()) {
                    $cssName = 'current_day';
                } else if (Carbon::create($task->date)->toDate() > Carbon::now()->toDate()){
                    $cssName = 'future_day';
                }
                $taskGroup[$task->date]['dayOfWeek'] = $days[date("w", strtotime($task->date) )];
                $taskGroup[$task->date]['dateUserFriendly'] = Carbon::create($task->date)->day . ' '. Carbon::create($task->date)->monthName;;
                $taskGroup[$task->date]['css_name'] = $cssName;
                $taskGroup[$task->date]['tasks'][$task->staff_id][] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'date' => $task->date
                ];
        }

        return response($taskGroup)->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = Task::create([
            'staff_id' => $request->staff_id,
            'title' => $request->title,
            'date' => $request->date,
        ]);

        return response($task->toArray(), 200)->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->staff_id);
        $task = Task::find($id);
        if($task){
            $task->title = $request->title;
            $task->status = $request->status;
            $task->staff_id = $request->staff_id;
            $task->date = $request->date;
            $task->save();
            return response($task->toArray(), 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message'=>'error'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if($task){
            $task->delete();
            return response(['message'=>'ok'], 200)->header('Content-Type', 'application/json');
        }else{
            //
        }
    }
}
