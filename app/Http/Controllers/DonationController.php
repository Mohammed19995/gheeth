<?php

namespace App\Http\Controllers;

use App\Broker;
use App\Donation;
use App\DonationDetail;
use App\Donor;
use App\Http\Custom\CustomValidator;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class DonationController extends Controller
{
    public $data;

    public function __construct()
    {

        //   $this->middleware('role:admin');
        $this->middleware('permission:donation_display|donation_update|donation_delete', ['only' => ['index']]);
        $this->middleware('permission:donation_create', ['only' => ['create']]);
        $this->middleware('permission:donation_update', ['only' => ['edit', 'updateDonation']]);
        $this->middleware('permission:donation_delete', ['only' => ['destroy']]);

        if (!Broker::where('name', 'نفسه')->exists()) {
            Broker::create([
                'name' => 'نفسه',
                'alias_name' => 'نفسه',
                'information' => ''
            ]);
        }

        $this->data['menu'] = 'donations';
        $this->data['selected'] = 'donations';
        $this->data['location'] = trans('main.donations');
        $this->data['location_title'] = trans('main.donations');

    }

    public function index()
    {
        $this->data['sub_menu'] = 'display-donations';
        $this->data['projects'] = Project::all();
        $this->data['brokers'] = $this->ifMoreThanBrokerName(Broker::all());
        $this->data['coin_type'] = $this->coin_types();

        return view('donations.index2', $this->data);

    }

    public function create()
    {
        $this->data['sub_menu'] = 'donations-create';
        $this->data['brokers'] = $this->ifMoreThanBrokerName(Broker::all());


        $mySelf = Broker::where('name', 'نفسه')->first()->id;
        $this->data['selectBrokers'] = [$mySelf];

        $this->data['donors'] = Donor::all();
        $this->data['selectDonors'] = [];

        $this->data['projects'] = Project::all();
        $this->data['selectProjects'] = [];

        $this->data['coin_type'] = $this->coin_types();
        return view('donations.create', $this->data);
    }


    public function store(Request $request)
    {


        $donationDetail = json_decode($request->donations);
        $rules = [
            //  'title' => 'required',
            'total_price' => 'required|numeric|is_zero',
        ];

        /*  foreach ($donationDetail as $p) {
              $rules[$p->project->id] = 'required';

              $rules[$p->donor->id] = 'required';
              $rules[$p->broker->id] = 'required';
              $rules[$p->coin_type] = 'required';
              $rules[$p->sar] = 'required|numeric';
              $rules[$p->donation_date] = 'required';

          }*/


        $validate = Validator::make($request->all(), $rules, [
            'total_price.is_zero' => 'The total price must equal 0'
        ]);

        $validate->after(function ($validate) use ($donationDetail) {
// || empty($p->coin_type) || empty($p->sar) || empty($p->donation_date
            foreach ($donationDetail as $p) {
                if (empty($p->project->id) || empty($p->donor->id) || empty($p->broker->id)) {
                    $validate->errors()->add('field', 'Something is wrong with this field!');
                }
            }


        });

        if ($validate->fails()) {
            return response()->json(['error' => trans('msg.error')]);
        } else {
            //   $title = $request->title;
            //  $total_price = $request->total_price;
            $donationDetail = json_decode($request->donations);
            $total_price = 0;
            foreach ($donationDetail as $p) {
                $total_price += $p->price;
            }

            $donation = Donation::create([
                // 'title' => $title,
                'total_price' => $total_price
            ]);


            $arr = [];
            foreach ($donationDetail as $p) {
                $data = [];
                $data['donations_id'] = $donation->id;
                $data['project_id'] = $p->project->id;
                $data['donor_id'] = $p->donor->id;
                $data['broker_id'] = $p->broker->id;
                $data['price'] = $p->price;
                $data['coin_type'] = $p->coin->id;
                $data['sar'] = $p->sar;
                $data['note'] = $p->note;
                $data['add_date'] = Carbon::parse($p->donation_date);

                array_push($arr, $data);

            }

            $donation->donationDetails()->createMany($arr);

            return response()->json(['done' => 'done']);
        }


    }

    public function edit($id)
    {
        $this->data['sub_menu'] = 'donations-create';
        $this->data['brokers'] = $this->ifMoreThanBrokerName(Broker::all());
        $this->data['selectBrokers'] = [];

        $this->data['donors'] = Donor::all();
        $this->data['selectDonors'] = [];

        $this->data['projects'] = Project::all();
        $this->data['selectProjects'] = [];

        $this->data['coin_type'] = $this->coin_types();
        $this->data['sub_menu'] = 'donations-edit';

        $donations = DonationDetail::where('donations_id', $id)->get()->count();
        $this->data['exist'] = $donations > 0 ? true : false;
        return view('donations.edit', $this->data, ['id' => $id]);
    }

    public function update(Request $request, $id)
    {


        $donationDetail = json_decode($request->donations);
        $rules = [
            // 'title' => 'required',
            'total_price' => 'required|numeric|is_zero',
        ];


        $validate = Validator::make($request->all(), $rules, [
            'total_price.is_zero' => 'The total price must equal 0'
        ]);

        $validate->after(function ($validate) use ($donationDetail) {
            foreach ($donationDetail as $p) {
                if (empty($p->project->id) || empty($p->donor->id) || empty($p->broker->id)) {
                    $validate->errors()->add('field', 'Something is wrong with this field!');
                }
            }


        });

        if ($validate->fails()) {
            return response()->json(['error' => trans('msg.error')]);
        } else {

            //  $title = $request->title;
            //  $total_price = $request->total_price;
            $donationDetail = json_decode($request->donations);

            $total_price = 0;
            foreach ($donationDetail as $p) {
                $total_price += $p->price;
            }

            $donation = Donation::find($id);
            $donation->update([

                'total_price' => $total_price
            ]);
            $donation->donationDetails()->delete();

            $arr = [];
            foreach ($donationDetail as $p) {
                $data = [];
                $data['donations_id'] = $donation->id;
                $data['project_id'] = $p->project->id;
                $data['donor_id'] = $p->donor->id;
                $data['broker_id'] = $p->broker->id;
                $data['price'] = $p->price;
                $data['coin_type'] = $p->coin->id;
                $data['sar'] = $p->sar;
                $data['note'] = $p->note;
                $data['add_date'] = Carbon::parse($p->donation_date);

                array_push($arr, $data);

            }

            $donation->donationDetails()->createMany($arr);
            return response()->json(['done' => 'done']);

        }


    }

    public function destroy($id)
    {

        $donation = DonationDetail::find($id);
        try {
            $donation->delete();
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status', "لا يمكن حذف التبرع"]);
            }
        }

    }


    public function getDonorForBroker(Request $request)
    {
        $broker = Broker::find($request->broker_id);
        $donors = $broker->donors;

        return response()->json(['donors' => $donors]);
    }

    public function contentListData(Request $request)
    {

        $broker = Donation::select('*')->get();
        $permissions = $this->getPermissions2();

        return Datatables::of($broker)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) use ($permissions) {
                $id = $model->id;

                $control = "";

                if (array_intersect(['donation_update'], $permissions)):
                    $control .= "<a class='btn btn-primary btn-sm' href = '" . url("donations/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a>";
                endif;


                if (array_intersect(['donation_delete'], $permissions)):
                    $control .= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a >";
                endif;

                return $control;

                /* return "<a class='btn btn-primary btn-sm' href = '" . url("donations/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> "
                     . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";
 */
            })
            ->make(true);

    }

    public function contentListData2(Request $request)
    {

        $donations = DonationDetail::leftJoin('brokers', 'brokers.id', '=', 'donation_details.broker_id')
            ->leftJoin('donors', 'donors.id', '=', 'donation_details.donor_id')
            ->leftJoin('projects', 'projects.id', '=', 'donation_details.project_id')
            ->select('projects.id as project_id', 'projects.name as project_name', 'donors.id as donor_id', 'donors.name as donor_name', 'brokers.id as broker_id', 'brokers.name as broker_name'
                , 'donation_details.*')
            ->get();
        $permissions = $this->getPermissions2();

        return Datatables::of($donations)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('add_date', function ($model) {
                $date = date('d-m-Y', strtotime($model->add_date));
                return $date;

            })->addColumn('control', function ($model) use ($permissions) {
                $id = $model->id;

                $control = "";

                //href = '" . url("donations/" . $id . "/edit") . "'
                if (array_intersect(['donation_update'], $permissions)):
                    $control .= "<a class='btn btn-primary btn-sm edit_donations' ><i class='fa fa-pencil' ></i ></a>";
                endif;


                if (array_intersect(['donation_delete'], $permissions)):
                    $control .= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a >";
                endif;

                return $control;

                /* return "<a class='btn btn-primary btn-sm' href = '" . url("donations/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> "
                     . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";
 */
            })
            ->make(true);

    }

    public function updateDonation(Request $request)
    {

        $id = $request->id;
        $donor_id = $request->donor_id;
        $broker_id = $request->broker_id;
        $project_id = $request->project_id;
        $sar = $request->sar;
        $coin_type = $request->coin_type;
        $price = $request->price;
        $date = Carbon::createFromFormat('d-m-Y', $request->add_date);
        $add_date = Carbon::parse($date);
        $note = $request->note;

        $donation = DonationDetail::find($id);

         $donation->update([
              "donor_id" => $donor_id,
              "broker_id" => $broker_id,
              "project_id" => $project_id,
              "sar" => $sar,
              "coin_type" => $coin_type,
              "price" => $price,
              "add_date" => $add_date,
              "note" =>$note
          ]);



        return response()->json($id);
    }

    public function getDonations(Request $request)
    {

        $donation = DonationDetail::where('donations_id', $request->id)->get();


        $donation = $donation->map(function ($value) {
            $data = [];

            $data['total_price'] = $value->donation->total_price;
            // $data['title'] = $value->donation->title;

            $data['project_id'] = $value->project_id;
            $data['project_name'] = $value->projects->first()->name;

            $data['donor_id'] = $value->donor_id;
            $data['donor_name'] = $value->donor->name;

            $data['broker_id'] = $value->broker_id;
            $data['broker_name'] = $value->broker->name;

            $data['price'] = $value->price;
            $data['coin_id'] = $value->coin_type;
            $data['coin_text'] = $this->lookup_title($value->coin_type)->lookup_title;
            $data['sar'] = $value->sar;
            $data['note'] = $value->note;
            $data['donation_date'] = $value->add_date->format('d-m-Y');
            return $data;
        });

        return response()->json(['data' => $donation]);
    }

    public function search(Request $request)
    {
        $this->data['menu'] = 'search';
        $this->data['selected'] = 'search';
        $this->data['sub_menu'] = 'donations-search';
        $this->data['result'] = '';

        if ($request->isMethod('post')) {
            if ($request->dateFrom == '' || $request->dateTo == '') {

                $result = DonationDetail::get();
                $result = $result->map(function ($value) {
                    $value->project_name = $value->projects()->first()->name;
                    $value->broker_name = $value->broker()->first()->name;
                    $value->donor_name = $value->donor()->first()->name;
                    $value->total_price = $value->donation()->first()->total_price;

                    return $value;
                });

                $this->data['result'] = $result;

                $this->data['dateFrom'] = $request->dateFrom;
                $this->data['dateTo'] = $request->dateTo;


                return view('donations.search', $this->data);

            } else {
                $from = Carbon::createFromFormat('d-m-Y H:i:s', $request->dateFrom . '00:00:00');
                $to = Carbon::createFromFormat('d-m-Y H:i:s', $request->dateTo . '00:00:00');
                $result = DonationDetail::whereDate('add_date', '>=', $from)
                    ->whereDate('add_date', '<=', $to)->get();

                $result = $result->map(function ($value) {
                    $value->project_name = $value->projects()->first()->name;
                    $value->broker_name = $value->broker()->first()->name;
                    $value->donor_name = $value->donor()->first()->name;
                    //  $value->total_price = $value->donation()->first()->total_price;

                    return $value;
                });

                $this->data['result'] = $result;

                $this->data['dateFrom'] = $request->dateFrom;
                $this->data['dateTo'] = $request->dateTo;
                return view('donations.search', $this->data);
            }


        } else {


            return view('donations.search', $this->data);
        }

    }
}
