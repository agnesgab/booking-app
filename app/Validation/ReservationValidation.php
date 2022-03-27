<?php

namespace App\Validation;

use App\Database;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReservationValidation {

    private int $count = 0;
    private int $apartmentId;
    private string $selectedDateFrom;
    private string $selectedDateTo;
    private CarbonPeriod $selectedDatesRange;
    private CarbonPeriod $availableDatesRange;
    private array $reservationRanges = [];

    public function __construct(int $apartmentId, string $selectedDateFrom, string $selectedDateTo)
    {
        $this->apartmentId = $apartmentId;
        $this->selectedDateFrom = $selectedDateFrom;
        $this->selectedDateTo = $selectedDateTo;
    }

    public function validateDates(){
        $this->makeSelectedDatesRange();
        $this->makeAvailableDatesRange();
        $this->makeAllReservationRanges();
    }

    public function makeSelectedDatesRange()
    {
        $inputFrom = date("Y-m-d", strtotime($this->selectedDateFrom));
        $inputTo = date("Y-m-d", strtotime($this->selectedDateTo));

        $selectedFrom = Carbon::createFromFormat('Y-m-d', $inputFrom);
        $selectedTo = Carbon::createFromFormat('Y-m-d', $inputTo);
        $this->selectedDatesRange = CarbonPeriod::create($selectedFrom, $selectedTo);
    }

    public function makeAvailableDatesRange()
    {
        $apartmentQuery = Database::connection()
            ->createQueryBuilder()
            ->select('*')
            ->from('apartments')
            ->where('id = ?')
            ->setParameter(0, $this->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

        foreach ($apartmentQuery as $data) {
            $this->availableDatesRange = CarbonPeriod::create($data['available_from'], $data['available_to']);
        }
    }

    public function makeAllReservationRanges()
    {
        $reservationsQuery = Database::connection()
            ->createQueryBuilder()
            ->select('reservation_date_from', 'reservation_date_to')
            ->from('reservations')
            ->where('apartment_id = ?')
            ->setParameter(0, $this->getApartmentId())
            ->executeQuery()
            ->fetchAllAssociative();

        if(!empty($reservationsQuery)){
            foreach ($reservationsQuery as $reservation) {
                $this->reservationRanges[] = CarbonPeriod::create(
                    $reservation['reservation_date_from'], $reservation['reservation_date_to']);

            }
        }

    }

    public function getOverlaps(): int
    {
        foreach ($this->getReservationRanges() as $range) {

            if ($this->getSelectedDatesRange()->overlaps($this->getAvailableDatesRange())
                && $this->getSelectedDatesRange()->overlaps($range)) {
                $this->count++;
            }
        }
        return $this->getCount();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return CarbonPeriod
     */
    public function getSelectedDatesRange(): CarbonPeriod
    {
        return $this->selectedDatesRange;
    }

    /**
     * @return int
     */
    public function getApartmentId(): int
    {
        return $this->apartmentId;
    }

    /**
     * @return CarbonPeriod
     */
    public function getAvailableDatesRange(): CarbonPeriod
    {
        return $this->availableDatesRange;
    }

    /**
     * @return array
     */
    public function getReservationRanges(): array
    {
        return $this->reservationRanges;
    }

}