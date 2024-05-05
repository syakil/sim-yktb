<?php

namespace App\Http\Controllers\PPDB;

use App\Http\Controllers\Controller;
use App\Models\FormulirPendaftaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FormulirPendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('ppdb/formulir-pendaftaran.index');
    }

    public function getData(){

        $data = FormulirPendaftaran::query();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <span class="sr-only"><i class="ri-settings-3-line"></i></span>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Edit</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>
                </div>
                ';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->filterColumn('column_name', function($query, $keyword) {
                $query->where('column_name', 'like', "%$keyword%");
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
