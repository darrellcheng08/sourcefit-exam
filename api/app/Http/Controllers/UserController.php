<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $users = User::orderBy('fname', 'asc')->get();

            return response()->json($users, 200);
        
        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ];
            Log::error($error);

            return response()->json([
                "status" => "error",
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($request, $model)
    {
        try 
        {
            $id = $model->id ?? null; 

            // create or update model
            $model->name = $request->fname . " " . $request->mname . " " . $request->lname;
            $model->fname = $request->fname;
            $model->lname = $request->lname;
            $model->mname = $request->mname;
            $model->contact_no = $request->contact_no;
            $model->email = $request->email;
            $model->save();

            // 200: OK. The standard success code and default option.
            $message = $id ? "updated" : "created";

            return response()->json([
                "status" => "success",
                'message' => "Item successfully $message.",
                'data' => $model
            ], 200);

        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ];
            Log::error($error);

            return response()->json([
                "status" => "error",
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = new User();

        return $this->create($request, $model);
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
    public function update(Request $request, User $user)
    {
        return $this->create($request, $user);
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
