<?php

namespace App\Observers;

use App\Models\Portofolio;

class PortofolioObserver
{
    public function created(Portofolio $portofolio)
    {
    }

    public function updated(Portofolio $portofolio)
    {
    }

    public function deleted(Portofolio $portofolio)
    {
        $portofolio->read()->delete();
    }

    public function restored(Portofolio $portofolio)
    {
    }

    public function forceDeleted(Portofolio $portofolio)
    {
    }
}
