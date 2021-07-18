<?php

namespace App\Http\Controllers;

use App\Models\Donation;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use RealRashid\SweetAlert\Facades\Alert;

class DonationController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        return view('donasi', [
            'pagetitle' => 'Donasi',
            'pagedesc' => 'Untuk memperpanjang usia website',
            'pageid' => 'donasi',
            'donators' => Donation::where('donor_status', 'success')->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_mail' => 'required|email',
            'donation_type' => 'required|in:Domain,Server',
            'donor_amount' => 'required|numeric|min:10000',
            'donor_note' => 'nullable|string|max:500',
        ]);

            if (Auth::check()) {
                $donor_id = Str::uuid();
            }
            else {
                $donor_id = uniqid();
            }

            $donation = Donation::create([
                'donor_id' => $donor_id,
                'donor_name' => $request->donor_name,
                'donor_mail' => $request->donor_mail,
                'donation_type' => $request->donation_type,
                'donor_amount' => intval($request->donor_amount),
                'donor_note' => $request->donor_note,
                'donor_date' => date('Y-m-d h:i:s', time()),
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $donation->donor_id,
                    'gross_amount' => $donation->donor_amount, // no decimal allowed for creditcard
                ],

                'customer_details' => [
                    'first_name'    => $donation->donor_name,
                    'email'         => $donation->donor_mail,
                ],

                'item_details' => [
                    [
                        'id' => $donation->donation_type,
                        'price' => $donation->donor_amount,
                        'quantity' => 1,
                        'name' => 'Donasi Biaya ' . $donation->donation_type,
                    ],
                ],
            ];

            $donation->save();

            try {
                $paymentUrl = \Midtrans\Snap::createTransaction($payload)->redirect_url;
                return redirect()->away($paymentUrl);
            }
            catch (Exception $e) {
                Alert::error('Error', $e->getMessage());
                return redirect()->route('donasi');
            }
    }

    public function notification()
    {
        $notif = new \Midtrans\Notification();

        DB::transaction(function() use($notif) {
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;

            $donation = Donation::where('donor_id', $orderId)->first();

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $donation->statusPending();
                    }
                    else {
                      $donation->statusSuccess();
                    }
                }
            }
            else if ($transactionStatus == 'settlement') {
                $donation->statusSuccess();
            }
            else if ($transactionStatus == 'pending') {
                $donation->statusPending();
            }
            else if ($transactionStatus == 'deny') {
                $donation->statusFailed();
            }
            else if ($transactionStatus == 'expire') {
                $donation->statusExpired();
            }
            else if ($transactionStatus == 'cancel') {
                $donation->statusCanceled();
            }
        });

        return;
    }

    public function donasi_finish()
    {
        Alert::success('Terima Kasih', 'Donasi dari anda telah kami terima!');
        return redirect()->route('donasi');
    }

    public function donasi_error(Request $request)
    {
        Alert::success('Error', 'Ada kesalahan dalam sistem pembayaran!');
        return redirect()->route('donasi');
    }
}
