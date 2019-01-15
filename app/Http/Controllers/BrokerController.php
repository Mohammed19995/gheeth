<?php

namespace App\Http\Controllers;

use App\Broker;
use App\Donation;
use App\DonationDetail;
use App\Http\Custom\CustomValidator;
use App\Http\Custom\Repository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Illuminate\Database\QueryException;
use Datatables;
use phpDocumentor\Reflection\Types\Parent_;

class BrokerController extends Controller
{
    public $data;
    public $permissions;

    public function __construct()
    {
        // $this->middleware('role:admin');

        $this->middleware('permission:broker_display|broker_update|broker_delete', ['only' => ['index']]);
        $this->middleware('permission:broker_create', ['only' => ['create']]);
        $this->middleware('permission:broker_update', ['only' => ['edit']]);
        $this->middleware('permission:broker_delete', ['only' => ['destroy']]);

        $this->middleware('permission:search', ['only' => ['search']]);


        $this->data['menu'] = 'brokers';
        $this->data['selected'] = 'brokers';
        $this->data['location'] = trans('main.broker');
        $this->data['location_title'] = trans('main.broker');

    }

    public function index()
    {
        $this->data['sub_menu'] = 'broker-display';
        return view('brokers.index', $this->data);
    }

    public function create()
    {
        $this->data['sub_menu'] = 'broker-create';
        $this->data['roles'] = Role::all();
        $this->data['contact'] = $this->contacts();
        return view('brokers.create', $this->data);
    }

    public function show($id)
    {
        $this->data['sub_menu'] = 'display-brokers';
        $this->data['contact'] = $this->contacts();
        $broker = Broker::find($id);
        $brokerContact = $broker->contacts->toArray();
        return view('brokers.show', $this->data, ['broker' => $broker, 'brokerContact' => $brokerContact]);
    }

    public function store(Request $request)
    {


        $getLookUp = $this->contacts();
        $rules = [
            'name' => 'required',
            'alias_name' => 'required',
            'information' => 'required',
            'group-c' => 'required'
        ];


        /*
         if ($request->has('group-c')) {
             $arrContact = $request->input('group-c');
             foreach ($arrContact as $p) {
                 if (empty($p['contact_details']) || !array_key_exists('contact_type', $p)) {
                     $rules['contact'] = 'required';
                     break;
                 }
             }
         }
         */

        $attributeNames = array(
            'alias_name' => 'الاسم المستعار',
            'information' => 'المعلومات الهامة',
            'group-c' => 'بيانات التواصل',

        );


        if ($request->has('group-c')) {
            foreach ($request->input('group-c') as $key => $val) {

                if (!array_key_exists('contact_type', $val)) {
                    $rules['group-c.' . $key . '.contact_type'] = 'required';
                } else if ($val['contact_type'] == null || empty($val['contact_type'])) {
                    $rules['group-c.' . $key . '.contact_type'] = 'required';
                } else if (DB::table('lookups')->where('lookup_id', $val['contact_type'])->first()->lookup_slug == "email") {
                    $rules['group-c.' . $key . '.contact_details'] = 'required|email';
                } else if (DB::table('lookups')->where('lookup_id', $val['contact_type'])->first()->lookup_slug == "number") {
                    $rules['group-c.' . $key . '.contact_details'] = 'required|numeric';
                } else {
                    $rules['group-c.' . $key . '.contact_details'] = 'required';
                }

                $rules['group-c.' . $key . '.contact_type'] = 'required';

                $a = $key + 1;
                $attributeNames['group-c.' . $key . '.contact_type'] = "  اختيار نوع بيانات التواصل" . $a;
                $attributeNames['group-c.' . $key . '.contact_details'] = "  اختيار ملئ بيانات التواصل" . $a;
            }
        }


        $message = [
            'contact.required' => 'الرجاء ملئ جميع بيانات التواصل كما هي مختارة',

        ];
        $validate = Validator::make($request->all(), $rules, $message);
        $validate->setAttributeNames($attributeNames);


        if ($validate->fails()) {

            return redirect()->back()->withInput()->withErrors($validate->errors()->toArray())->with('contacts', $request->input('group-c'));
        } else {

            $name = $request->name;
            $alias_name = $request->alias_name;
            $information = $request->information;

            $broker = Broker::create([
                'name' => $name,
                'alias_name' => $alias_name,
                'information' => $information
            ]);


            $arrContact = [];
            $arr = [];
            foreach ($request->input('group-c') as $p) {
                $arrContact['broker_id'] = $broker->id;
                $arrContact['contact_type'] = $p['contact_type'];
                $arrContact['contact_details'] = $p['contact_details'];
                array_push($arr, $arrContact);
            }
            $broker->contacts()->createMany($arr);
            return redirect()->route('brokers.index')->with('status', trans('actions.success', ['var' => 'الاضافة']));
            //  return redirect()->back()->withInput(Input::all());
        }


    }

