<?php

namespace Database\Seeders;

use App\Models\TicketItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ticketItems = [
            [
                'ticket_id' => '1',
                'asset_id' => '1',
                'qty' => '1'
            ],
            [
                'ticket_id' => '1',
                'asset_id' => '2',
                'qty' => '1'
            ],
            [
                'ticket_id' => '2',
                'asset_id' => '3',
                'qty' => '2'
            ],
            [
                'ticket_id' => '3',
                'asset_id' => '4',
                'qty' => '1'
            ],
            [
                'ticket_id' => '3',
                'asset_id' => '5',
                'qty' => '1'
            ],
            [
                'ticket_id' => '4',
                'asset_id' => '6',
                'qty' => '1'
            ],
            [
                'ticket_id' => '5',
                'asset_id' => '1',
                'qty' => '1'
            ],
            [
                'ticket_id' => '5',
                'asset_id' => '4',
                'qty' => '2'
            ],
            [
                'ticket_id' => '5',
                'asset_id' => '5',
                'qty' => '1'
            ],
            [
                'ticket_id' => '5',
                'asset_id' => '6',
                'qty' => '1'
            ],
            [
                'ticket_id' => '5',
                'asset_id' => '7',
                'qty' => '1'
            ],
        ];

        foreach ($ticketItems as $ticketItem) {
            TicketItem::create($ticketItem);
        }
    }
}
