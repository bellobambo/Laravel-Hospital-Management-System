<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function addview()
    {
        return view('admin.add_doctor');
    }

    public function upload(Request $request)
    {
        $doctor = new Doctor;
        $image = $request->file;

        $imagename = time() . '.' . $image->getClientOriginalExtension();


        $directory = 'doctorimage';
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $request->file->move($directory, $imagename);

        $doctor->image = $imagename;

        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->room = $request->room;
        $doctor->specialty = $request->specialty;

        $doctor->save();

        return redirect()->back()->with('message' , 'Doctor Added Successfully');
    }
}
