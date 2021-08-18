@extends('frontend.layouts.app')
@section('title', 'Table Data Covid-19 | Pontianak Covid-19')

@section('css')
    <style>
        th {
            text-align: center;
            vertical-align: middle;
        }
        .mapboxgl-popup {
            max-width: 400px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }

        .map-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.8);
            margin-right: 20px;
            font-family: Arial, sans-serif;
            overflow: auto;
            border-radius: 3px;
        }

        #legend {
            padding: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            line-height: 18px;
            height: 130px;
            margin-bottom: 40px;
            width: 200px;
        }

        .legend-key {
            display: inline-block;
            border-radius: 20%;
            width: 10px;
            height: 10px;
            margin-right: 5px;
        }
    </style>
@endsection

@section('content')
<div id="map_pontianak" style="width: 100%; height: 600px;"></div>
<div class="map-overlay" id="legend"></div>
<div id="data_per_kecamatan" class="section" style="margin: 0px;margin-top: 1rem;">
    <h1 class="text-center" style="margin-bottom: 1rem;">Data Per Kecamatan</h1>
    @foreach ($kecamatans as $kecamatan)
    <div class="row" style="padding: 2rem;margin-top: 1rem;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-left">
                    <h4 style="margin-bottom: 1rem;">{{$kecamatan->nama}}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Pertanggal</h4>
                        </div>
                        <div class="col-md-6">
                            <input type="date" class="form-control" id="tgl{{$kecamatan->id}}">
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-checkable" id="table_kecamatan{{$kecamatan->id}}">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelurahan</th>
                            <th>Positif</th>
                            <th>Positif Isolasi (dirawat)</th>
                            <th>Meninggal</th>
                            <th>Suspek</th>
                            <th>Kontak Erat</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @endforeach    
</div>
@endsection

