<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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

        return redirect()->back()->with('message', 'Doctor Added Successfully');
    }


    public function showappointment()
    {

        $data = Appointment::all();
        return view('admin.showappointment', compact('data'));
    }

    public function approved($id)
    {
        $data = Appointment::find($id);

        $data->status = 'Approved';

        $data->save();
        return redirect()->back();
    }
    public function canceled($id)
    {
        $data = Appointment::find($id);

        $data->status = 'Canceled';

        $data->save();
        return redirect()->back();
    }

    public function showdoctor()
    {
        $data = Doctor::all();
        return view('admin.showdoctor', compact('data'));
    }
    public function deletedoctor($id)
    {
        $data = Doctor::find($id);

        $data->delete();

        return redirect()->back();
    }

    public function updatedoctor($id)
    {
        $data = Doctor::find($id);
        return view('admin.update_doctor', compact('data'));
    }

    public function editdoctor(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->specialty = $request->specialty;
        $doctor->room = $request->room;

        $image = $request->file;

        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            $request->file->move('doctorimage', $imagename);
            $doctor->image = $imagename;

        }


        $doctor->save();

        return redirect()->back()->with('message' , 'Doctor updated Successfully');


    }
}
