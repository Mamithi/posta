<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registeredUsers()
    {
        $data = DB::table('persons')
            ->select('FirstName', 'LastName', 'Email', 'Phone', 'credits', 'Subscribe')
            ->orderBy('FirstName', 'desc')
            ->get();

        if(count($data) > 0){
            return response(array(
                'registered' =>$data-> toArray()
                ));
        }else{
               return response(array(
                 "No registerd users"
                ));
        }
    }
     public function subscribedUsers()
    {
        $data = DB::table('persons')
            ->select('FirstName', 'LastName', 'Email', 'Phone', 'credits', 'Box', 'CodeNumber')
            ->orderBy('FirstName', 'desc')
            ->get();

        if(count($data) > 0){
            return response(array(
                'subscribed' =>$data-> toArray()
                ));
        }else{
               return response(array(
                 "No  users has subscribed"
                ));
        }
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
        //
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
