@extends('layouts.app')

@section('content')

<!-- Page title & breadcrumb -->
<div class="cr-page-title">
    <div class="cr-breadcrumb">
        <h5>Dashboard</h5>
    </div>
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-md-4">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div class="title">
                            <span class="icon icon-1"><i class="ri-shield-user-line"></i></span>
                            <div class="growth-numbers">
                                <h4>Pendaftar</h4>
                                <h5>{{$total_pendaftar}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div class="title">
                            <span class="icon icon-2"><i class="ri-archive-drawer-fill"></i></span>
                            <div class="growth-numbers">
                                <h4>Sudah Daftar Ulang</h4>
                                <h5>{{$total_sudah_verifikasi}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div class="title">
                            <span class="icon icon-3"><i class="ri-exchange-dollar-line"></i></span>
                            <div class="growth-numbers">
                                <h4>Total DSP</h4>
                                <h5>Rp {{$total_dsp}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-md-6">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div id="chart-sekolah" style="width:100%; height:400px; margin-top:2px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cr-card">
                    <div class="cr-card-content label-card">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control" id="filter">
                                        <option selected>All</option>
                                        @foreach($sekolah as $list)
                                        <option value="{{ $list->id }}">{{ $list->nama_sekolah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="chart-jurusan" style="width:100%; margin-top:2px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-md-12">
                <div class="cr-card">
                    <div class="cr-card-content label-card">

                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" id="filter-sekolah-spline">
                                        <option value="all" selected>Semua Sekolah</option>
                                        @foreach($sekolah as $list)
                                        <option value="{{ $list->id }}">{{ $list->nama_sekolah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="filter-jurusan-spline">
                                        <option value="all" selected>Semua Jurusan </option>
                                        @foreach($jurusan as $list)
                                        <option value="{{ $list->id }}">{{ $list->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="trend-chart" style="width:100%; height:400px;margin-top:30px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script>
    function fetchChartData(filter) {
        $.ajax({
            url: "{{ route('home.chart-jurusan') }}",
            method: 'GET',
            data: { sekolah: filter },
            success: function(response) {
                Highcharts.chart('chart-jurusan', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: 'Pendaftaran Berdasarkan Jurusan'
                    },
                    plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 35,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name}'
                                }
                            }
                        },
                    series: [{
                        name: 'Pendaftar',
                        colorByPoint: true,
                        data: response.labels.map(function(label, index) {
                            return {
                                name: label,
                                y: response.series[index]
                            };
                        })
                    }]
                });
            },
            error: function(error) {
                console.error('Error fetching chart data:', error);
            }
        });
    }

    function fetchTrendData() {
            $.ajax({
                url: "{{ route('home.trend') }}",
                method: 'GET',
                data : {
                    sekolah: $('#filter-sekolah-spline').val(),
                    jurusan: $('#filter-jurusan-spline').val()
                },
                success: function(response) {
                    Highcharts.chart('trend-chart', {
                        chart: {
                            type: 'spline'
                        },
                        title: {
                            text: "Pendaftaran Bedasarkan Tanggal"
                        },
                        xAxis: {
                            categories: response.labels
                        },
                        yAxis: {
                            title: {
                                text: 'Jumlah Pendaftar'
                            }
                        },
                        series: [{
                            name: 'Jumlah Pendaftar',
                            data: response.series
                        }]
                    });
                },
                error: function(error) {
                    console.error('Error fetching trend data:', error);
                }
            });
        }

    $(document).ready(function() {
        var filter = $('#filter').val();
        fetchChartData(filter);
        fetchTrendData();

        $('#filter').on('change', function() {
            var selectedFilter = $(this).val();
            fetchChartData(selectedFilter);
        });

        $('#filter-sekolah-spline').on('change', function() {
            fetchTrendData();
        });

        $('#filter-jurusan-spline').on('change', function() {
            fetchTrendData();
        });

        $.ajax({
            url: "{{ route('home.chart') }}",
            method: 'GET',
            success: function(response) {
                Highcharts.chart('chart-sekolah', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: 'Pendaftaran Berdasarkan Jurusan'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}'
                            }
                        }
                    },
                    series: [{
                        name: 'Pendaftar',
                        colorByPoint: true,
                        data: response.labels.map(function(label, index) {
                            return {
                                name: label,
                                y: response.series[index]
                            };
                        })
                    }]
                });
            },
            error: function(error) {
                console.error('Error fetching chart data:', error);
            }
        });
    });
</script>
@endsection
