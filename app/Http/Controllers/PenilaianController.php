<?php

namespace App\Http\Controllers;


use App\Models\Penilaian;
use App\Models\Nilai;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psy\Command\WhereamiCommand;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $penilaian;
    protected $nilai;
    public function __construct()
    {
        $this->penilaian = new Penilaian();
        $this->nilai = new Nilai();
    }
    public function index()
    {
        $jurusan = DB::table('jurusan')
            ->get();
        
        //get data view
        $dataview = DB::table('penilaian')
            ->join('pembimbing_perusahaan', 'pembimbing_perusahaan.nik_pp', '=', 'penilaian.nik_pp')
            ->join('nilai', 'nilai.id_penilaian', '=', 'penilaian.id_penilaian')
            ->join('kompetensi', 'kompetensi.id_kompetensi', '=', 'nilai.kompetensi')
            ->join('siswa', 'siswa.nis', '=', 'penilaian.nis')
            ->select('pembimbing_perusahaan.nama_pp', 'penilaian.*', 'siswa.nama_siswa','nilai.nilai','kompetensi.nama_kompetensi')
            ->get();

        //get data form
        $nilaisiswa = DB::table('penilaian')
            ->join('prakerin', 'prakerin.nis', '=', 'penilaian.nis')
            ->join('siswa', 'siswa.nis', '=', 'penilaian.nis')
            ->select('penilaian.*', 'prakerin.*','siswa.nama_siswa')
            ->get();
            return view('dashboard.module.penilaian',compact('jurusan'),['nilaisiswa'=>$nilaisiswa,
                                                                         'dataview'=>$dataview
                                                                        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getKompetensi(Request $request)
    {
        $kompetensi = DB::table('kompetensi')
            ->where('id_jurusan', $request->id_jurusan)
            ->get();
        
        if (count($kompetensi) > 0) {
            return response()->json($kompetensi);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePenilaianRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function simpan(Request $request)
    {
        //insert tabel nilai
        try {
            $datanilai = [
                'id_penilaian' => $request->input('id_penilaian'),
                'kompetensi' => $request->input('kompetensi'),
                'nilai'      => $request->input('nilai')
            
              
            ];
            // dd($datanilai);
            //insert data ke database
            // $insert = $this->nilai->create($datanilai);
            $insert = Nilai::create($datanilai);
            if ($insert) {
                //redirect('gudang','refresh');
                return redirect('penilaian');
            } else {
                return "input data gagal";
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return "yaaah error nih, sorry ya";
        }
        
    }
  
       //UPDATE 
   public function edit($id)
   {
    // dd($nilai);
       $datanilai = DB::table('nilai')
                    ->join('kompetensi', 'kompetensi.id_kompetensi', '=', 'nilai.kompetensi')
                    ->select('kompetensi.nama_kompetensi', 'nilai.*')
                    ->where('id_penilaian', $id, 'nilai.*')
                    ->get();

       return view('dashboard.module.editnilai', ['datanilai' => $datanilai]);
   }
   public function update(Request $request)
    {
        // dd($request);
      
        DB::table('nilai')
            ->where('id_penilaian','=', $request->id_penilaian)
            ->where('kompetensi','=', $request->kompetensi)
            
        ->update([
        
            // 'id_penilaian' => $request->id_penilaian,
            // 'kompetensi' => $request->input->kompetensi,
            'nilai' => $request->nilai

        ]);

        return back();
           
    } 
   }
    
   
   
   