@section('js')
<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $(document).ready(function(){
        mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jpc3RvZm9ydXMiLCJhIjoiY2twZzNhZ3MwMDBlbzJucDRwNmhuYmZiZCJ9.7PP-LErWIjLon-ZiT9q_xA';
        var map = new mapboxgl.Map({
            container: 'map_pontianak', // container id
            style: 'mapbox://styles/mapbox/light-v10', // style URL
            center: [109.32880642681448, -0.02008090342398816], // starting position [lng, lat]
            zoom: 12 // starting zoom
        });

        var layers = ['Pontianak Utara', 'Pontianak Timur','Pontianak Tenggara', 'Pontianak Kota', 'Pontianak Selatan', 'Pontianak Barat'];
        var colors = ['#e8befe', '#beffe7','#e9ffbe', '#f5ce0f', '#ffffbe' , '#febebe'];
        for(i = 0; i < layers.length; i++)
        {
            var layer = layers[i];
            var color = colors[i];
            var item = document.createElement('div');
            var key = document.createElement('span');
            key.className = 'legend-key';
            key.style.backgroundColor = color;

            var value = document.createElement('span');
            value.innerHTML = layer;
            item.appendChild(key);
            item.appendChild(value);
            legend.appendChild(item);
        }

        const loadLocations = (geoJson)=>{
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location;
                const {kecamatanId, nama, color} = properties;
                map.on('load', function(){
                    map.addSource(''+nama+'', {
                        'type':'geojson',
                        'data':{
                            'type':'Feature',
                            'geometry':{
                                'type' : 'Polygon',
                                'coordinates':[
                                    eval('[' + geometry.coordinates + ']')
                                ]
                            }
                        }
                    });

                    map.addLayer({
                        'id':''+kecamatanId+'',
                        'type':'fill',
                        'source':''+nama+'',
                        'layout':{},
                        'paint':{
                            'fill-color': ''+color+'',
                            'fill-opacity':0.8
                        }
                    });

                    map.addLayer({
                        'id':'outline'+kecamatanId+'',
                        'type':'line',
                        'source':''+nama+'',
                        'layout':{},
                        'paint':{
                            'line-color':'#fff',
                            'line-width': 2
                        }
                    });
                    const content = '<div style="overflow-y, auto; max-height:400px, width:100%">'+
                    '<table class="table table-sm mt-2 table-borderless">'+
                    '<tr><td>Nama Kecamatan:</td><td>'+nama+'</td></tr>'+
                    '</table></div>';

                    map.on('click', ''+kecamatanId+'', function(e){

                        new mapboxgl.Popup({
                            offset:25
                        }).setHTML(content)
                        .setLngLat(e.lngLat)
                        .addTo(map);
                    });

                    map.on('mouseenter', ''+kecamatanId+'', function () {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', ''+kecamatanId+'', function () {
                        map.getCanvas().style.cursor = '';
                    });
                });
            });
        }

        $.ajax({
            url: "{{ route('peta_kecamatan') }}",
            dataType: "json",
            success: function(geoJson)
            {
                loadLocations(geoJson);
            }
        });

        fill_datatable1();
        function fill_datatable1(tgl1 = '')
        {
            var dataTables1 = $('#table_kecamatan1').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_data.pontura') }}",
                    data: {tgl1:tgl1}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan',
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
                $('#table_kecamatan1').DataTable().destroy();
                fill_datatable1(tgl1);
            }
        });

        $.ajax({
            url: "{{ route('table_data.tgl1') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tgl1').val(data.result.tgl);
            }
        });

        fill_datatable2();
        function fill_datatable2(tgl2 = '')
        {
            var dataTables2 = $('#table_kecamatan2').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_data.pontur') }}",
                    data: {tgl2:tgl2}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan',
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

        $('#tgl2').on("input", function(){
            var tgl2 = $('#tgl2').val();
            if(tgl2 != '')
            {
                $('#table_kecamatan2').DataTable().destroy();
                fill_datatable2(tgl2);
            }
        });

        $.ajax({
            url: "{{ route('table_data.tgl2') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tgl2').val(data.result.tgl);
            }
        });

        fill_datatable3();
        function fill_datatable3(tgl3 = '')
        {
            var dataTables3 = $('#table_kecamatan3').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_data.ponteng') }}",
                    data: {tgl3:tgl3}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan',
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

        $('#tgl3').on("input", function(){
            var tgl3 = $('#tgl3').val();
            if(tgl3 != '')
            {
                $('#table_kecamatan3').DataTable().destroy();
                fill_datatable3(tgl3);
            }
        });

        $.ajax({
            url: "{{ route('table_data.tgl3') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tgl3').val(data.result.tgl);
            }
        });

        fill_datatable4();
        function fill_datatable4(tgl4 = '')
        {
            var dataTables4 = $('#table_kecamatan4').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_data.ponko') }}",
                    data: {tgl4:tgl4}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan',
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

        $('#tgl4').on("input", function(){
            var tgl4 = $('#tgl4').val();
            if(tgl4 != '')
            {
                $('#table_kecamatan4').DataTable().destroy();
                fill_datatable4(tgl4);
            }
        });

        $.ajax({
            url: "{{ route('table_data.tgl4') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tgl4').val(data.result.tgl);
            }
        });

        fill_datatable5();
        function fill_datatable5(tgl5 = '')
        {
            var dataTables5 = $('#table_kecamatan5').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_data.ponsel') }}",
                    data: {tgl5:tgl5}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan',
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

        $('#tgl5').on("input", function(){
            var tgl5 = $('#tgl5').val();
            if(tgl5 != '')
            {
                $('#table_kecamatan5').DataTable().destroy();
                fill_datatable5(tgl5);
            }
        });

        $.ajax({
            url: "{{ route('table_data.tgl5') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tgl5').val(data.result.tgl);
            }
        });

        fill_datatable6();
        function fill_datatable6(tgl6 = '')
        {
            var dataTables6 = $('#table_kecamatan6').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('table_data.ponbar') }}",
                    data: {tgl6:tgl6}
                },
                columns: [
                    {
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'kelurahan',
                        name: 'kelurahan',
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

        $('#tgl6').on("input", function(){
            var tgl6 = $('#tgl6').val();
            if(tgl6 != '')
            {
                $('#table_kecamatan6').DataTable().destroy();
                fill_datatable6(tgl6);
            }
        });

        $.ajax({
            url: "{{ route('table_data.tgl6') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tgl6').val(data.result.tgl);
            }
        });

        $.ajax({
            url: "{{ route('peta_kecamatan') }}",
            dataType: "json",
            success: function(data)
            {
            }
        });
    });
</script>
@endsection