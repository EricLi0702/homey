<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\User;
use App\Apartment;
use App\Facility;
use App\ReservationFacility;

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
}
