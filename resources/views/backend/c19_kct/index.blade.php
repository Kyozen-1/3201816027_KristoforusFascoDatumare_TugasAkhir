@extends('backend.layouts.app')
@section('title', 'Admin | Covid-19_Kecamatan')
@section('subheader', 'Covid_19 Kecamatan')

@section('content')
    @foreach ($kecamatans as $kecamatan)
    <div class="d-flex flex-column-fluid mb-3">
        <div class="container">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-architecture-and-city text-primary"></i>
                        </span>
                        <h3 class="card-label">{{$kecamatan->nama}}</h3>
                    </div>
                    <div class="card-title text-right">
                        <h3 class="card-label">Pertanggal:</h3>
                        <input type="date" class="form-control" id="tgl{{$kecamatan->id}}">
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-checkable" id="c19_kct_table{{$kecamatan->id}}">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelurahan</th>
                                <th>Positif</th>
                                <th>Positif Isolasi (Dirawat)</th>
                                <th>Meninggal</th>
                                <th>Suspek</th>
                                <th>Kontak Erat</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@section('js')
    <script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/select2.js') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('metronic/assets/js/pages/crud/forms/widgets/bootstrap-select.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/pages/features/charts/apexcharts.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script>
    <script>
        $(document).ready(function(){
            fill_datatable1();
            function fill_datatable1(tgl1 = '')
            {
                var dataTables1 = $('#c19_kct_table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('c19_kct.pontura') }}",
                    data: {tgl1:tgl1}
                },
                columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan'
                        },
                        {
                            data: 'positif',
                            name: 'positif'
                        },
                        {
                            data: 'positif_isolasi',
                            name: 'positif_isolasi'
                        },
                        {
                            data: 'meninggal',
                            name: 'meninggal'
                        },
                        {
                            data: 'suspek',
                            name: 'suspek'
                        },
                        {
                            data: 'kontak_erat',
                            name: 'kontak_erat'
                        }
                    ]
                });
            }
            
            $('#tgl1').on("input", function(){
                var tgl1 = $('#tgl1').val();
                if(tgl1 != '')
                {
                    $('#c19_kct_table1').DataTable().destroy();
                    fill_datatable1(tgl1);
                }
            });

            $.ajax({
                url: "{{ route('pontura_tgl') }}",
                dataType: "json",
                success: function(data)
                {
                    $('#tgl1').val(data.result.tgl);
                }
            });

            fill_datatable2();
            function fill_datatable2(tgl2='')
            {
                var dataTables2 = $('#c19_kct_table2').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('c19_kct.pontur') }}",
                        data: {tgl2:tgl2}
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan'
                        },
                        {
                            data: 'positif',
                            name: 'positif'
                        },
                        {
                            data: 'positif_isolasi',
                            name: 'positif_isolasi'
                        },
                        {
                            data: 'meninggal',
                            name: 'meninggal'
                        },
                        {
                            data: 'suspek',
                            name: 'suspek'
                        },
                        {
                            data: 'kontak_erat',
                            name: 'kontak_erat'
                        }
                    ]
                });
            }
            
            $.ajax({
                url: "{{ route('pontur_tgl') }}",
                dataType: "json",
                success: function(data)
                {
                    $('#tgl2').val(data.result.tgl);
                }
            });

            $('#tgl2').on("input", function(){
                var tgl2 = $('#tgl2').val();
                if(tgl2 != '')
                {
                    $('#c19_kct_table2').DataTable().destroy();
                    fill_datatable2(tgl2);
                }
            });

            fill_datatable3();
            function fill_datatable3(tgl3='')
            {
                var dataTables3 = $('#c19_kct_table3').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('c19_kct.ponteng') }}",
                        data: {tgl3:tgl3}
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan'
                        },
                        {
                            data: 'positif',
                            name: 'positif'
                        },
                        {
                            data: 'positif_isolasi',
                            name: 'positif_isolasi'
                        },
                        {
                            data: 'meninggal',
                            name: 'meninggal'
                        },
                        {
                            data: 'suspek',
                            name: 'suspek'
                        },
                        {
                            data: 'kontak_erat',
                            name: 'kontak_erat'
                        }
                    ]
                });
            }

            $.ajax({
                url: "{{ route('ponteng_tgl') }}",
                dataType: "json",
                success: function(data)
                {
                    $('#tgl3').val(data.result.tgl);
                }
            });

            $('#tgl3').on("input", function(){
                var tgl3 = $('#tgl3').val();
                if(tgl3 != '')
                {
                    $('#c19_kct_table3').DataTable().destroy();
                    fill_datatable3(tgl3);
                }
            });

            fill_datatable4();
            function fill_datatable4(tgl4='')
            {
                var dataTables4 = $('#c19_kct_table4').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('c19_kct.ponko') }}",
                        data: {tgl4:tgl4}
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan'
                        },
                        {
                            data: 'positif',
                            name: 'positif'
                        },
                        {
                            data: 'positif_isolasi',
                            name: 'positif_isolasi'
                        },
                        {
                            data: 'meninggal',
                            name: 'meninggal'
                        },
                        {
                            data: 'suspek',
                            name: 'suspek'
                        },
                        {
                            data: 'kontak_erat',
                            name: 'kontak_erat'
                        }
                    ]
                });
            }
            
            $.ajax({
                url: "{{ route('ponko_tgl') }}",
                dataType: "json",
                success: function(data)
                {
                    $('#tgl4').val(data.result.tgl);
                }
            });

            $('#tgl4').on("input", function(){
                var tgl4 = $('#tgl4').val();
                if(tgl4 != '')
                {
                    $('#c19_kct_table4').DataTable().destroy();
                    fill_datatable4(tgl4);
                }
            });

            fill_datatable5();
            function fill_datatable5(tgl5='')
            {
                var dataTables5 = $('#c19_kct_table5').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('c19_kct.ponsel') }}",
                        data: {tgl5:tgl5}
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan'
                        },
                        {
                            data: 'positif',
                            name: 'positif'
                        },
                        {
                            data: 'positif_isolasi',
                            name: 'positif_isolasi'
                        },
                        {
                            data: 'meninggal',
                            name: 'meninggal'
                        },
                        {
                            data: 'suspek',
                            name: 'suspek'
                        },
                        {
                            data: 'kontak_erat',
                            name: 'kontak_erat'
                        }
                    ]
                });
            }
    
            $.ajax({
                url: "{{ route('ponsel_tgl') }}",
                dataType: "json",
                success: function(data)
                {
                    $('#tgl5').val(data.result.tgl);
                }
            });

            $('#tgl5').on("input", function(){
                var tgl5 = $('#tgl5').val();
                if(tgl5 != '')
                {
                    $('#c19_kct_table5').DataTable().destroy();
                    fill_datatable5(tgl5);
                }
            });

            fill_datatable6();
            function fill_datatable6(tgl6='')
            {
                var dataTables6 = $('#c19_kct_table6').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('c19_kct.ponbar') }}",
                    data: {tgl6:tgl6}
                },
                columns: [
                        {
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'kelurahan',
                            name: 'kelurahan'
                        },
                        {
                            data: 'positif',
                            name: 'positif'
                        },
                        {
                            data: 'positif_isolasi',
                            name: 'positif_isolasi'
                        },
                        {
                            data: 'meninggal',
                            name: 'meninggal'
                        },
                        {
                            data: 'suspek',
                            name: 'suspek'
                        },
                        {
                            data: 'kontak_erat',
                            name: 'kontak_erat'
                        }
                    ]
                });
            }
        
            $.ajax({
                url: "{{ route('ponbar_tgl') }}",
                dataType: "json",
                success: function(data)
                {
                    $('#tgl6').val(data.result.tgl);
                }
            });

            $('#tgl6').on("input", function(){
                var tgl6 = $('#tgl6').val();
                if(tgl6 != '')
                {
                    $('#c19_kct_table6').DataTable().destroy();
                    fill_datatable6(tgl6);
                }
            });

        });
    </script>
@endsection