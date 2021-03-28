<?php

namespace App\Formatter;

use Symfony\Component\Security\Core\Security;

class BookingToJsonFormatter
{
    private $security;

    public function __construct(Security $security)
    {

        $this->security = $security;
    }

    public function format(array $bookings)
    {
        $bookingsJson = [];

        foreach($bookings as $booking){

            $bookingsJson[] = [
                'id' => $booking->getId(),
                'title' => $this->setEventTitle($booking),
                'start' => $booking->getStartedAt()->format('Y-m-d H:i:s'),
                'end' => $booking->getEndAt()->format('Y-m-d H:i:s'),
                'color' => $this->setEventBackgroundColor($booking),
            ];
        }
        return $bookingsJson;
    }
    public function formatMyBookings(array $bookings)
    {
        $bookingsJson = [];

        foreach($bookings as $booking){

            $bookingsJson[] = [
                'id' => $booking->getId(),
                'title' => $booking->getActivity()->getName(),
                'start' => $booking->getStartedAt()->format('Y-m-d H:i:s'),
                'end' => $booking->getEndAt()->format('Y-m-d H:i:s'),
            ];
        }
        return $bookingsJson;
    }
    private function isCurrentUserTheOwnerOfThisActivity($booking)
    {
        $currentUser = "";
        if($this->security->getUser()){
            $currentUser = $this->security->getUser()->getId();
        }

        $activityOwner = $booking->getActivity()->getUser()->getId();

        return $currentUser===$activityOwner;
    }
    private function setEventTitle($event)
    {
        $title = "erreur";
        if($this->isCurrentUserTheOwnerOfThisActivity($event)){
            if($event->getBookedBy()){
                $title = "Informations";
            }else{
                $title = "Supprimer la réservation";
            }

        }else{
            if($event->getBookedBy()){
                $title = "Indisponible";
            }else{
                $title = "Résrever";
            }
        }
        return $title;
    }
    private function setEventBackgroundColor($event)
    {
        $color = "#808080";
        if($this->isCurrentUserTheOwnerOfThisActivity($event)){
            if($event->getBookedBy()){
                $color = "#008000";
            }else{
                $color = "#808080";
            }

        }else{
            if($event->getBookedBy()){
                $color = "#FF0000";
            }else{
                $color = "#008000";
            }
        }
        return $color;
    }
}