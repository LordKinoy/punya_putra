<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Presensi</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">   -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-[#CCE0DD] h-full">
    <center>
        <h1 class=" font-extrabold text-[30px] tracking-[.20em] text-[#173A6F] mt-10"> DAFTAR NILAI SISWA PRAKERIN</h1>
    </center>
    <div class="overflow-x-auto mx-20 mt-20">
        <div class="float-left">
            <label for="my-modal-3" class="btn bg-blue-500 mb-2">Isi Nilai</label>
        </div>
    </div>

    <!-- The button to open modal -->
    <div class="overflow-x-scroll mx-20">
        <table border="1" cellpadding="0" class="table w-full text-center border-collapse ">
            <tr>

                <td class="font-bold">No</td>
                <th>NAMA SISWA</th>
                <th>PEMBIMBING</th>
                <th>KOMPETENSI</th>
                <th>NILAI</th>
                <th>AKSI</th>
            </tr>

            <?php 
        $no = 1;
    ?>
            @foreach($dataview as $d)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$d->nama_siswa }}</td>
                <td>{{$d->nama_pp}}</td>
                <td>
                    <p class="whitespace-normal text-left">{{$d->nama_kompetensi}}</p>
                <td>
                    {{$d->nilai}}
                </td>
                <td>
                    <div class="flex w-44 justify-center">
                        <a href="" onclick="return confirm('Anda yakin ingin hapus data ini ?')"><label for="" class="bg-red-600 mr-1 hidden hover:bg-yellow-400 text-white rounded-lg font-bold text-sm p-2 btn
            ">HAPUS</label></a>
                        <a href="/nilai/edit/{{$d->id_penilaian}}"><button type="submit"
                                class="btn btn-success mr-6">EDIT</button></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>

    </div>
    <input type="checkbox" id="my-modal-3" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box font-bold">
            <label for="my-modal-3"
                class="btn btn-sm btn-circle absolute hover:bg-red-500 border border-white right-2 top-2">✕</label>
            <form action="simpan_nilai" method="POST">
                @csrf
                <div class="w-full mb-2">
                    <label for="id_penilaian"> Siswa </label>
                    <br>
                    <select name="id_penilaian" id="id_penilaian" class="select select-bordered w-full p-1 text-center">
                        <option disabled selected>--Pilih Siswa--</option>
                        @foreach($nilaisiswa as $siswa)
                        <option value="{{$siswa->id_penilaian}}">{{$siswa->nama_siswa}} NIS( {{$siswa->nis}} )</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full mb-2">
                    <label for="jurusan"> Jurusan</label>
                    <br>
                    <select id="jurusan" class="select select-bordered w-full p-1 text-center">
                        <option selected disabled>--Pilih Jurusan--</option>
                        @foreach ($jurusan as $j)
                        <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full mb-2">
                    <label for="kompetensi">Kompetensi</label>
                    <select name="kompetensi" id="kompetensi"
                        class="select select-bordered w-full p-1 text-center"></select>
                </div>
                <div class="w-full mb-2">
                    <label for="nilai"> Nilai </label>
                    <br>
                    <input type="number" max="100" name="nilai" id="nilai"
                        class="w-full rounded-md shadow-inner border border-gray-400">
                </div>

                <div class="modal-action">
                    <button type="submit" value="simpan"
                        class="btn bg-[#256D85] rounded-lg px-5 py-3 text-center shadow-md hover:bg-emerald-700 font-bold text-white">Simpan</button>
                </div>

            </form>
        </div>
    </div>

    <!-- <div class="m-5 w-50">
        <h1 class="lead">Dependent dropdown example</h1>
        <div class="mb-3">
            <select class="form-select form-select-lg mb-3" id="jurusan">
                <option selected disabled>Select country</option>
                @foreach ($jurusan as $j)
                <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-select form-select-lg mb-3" id="kompetensi"></select>
        </div>
    </div> -->

    <!-- js -->
    <script type="text/javascript">
    $(document).ready(function() {
        $('#jurusan').on('change', function() {
            var id_jurusan = this.value;
            $('#kompetensi').html('');
            $.ajax({
                url: "{{ route('getKompetensi') }}?id_jurusan=" + id_jurusan,
                type: 'get',
                success: function(res) {
                    $('#kompetensi').html('<option value="">--Pilih Kompetensi--</option>');
                    $.each(res, function(key, value) {
                        $('#kompetensi').append('<option value="' + value
                            .id_kompetensi + '">' + value.nama_kompetensi +
                            '</option>');
                    });
                    $('#city').html('<option value=""></option>');
                }
            });
        });
    });
    </script>
</body>

</html>