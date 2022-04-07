<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityUserResource;
use App\Http\Resources\RequestUserResource;
use App\Models\Country;
use App\Models\ErrorLog;
use App\Models\Inventory;
use App\Models\Ticket;
use App\Traits\ExceptionLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ExceptionLog;

    public function requestByUser() {
        try {
            $ticketData = Ticket::selectRaw("count(case when status = 'open' then 0 end) as open")
            ->selectRaw("count(case when status = 'pending' then 0 end) as pending")
            ->selectRaw("count(case when status = 'closed' then 0 end) as closed")
            ->selectRaw('created_by')
            ->groupBy('created_by')
            ->get();

            return RequestUserResource::collection($ticketData)->additional(['success' => true]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function hardwareInventory() {
        try {
            $inventory = Inventory::selectRaw('count(*) as totalinventory')
            ->selectRaw("count(case when status = 'available' then 0 end) as available")
            ->selectRaw("count(case when status = 'assign' then 0 end) as assign")
            ->get();

            return response()->json(['success' => true, 'data' => $inventory]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function trackByContry() {
        try {
            $trackCountry = Country::get();
            foreach ($trackCountry as $value) {
                foreach ($value->ticket as $v) {
                   $count = [
                    'country_name' => $value->country_name,
                    'country_code' => $value->country_code,
                    'totaltikit' =>  $v->count(),
                   ];
                }
            }
            return response()->json(['success' => true, 'totalticket' => $count]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function ticketRequest() {
        try {
        $dailycount = Ticket::whereDate('created_at', Carbon::today())->get();
        $weeklycount = Ticket::whereDate('created_at', Carbon::now()->subDays(7))->get();
        $monthlycount = Ticket::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
        return response()->json([
                'success' => true,
                'daily' => $dailycount,
                'weekly' => $weeklycount,
                'monthly' => $monthlycount,
                // 'high' => PriorityUserResource::collection($HighTicketList),
            ]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function ticketPriorityLevel() {
        try {
            $LowTicketList = Ticket::with('support')->where('priority','low')->get();
            $MedimumTicketList = Ticket::with('support')->where('priority', 'medium')->get();
            $HighTicketList = Ticket::with('support')->where('priority','high')->get();

            return response()->json([
                'success' => true,
                'low' => PriorityUserResource::collection($LowTicketList),
                'medium' => PriorityUserResource::collection($MedimumTicketList),
                'high' => PriorityUserResource::collection($HighTicketList),
            ]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }
}
