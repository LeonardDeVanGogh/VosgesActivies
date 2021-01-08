<?php


namespace App\Formatter;


class BookingToJsonFormatter
{
    public function format(array $bookings)
    {
        $bookingsJson = [];
        foreach($bookings as $booking){
            $backgroundColor = $booking->getBookedBy()==null?"#008000":"#808080";
            $bookingsJson[] = [
                'id' => $booking->getId(),
                'title' => 'test',
                'start' => $booking->getStartedAt()->format('Y-m-d H:i:s'),
                'end' => $booking->getEndAt()->format('Y-m-d H:i:s'),
                'background-color' => $backgroundColor,
            ];
        }
        return json_encode($bookingsJson, JSON_UNESCAPED_UNICODE);
    }
}