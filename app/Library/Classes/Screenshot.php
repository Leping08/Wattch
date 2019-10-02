<?php


namespace App\Library\Classes;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class Screenshot extends DuskTestCase
{
    public function yeet()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://theswimschoolfl.com')
                ->screenshot('swim-school');
        });
    }
}
