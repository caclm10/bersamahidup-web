<?php

namespace App\View\Components\Home;

use Illuminate\View\Component;

class CampaignList extends Component
{
    public $title;
    public $campaigns;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = '', $campaigns = [])
    {
        $this->title = $title;
        $this->campaigns = $campaigns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.campaign-list');
    }
}
