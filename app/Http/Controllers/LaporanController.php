<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        return view('pages.laporan.index');
    }

    public function filter(Request $request)
    {
        $periode = $request->input('periode');
        $tanggal = $request->input('tanggal');

        $orders = Order::query();

        if ($tanggal) {
            $tanggal = Carbon::parse($tanggal);
            switch ($periode) {
                case 'harian':
                    $orders->whereDate('transaction_time', $tanggal);
                    break;
                case 'mingguan':
                    $orders->whereBetween('transaction_time', [
                        $tanggal->copy()->startOfWeek(),
                        $tanggal->copy()->endOfWeek(),
                    ]);
                    break;
                case 'bulanan':
                    $orders->whereMonth('transaction_time', $tanggal->month)
                           ->whereYear('transaction_time', $tanggal->year);
                    break;
            }
        }

        $orders = $orders->with('orderItems.product')->get();

        return view('pages.laporan.result', compact('orders', 'periode', 'tanggal'));
    }

public function exportPdf(Request $request)
{
    $periode = $request->input('periode');
    $tanggal = $request->input('tanggal');

    $orders = Order::query();

    if ($tanggal) {
        $tanggal = Carbon::parse($tanggal);
        switch ($periode) {
            case 'harian':
                $orders->whereDate('transaction_time', $tanggal);
                break;
            case 'mingguan':
                $orders->whereBetween('transaction_time', [
                    $tanggal->copy()->startOfWeek(),
                    $tanggal->copy()->endOfWeek(),
                ]);
                break;
            case 'bulanan':
                $orders->whereMonth('transaction_time', $tanggal->month)
                       ->whereYear('transaction_time', $tanggal->year);
                break;
        }
    }

    $orders = $orders->with('orderItems.product')->get();

    $pdf = PDF::loadView('pages.laporan.pdf', compact('orders', 'periode', 'tanggal'));
    return $pdf->download("laporan-penjualan-{$periode}-{$tanggal->format('Y-m-d')}.pdf");
}

}
