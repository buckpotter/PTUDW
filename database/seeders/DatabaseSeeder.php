<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bus;
use App\Models\Rate;
use App\Models\Trip;
use App\Models\Ticket;
use App\Models\BusRoute;
use App\Models\Location;
use App\Models\BusCompany;
use App\Models\NormalUser;
use App\Models\BusDatetime;
use App\Models\BusRouteDetail;
use App\Models\Image;
use App\Models\Seat;
use App\Models\TicketDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // BusCompany::factory(30)->create();
        // NormalUser::factory(10000)->create();
        // Bus::factory(2000)->create();
        // Location::factory(63)->create();
        // Image::factory(63)->create();
        // BusRoute::factory(3906)->create();
        // Trip::factory(7000)->create();
        // Seat::factory(5000)->create();
        // Ticket::factory(10000)->create();
        // TicketDetail::factory(200000)->create();
        Rate::factory(10000)->create();
    }
}
