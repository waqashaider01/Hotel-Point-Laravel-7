<?php

namespace App\Http\Controllers;

use App\Models\BookingAgency;
use App\Models\HotelSetting;
use App\Models\Reservation;
use App\Models\OpexData;
use App\Models\HotelBudget;
use App\Models\DailyRate;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function revenue_report(Request $request)
    {
        return view('front.Reports.revenue_reports');
    }

    public function housekeeping_report(Request $request)
    {
        return view('front.Reports.house_keeping_reports');
    }

    public function kpi_report(Request $request)
    {
        return view('front.Reports.kpi_reports');
    }

    public function b2b_report(Request $request)
    {
        return view('front.Reports.b2b_reports');
    }

    public function accounting_report(Request $request)
    {
        return view('front.Reports.accounting_reports');
    }

    public function opex_report(Request $request)
    {
        return view('front.Reports.opex_reports');
    }

    public function roomdivision_report(Request $request)
    {
        return view('front.Reports.room_division_reports');
    }

    public function getMinDate(){
        $mindate=getHotelSettings()->value('date');
        $maxreservation=Reservation::max('check_out');
        $maxopex=OpexData::max('date');
        // $maxbudget=HotelBudget::max('budget_year');
        if(is_null($mindate) || $mindate=="0000-00-00" || $mindate==''){
            $mindate=today()->year;
        }else{
            $mindate=Carbon::parse($mindate)->year;
        }
        if(is_null($maxreservation) || $maxreservation=="0000-00-00" || $maxreservation==''){
            $maxreservation=today()->year;
        }else{
            $maxreservation=Carbon::parse($maxreservation)->year;
        }
        if(is_null($maxopex) || $maxopex=="0000-00-00" || $maxopex==''){
            $maxopex=today()->year;
        }else{
            $maxopex=Carbon::parse($maxopex)->year;
        }
        $maxyear=max($maxreservation, $maxopex);

        $result=collect();
        $result['minyear']=$mindate;
        $result['maxreservation']=$maxreservation;
        $result['maxyear']=$maxyear;

        return $result;

    }


}
