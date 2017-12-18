<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepositoryEloquent;
use App\Repositories\EventTypeRepositoryEloquent;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class EventController extends Controller
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
        
        return view('admin.event.index', ['events' => $this->event->orderBy('id', 'desc')->all(), 'eventType' => $this->eventtype->pluck('name', 'event_type')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create',[
            'eventType' => $this->eventtype->pluck('name', 'event_type')]);
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
            'event_type_id' => 'required',
            'description' => 'required',
            'new_flg' => 'required',
            'code' => 'required|unique:ccll_r_event_data,code',
            'publish_event' => 'required',
            'status' => 'required',
            'image' => 'required|image',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
        ]);
        //$data['code'] = $this->getCode();
        $data['create_date'] = date('Ymd.His', time());
        dd($data);
        if ($request->has('image')) {
            $data['image'] = asset('storage/' . $request->file('image')->store('event', 'public'));
        }
        $result = $this->event->create($data);
        return redirect()->route('admin.event.index');
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
        return view('admin.event.edit', ['event' => $this->event->find($id),'eventType' => $this->eventtype->pluck('name', 'event_type')]);
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
            'event_type_id' => 'required',
            'description' => 'required',
            'new_flg' => 'required',
            'code' =>  [
                'required',
                Rule::unique('ccll_r_event_data')->ignore($id),
            ],
            'status' => 'required',
            'publish_event' => 'required',
            'image' => 'image',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $event_rs = $this->event->find($id);
        if ($request->has('image')) {
            $data['image'] = asset('storage/' . $request->file('image')->store('event', 'public'));
            Storage::disk('public')->delete($event_rs->image);
        }
        $result = $this->event->update($data, $id);
        return redirect()->route('admin.event.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->event->delete($id);
        return redirect()->route('admin.event.index');
    }

    private function getCode(){
        $event = $this->event->orderBy('code','desc')->first();
        $code = (int)$event['code'] + 1;
        return str_pad($code, 5, "0", STR_PAD_LEFT);
    }
}
