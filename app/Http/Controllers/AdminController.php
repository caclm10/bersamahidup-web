<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'only-admin']);
    }

    public function campaigns()
    {
        $campaigns = Campaign::orderBy('tgl_diajukan', 'desc')->get();

        return view('admin.campaigns', [
            'campaigns' => $campaigns
        ]);
    }

    public function showCampaign($id)
    {
        $campaign = Campaign::find($id);

        return view('partials.campaign_detail', [
            'campaign' => $campaign
        ]);
    }

    public function acceptance(Request $request, $id)
    {
        $campaign = Campaign::find($id);
        $isAccepted = $request->input('accept');

        if ($isAccepted) {
            $campaign->tgl_diterima = now();
            $campaign->save();
        } else {
            $campaign->delete();
        }

        return response()->json();
    }
}
