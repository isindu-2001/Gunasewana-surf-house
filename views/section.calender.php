<?php

$bookings = bookings::fetchMyGardenBookings();
$booked_dates = [];
foreach ($bookings as $booking) {
    if ($booking['booking_status'] !== 'cancelled') {
        $date = date('Y-m-d', strtotime($booking['checkin']));
        $checkin_time = date('h:i A', strtotime($booking['checkin']));
        $checkout_time = date('h:i A', strtotime($booking['checkout']));
        $booked_dates[$date][] = [
            'checkin' => $checkin_time,
            'checkout' => $checkout_time
        ];
    }
} ?>

<style>
.villoz-calendar__wrapper {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.villoz-calendar__table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}

.villoz-calendar__table caption {
    font-size: 1.5em;
    font-weight: bold;
    padding: 10px 0;
    color: #333;
}

.villoz-calendar__table th {
    background: #4a90e2;
    color: #fff;
    padding: 10px;
    text-align: center;
    font-weight: 600;
}

.villoz-calendar__table td {
    padding: 15px;
    text-align: center;
    font-size: 1em;
    color: #333;
    border: 1px solid #e0e0e0;
    position: relative;
    transition: background 0.3s ease, transform 0.3s ease;
}

.villoz-calendar__table td.empty {
    background: #f9f9f9;
    border: none;
}

.villoz-calendar__table td.today {
    background: #ffe082;
    font-weight: bold;
    color: #333;
}

.villoz-calendar__table td.booked {
    background: #ff6b6b;
    color: #fff;
}

.villoz-calendar__table td:hover:not(.empty) {
    background: #e3f2fd;
    cursor: pointer;
    transform: scale(1.05);
}

.villoz-calendar__table td.booked:hover {
    background: #ff8787;
}

.villoz-calendar__table td[data-tooltip]:hover:after {
    content: attr(data-tooltip);
    position: absolute;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    background: #333;
    color: #fff;
    padding: 8px 12px;
    border-radius: 5px;
    font-size: 0.9em;
    white-space: normal;
    max-width: 250px;
    z-index: 10;
    text-align: left;
}

@media (max-width: 600px) {
    .villoz-calendar__table th, .villoz-calendar__table td {
        padding: 10px;
        font-size: 0.9em;
    }

    .villoz-calendar__table td[data-tooltip]:hover:after {
        font-size: 0.8em;
        top: -40px;
        max-width: 200px;
    }

    .villoz-calendar__wrapper {
        padding: 10px;
    }
}
</style>

<section class="villa-details-one">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xl-5">
                        <div class="villa-details-one__info">
                            <p class="villa-details-one__address">Bookings Calendar</p>
                            <h3 class="villa-details-one__title">Garden Bookings for <?= date('F') ?></h3>
                            <div class="villa-details-one__price-wrap">
                                <div class="villa-details-one__flash">
                                    <p class="villa-details-one__flash__label off"><?= count(array_filter($bookings, function($b) { return $b['booking_status'] !== 'cancelled'; })) ?> Bookings</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="villoz-calendar__wrapper">
                            <?php 
                            $month = date('m');
                            $year = date('Y');
                            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                            $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
                            $dayOfWeek = date('w', $firstDayOfMonth);
                            $monthName = date('F', $firstDayOfMonth);

                            echo '<table class="villoz-calendar__table">';
                            echo '<caption>' . $monthName . ' ' . $year . '</caption>';
                            echo '<thead><tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr></thead>';
                            echo '<tbody><tr>';

                            for ($i = 0; $i < $dayOfWeek; $i++) {
                                echo '<td class="empty"></td>';
                            }

                            for ($day = 1; $day <= $daysInMonth; $day++) {
                                $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $class = (date('Y-m-d') === $currentDate) ? 'today' : '';
                                $booked_class = isset($booked_dates[$currentDate]) ? 'booked' : '';
                                $tooltip = '';
                                if ($booked_class) {
                                    $times = array_map(function($slot) {
                                        return "Check-in: {$slot['checkin']}, Check-out: {$slot['checkout']}";
                                    }, $booked_dates[$currentDate]);
                                    $tooltip = ' data-tooltip="' . htmlspecialchars(implode('; ', $times)) . '"';
                                }
                                echo '<td class="' . $class . ' ' . $booked_class . '"' . $tooltip . '>' . $day . '</td>';
                                if (($dayOfWeek + $day) % 7 == 0) {
                                    echo '</tr><tr>';
                                }
                            }

                            $remainingCells = (7 - (($dayOfWeek + $daysInMonth) % 7)) % 7;
                            for ($i = 0; $i < $remainingCells; $i++) {
                                echo '<td class="empty"></td>';
                            }

                            echo '</tr></tbody>';
                            echo '</table>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>