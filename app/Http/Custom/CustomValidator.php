<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 14/07/18
 * Time: 01:44 م
 */

namespace App\Http\Custom;

use Illuminate\Support\Facades\Validator;

class CustomValidator extends Validator
{
    public $validator;

    public $request;
    public $rules;
    public $message;
    public $attribute_names;
    public $arr;
    public $multi_arr;

    public function __construct()
    {

    }

    /*

    arr = [
    ['images'  => [] , 'rules' => ''  , 'attribute_name' => ''],
    ['images2' => [] , 'rules' => '' ,'attribute_name' => '']
    ]

   mutli_arr = [
         ['group_c' => group_c , 'rules => ['contact' => '' , 'contact_details' => ''] ,  'attribute_name' => ['contact' => '' , 'contact_details' => ''] ]

        ];

    group_c = group_c[0]['contact_type']
             group_c[0]['contact_details']

             group_c[1]['contact_type']
             group_c[1]['contact_details']
     */

    public function add($request, $rules, $message, $attribute_names = null, $arr = null, $multi_arr = null)
    {
        $this->request = $request;
        $this->rules = $rules;
        $this->message = $message;
        $this->attribute_names = $attribute_names;
        $this->arr = $arr;
        $this->multi_arr = $multi_arr;
        return $this->rules;
    }

    public function make()
    {


        if ($this->arr != null) {
            foreach ($this->arr as $arrP) {
                $arr_keys = array_keys($arrP);

                $rules = $arrP['rules'];
                // define message in lang->validation
                $attribute_name = $arrP['attribute_name'];

                $sub_arr_name = $arr_keys[0];
                $sub_arr = $arrP[$arr_keys[0]];

                foreach ($sub_arr as $key => $sub) {
                    $num = $key + 1;
                    $this->rules[$sub_arr_name . "." . $key] = $rules;
                    $this->attribute_names[$sub_arr_name . "." . $key] = $attribute_name . " " . $num;
                }
            }
        }
        if ($this->multi_arr != null) {
            foreach ($this->multi_arr as $arrP) {
                $multi_arr_keys = array_keys($arrP);
                $multi_arr_rules = $arrP['rules'];
                $multi_arr_attribute_name = $arrP['attribute_name'];

                $sub_multi_arr_name = $multi_arr_keys[0]; // group_c
                $sub_multi_arr = $arrP[$multi_arr_keys[0]];

                foreach ($sub_multi_arr as $key => $sub_multi) {
                    foreach ($multi_arr_attribute_name as $attr_key => $multi_attr_name) {
                        $this->rules[$sub_multi_arr_name . "." . $key . "." . $attr_key] = $multi_arr_rules[$attr_key];
                        $this->attribute_names[$sub_multi_arr_name . "." . $key . "." . $attr_key] = $multi_attr_name;
                    }
                }
            }
        }

        $validate = Validator::make($this->request, $this->rules, $this->message);
        $validate->setAttributeNames($this->attribute_names);

        if ($validate->fails()) {
            return ['status' => false, 'msg' => $validate->errors()];
        } else {
            return ['status' => true, 'msg' => ''];
        }
    }

}