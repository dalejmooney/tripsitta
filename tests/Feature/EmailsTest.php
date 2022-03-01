<?php

namespace Tests\Feature;

use App\Mail\AccountActivatedBabysitter;
use App\Mail\AccountDeactivatedBabysitter;
use App\Mail\NewBabysitterBookingConfirmationParent;
use App\Mail\NewRegistrationBabysitter;
use App\Mail\NewRegistrationParent;
use App\Service\BookingPrice;
use Carbon\Carbon;
use Tests\TestCase;
use Mail;

class EmailsTest extends TestCase
{
    private $email_name, $email_address;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->email_name = 'John';
        $this->email_address = 'info@insperio.co.uk';

        parent::__construct($name, $data, $dataName);
    }

    public function testParentRegistrationEmail()
    {
        $class = NewRegistrationParent::class;

        Mail::fake();

        Mail::to($this->email_name)->send(new $class($this->email_address));

        Mail::assertSent($class);
        Mail::assertNotQueued($class);
    }

    public function testBabysitterRegistrationEmail()
    {
        $class = NewRegistrationBabysitter::class;

        Mail::fake();

        Mail::to($this->email_name)->send(new $class($this->email_address, '10 Dec 2020', '10:00:00'));

        Mail::assertSent($class);
        Mail::assertNotQueued($class);
    }

    public function testBabysitterAccountActivatedEmail()
    {
        $class = AccountActivatedBabysitter::class;

        Mail::fake();

        Mail::to($this->email_name)->send(new $class($this->email_address));

        Mail::assertSent($class);
        Mail::assertNotQueued($class);
    }

    public function testBabysitterAccountDeactivatedEmail()
    {
        $class = AccountDeactivatedBabysitter::class;

        Mail::fake();

        Mail::to($this->email_name)->send(new $class($this->email_address));

        Mail::assertSent($class);
        Mail::assertNotQueued($class);
    }

    public function testNewBabysitterBookingConfirmationForParents()
    {
        $class = NewBabysitterBookingConfirmationParent::class;

        Mail::fake();

        Mail::to($this->email_name)->send(new $class($this->email_address, '10 Dec 2020 8:00', '10 Dec 2020 12:00', 'Annie'));

        Mail::assertSent($class);
        Mail::assertNotQueued($class);
    }
}
