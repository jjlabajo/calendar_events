<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($month, $year)
    {
        return Event::where(["month" => $month, "year" => $year])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if(empty(request()->events) ){
            throw new \ErrorException("Empty key in payload: events", 400);
        }
        $stored = [];
        Event::truncate();
        foreach(request()->events as $event){
            $store = Event::create($event);
            if($store){
                $stored[] = $store->id;
            }else{
                throw new \ErrorException("Database error.", 500);
            }
        }
        return $stored;
    }

}
