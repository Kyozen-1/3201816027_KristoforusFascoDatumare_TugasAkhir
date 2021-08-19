@extends('frontend.layouts.app')
@section('title', 'Home | Pontianak Covid-19')

@section('css')
<style>
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
        height: 100px;
        margin-bottom: 40px;
        width: 150px;
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
<div class="mt-5" id="c19_ptk" style="margin-right: 50px;margin-left: 50px; margin-bottom:50px;">
    <h5 class="text-right mb-2">Pertanggal:&nbsp;<span id="tgl"></span></h5>
    <div class="row text-center justify-content-center align-items-center">
        <div class="col-md-2 justify-content-center align-item-center mr-2 card shadow bg-info text-white" style="height: 200px;">
            <h3 class="text-center">Kontak Erat</h3><label class="text-center" id="kontak_erat"></label>
        </div>
        <div class="col-md-4 justify-content-center align-item-center mr-2 card shadow bg-warning text-white" style="height: 200px;">
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <h3 style="margin-top: 5px;">Suspek</h3><label id="suspek"></label>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <h4 id="di_rs"></h4><label>Di rawat di RS</label>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <h4 id="discarded"></h4><label>Discarded</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col align-self-end">
                            <h4 id="probable"></h4><label>Probable</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 justify-content-center align-item-center mr-2 card shadow bg-danger text-white" style="height: 200px;">
            <div class="row">
                <div class="col-md-4 align-self-center">
                    <h4 style="margin-top: 5px;">Konfirmasi Positif</h4><label id="positif"></label>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-md-6 align-self-center">
                            <h4 id="isolasi"></h4><label>Perawatan Isolasi</label>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <h4 id="meninggal"></h4><label>Meninggal</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col align-self-end">
                            <h4 id="sembuh"></h4><label>Sembuh</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
{{-- <script src="{{ asset('metronic/assets/js/pages/crud/datatables/search-options/advanced-search.js') }}"></script> --}}
<script>
    $(document).ready(function(){
        mapboxgl.accessToken = 'pk.eyJ1Ijoia3Jpc3RvZm9ydXMiLCJhIjoiY2twZzNhZ3MwMDBlbzJucDRwNmhuYmZiZCJ9.7PP-LErWIjLon-ZiT9q_xA';
        var map = new mapboxgl.Map({
            container: 'map_pontianak', // container id
            style: 'mapbox://styles/mapbox/light-v10', // style URL
            center: [109.32880642681448, -0.02008090342398816], // starting position [lng, lat]
            zoom: 12 // starting zoom
        });

        var geolocate = new mapboxgl.GeolocateControl({
                            positionOptions: {
                                enableHighAccuracy: true
                            },
                            trackUserLocation: true
                        });
        map.addControl(geolocate);
        geolocate.on('geolocate', function(e){
            map.setZoom(12);
        });
        map.addControl(new mapboxgl.NavigationControl());
        var layers = ['Zona Merah', 'Zona Orange', 'Zona Kuning', 'Zona Hijau'];
        var colors = ['#fb2205', '#ff9302','#ffe309', '#019f43' ];
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
        // map.on('click', (e) => {
        //     const longtitude = e.lngLat.lng;
        //     const lattitude = e.lngLat.lat;

        //     console.log({longtitude, lattitude});
        // });

        const loadLocations = (geoJson)=>{
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location;
                const {kelurahanId, nama, kontak_erat, suspek, positif, positif_isolasi, meninggal, color, tgl} = properties;
                map.on('load', function(){
                    geolocate.trigger(); 
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
                        'id':''+kelurahanId+'',
                        'type':'fill',
                        'source':''+nama+'',
                        'layout':{},
                        'paint':{
                            'fill-color': ''+color+'',
                            'fill-opacity':0.5
                        }
                    });

                    map.addLayer({
                        'id':'outline'+kelurahanId+'',
                        'type':'line',
                        'source':''+nama+'',
                        'layout':{},
                        'paint':{
                            'line-color':'#fff',
                            'line-width': 2
                        }
                    });
                    let pesan = '';
                    if (color == '#f71010') {
                        pesan = '<tr><td colspan="2" class="text-center"><span class="text-danger text-primary font-weight-bold">Zona Merah! Ikuti Prokes Ketat Demi Kesehatan Anda</span></td></tr>'
                    } else {
                        pesan ='<tr><td colspan="2" class="text-center"><span class="text-warning text-primary font-weight-bold">Selalu Waspada! Selalu Ingat Gerakan 5M Protokol Kesehatan</span></td></tr>'
                    }
                    const content = '<div style="overflow-y, auto; max-height:400px, width:100%"> <table class="table table-sm mt-2 table-borderless">'+
                    '<tr><td>Nama Kelurahan:</td><td>'+nama+'</td></tr>'+
                    '<tr><td>Positif:</td><td>'+positif+'</td></tr>'+
                    '<tr><td>Positif Isolasi:</td><td>'+positif_isolasi+'</td></tr>'+
                    '<tr><td>Suspek:</td><td>'+suspek+'</td></tr>'+
                    '<tr><td>Kontak Erat:</td><td>'+kontak_erat+'</td></tr>'+
                    '<tr><td>Meninggal:</td><td>'+meninggal+'</td></tr>'+
                    '<tr><td>Per Tanggal:</td><td>'+tgl+'</td></tr>'+
                    pesan+
                    '</table></div>';

                    map.on('click', ''+kelurahanId+'', function(e){

                        new mapboxgl.Popup({
                            offset:25
                        }).setHTML(content)
                        .setLngLat(e.lngLat)
                        .addTo(map);
                    });

                    map.on('mouseenter', ''+kelurahanId+'', function () {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', ''+kelurahanId+'', function () {
                        map.getCanvas().style.cursor = '';
                    });
                });
            });
        }

        $.ajax({
            url: "{{ route('peta_utama') }}",
            dataType: "json",
            success: function(geoJson)
            {
                loadLocations(geoJson);
            }
        });

        $.ajax({
            url: "{{ route('home.data_ptk') }}",
            dataType: "json",
            success: function(data)
            {
                console.log(data.c19_ptk.di_rs);
                let kontak_erat = data.c19_klh.map(({kontak_erat}) => kontak_erat);
                let suspek = data.c19_klh.map(({suspek}) => suspek);
                let positif = data.c19_klh.map(({positif}) => positif);

                $('#kontak_erat').text(kontak_erat[0]);
                $('#suspek').text(suspek[0]);
                $('#positif').text(positif[0]);
                $('#di_rs').text(data.c19_ptk.di_rs);
                $('#probable').text(data.c19_ptk.probable);
                $('#discarded').text(data.c19_ptk.discarded);
                $('#isolasi').text(data.c19_ptk.isolasi);
                $('#sembuh').text(data.c19_ptk.sembuh);
                $('#meninggal').text(data.c19_ptk.meninggal);
                $('#tgl').text(data.c19_ptk.tgl);
            }
        });
    });
</script>
@endsection