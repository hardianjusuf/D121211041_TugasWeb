<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        if ($students->count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Record Found'
            ], 404);
        }
    }

    // Insert Data
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'class' => 'required|string|max:191',
            'subject' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'class' => $request->class,
                'subject' => $request->subject,
            ]);

            if ($student) {

                return response()->json([
                    'status' => 200,
                    'message' => 'Student Created Succesfully'
                ], 200);
            } else {

                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong'
                ], 500);

            }

        }
    }

    // Show Data
    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {

            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!'
            ], 404);
        }
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {

            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'No Student ID Found!'
            ], 404);
        }
    }


    // Update
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'class' => 'required|string|max:191',
            'subject' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {

            $student = Student::find($id);
            if ($student) {

                $student->update([
                    'name' => $request->name,
                    'class' => $request->class,
                    'subject' => $request->subject,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Student updated Succesfull"
                ], 200);
            } else {

                return response()->json([
                    'status' => 404,
                    'message' => 'No Such Student Found'
                ], 404);

            }
        }
    }


    public function destroy($id)
    {
        $student = Student::find($id);
        if ($student) {

            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student Deleted Succesfully'
            ], 404);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found'
            ], 404);
        }
    }

}
