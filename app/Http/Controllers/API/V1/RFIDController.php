<?php

namespace App\Http\Controllers\API\V1;

use Log;
use App\User;
use App\Models\Tariff;
use App\Models\Parking;
use App\Models\RfidVehicle;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\CategoryWiseFloorSlot;

class RFIDController extends Controller
{
    /**
     * @author Ahsan Zahid Chowdhury <ahsan.zahid@systechdigital.com>
     * @since v2.1 API Endpoint for Silicon Wireless Systems Pvt. Ltd
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     string
     * $RFID=0#     Success
     * $RFID=-1#    Exception Occurred
     * $RFID=-2#    Vehicle Not Registerd
     * $RFID=-3#    Slot Not Availble
     *
     */
    public function sws(Request $request){    
        

        try{
            if(env('APP_DEBUG',false))
                Log::channel('rfid_api')->info(json_encode($request->all()));
            $getKeys = array_keys($request->all());
            $getKeys[0] = (int)str_replace("$", '',$getKeys[0]);
            $getKeys[3] = str_replace("*", '',$getKeys[3]);
            $rfidVehicle = RfidVehicle::where('rfid_no',$getKeys[2])->first();
            if(!$rfidVehicle){
                return '$RFID=-2#';
            }
            // Find the parking item
            $parking = Parking::where('rfid_no',$rfidVehicle->rfid_no)
                        ->where('category_id',$rfidVehicle->category_id)                        
                        ->where('place_id',$getKeys[0])
                        ->orderBy('id','DESC')
                        ->first();
            
            $date = \Carbon\Carbon::createFromFormat('dmYHis', $getKeys[3]);
            // Find the user for requested place
            $user = User::where('place_id',$getKeys[0])->first();
            if(!$user)
                $user = Role::where('name','admin')->with('users')->first()->users[0];
            // Check the status of the parking
            if($parking && $parking->status < 3){
                $tariff = Tariff::getCurrent($parking->category_id, $parking->place_id);
                $parking->out_time = $date;
                $dateDiff = $parking->out_time->diff(new \DateTime($parking->in_time));

                $hour = $dateDiff->h;
                $amt = $tariff->min_amount;
                if ($dateDiff->days > 0)
                    $hour = $dateDiff->h + ($dateDiff->days * 24);
                $hour += ($dateDiff->i / 60);
                if ($hour > 1)
                    $amt = $hour * $tariff->amount;
                              
                $parking->amount = $amt;
                $parking->modified_by = $user->id;
                $parking->status = 3;
                $parking->update();
            }else{
                $availableSlot = CategoryWiseFloorSlot::whereDoesntHave('active_parking')->where('category_id',$rfidVehicle->category_id)->where('floor_id',$getKeys[1])->first();
                if(!$availableSlot){
                    return '$RFID=-3#';
                }
                $parking = Parking::create([
                    'place_id'      => $getKeys[0],
                    'slot_id'       => $availableSlot->id,
                    'vehicle_no'    => $rfidVehicle->vehicle_no,
                    'rfid_no'       => $rfidVehicle->rfid_no,
                    'category_id'   => $rfidVehicle->category_id,
                    'driver_name'   => $rfidVehicle->driver_name,
                    'driver_mobile' => $rfidVehicle->driver_mobile,
                    'barcode'       => $date->format('YmdHis') . $user->id,
                    'in_time'       => $date->format('Y-m-d H:i:s'),
                    'rfid_status'   => 1,
                    'created_by'    => $user->id
                ]);                
            }
            
            return '$RFID=0#';
        }catch(\Exception $e){
            if(env('APP_DEBUG',false))
                Log::channel('rfid_api')->debug($e->getMessage());
            return '$RFID=-1#';
        }

    }
}
