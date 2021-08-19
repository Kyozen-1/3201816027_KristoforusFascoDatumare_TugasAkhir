@extends('frontend.layouts.app')
@section('title', 'Statistik | Pontianak Covid-19')
@section('css')
<style>
    .mapboxgl-popup {
        width: 400px;
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
<div style="margin-top: 10px; margin-bottom: 50px;">
    <div id="map_pontianak" style="width: 100%; height: 600px;"></div>
    <div class="map-overlay" id="legend"></div>
</div>
<div class="text-center" id="statistik" style="margin-top: 45px;margin-right: 50px;margin-left: 50px;">
    <h2 class="text-center mb-2">Tren Data Covid-19 di Kota Pontianak</h2>
    <div class="row" style="margin-bottom: 10px;margin-top: 10px;" id="filter">
        <div class="col-md-6 text-right"></div>
        <div class="col-md-6 text-right align-self-center">
            <div class="row text-right">
                <div class="col-md-6">
                    <select name="filter_bulan" class="form-control" id="filter_bulan">
                        @foreach ($bulanans as $bulanan)
                            <option value="{{$bulanan->bulan}}">{{$bulanan->bulan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select style="margin-right: 5px;" class="form-control" name="filter_tgl" id="filter_tgl">
                        <option value="harian" selected>Harian</option>
                        <option value="bulanan">Bulanan</option>
                        <option value="tahunan">Tahunan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="tren_data_covid" style="width: 100%; height: 500px;"></div>
</div>
@endsection

@section('js')
<script src="{{ asset('metronic/assets/js/pages/features/charts/apexcharts.js') }}"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{route('statistik')}}",
            dataType: "json",
            success: function(data)
            {
                var option_trend_data = {
                    series: [
                        {
                            name: "Positif",
                            data: data.positif
                        },
                        {
                            name: "Sembuh",
                            data: data.sembuh
                        },
                        {
                            name: "Meninggal",
                            data: data.meninggal
                        }
                    ],
                    chart: {
                        height: 500,
                        type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#d9534f', '#5cb85c', '#000000'],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Data Positif, Sembuh, dan Meninggal Covid-19 Kota Pontianak',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 1
                    },
                    xaxis: {
                        categories: data.tgl,
                    },
                    yaxis: {
                        title: {
                            text: 'Tren Covid-19 Pontianak'
                        },
                    },
                    legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };
                var chart = new ApexCharts(document.querySelector("#tren_data_covid"), option_trend_data);

                chart.render();
            }
        });
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
                const {kecamatanId, nama, color, positif, positif_isolasi, meninggal, suspek, kontak_erat,tgl} = properties;
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
                    const content = '<div style="overflow-y, auto; max-height:200px, width:300px">'+
                    '<table class="table table-sm mt-2 table-borderless">'+
                    '<tr><td>Nama Kecamatan:</td><td>'+nama+'</td></tr>'+
                    '<tr><td>Per Tanggal:</td><td>'+tgl+'</td></tr>'+
                    '<tr><td colspan="2"><div id="bar'+kecamatanId+'"></div></td></tr>'+
                    '</table></div>';

                    map.on('click', ''+kecamatanId+'', function(e){

                        new mapboxgl.Popup({
                            offset:25
                        }).setHTML(content).setMaxWidth("500px")
                        .setLngLat(e.lngLat)
                        .addTo(map);

                        var options= {
                            series: [{
                                data: [positif, positif_isolasi, meninggal, suspek, kontak_erat]
                            }],
                            chart: {
                                height: 200,
                                type: 'bar',
                                toolbar: {
                                    show: true,
                                    tools: {
                                        download: false
                                    }
                                }
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '45%',
                                    distributed: true,
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            legend: {
                                show: false
                            },
                            xaxis: {
                                categories: ['Positif', 'Positif (Isolasi)', 'Meninggal', 'Suspek', 'Kontak Erat'],
                                labels: {
                                    style: {
                                    fontSize: '12px'
                                    }
                                }
                            }
                        };
                        var chart = new ApexCharts(document.getElementById('bar'+kecamatanId), options);
                        chart.render();
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
            url: "{{ route('statistik_peta_kecamatan') }}",
            dataType: "json",
            success: function(geoJson)
            {
                loadLocations(geoJson);
            }
        });
    });

    $('#filter_tgl').change(function(){
        if($(this).val() == "harian")
        {
            document.getElementById("filter_bulan").style.display = "block";
        }
        if($(this).val() == "bulanan")
        {
            document.getElementById("filter_bulan").style.display = "none";
            $('#filter_bulan')[0].selectedIndex = 0;
        }
        if($(this).val() == "tahunan")
        {
            document.getElementById("filter_bulan").style.display = "none";
            $('#filter_bulan')[0].selectedIndex = 0;  
        }
        var filter = $('#filter_tgl').val();
        var bln = $('#filter_bulan').val();
        $.ajax({
            url:"/statistik/filter/"+filter+"/"+bln,
            dataType: "json",
            success: function(data)
            {
                $('#tren_data_covid').remove();
                var trenDiv = $('<div style="width: 100%; height: 500px;"></div>');
                $('#filter').append(trenDiv);
                trenDiv.attr('id', 'tren_data_covid');
                var option_trend_data = {
                    series: [
                        {
                            name: "Positif",
                            data: data.positif
                        },
                        {
                            name: "Sembuh",
                            data: data.sembuh
                        },
                        {
                            name: "Meninggal",
                            data: data.meninggal
                        }
                    ],
                    chart: {
                        height: 500,
                        type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#d9534f', '#5cb85c', '#000000'],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Data Positif, Sembuh, dan Meninggal Covid-19 Kota Pontianak',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 1
                    },
                    xaxis: {
                        categories: data.tgl,
                    },
                    yaxis: {
                        title: {
                            text: 'Tren Covid-19 Pontianak'
                        },
                    },
                    legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };

                var chart = new ApexCharts(document.querySelector("#tren_data_covid"), option_trend_data);
                chart.render();
            }
        });
    });

    $('#filter_bulan').change(function(){
        var filter = $('#filter_tgl').val();
        var bln = $('#filter_bulan').val();
        $.ajax({
            url:"/statistik/filter/"+filter+"/"+bln,
            dataType: "json",
            success: function(data)
            {
                $('#tren_data_covid').remove();
                var trenDiv = $('<div style="width: 100%; height: 500px;"></div>');
                $('#filter').append(trenDiv);
                trenDiv.attr('id', 'tren_data_covid');
                var option_trend_data = {
                    series: [
                        {
                            name: "Positif",
                            data: data.positif
                        },
                        {
                            name: "Sembuh",
                            data: data.sembuh
                        },
                        {
                            name: "Meninggal",
                            data: data.meninggal
                        }
                    ],
                    chart: {
                        height: 500,
                        type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#d9534f', '#5cb85c', '#000000'],
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: 'Data Positif, Sembuh, dan Meninggal Covid-19 Kota Pontianak',
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 1
                    },
                    xaxis: {
                        categories: data.tgl,
                    },
                    yaxis: {
                        title: {
                            text: 'Tren Covid-19 Pontianak'
                        },
                    },
                    legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };

                var chart = new ApexCharts(document.querySelector("#tren_data_covid"), option_trend_data);
                chart.render();
            }
        });
    });
</script>
@endsection