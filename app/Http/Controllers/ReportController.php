<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $type  = $request->type;
        $start = $request->start;
        $end   = $request->end;

        $data = collect(); // default collection kosong

        if ($type === 'reservasi') {
            $query = Reservasi::query();
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->paginate(20)->withQueryString();
        } elseif ($type === 'pembayaran') {
            $query = Pembayaran::query();
            if ($start && $end) {
                $query->whereBetween('payment_date', [$start, $end]);
            }
            $data = $query->paginate(20)->withQueryString();
        } elseif ($type === 'pembatalan') {
            $query = Reservasi::where('status', 'cancelled');
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->paginate(20)->withQueryString();
        }

        return view('report.index', compact('data', 'type', 'start', 'end'));
    }

    public function export(Request $request)
    {
        $type  = $request->type;
        $start = $request->start;
        $end   = $request->end;

        $data = collect();

        if ($type === 'reservasi') {
            $query = Reservasi::query();
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->get();
        } elseif ($type === 'pembayaran') {
            $query = Pembayaran::query();
            if ($start && $end) {
                $query->whereBetween('payment_date', [$start, $end]);
            }
            $data = $query->get();
        } elseif ($type === 'pembatalan') {
            $query = Reservasi::where('status', 'cancelled');
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->get();
        }

        $pdf = Pdf::loadView('report.pdf', compact('data', 'type', 'start', 'end'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-' . $type . '.pdf');
    }
}
