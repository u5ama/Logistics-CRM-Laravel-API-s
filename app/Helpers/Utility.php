<?php


namespace App\Helpers;


class Utility
{
    public static function checkUserType($type_id)
    {
        return match ($type_id) {
            '1' => 'Administrator',
            '2' => 'Accounts',
            '3' => 'Allocators',
            '4' => 'Sales',
            '5' => 'Drivers',
            '6' => 'Safety Officer',
            default => 'Something went wrong.',
        };
    }

    public function generateFormattedId($id)
    {
        return 'QUO' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }
    public function generateFormattedIdForInvoice($id)
    {
        return 'INV' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }
}
