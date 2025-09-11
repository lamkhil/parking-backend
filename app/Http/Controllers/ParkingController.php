<?php

namespace App\Http\Controllers;

use App\Models\ParkingRateRule;
use App\Models\ParkingTicket;
use App\Models\VehicleType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ParkingController extends Controller
{
    /**
     * Entry (Gate In) - Buat tiket baru
     */
    public function entry(Request $request)
    {
        $request->validate([
            'gate_in_id' => 'required|exists:parking_gates,id',
            'vehicle_plate_number' => 'required|string',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'photo_in' => 'nullable|image|max:2048',
        ]);

        $ticket = ParkingTicket::create([
            'gate_in_id' => $request->gate_in_id,
            'ticket_number' => strtoupper(Str::random(10)),
            'vehicle_plate_number' => $request->vehicle_plate_number,
            'created_by' => $request->user()->id ?? null,
            'updated_by' => $request->user()->id ?? null,
            'ip_address' => $request->ip(),
            'photo_in' => $request->file('photo_in')->store('photos', 'public'),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return response()->json([
            'message' => 'Tiket berhasil dibuat',
            'ticket' => $ticket,
        ]);
    }

    /**
     * Exit + Payment
     */
    public function exitAndPay(Request $request, $id)
    {
        $request->validate([
            'gate_out_id' => 'required|exists:parking_gates,id',
            'payment_method' => 'required|in:cash,qris',
            'paid_by' => 'nullable|string',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'photo_out' => 'nullable|image|max:2048',
        ]);

        $ticket = ParkingTicket::findOrFail($id);

        if ($ticket->status !== 'active') {
            return response()->json(['message' => 'Tiket tidak aktif atau sudah dibayar'], 400);
        }

        $exitTime = Carbon::now();
        $durationMinutes = $ticket->created_at->diffInMinutes($exitTime);

        // Hitung tarif berdasarkan rules
        $rules = ParkingRateRule::where('vehicle_type_id', $request->vehicle_type_id)->get();
        $amount = $this->calculateAmount($rules, $durationMinutes);

        // Update tiket
        $ticket->update([
            'gate_out_id' => $request->gate_out_id,
            'exited_at' => $exitTime,
            'duration_minutes' => $durationMinutes,
            'amount' => $amount,
            'status' => 'paid',
            'payment_method' => $request->payment_method,
            'paid_by' => auth()->user()->id ?? null,
            'paid_at' => now(),
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil',
            'ticket' => $ticket,
        ]);
    }

    public function entryAndExit(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string',
            'vehicle_plate_number' => 'required|string',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'payment_method' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        if (ParkingTicket::where('ticket_number', $request->ticket_number)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Ticket sudah diinput'
            ], 401);
        }

        // Buat tiket baru
        $ticket = ParkingTicket::create([
            'gate_in_id' => auth()->user()->parking_gate_id ?? null,
            'gate_out_id' => auth()->user()->parking_gate_id ?? null,
            'shift_id' => auth()->user()->shift_id,
            'ticket_number' => $request->ticket_number,
            'vehicle_plate_number' => $request->vehicle_plate_number,
            'created_by' => auth()->user()->id ?? null,
            'updated_by' => auth()->user()->id  ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'vehicle_type_id' => $request->vehicle_type_id,
            'payment_method' => $request->payment_method,
            'photo_in' => $request->file('photo') != null ? $request->file('photo')->store('photos', 'public') : null,
            'photo_out' => $request->file('photo') != null ? $request->file('photo')->store('photos', 'public') : null,
        ]);

        // Hitung durasi parkir (misal 1 menit untuk simulasi)
        $exitTime = Carbon::now()->addMinute();
        $durationMinutes = $ticket->created_at->diffInMinutes($exitTime);

        // Hitung tarif berdasarkan rules
        $rules = ParkingRateRule::where('vehicle_type_id', $request->vehicle_type_id)->get();
        $amount = $this->calculateAmount($rules, $durationMinutes);

        // Update tiket untuk exit dan payment
        $ticket->update([
            'exited_at' => $exitTime,
            'duration_minutes' => (int)$durationMinutes,
            'amount' => $amount
        ]);

        return response()->json([
            'message' => 'Tiket berhasil dibuat',
            'data' => $ticket->load('parkingGateIn', 'parkingGateOut','shift', 'vehicleType'),
        ]);
    }

    public function pay(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string|exists:parking_tickets,ticket_number',
        ]);

        // Cari tiket
        $ticket = ParkingTicket::where('ticket_number', $request->ticket_number)->first();

        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan',
            ], 404);
        }

        // Cek apakah sudah dibayar
        if ($ticket->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah dibayar sebelumnya',
                'data' =>  $ticket->load('parkingGateIn', 'parkingGateOut','shift', 'vehicleType'),
            ], 400);
        }

        // Update tiket untuk pembayaran
        $ticket->update([
            'status' => 'paid',
            'paid_by' => auth()->user()->id ?? null,
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            'data' =>  $ticket->load('parkingGateIn', 'parkingGateOut','shift', 'vehicleType'),
        ]);
    }

    /**
     * Hitung biaya parkir
     */
    private function calculateAmount($rules, $durationMinutes)
    {
        $amount = 0;

        foreach ($rules as $rule) {
            if (
                $durationMinutes >= $rule->start_minute &&
                (is_null($rule->end_minute) || $durationMinutes <= $rule->end_minute)
            ) {
                if ($rule->fixed_price) {
                    $amount += $rule->fixed_price;
                }

                if ($rule->per_hour_price) {
                    $hours = ceil($durationMinutes / 60);
                    $amount += $hours * $rule->per_hour_price;
                }

                if ($rule->per_day_price) {
                    $days = ceil($durationMinutes / (60 * 24));
                    $amount += $days * $rule->per_day_price;
                }
            }
        }

        return $amount;
    }

    /**
     * List semua tiket
     */
    public function index()
    {
        return ParkingTicket::latest()->paginate(20);
    }

    /**
     * Detail tiket
     */
    public function show($id)
    {
        return ParkingTicket::findOrFail($id);
    }

    public function vehicleType()
    {
        $vehicleType = VehicleType::with('parkingRateRules')->get();

        return response()->json([
            'data' => $vehicleType,
            'message' => 'Fetch Data Successfully'
        ]);
    }
}
