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
            ->select('tasks.id','tasks.title','tasks.date','staff.name')
            ->where('tasks.date','>',$date)
            ->orderBy('tasks.date','asc')
            ->get();
        //grouping by date & staff
        $days = [
            'Воскресенье', 'Понедельник', 'Вторник', 'Среда',
            'Четверг', 'Пятница', 'Суббота'
        ];

        $taskGroup = [];
        foreach ($taskList as $task){
            $dayOfWeek = $days[date("w", strtotime($task->date) )];

                $taskGroup[$task->date]['dayOfWeek'] = $dayOfWeek;
                $taskGroup[$task->date]['tasks'][$task->name][] = [
                    'id' => $task->id,
                    'title' => $task->title
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
