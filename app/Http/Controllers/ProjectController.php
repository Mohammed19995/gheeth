<?php

namespace App\Http\Controllers;

use App\Donation;
use App\DonationDetail;
use App\Http\Custom\CustomValidator;
use App\Http\Custom\Repository;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\In;
use Illuminate\Database\QueryException;
use Datatables;

class ProjectController extends Controller
{
    public $data;
    public $model;

    public function __construct(Project $project)
    {
        //$this->middleware('role:admin');
        $this->middleware('permission:project_display|project_update|project_delete', ['only' => ['index']]);
        $this->middleware('permission:project_create', ['only' => ['create']]);
        $this->middleware('permission:project_update', ['only' => ['edit']]);
        $this->middleware('permission:project_delete', ['only' => ['destroy']]);

        $this->middleware('permission:search', ['only' => ['search']]);

        $this->model = new Repository($project);

        $this->data['menu'] = 'projects';
        $this->data['selected'] = 'projects';
        $this->data['location'] = trans('main.project');
        $this->data['location_title'] = trans('main.project');

    }

    public function index()
    {
        $this->data['sub_menu'] = 'display-projects';
        return view('projects.index', $this->data);
    }

    public function create()
    {
        $this->data['sub_menu'] = 'projects-create';
        return view('projects.create', $this->data);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'information' => 'required',
        ];

        $attributeNames = array(
            'information' => 'المعلومات الهامة',

        );

        $validate = Validator::make($request->all(), $rules);
        $validate->setAttributeNames($attributeNames);

        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate->errors()->toArray());

        } else {

            $name = $request->name;
            $information = $request->information;


            Project::create([
                'name' => $name,
                'information' => $information
            ]);

            return redirect()->route('projects.index')->with('status', trans('actions.success', ['var' => 'الاضافة']));

        }

    }

    public function edit($id)
    {
        $this->data['sub_menu'] = 'projects-edit';
        $project = Project::find($id);
        return view('projects.edit', $this->data, ['project' => $project]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'information' => 'required',
        ];


        $attributeNames = array(
            'information' => 'المعلومات الهامة',
        );


        $validate = Validator::make($request->all(), $rules);
        $validate->setAttributeNames($attributeNames);


        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate->errors()->toArray());

        } else {
            $name = $request->name;
            $information = $request->information;

            $project = Project::find($id);
            $project->update([
                'name' => $name,
                'information' => $information
            ]);

            return redirect()->route('projects.index')->with('status', trans('actions.success', ['var' => 'التعديل']));

        }
    }

    public function contentListData(Request $request)
    {

        $broker = Project::select('*')->get();
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

                if (array_intersect(['project_update'], $permissions)):
                    $control .= "<a class='btn btn-primary btn-sm' href = '" . url("projects/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a>";
                endif;


                if (array_intersect(['project_delete'], $permissions)):
                    $control .= "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a >";
                endif;

                return $control;

                /*  return "<a class='btn btn-primary btn-sm' href = '" . url("projects/" . $id . "/edit") . "'><i class='fa fa-pencil' ></i ></a> "

                      . "<a class='btn btn-danger btn-sm delete' ><input type = 'hidden' class='id_hidden' value = '" . $id . "' > <i class='fa fa-remove' ></i ></a > ";
  */
            })
            ->make(true);

    }


    public function destroy($id)
    {

        $project = Project::find($id);
        // $donation_arr = DonationDetail::where('project_id', '=', $id)->pluck('donations_id')->toArray();
        $project_id = $project->id;
        try {
            $project->delete();

            /*   foreach ($donation_arr as $a) {
                   if (DonationDetail::where('donations_id', $a)->get()->count() <= 0) {
                       Donation::find($a)->delete();
                   }
               }
   */
            DonationDetail::where('project_id', $project_id)->delete();

            return response()->json(['status' => true]);
        } catch (QueryException $e) {
            if ($e->getCode() == "2292") {
                return response()->json(['status', "لا يمكن حذف المشروع"]);
            }
        }

    }


    public function search(Request $request)
    {
        $this->data['menu'] = 'search';
        $this->data['selected'] = 'search';
        $this->data['sub_menu'] = 'projects-search';
        $this->data['projects'] = Project::all();
        $this->data['selectProject'] = '';

        if ($request->isMethod('post')) {

            $id = $request->selectProject;
            $name = $request->name;
            $priceFrom = $request->priceFrom;
            $priceTo = $request->priceTo;


            $donation = DonationDetail::select('*');


            if (empty($id)) {
                if ($donation->get()->count() > 0) {
                    $maxDate = $donation->get()->max('add_date');
                    $minDate = $donation->get()->min('add_date');

                    $maxPrice = $donation->get()->max('price');
                    $minPrice = $donation->get()->min('price');

                    $result = $donation
                        ->where('price', '>=', !empty($priceFrom) && is_numeric($priceFrom) ? $priceFrom : $minPrice)
                        ->where('price', '<=', !empty($priceTo) && is_numeric($priceTo) ? $priceTo : $maxPrice)
                        ->whereDate('add_date', '>=', !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateFrom . '00:00:00') : $minDate)
                        ->whereDate('add_date', '<=', !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y H:i:s', $request->dateTo . '00:00:00') : $maxDate)
                        ->get();
                } else {
                    $result = $donation->get();
                }


            } else {
                $donation = $donation->where('project_id', $id);


                if ($donation->get()->count() > 0) {

                    $maxDate = $donation->get()->max('add_date');
                    $minDate = $donation->get()->min('add_date');

                    $maxPrice = $donation->get()->max('price');
                    $minPrice = $donation->get()->min('price');

                    $result = $donation
                        ->where('price', '>=', !empty($priceFrom) && is_numeric($priceFrom) ? $priceFrom : $minPrice)
                        ->where('price', '<=', !empty($priceTo) && is_numeric($priceTo) ? $priceTo : $maxPrice)
                        ->whereDate('add_date', '>=', !empty($request->dateFrom) ? Carbon::createFromFormat('d-m-Y', $request->dateFrom)->format('Y-m-d') : $minDate->format('Y-m-d'))
                        ->whereDate('add_date', '<=', !empty($request->dateTo) ? Carbon::createFromFormat('d-m-Y', $request->dateTo)->format('Y-m-d') : $maxDate->format('Y-m-d'))
                        ->get();

                } else {
                    $result = $donation->get();
                }


            }

            $result = $result->map(function ($value) {
                $value->donor_name = $value->donor()->first()->name;
                $value->donor_alias_name = $value->donor()->first()->alias_name;
                return $value;
            });


            $this->data['result'] = $result;
            $this->data['name'] = $name;
            $this->data['dateFrom'] = $request->dateFrom;
            $this->data['dateTo'] = $request->dateTo;
            $this->data['priceFrom'] = $request->priceFrom;
            $this->data['priceTo'] = $request->priceTo;
            $this->data['selectProject'] = $id;
            return view('projects.search', $this->data);
        } else {

            $this->data['result'] = '';
            $this->data['projects'] = Project::all();
            return view('projects.search', $this->data);
        }

    }


}
