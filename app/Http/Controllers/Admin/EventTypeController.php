<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepositoryEloquent;
use App\Repositories\EventTypeRepositoryEloquent;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventTypeController extends Controller
{
    /**
     * @var GameRepository
     */
    protected $event;
    protected $eventtype;

    public function __construct(EventRepositoryEloquent $event, EventTypeRepositoryEloquent $eventtype)
    {
        $this->event = $event;
        $this->eventtype = $eventtype;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.eventtype.index', ['types' => $this->eventtype->orderBy('id', 'desc')->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.eventtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'event_type' => 'required|unique:ccll_r_event_type',
        ]);
        $data['create_date'] = date('Ymd.His', time());
        $result = $this->eventtype->create($data);
        return redirect()->route('admin.eventtype.index');
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
        return view('admin.eventtype.edit', ['eventtype' => $this->eventtype->find($id)]);
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
        $data = $request->validate([
            'name' => 'required',
            'event_type' => 'required',
        ]);
        $result = $this->eventtype->update($data, $id);
        return redirect()->route('admin.eventtype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->eventtype->delete($id);
        return redirect()->route('admin.eventtype.index');
    }
}
