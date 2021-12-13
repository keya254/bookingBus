<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingSeat;
use App\Models\Passenger;
use App\Models\Seat;
use App\Models\Trip;
use App\Notifications\BookingSeatNotification;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function __invoke(BookingSeat $request)
    {
        $trip = Trip::Where('id', $request->trip_id)->beforeNow()->firstOrFail();
        $passenger = Passenger::UpdateOrCreate(
            ['phone_number' => $request->phone_number],
            [
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ]);
        $count_seats_in_trip_to_passenger = Seat::Where('trip_id', $request->trip_id)->Where('passenger_id', $passenger->id)->count();
        $count_available_seats_in_trip = Seat::Where('trip_id', $request->trip_id)->Where('passenger_id', null)->count();
        //get count seats in booking request convert string to array
        $my_seats_count = explode(',', $request->myseats);
        //check max seats in the trip
        if ($trip->max_seats >= ($count_seats_in_trip_to_passenger + count($my_seats_count))
            && $count_available_seats_in_trip >= ($count_seats_in_trip_to_passenger + count($my_seats_count))) {
            foreach ($my_seats_count as $key => $value) {
                Seat::Where('trip_id', $request->trip_id)->Where('name', $value)->Where('passenger_id', null)->update(
                    ['status' => 1, 'passenger_id' => $passenger->id, 'booking_time' => now()]);
            }
            Notification::send($trip->driver, new BookingSeatNotification($trip->id, $request->myseats, $request->phone_number));
            Notification::send($trip->car->owner, new BookingSeatNotification($trip->id, $request->myseats, $request->phone_number));
            return response()->json(['message' => 'تم الحجز بنجاح'], 200);
        } else {
            return response()->json(['message' => "  عفواً الحد الاقصي  لحجز عدد مقاعد هو '$trip->max_seats'"], 422);
        }
        return response()->json(['message' => 'حدث خطئ ما'], 422);
    }
}
