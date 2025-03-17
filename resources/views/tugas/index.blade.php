@extends('layouts.layouts')

@push('css')
<style>
    body{
        background-color: #E3FCBF;
    }

    .card:hover{
        cursor:pointer;
        background-color: #B8F1B0;
    }

    .done{
        background-color: #00FFAB;
    }

    .icon:hover{
        background-color: #B8F1B0;
    }
</style>
@endpush
@section('content')
<div class="input-group my-3">
    <input type="text" class="form-control" id="key" placeholder="Cari Tugas" aria-label="Recipient's username" aria-describedby="button-addon2">
    <button class="btn btn-success" type="button" id="button-addon2" data-bs-toggle="modal" data-bs-target="#exampleModal" id="button-tambah">Tambah</button>
</div>
@includeIf('tugas.modal')
@includeIf('tugas.detail-tugas')
<div class="list" id="container-list">

</div>
@endsection

@push('js')
    <script>
        $("#key").on("keyup", function () {
            let key = $(this).val();
            console.log(key);
            $.ajax({
                type: "GET",
                url: "{{ route('tugas.data') }}",
                data: {
                    "key":key,
                },
                dataType: "json",
                success: function (response) {
                    $('#container-list').html("");
                    if(response.length != 0){
                        $.each(response.tugas, function(key, item){
                        let s = item.status == 1 ? 'bg-secondary text-white' : '';
                        $('#container-list').append(`
                            <div class="card ${s}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-title">${item.judul}</h6>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-success btn-sm" onclick="status(${item.id_tugas})"><i class="fa-solid fa-check"></i></a>
                                                <a href="#" class="btn btn-warning btn-sm edit" data-bs-toggle="modal"
                                                data-bs-target="#taskmodal" onclick="show(${item.id_tugas})"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="hapus(${item.id_tugas})"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    ${item.deskripsi}
                                </div>
                            </div>
                        `);
                    })
                    }
                }
            });
        });

        dataTugas();  // Panggil fungsi untuk mengambil data saat halaman dimuat
        function dataTugas(){
            $.ajax({
                type: "GET",
                url: "{{ route('tugas.data') }}",
                dataType: "json",
                success: function (response) {
                    $('#container-list').html("");
                    if(response.length != 0){
                        $.each(response.tugas, function(key, item){
                        let s = item.status == 1 ? 'bg-secondary text-white' : '';
                        $('#container-list').append(`
                            <div class="card ${s}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-title">${item.judul}</h6>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-success btn-sm" onclick="status(${item.id_tugas})"><i class="fa-solid fa-check"></i></a>
                                                <a href="#" class="btn btn-warning btn-sm edit" data-bs-toggle="modal"
                                                data-bs-target="#taskmodal" onclick="show(${item.id_tugas})"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="hapus(${item.id_tugas})"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    ${item.deskripsi}
                                </div>
                            </div>
                        `);
                    })
                    }
                }
            });
        }

        function tambah(){
            $('#tambah').removeAttr('onclick');

            let judul = $('#judul').val(); //id
            let deskripsi = $('#deskripsi').val();

            var data = {
                'judul' : judul,
                'deskripsi' : deskripsi,
            }

            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name = "csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('tugas.store') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('#judul').val("");
                        $('deskripsi').val("");
                        $('.modal').removeClass('show');
                        $('.modal').css('display', 'none');
                        $('.modal-backdrop').remove();
                        $('body').removeAttr('class');
                        $('body').removeAttr('style');
                        $('#tambah').attr('onclick', 'tambah()');
                        dataTugas();
                    }
                }
            });
        }

        function status(id_tugas){
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name = "csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "{{ url('/todoliststatus') }}/" + id_tugas,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        console.log('Berhasil');
                        dataTugas();
                    }
                }
            });
        }
    </script>
@endpush
