<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        

        if($employees->count() > 0){
            return response()->Json([
                    'status' => 200,
                    'employees' => $employees

            ], 200);
        } else {
            
                return response()->Json([
                    'status' => 404,
                    'message' => 'No Records Found'

                 ], 404);

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors'=> $validator->messages()
            ], 422);
        }else {
            $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'cell_phone' => $request->cell_phone,
                'address' => $request->address,
                'state' => $request->state,
                'salary' => $request->salary
            ]);

            if($employee){
                return response()->json([
                    'status' => 200,
                    'message' => 'Employee Create Successfully'
                ],200);
            }else{

                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong!'
                ],500);

            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);
        if($employee){
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Employee Found!'
            ],404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::find($id);
        if($employee){
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Employee Found!'
            ],404);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors'=> $validator->messages()
            ], 422);
        }else {
            $employee = Employee::find($id);
           
            if($employee){

                $employee->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'cell_phone' => $request->cell_phone,
                    'address' => $request->address,
                    'state' => $request->state,
                    'salary' => $request->salary
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Employee Updated Successfully'
                ],200);
            }else{

                return response()->json([
                    'status' => 404,
                    'message' => 'No Such Employee Found!'
                ],404);

            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        if($employee){
            $employee->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Employee Deleted Sucessfully!'
            ],200);

        }else {

            return response()->json([
                'status' => 404,
                'message' => 'No Such Employee Found!'
            ],404);

        }
    }
}
