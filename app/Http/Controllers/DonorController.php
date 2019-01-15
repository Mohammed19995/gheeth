<?php

namespace App\Http\Controllers;

use App\Broker;
use App\Donation;
use App\DonationDetail;
use App\Donor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Illuminate\Database\QueryException;
use Datatables;

class DonorController extends Controller
{
    public $data;

    public function __construct()
    {
        //$this->middleware('role:admin');
        $this->middleware('permission:donor_display|donor_update|donor_delete', ['only' => ['index']]);
        $this->middleware('permission:donor_create', ['only' => ['create']]);
        $this->middleware('permission:donor_update', ['only' => ['edit']]);
        $this->middleware('permission:donor_delete', ['only' => ['destroy']]);

        $this->middleware('permission:search', ['only' => ['search']]);

        $this->data['menu'] = 'donors';
        $this->data['selected'] = 'donors';
        $this->data['location'] = trans('main.donor');
        $this->data['location_title'] = trans('main.donor');

        if (!Broker::where('name' , 'نفسه')->exists()) {
            Broker::create([
               'name' => 'نفسه' ,
               'alias_name' => 'نفسه' ,
               'information' => ''
            ]);
        }

    }

    public function index()
    {

        $this->data['sub_menu'] = 'display-donors';
        return view('donors.index', $this->data);
    }

    public function create()
    {
        $this->data['sub_menu'] = 'donors-create';
        $this->data['roles'] = Role::all();
        $this->data['contact'] = $this->contacts();
        $brokers = Broker::all();

        $this->data['brokers'] = $this->ifMoreThanBrokerName($brokers);
        $this->data['selectBrokers'] = [];
        return view('donors.create', $this->data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'alias_name' => 'required',
            'information' => 'required',
            'group-c' => 'required',
            'selectBrokers' => 'required'
        ];

        $attributeNames = array(
            'alias_name' => 'الاسم المستعار',
            'information' => 'المعلومات الهامة',
            'group-c' => 'بيانات التواصل',
            'selectBrokers' => 'اسم الوسيط'

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
            return redirect()->back()->withInput()->withErrors($validate->errors())->with('contacts', $request->input('group-c'));
        } else {


            $name = $request->name;
            $alias_name = $request->alias_name;
            $information = $request->information;

            $donor = Donor::create([
                'name' => $name,
                'alias_name' => $alias_name,
                'information' => $information
            ]);


            $arrContact = [];
            $arr = [];
            foreach ($request->input('group-c') as $p) {
                $arrContact['donor_id'] = $donor->id;
                $arrContact['contact_type'] = $p['contact_type'];
                $arrContact['contact_details'] = $p['contact_details'];
                array_push($arr, $arrContact);
            }
            $donor->contacts()->createMany($arr);
            $selectBroker = $request->selectBrokers;
            $self = Broker::where('name' , 'نفسه')->first()->id;
            if(!in_array($self ,$selectBroker)) {
                array_push($selectBroker ,$self );
            }

            //array_push($selectBroker , Broker::where('name' , 'نفسه')->first()->id);
            $donor->brokers()->attach($selectBroker);
            return redirect()->route('donors.index')->with('status', trans('actions.success', ['var' => 'الاضافة']));

            //  return redirect()->back()->withInput(Input::all());

        }
    }

