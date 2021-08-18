@extends('frontend.layouts.app')
@section('title', 'Rumah Sakit Rujukan | Pontianak Covid-19')

@section('css')
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
@endsection

@section('content')
<div id="peta" style="margin-top: 10px;margin-bottom: 100px;width: 100%; height: 600px;"></div>
<div id="table-data-rs" style="margin-right: 49px;margin-left: 50px;margin-bottom: 50px;">
    <h2 class="text-center" style="margin-bottom: 20px;">Data Rumah Sakit</h2>
    <p class="text-right">Pertanggal: <span id="tanggal_data"></span></p>
    <div class="table-responsive text-center">
        <table class="table table-bordered" id="table_rs_kecamatan">
            <thead class="thead-dark justify-content-center">
                <tr class="text-center">
                    <th class="text-center" style="text-align: center;">Nama Rumah Sakit</th>
                    <th class="text-center">Ketersediaan&nbsp;<br>tempat&nbsp;tidur&nbsp;<br>ICU<br></th>
                    <th class="text-center">Jumlah&nbsp;Tempat&nbsp;Tidur&nbsp;<br>ICU&nbsp;Terisi&nbsp;Pasien&nbsp;Positif&nbsp;<br>Covid-19&nbsp;+&nbsp;Suspek<br></th>
                    <th class="text-center">BOR&nbsp;ICU&nbsp;(%)<br></th>
                    <th class="text-center"><br>Ketersediaan&nbsp;<br>Tempat&nbsp;Tidur&nbsp;<br>Isolasi<br></th>
                    <th class="text-center"><br>Jumlah&nbsp;Tempat&nbsp;<br>Tidur&nbsp;Terisi&nbsp;<br>Positif&nbsp;Covid-19<br></th>
                    <th class="text-center">Jumlah&nbsp;Kamar&nbsp;<br>Tidur&nbsp;Terisi&nbsp;<br>Suspek<br></th>
                    <th>BOR&nbsp;Isolasi&nbsp;(%)<br></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('js')
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
<script src="{{ asset('metronic/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jpc3RvZm9ydXMiLCJhIjoiY2twZzNhZ3MwMDBlbzJucDRwNmhuYmZiZCJ9.7PP-LErWIjLon-ZiT9q_xA';
    var map = new mapboxgl.Map({
        container: 'peta', // container id
        style: 'mapbox://styles/mapbox/streets-v11', // style URL
        center: [109.34468508260471, -0.023170800986903828], // starting position [lng, lat]
        zoom: 11 // starting zoom
    });

    // map.on('click', (e) => {
    //         const longtitude = e.lngLat.lng;
    //         const lattitude = e.lngLat.lat;

    //         console.log({longtitude, lattitude});
    //     });

    var geolocate = new mapboxgl.GeolocateControl();

    map.addControl(new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    }));
    map.addControl(geolocate);
    geolocate.on('geolocate', function(e){
        map.setZoom(11);
    });
    map.addControl(new mapboxgl.NavigationControl());

    const loadLocations = (geoJson) => {
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location;
                const {locationId, title, k_icu, jlh_tmpt_icu, bor_icu, k_isolasi, jlh_tmpt_positif, jlh_tmpt_suspek, bor_isolasi, tersisa_icu, tersisa_isolasi,tgl} = properties;
                let markerElement = document.createElement('div');
                markerElement.className = 'marker' + locationId;
                markerElement.style.backgroundImage = "url({{asset('images/icons/icon_location.png')}})";
                markerElement.style.backgroundSize = 'cover';
                markerElement.style.width = '50px';
                markerElement.style.height = '50px';

                const content = '<div style="overflow-y, auto; max-height:400px, width:100%">'+
                '<table class="table table-sm mt-2 table-borderless">'+
                '<tr><td>Nama Rumah Sakit:</td><td>'+title+'</td></tr>'+
                '<tr><td>Kapasitas ICU:</td><td>'+k_icu+'</td></tr>'+
                '<tr><td>Jumlah ICU Terisi:</td><td>'+jlh_tmpt_icu+'</td></tr>'+
                '<tr><td>BOR ICU (%):</td><td>'+bor_icu+'</td></tr>'+
                '<tr><td>Kapasitas Isolasi:</td><td>'+k_isolasi+'</td></tr>'+
                '<tr><td>Jumlah Terisi Pasien Positif:</td><td>'+jlh_tmpt_positif+'</td></tr>'+
                '<tr><td>Jumlah Terisi Suspek:</td><td>'+jlh_tmpt_suspek+'</td></tr>'+
                '<tr><td>BOR Isolasi (%):</td><td>'+bor_isolasi+'</td></tr>'+
                '<tr><td>Per Tanggal:</td><td>'+tgl+'</td></tr>'+
                '<tr><td><div id="bor_isolasi"></div></td></tr>'
                '</table></div>';
                const popUp = new mapboxgl.Popup({
                    offset:25
                }).setHTML(content).setMaxWidth("400px");

                new mapboxgl.Marker(markerElement)
                .setLngLat(geometry.coordinates)
                .setPopup(popUp)
                .addTo(map);              
            });
        }
        $.ajax({
            url: "{{ route('rumah_sakit.data_covid') }}",
            dataType: "json",
            success: function(geoJson)
            {
                loadLocations(geoJson);
            }
        });
        var dataTables1 = $('#table_rs_kecamatan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('rumah_sakit') }}"
            },
            columns: [
                {
                    data: 'rs',
                    name: 'rs',
                },
                {
                    data: 'k_icu',
                    name: 'k_icu'
                },
                {
                    data: 'jlh_tmpt_icu',
                    name: 'jlh_tmpt_icu'
                },
                {
                    data: 'bor_icu',
                    name: 'bor_icu'
                },
                {
                    data: 'k_isolasi',
                    name: 'k_isolasi'
                },
                {
                    data: 'jlh_tmpt_positif',
                    name: 'jlh_tmpt_positif'
                },
                {
                    data: 'jlh_tmpt_suspek',
                    name: 'jlh_tmpt_suspek'
                },
                {
                    data: 'bor_isolasi',
                    name: 'bor_isolasi'
                }
            ]
        });

        $.ajax({
            url: "{{ route('rumah_sakit.tgl') }}",
            dataType: "json",
            success: function(data)
            {
                $('#tanggal_data').text(data.result.tgl);
            }
        });
</script>
@endsection