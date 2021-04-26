<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
	public function index(){

    $students = Student::orderBy('id','DESC')->get();
    $students = Student::paginate(3);
    return view('students',compact('students'));
    }

    public function addStudent(Request $request)
    {
    	$student = new Student();
    	$student->firstname = $request->firstname;
    	$student->lastname = $request->lastname;
    	$student->email = $request->email;
    	$student->phone = $request->phone;
    	$student->save();
    	return response()->json($student);
    }

    public function getStudentById($id)
    {
         $student = Student::find($id);
         return response()->json($student);
    }

    public function updateStudent(Request $request)
    {
    	$student = Student::find($request>id);
    	$student->firstname = $request->firstname;
    	$student->lastname = $request->lastname;
    	$student->email = $request->email;
    	$student->phone = $request->phone;
    	$student->save();
    	return response()->json($student);
    }

    public function deleteStudent($id) 
    {

       $student = Student::find($id);
       $student->delete();
       return response()->json(['success'=>'record has been deleted']);
    }
}
