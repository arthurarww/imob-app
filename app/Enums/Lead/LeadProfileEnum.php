<?php

namespace App\Enums\Lead;

enum LeadProfileEnum: string
{
    case BUYER = 'buyer';
    case SELLER = 'seller';
    case RENTER = 'renter';
}
