<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Company;
use Modules\Report\Exports\ItemSoldExport;
use Carbon\Carbon;
use App\Models\Tenant\{
    DocumentItem,
    DocumentPosItem
};
use DB;

class ReportItemSoldController extends Controller
{

    public function index()
    {
        return view('report::co-items-sold.index');
    }

    /**
     *
     * @param  Request $request
     * @return Collection
     */
    public function getQueryRecords($request)
    {
        $document_type_id = $request->document_type_id ?? null;
        $records = [];
        switch ($document_type_id)
        {
            case 'documents':
                $records = DocumentItem::filterReportSoldItems($request)->get();
                break;

            case 'documents_pos':
                $records = DocumentPosItem::filterReportSoldItems($request)->get();
                break;

            default:
                $document_items = DocumentItem::filterReportSoldItems($request)->get();
                $document_items_pos = DocumentPosItem::filterReportSoldItems($request)->get();
                $records = $document_items->concat($document_items_pos);
                break;
        }

//        // Agrupación por item_id
//        $grouped = $records->groupBy('item_id')->map(function ($group) {
//            $first = $group->first();
//            $first->total_quantity = $group->sum('quantity');
//            return $first;
//        })->values();
//
//        return $grouped;
        return $records;
    }

    public function export(Request $request, $type)
    {
        switch ($type) {
            case 'excel':
                return $this->excel($request);
                break;

            default:
                return $this->pdf($request);
                break;
        }
    }


    /**
     *
     * @param  Request $request
     * @return mixed
     */
    public function pdf(Request $request)
    {
        $records = $this->getQueryRecords($request);
        $filters = $request;
        $company = Company::first();
        $establishment = auth()->user()->establishment;
        $pdf = PDF::loadView('report::co-items-sold.report_pdf', compact('records', 'company', 'establishment', 'filters'))->setPaper('a4', 'landscape');
        $filename = 'Reporte_Articulos_Vendidos_'.date('YmdHis');
        return $pdf->stream($filename.'.pdf');
    }

    /**
     * Excel
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request) {
        $records = $this->getQueryRecords($request);
        $filters = $request;
        $company = Company::first();
        $establishment = auth()->user()->establishment;
        return (new ItemSoldExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->filters($filters)
            ->download('ReporteArticulosVendidos'.Carbon::now().'.xlsx');
    }
}
