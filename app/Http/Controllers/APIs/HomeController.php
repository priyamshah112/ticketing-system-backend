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
use DB;
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
            ->selectRaw("count(case when status = 'Available' then 0 end) as available")
            ->selectRaw("count(case when status = 'Not Available' then 0 end) as assign")
            ->get();

            return response()->json(['success' => true, 'data' => $inventory]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function trackByContry() {

        $countCountry = array();
        try {
            $trackCountry = Country::get();
            foreach ($trackCountry as $value) {
                   $countryData['country_name'] = $value->country_name;
                   $countryData['count'] = $value->ticket->count();
                   array_push($countCountry,$countryData);
            }
            return response()->json(['success' => true, 'totalticket' => $countCountry]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }
    
    public function countries() {
        try {
            $countries = Country::select('id','country_code','country_name')->get();
            return response()->json(['success' => true, 'countries' => $countries]);
        } catch (\Exception $exception) {
            $this->exceptionHandle($exception, __METHOD__);
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function ticketRequest() {
        try {

            $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
            $tillDate = Carbon::now()->subDay()->toDateString();

            $dateS = Carbon::now()->startOfMonth()->subMonth(1);
            $dateE = Carbon::now()->startOfMonth();

            $weeklyCount = Ticket::selectRaw('DATE(created_at) as Date')->selectRaw('DATE_FORMAT(created_at,"%W") as days, COUNT(*) as count')->groupBy('Date')->whereBetween( DB::raw('date(created_at)'), [$fromDate, $tillDate])->orderBy('Date')->get();

            $monthlyCount = Ticket::selectRaw('DATE(created_at) as Date, COUNT(*) as count')->groupBy('Date')->whereBetween('created_at',[$dateS,$dateE])->get();

            $dailycount = DB::table('tickets')->whereDate('created_at', '>=', Carbon::now()->format('Y-m-d'))->whereDate('created_at', '<=', Carbon::now()->addDay()->format('Y-m-d'))->count();

        return response()->json([
                'success' => true,
                'data' => [
                    'daily' => $dailycount,
                    'weekly' => $weeklyCount,
                    'monthly' => $monthlyCount,
                ]
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