    public function edit($id)
    {

        $this->data['sub_menu'] = 'donors-edit';
        $this->data['contact'] = $this->contacts();
        $donor = Donor::find($id);
        $brokers = Broker::all();
        $this->data['brokers'] =  $this->ifMoreThanBrokerName($brokers);;
        $this->data['selectBrokers'] = $donor->brokers->pluck('id')->toArray();
        return view('donors.edit', $this->data, ['donor' => $donor]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'alias_name' => 'required',
            'information' => 'required',
            'group-c' => 'required',
            'selectBrokers' => 'required'
        ];


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

            $donor = Donor::find($id);
            $donor->update([
                'name' => $name,
                'alias_name' => $alias_name,
                'information' => $information
            ]);
            $donor->contacts()->delete();
            $donor->brokers()->detach();

            $arrContact = [];
            $arr = [];
            foreach ($request->input('group-c') as $p) {
                $arrContact['broker_id'] = $donor->id;
                $arrContact['contact_type'] = $p['contact_type'];
                $arrContact['contact_details'] = $p['contact_details'];
                array_push($arr, $arrContact);
            }
            $donor->contacts()->createMany($arr);
            $self = Broker::where('name' , 'نفسه')->first()->id;
            $selectBroker = $request->selectBrokers;
            if(!in_array($self ,$selectBroker)) {
                array_push($selectBroker ,$self );
            }

            $donor->brokers()->attach($selectBroker);

            //$donor->brokers()->attach($request->selectBrokers);
            return redirect()->route('donors.index')->with('status', trans('actions.success', ['var' => 'التعديل']));
            //  return redirect()->back()->withInput(Input::all());
        }
    }

    public function contentListData(Request $request)
    {

        $broker = Donor::select('*')->get();
        $permissions = $this->getPermissions2();


        return Datatables::of($broker)
            ->setRowId(function ($model) {
                return "row-" . $model->id;
            })
            ->EditColumn('created_at', function ($model) {
                $date = date('d-m-Y', strtotime($model->created_at));
                return $date;

            })->addColumn('control', function ($model) use($permissions) {
                $id = $model->id;


                $control = "";

                if (array_intersect(['donor_update'], $permissions)):
                    $control .= "<a class='btn btn-primary btn-sm' href = '" . url("donors/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a>";
                endif;

                if (array_intersect(['donor_display'], $permissions)):
                    $control .= "<a class='btn btn-success btn-sm view' ><input type = 'hidden' class='id_hidden_view' value = '" . $id . "' ><i class='fa fa-eye' ></i ></a>";
                endif;

                if (array_intersect(['donor_delete'], $permissions)):
                    $control .="<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a >";
                endif;

                return $control;


                /* return "<a class='btn btn-primary btn-sm' href = '" . url("donors/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> " .
                     "<a class='btn btn-success btn-sm view' ><i class='fa fa-eye' ></i ></a> "
                     . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";
 */
            })
            ->make(true);

    }


    public function destroy($id)
    {

        $donor = Donor::find($id);
       // $donation_arr = DonationDetail::where('donor_id', '=', $id)->pluck('donations_id')->toArray();
        $donor_id = $donor->id;
        try {
            $donor->delete();
            DonationDetail::where('donor_id' ,$donor_id )->delete();
          /*  foreach ($donation_arr as $a) {
                if (DonationDetail::where('donations_id', $a)->get()->count() <= 0) {
                    Donation::find($a)->delete();
                }
            }*/
            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status', "لا يمكن حذف المتبرع"]);
            }
        }

    }

    public function viewDonor(Request $request)
    {
        $donor = Donor::find($request->id);
        $DonorContact = $donor->contacts;
        $brokers = $this->ifMoreThanBrokerName($donor->brokers);
        $contact = $this->contacts();
        return response()->json(['donor' => $donor, 'donorContact' => $DonorContact, 'contact' => $contact, 'brokers' => $brokers]);
    }


    public function search(Request $request)
    {
        $this->data['menu'] = 'search';
        $this->data['selected'] = 'search';
        $this->data['sub_menu'] = 'donors-search';

        if ($request->isMethod('post')) {

            $selectDonor = $request->selectDonor;
            $selectAliasDonor = $request->selectAliasDonor;
            $priceFrom = $request->accountFrom;
            $priceTo = $request->accountTo;

            $id = !empty($selectDonor) ? $selectDonor :$selectAliasDonor ;
            $donation = DonationDetail::select('*');
            if (empty($id)) {

                $result = '';

            } else {
                $donation = $donation->where('donor_id', $id);

                if ($donation->get()->count() > 0) {
                    $maxDate = $donation->get()->max('add_date');
                    $minDate = $donation->get()->min('add_date');

                    $maxPrice = $donation->get()->max('price');
                    $minPrice = $donation->get()->min('price');

                    $result = $donation
                        ->where('price', '>=', !empty($priceFrom) && is_numeric($priceFrom) ? $priceFrom : $minPrice)
                        ->where('price', '<=', !empty($priceTo) && is_numeric($priceTo) ? $priceTo : $maxPrice)
                       /* ->whereDate('add_date', '>=', !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateFrom . '00:00:00') : $minDate)
                        ->whereDate('add_date', '<=', !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateTo . '00:00:00') : $maxDate)
                        ->get();*/
                       ->whereDate('add_date', '>=', !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y', $request->dateFrom)->format('Y-m-d') : $minDate->format('Y-m-d'))
                        ->whereDate('add_date', '<=', !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y', $request->dateTo)->format('Y-m-d') : $maxDate->format('Y-m-d'))
                        ->get();

                    $result = $result->map(function ($value) {
                        $value->project_name = $value->project()->first()->name;
                        return $value;
                    });

                } else {
                    $result = '';
                }


            }


            $this->data['result'] = $result;
            $this->data['donors'] =Donor::all();
            $this->data['selectDonor'] = $id;
            $this->data['dateFrom'] = $request->dateFrom;
            $this->data['dateTo'] = $request->dateTo;
            $this->data['accountFrom'] = $request->accountFrom;
            $this->data['accountTo'] = $request->accountTo;


            return view('donors.search', $this->data);
        } else {

            $this->data['donors'] =Donor::all();
            $this->data['selectDonor'] ='';
            $this->data['result'] = '';
            return view('donors.search', $this->data);
        }

    }




}
