<?php

namespace App\Http\Controllers;

use App\Models\employees;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = employees::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'Get All Resources',
            'data' => $employees
        ];

        return response()->json($response, 200);
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
            'name' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'email'],
            'status' => ['required'],
            'hired_on' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $employees = employees::create($request->all());
            $response = [
                'message' => 'Data created',
                'data' => $employees
            ];

            return response()->json($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employees = employees::findOrFail($id);
        $response = [
            'message' => 'Detail of data',
            'data' => $employees
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employees = employees::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'gender' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'email'],
            'status' => ['required'],
            'hired_on' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $employees->update($request->all());
            $response = [
                'message' => 'Data updated',
                'data' => $employees
            ];

            return response()->json($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employees = employees::findOrFail($id);

        try {
            $employees->delete();
            $response = [
                'message' => 'Data deleted'
            ];

            return response()->json($response, 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    public function search($name)
    {
        // cari name sesuai apa yang anda inginkan
        $employees = Employees::where('name', 'like', '%' . $name . '%')->get();

        // jika terdapat id pada employees
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Resource not found',
                'data' => $employees
            ];

            // mengirim data (json) dan kode 404
            return response()->json($data, 404);

            // jika tidak ditemukan idnya
        }
        $data = [
            'message' => 'Get Searched Resource',
            'data' => $employees
        ];

        // mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }

     // Menambahkan method untuk mendapatkan karyawan yang aktif
    public function active()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $activeEmployees = Employees::where('status', 'aktif')->get();

        // Jika tidak ada karyawan yang aktif
        if ($activeEmployees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang aktif',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Active Employees',
            'data' => $activeEmployees,
        ];
        return response()->json($data, 200);
    }

    // Menambahkan method untuk mendapatkan karyawan yang tidak aktif
    public function inactive()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $inactiveEmployees = Employees::where('status', 'tidak aktif')->get();

        // Jika tidak ada karyawan yang aktif
        if ($inactiveEmployees->isEmpty()) {
            $data = [
                'message' => 'Semua karyawan aktif',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Inactive Employees',
            'data' => $inactiveEmployees,
        ];
        return response()->json($data, 200);
    }

    // Menambahkan method untuk mendapatkan karyawan yang terminated
    public function terminated()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $terminEmployees = Employees::where('status', 'terminated')->get();

        // Jika tidak ada karyawan yang aktif
        if ($terminEmployees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang dipecat',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Terminated Employees',
            'data' => $terminEmployees,
        ];
        return response()->json($data, 200);
    }

}
