<?php


namespace App\Formatter;


class BookingToJsonFormatter
{
    public function format(array $bookings)
    {
        $bookingsJson = [];
        foreach($bookings as $booking){
            $bookedBy = $booking->getBookedBy()==null?"libre":"Réservé";
            $bookingsJson[] = [
                'id' => $booking->getId(),
                'title' => $bookedBy,
                'start' => $booking->getStartedAt()->format('Y-m-d H:i:s'),
                'end' => $booking->getEndAt()->format('Y-m-d H:i:s'),
                'color' => $booking->getBookedBy() === null ? "#008000" : "#808080",
            ];
        }
        return $bookingsJson;
    }
}