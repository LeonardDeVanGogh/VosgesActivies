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
    private function isCurrentUserTheOwnerOfThisActivity($booking)
    {
        $currentUser = "";
        if($this->security->getUser()){
            $currentUser = $this->security->getUser()->getId();
        }
        $activityOwner = $booking->getActivity()->getUser()->getId();
        return $currentUser===$activityOwner;
    }

    public function format(array $bookings)
    {
        $bookingsJson = [];
        foreach($bookings as $booking){
            if($this->isCurrentUserTheOwnerOfThisActivity($booking) || !$booking->getBookedBy()){
                $bookingsJson[] = [
                    'id' => $booking->getId(),
                    'title' => $this->setEventTitle($booking),
                    'start' => $booking->getStartedAt()->format('Y-m-d H:i:s'),
                    'end' => $booking->getEndAt()->format('Y-m-d H:i:s'),
                    'color' => $this->setEventBackgroundColor($booking),
                ];
            }
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
                'url' => '/activity/read/' . $booking->getActivity()->getId(),
            ];
        }
        return $bookingsJson;
    }

    private function setEventTitle($event)
    {
        $title = "erreur";
        if($this->isCurrentUserTheOwnerOfThisActivity($event) || $this->security->isGranted('ROLE_ADMIN' ,$this->security->getUser())){
            if($event->getBookedBy()){
                $title = "mail: " . $event->getBookedBy()->getEmail() . " / tél: " . $event->getBookedBy()->getPhoneNumber();
            }else{
                $title = "Supprimer";
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
        if($this->isCurrentUserTheOwnerOfThisActivity($event) || $this->security->isGranted('ROLE_ADMIN' ,$this->security->getUser())){
            if($event->getBookedBy()){
                $color = "#008000";
            }else{
                $color = "#FF0000";
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