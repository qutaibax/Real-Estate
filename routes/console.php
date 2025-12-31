<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Models\Book;
use App\Services\NotificationService;
use App\Traits\sendWhatsAppMessage;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


//Schedule::call(function ()   {
//    DB::table('books')->where('end_date', '<', now())
//        ->where('status', '=', 'current')
//        ->update([
//            'status' => 'ended',
//            'updated_at' => now(),
//        ]);;
//
//})->weekly();


Schedule::call(function () {
    $books = Book::with('renter')->where('end_date', '<', now())
        ->where('status', 'current')
        ->get();

    foreach ($books as $book) {
        $book->status = 'ended';
        $book->save();

        if ($book->renter) {
            app(NotificationService::class)->send(
                $book->renter,
                'Booking Ended',
                'Your booking has ended',
                'booking_ended'
            );
        }
    }
})->everyFiveSeconds();
