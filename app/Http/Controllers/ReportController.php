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
        $type  = $request->get('type');
        $start = $request->get('start');
        $end   = $request->get('end');

        $data = collect();

        if ($type === 'reservasi') {
            $query = Reservasi::query()
                        ->orderBy('start_date', 'desc');
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->paginate(20)->withQueryString();

        } elseif ($type === 'pembayaran') {
            $query = Pembayaran::query()
                        ->orderBy('payment_date', 'desc');
            if ($start && $end) {
                $query->whereBetween('payment_date', [$start, $end]);
            }
            $data = $query->paginate(20)->withQueryString();

        } elseif ($type === 'pembatalan') {
            $query = Reservasi::where('status', 'cancelled')
                        ->orderBy('start_date', 'desc');
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->paginate(20)->withQueryString();
        }

        return view('report.index', compact('data', 'type', 'start', 'end'));
    }

    public function export(Request $request)
    {
        $type  = $request->get('type');
        $start = $request->get('start');
        $end   = $request->get('end');

        $data = collect();

        if ($type === 'reservasi') {
            $query = Reservasi::query()
                        ->orderBy('start_date', 'desc');
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->get();

        } elseif ($type === 'pembayaran') {
            $query = Pembayaran::query()
                        ->orderBy('payment_date', 'desc');
            if ($start && $end) {
                $query->whereBetween('payment_date', [$start, $end]);
            }
            $data = $query->get();

        } elseif ($type === 'pembatalan') {
            $query = Reservasi::where('status', 'cancelled')
                        ->orderBy('start_date', 'desc');
            if ($start && $end) {
                $query->whereBetween('start_date', [$start, $end]);
            }
            $data = $query->get();
        }

        $pdf = Pdf::loadView('report.pdf', compact('data', 'type', 'start', 'end'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download("laporan-{$type}.pdf");
    }
}
