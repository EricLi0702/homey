<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\User;
use App\Apartment;
use App\Facility;
use App\ReservationFacility;
use Carbon\Carbon;

class ReservationFacilityController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'reservationData' => 'bail|required',
            'aptId' => 'bail|required',
            'facilityId' => 'bail|required',
        ]);
        $requestedReservationData = $request->reservationData;
        $facilityId = $request->facilityId;
        $getAllReservationOfFacility = ReservationFacility::where([['facilityId', '=', $facilityId]])->get();
        
        //check if this request is the first time for a facility
        if(sizeof($getAllReservationOfFacility) == 0){
            $userId = Auth::user()->id;
            $reservationData['userId'] = $userId;
            $reservationData['aptId'] = $request->aptId;
            $reservationData['facilityId'] = $request->facilityId;
            $reservationData['title'] = $requestedReservationData['title'];
            $reservationData['max'] = $requestedReservationData['max'];
            $reservationData['purpose'] = $requestedReservationData['purpose'];
            $reservationData['periodFrom'] = $requestedReservationData['period'][0];
            $reservationData['periodTo'] = $requestedReservationData['period'][1];
            $reservation = ReservationFacility::create($reservationData); 

            return response()->json([
                'reservation' => $reservation
            ], 201);
        }
        else{
            $requestedFrom = new DateTime($requestedReservationData['period'][0]);
            $requestedTo = new DateTime($requestedReservationData['period'][1]);

            foreach ($getAllReservationOfFacility as $key => $reservation){
                $reservatedFrom = new DateTime($reservation->periodFrom);
                $reservatedTo = new DateTime($reservation->periodTo);
                //possible
                if(($reservatedFrom > $requestedTo && $reservatedFrom > $requestedFrom) || (
                    $reservatedTo < $requestedTo && $reservatedTo < $requestedFrom)){
                }
                //impossible
                else{
                    return response()->json([
                        'msg' => "impossible"
                    ], 416);
                }
            }
            $userId = Auth::user()->id;
            $reservationData['userId'] = $userId;
            $reservationData['aptId'] = $request->aptId;
            $reservationData['facilityId'] = $request->facilityId;
            $reservationData['title'] = $requestedReservationData['title'];
            $reservationData['max'] = $requestedReservationData['max'];
            $reservationData['purpose'] = $requestedReservationData['purpose'];
            $reservationData['periodFrom'] = $requestedReservationData['period'][0];
            $reservationData['periodTo'] = $requestedReservationData['period'][1];
            $reservation = ReservationFacility::create($reservationData); 

            return response()->json([
                'reservation' => $reservation
            ], 201);

        }
    }

    public function getReservatoinCnt(Request $request){
        $weekData = ReservationFacility::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $todayData = ReservationFacility::whereDate('created_at', Carbon::today())->count();
        $monthData = ReservationFacility::whereYear('created_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->count();
        $id = Auth::user()->aptId;
        $registerUserCnt = User::where('aptId',$id)->count();
        $currentUserCnt = User::where([['aptId','=',$id],['email_verified_at','<>',null]])->count();
        return response()->json([
            'today'=>$todayData,
            'week'=>$weekData,
            'month'=>$monthData,
            'registerCnt'=>$registerUserCnt,
            'currentCnt'=>$currentUserCnt
        ]);
    }
}
