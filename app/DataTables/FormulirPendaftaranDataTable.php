<?php

namespace App\DataTables;

use App\Models\FormulirPendaftaran;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FormulirPendaftaranDataTable extends DataTable
{
     /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at',function($query){
                return $query->created_at->format('d M Y');
            })
            ->addColumn('action', function ($query){
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
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MasterVendorDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FormulirPendaftaran $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $sekolahOptions = Sekolah::pluck('nama_sekolah', 'id')->toArray();
        $sekolahOptions = ['' => 'Semua Sekolah'] + $sekolahOptions;

        $domOption = "<'row mb-4'<'col-sm-12 col-md-2'l><'col-sm-12 col-md-6 pb-2'B>>
                          <'row'<'col-sm-12'tr>>
                      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";

        return $this->builder()
                    ->columns($this->getColumns())
                    ->parameters([
                        'initComplete' => "function () {
                            var r = $('#formulir-pendaftaran-table tfoot tr');
                            $('#formulir-pendaftaran-table thead').append(r);
                            this.api().columns().every(function (index) {
                                var column = this;
                                var input = document.createElement('input');
                                if (index === 1) { // Index 1 is the 'created_at' column
                                    input.type = 'date';
                                    input.className = 'form-control form-control-sm form-search-' + index;
                                } else if (index === 2) { // Index 2 is the 'sekolah_yang_dituju' column
                                    var select = document.createElement('select');
                                    select.className = 'form-control form-control-sm form-search-' + index + ' select2';
                                    select.options[0] = new Option('Semua Sekolah', '');
                                    $.each(" . json_encode($sekolahOptions) . ", function(key, value) {
                                        var option = new Option(value, key);
                                        select.appendChild(option);
                                    });
                                    $(select).appendTo($(column.footer()).empty()).select2({
                                        width: '100%',
                                        placeholder: 'Pilih Sekolah',
                                        allowClear: true,
                                    }).on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );
                                        column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                    }).next('.select2-container').find('.select2-selection').removeAttr('aria-haspopup aria-expanded aria-disabled role');
                                } else {
                                    input.className = 'form-control form-control-sm form-search-' + index;
                                    $(input).appendTo($(column.footer()).empty())
                                        .on('keyup change', function () {
                                            if (index === 1) {
                                                var val = $(this).val();
                                                if (val) {
                                                    column.search(val).draw();
                                                } else {
                                                    column.search('').draw();
                                                }
                                            } else {
                                                column.search($(this).val(), false, false, true).draw();
                                            }
                                        });
                                }
                            });
                        }",
                    ])
                    ->dom($domOption);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('no_pendaftaran')
                    ->title('No Pendaftaran')
                    ->footer('No Pendaftaran'),
            Column::make('created_at')
                    ->title('Tanggal Pendaftaran')
                    ->footer('Tanggal Pendaftaran'),
            Column::make('sekolah_yang_dituju')
                    ->title('Sekolah')
                    ->footer('Sekolah'),
            Column::make('jurusan')
                    ->title('Jurusan')
                    ->footer('Jurusan'),
            Column::make('nama_anak')
                    ->title('Nama Siswa')
                    ->footer('Nama Siswa'),
            Column::make('no_hp')
                    ->title('No Handphone')
                    ->footer('No Handphone'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
        ];
    }

}