    public function edit($id)
    {
        $this->data['sub_menu'] = 'brokers-edit';
        $this->data['contact'] = $this->contacts();
        $broker = Broker::find($id);
        return view('brokers.edit', $this->data, ['broker' => $broker]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'alias_name' => 'required',
            'information' => 'required',
            'group-c' => 'required'
        ];


        /*
         if ($request->has('group-c')) {
             $arrContact = $request->input('group-c');
             foreach ($arrContact as $p) {
                 if (empty($p['contact_details']) || !array_key_exists('contact_type', $p)) {
                     $rules['contact'] = 'required';
                     break;
                 }
             }
         }
         */

        $attributeNames = array(
            'alias_name' => 'الاسم المستعار',
            'information' => 'المعلومات الهامة',
            'group-c' => 'بيانات التوصل',

        );


        foreach ($request->input('group-c') as $key => $val) {

            if (!array_key_exists('contact_type', $val)) {
                $rules['group-c.' . $key . '.contact_type'] = 'required';
            } else if ($val['contact_type'] == null || empty($val['contact_type'])) {
                $rules['group-c.' . $key . '.contact_type'] = 'required';
            } else if (DB::table('lookups')->where('lookup_id', $val['contact_type'])->first()->lookup_slug == "email") {
                $rules['group-c.' . $key . '.contact_details'] = 'required|email';
            } else if (DB::table('lookups')->where('lookup_id', $val['contact_type'])->first()->lookup_slug == "number") {
                $rules['group-c.' . $key . '.contact_details'] = 'required|numeric';
            } else {
                $rules['group-c.' . $key . '.contact_details'] = 'required';
            }

            $rules['group-c.' . $key . '.contact_type'] = 'required';

            $a = $key + 1;
            $attributeNames['group-c.' . $key . '.contact_type'] = "  اختيار نوع بيانات التواصل" . $a;
            $attributeNames['group-c.' . $key . '.contact_details'] = "  اختيار ملئ بيانات التواصل" . $a;
        }

        $message = [
            'contact.required' => 'الرجاء ملئ جميع بيانات التواصل كما هي مختارة',

        ];
        $validate = Validator::make($request->all(), $rules, $message);
        $validate->setAttributeNames($attributeNames);


        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate->errors());
        } else {

            $name = $request->name;
            $alias_name = $request->alias_name;
            $information = $request->information;

            $broker = Broker::find($id);
            $broker->update([
                'name' => $name,
                'alias_name' => $alias_name,
                'information' => $information
            ]);
            $broker->contacts()->delete();

            $arrContact = [];
            $arr = [];
            foreach ($request->input('group-c') as $p) {
                $arrContact['broker_id'] = $broker->id;
                $arrContact['contact_type'] = $p['contact_type'];
                $arrContact['contact_details'] = $p['contact_details'];
                array_push($arr, $arrContact);
            }
            $broker->contacts()->createMany($arr);
            return redirect()->route('brokers.index')->with('status', trans('actions.success', ['var' => 'التعديل']));
            //  return redirect()->back()->withInput(Input::all());
        }
    }

    public function destroy($id)
    {

        $broker = Broker::find($id);
        $broker_id = $broker->id;
        //   $donation_arr = DonationDetail::where('broker_id', '=', $id)->pluck('donations_id')->toArray();


        try {
            $broker->delete();
            DonationDetail::where('broker_id', $broker_id)->delete();
            /* foreach ($donation_arr as $a) {
                 if (DonationDetail::where('donations_id', $a)->get()->count() <= 0) {
                     Donation::find($a)->delete();
                 }
             }*/


            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status', "لا يمكن حذف الوسيط"]);
            }
        }

    }


    public function contentListData(Request $request)
    {

        $broker = Broker::select('*')->get();
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

                if (array_intersect(['broker_update'], $permissions)):
                    $control .= "<a class='btn btn-primary btn-sm' href = '" . url("brokers/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a>";
                endif;

                if (array_intersect(['broker_display'], $permissions)):
                    $control .= "<a class='btn btn-success btn-sm view' ><input type = 'hidden' class='id_hidden_view' value = '" . $id . "' ><i class='fa fa-eye' ></i ></a>";
                endif;

                if (array_intersect(['broker_delete'], $permissions)):
                    $control .= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a >";
                endif;

                return $control;

                /*   return "<a class='btn btn-primary btn-sm' href = '" . url("brokers/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> " .
                       "<a class='btn btn-success btn-sm view' ><input type = 'hidden' class='id_hidden_view' value = '" . $id . "' ><i class='fa fa-eye' ></i ></a> "
                       . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";

   */
            })
            ->make(true);

    }


    public function viewBroker(Request $request)
    {
        $broker = Broker::find($request->id);
        $brokerContact = $broker->contacts;
        $contact = $this->contacts();
        return response()->json(['broker' => $broker, 'brokerContact' => $brokerContact, 'contact' => $contact]);
    }

    public function checkExistEmail(Request $request)
    {

        if ($request->a)
            return response()->json(false);
        else
            return response()->json(true);
    }

    public function search(Request $request)
    {
        $this->data['menu'] = 'search';
        $this->data['selected'] = 'search';
        $this->data['sub_menu'] = 'brokers-search';

        if ($request->isMethod('post')) {
            $selectBroker = $request->selectBroker;
            $selectAliasBroker = $request->selectِAliasBroker;
            $priceFrom = $request->accountFrom;
            $priceTo = $request->accountTo;

            $id = !empty($selectBroker) ? $selectBroker : $selectAliasBroker;
            $donation = DonationDetail::select('*');
            if (empty($id)) {
                $result = '';

            } else {
                $donation = $donation->where('broker_id', $id);

                if ($donation->get()->count() > 0) {
                    $maxDate = $donation->get()->max('add_date');
                    $minDate = $donation->get()->min('add_date');

                    $maxPrice = $donation->get()->max('price');
                    $minPrice = $donation->get()->min('price');

                    $result = $donation
                        ->where('price', '>=', !empty($priceFrom) && is_numeric($priceFrom) ? $priceFrom : $minPrice)
                        ->where('price', '<=', !empty($priceTo) && is_numeric($priceTo) ? $priceTo : $maxPrice)
                        /*  ->whereDate('add_date', '>=', !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateFrom . '00:00:00') : $minDate)
                          ->whereDate('add_date', '<=', !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateTo . '00:00:00') : $maxDate)
                          ->get();*/
                        ->whereDate('add_date', '>=', !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y', $request->dateFrom)->format('Y-m-d') : $minDate->format('Y-m-d'))
                        ->whereDate('add_date', '<=', !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y', $request->dateTo)->format('Y-m-d') : $maxDate->format('Y-m-d'))
                        ->get();

                    $result = $result->map(function ($value) {
                        $value->project_name = $value->project()->first()->name;
                        $value->donor_name = $value->donor()->first()->name;
                        return $value;
                    });

                } else {
                    $result = '';
                }


            }


            $this->data['result'] = $result;
            $this->data['brokers'] = $this->ifMoreThanBrokerName(Broker::all());
            $this->data['selectBroker'] = $id;
            $this->data['dateFrom'] = $request->dateFrom;
            $this->data['dateTo'] = $request->dateTo;
            $this->data['accountFrom'] = $request->accountFrom;
            $this->data['accountTo'] = $request->accountTo;

            return view('brokers.search', $this->data);
        } else {

            $this->data['result'] = '';
            $this->data['brokers'] = $this->ifMoreThanBrokerName(Broker::all());
            $this->data['selectBroker'] = '';
            return view('brokers.search', $this->data);
        }

    }

    public function searchBrokerDonor(Request $request)
    {
        $this->data['menu'] = 'search';
        $this->data['selected'] = 'search';
        $this->data['sub_menu'] = 'broker-donor-search';
        $this->data['brokers'] = $this->ifMoreThanBrokerName(Broker::all());
        $this->data['selectBroker'] = '';

        if ($request->isMethod('post')) {

            $id = $request->selectBroker;

            if (!empty($id)) {
                $broker = Broker::find($id);


                $result = $broker->donors();
                if ($result->count() > 0) {
                    $maxDate = $result->get()->max('created_at');
                    $minDate = $result->get()->min('created_at');

                    $dateFrom = !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateFrom . '00:00:00') : $minDate;
                    $dateTo = !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateTo . '00:00:00')->addDays(1) : $maxDate;


                    $result = $result->where('donors.created_at', '>=', $dateFrom)
                        ->where('donors.created_at', '<=', $dateTo)
                        ->get();


                } else {

                    $result = $broker->donors()->get();
                }

            }

            $this->data['result'] = $result;
            $this->data['id'] = $id;
            $this->data['selectBrokerName'] = $broker->name;
            $this->data['dateFrom'] = $request->dateFrom;
            $this->data['dateTo'] = $request->dateTo;
            $this->data['selectBroker'] = $id;

            return view('brokers.searchBrokerDonor', $this->data);
        } else {

            $this->data['selectBroker'] = '';
            $this->data['result'] = '';
            return view('brokers.searchBrokerDonor', $this->data);
        }

    }


}
