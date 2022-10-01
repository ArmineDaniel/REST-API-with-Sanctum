<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function getAllStudents()
    {
       $students = Student::get()->toJson(JSON_PRETTY_PRINT);
       return response($students, 200);
    }

    public function createStudent(Request $request)
    {
        $student = new Student();
        $student->name = $request->name;
        $student->course = $request->course;
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else{
            $student->save();
            return response()->json([
                "message" => "student record created"
            ], 201);
        }
    }

    public function getStudent($id)
    {
        if(Student::find($id)){
            $student = Student::find($id)-> toJson(JSON_PRETTY_PRINT);
            return response($student, 200);
        }
        else{
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }

    public function updateStudent(Request $request, $id)
    {
        if(Student::find($id)){
            $student = Student::find($id);
            $student->name = $request->name ?? $student->name;
            $student->course = $request->course ?? $student->course;
            $student->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        }
        else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }

    public function deleteStudent ($id)
    {
        if(Student::find($id)){
            $student = Student::find($id);
            $student->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        }
        else {
            return response()->json([
                "message" => "Student not found"
            ], 404);
        }
    }
}
