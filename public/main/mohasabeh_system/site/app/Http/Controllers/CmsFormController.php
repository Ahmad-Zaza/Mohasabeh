<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;

class CmsFormController extends Controller
{
    //
    public function getForm($id)
    {
        if(! \CRUDBooster::myId()) return  redirect('admin/login');
        
        \LaravelLocalization::setLocale("En");
        
        $form= \DB::table('forms')->find($id);
        $elemnt_form="";
        if($form){
            $elemnt_form.="<form method='POST' action='/request/form/".$form->id."' class='".$form->row_type." well' style='background:#FFF' >";
            $fileds=\DB::table('form_field')->select(
                'form_field.*',
                'fields.title',
                'forms.*'
            )
            ->join('fields','form_field.field_id','=','fields.id')
            ->join('forms','form_field.form_id','=','forms.id')
            ->where('form_field.form_id',$form->id)->orderBy('form_field.sorting','asc')->get();
            // return  response()->json($fileds, 200);
            
            if($fileds){
                foreach ($fileds as $item) {
                    $req=($item->required_filed=='Yes')?"required":"";
                    $elemnt_form.="<div class='form-group'>";
                    $elemnt_form.="<label>".$item->label_filed.":</label>";
                    if($item->title=='email' || $item->title=='text'){
                        $elemnt_form.="<input type='".$item->title."' class='form-control' name='".$this->stripSpace($item->label_filed)."' ".$req." />";                        
                    }
                    else if($item->title=='checkbox'){
                        $array_values = explode(',', $item->values);
                        foreach ($array_values as $filed) {
                            $elemnt_form.="<label><input type='".$item->title."'  value='".$filed."' name='".$this->stripSpace($item->label_filed)."[]' ".$req." />".$filed."</label><br>";                                                
                        }
                    }
                    else if($item->title=='radio'){
                        $array_values = explode(',', $item->values);
                        foreach ($array_values as $filed) {
                            $elemnt_form.="<label><input type='".$item->title."'  value='".$filed."' name='".$this->stripSpace($item->label_filed)."' ".$req." />".$filed."</label><br>";                                                
                        }
                    }

                    else if($item->title=='select'){
                        $array_values = explode(',', $item->values);
                        $elemnt_form.="<select name='".$this->stripSpace($item->label_filed)."' class='form-control' >";                                                
                        
                        foreach ($array_values as $filed) {
                            $elemnt_form.="<option value='".$filed."'>".$filed."</option>";                                                
                        }
                        $elemnt_form.="</select>";
                    }

                    $elemnt_form.="</div>";
                }
            $elemnt_form.="<div class='form-group'>";
                
            $elemnt_form.="<input type='submit' class='btn btn-primary' value='SEND' />";
            $elemnt_form.="</div>";
            
            $elemnt_form.="</form>";
            
            }
            return  view('form',array('data'=>$elemnt_form));
        }
    }



    public function submit(Request $request , $id)
    {
        $form= \DB::table('forms')->find($id);
        $fileds=\DB::table('form_field')->select(
            'form_field.*',
            'fields.title',
            'forms.*'
        )
        ->join('fields','form_field.field_id','=','fields.id')
        ->join('forms','form_field.form_id','=','forms.id')
        ->where('form_field.form_id',$form->id)->orderBy('form_field.sorting','asc')->get();
        $validations=[];

        foreach ($fileds as $item) {
            $valid=($item->required_filed=='Yes')?'required':null;
            if($valid){
                $validations[$this->stripSpace($item->label_filed)]= $valid;
            }
            
        }
        $request->validate($validations);

        $application=new Application();
        $application->form_id=$form->id;
        $submit="<table class='table'><thead><tr>";
        foreach ($fileds as $item) {
            $submit.="<th>".$item->label_filed."</th>";
            
        }
        $submit.="</tr></thead><body><tr>";
        
        foreach ($fileds as $item) {
            if(is_array($request->input($this->stripSpace($item->label_filed)))){
                $submit.="<td>";
                foreach ($request->input($this->stripSpace($item->label_filed)) as $val) {
                    $submit.=$val.",";                
                }
                $submit.="</td>";
                
            }
            else{
                $submit.="<td>".$request->input($this->stripSpace($item->label_filed))."</td>";                
            }
        }

        $submit.="</tr></tbody></table>";

        $application->response=$submit;
        $application->save();
        return back()->with('success',$form->response);
    }



    public function getSubmits($id)
    {
        \LaravelLocalization::setLocale("En");
        $applications=Application::where('form_id',$id)->get();
        return view('submits',array('data'=>$applications));

    }
    private function stripSpace($string)
    {   
        return $string= str_replace(' ','', trim($string));
    }


    public function getForms()
    {
        \LaravelLocalization::setLocale("En");
        if(! \CRUDBooster::myId()) return  redirect('admin/login');
        
        $forms=\DB::table('forms')->get();
        return response()->json(array("data"=>$forms), 200);
    }
}
