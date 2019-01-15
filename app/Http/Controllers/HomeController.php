<?php

namespace App\Http\Controllers;

use App\Broker;
use App\Donor;
use App\Project;
use Illuminate\Http\Request;
use App\Product;
use App\Ticket;
use App\Category;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $data = array();

    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('permission:home_page', ['only' => ['index']]);
        $this->data['menu'] = 'home';
        $this->data['location'] = trans('main.main');
        $this->data['location_title'] = trans('main.main');
        $this->data['selected'] = '';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sub_menu'] = '';
        $this->data['users'] = User::all()->count();
        $this->data['projects'] = Project::all()->count();
        $this->data['donors'] = Donor::all()->count();
        $this->data['brokers'] = Broker::all()->count();
        $this->data['accountDonor'] = $this->getAccount($this->accountToData(Donor::all() , '' , ''));
        $this->data['accountBroker'] = $this->getAccount($this->accountToData(Broker::all() , '' , ''));

        return view('home',$this->data);
    }

    public function getAccount($data) {
        return array_values($data->sortByDesc('account')->take(5)->toArray());
    }

}
