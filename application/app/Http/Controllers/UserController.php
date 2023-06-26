<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\PropertyMeta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
	{
		$property = Property::where('owner_id',Auth::user()->id)->where('status',0)->with('owner','transaction')->limit(10)->get();
		$property_ids = Property::where('owner_id',Auth::user()->id)->where('status',0)->selectRaw('GROUP_CONCAT(id) as ids')->get()->toArray();
		$property_ids = $property_ids[0]['ids'];
		
		
				$max = Transaction::whereIn('property_id',explode(',',$property_ids))->selectRaw('Max(price) as price')->get()->toArray();
			//print_r($max);die();
		$months = array('1'=>'January','February','March','April','May','June','July','August','September','October','November','December');
		
		return view('dashboards.user.index')->with(compact('property','months','property_ids'));
		
	}
	
	public function propertyDetail($id,$revenueY=null,$expenseY=null)
	{
		
		if(!empty($revenueY) && !empty($expenseY)){
			if($revenueY < 2022 || $expenseY < 2022){
				return redirect()->route('user.propertyDetail',[$id]);
				exit();
			}
		}
		
		$property = Property::where('id',$id)->with('owner','propertyDocuments','propertyGallery','propertyMeta')->first();
		
		if($property->status != 0){
			return redirect()->route('user.dashboard');
		}
		$months = array('1'=>'January','February','March','April','May','June','July','August','September','October','November','December');
		$docs = array("1"=>"Property Documents", "Rental Agreement", "CPCV & Deeds","Tenant Documents");
		return view('dashboards.user.propertyDetail')->with(compact('property','months','docs','revenueY','expenseY'));
	}
	
	public function properties()
	{
		$property = Property::where('owner_id',Auth::user()->id)->where('status',0)->with('owner')->get();
		return view('dashboards.user.properties')->with(compact('property'));
	}
	
	
	
	public function pdfview($id,$revenueY=null,$expenseY=null){
		 
		 
	  $property = Property::where('id',$id)->with('owner','propertyDocuments','propertyMeta')->first();	
      $months = array("1"=>"January", "February", "March","April","May","June","July","August","September","October","November","Dec");
      $docs = array("1"=>"Property Documents", "Rental Agreement", "CPCV & Deeds","Tenant Documents");
		
	   return view('dashboards.user.pdfview')->with(compact('property','months','docs','revenueY','expenseY'));
	 }
	 
	public function downloadpdfview($id,$revenueY=null,$expenseY=null){
		$property = Property::where('id',$id)->with('owner','propertyDocuments','propertyMeta')->first();	
		$months = array("1"=>"January", "February", "March","April","May","June","July","August","September","October","November","Dec");
		$docs = array("1"=>"Property Documents", "Rental Agreement", "CPCV & Deeds","Tenant Documents");
		
		$pdf = PDF::loadView('dashboards.user.pdfview',compact('property','months','docs','revenueY','expenseY'));
		return $pdf->download('rambla.pdf');

	}
	
	
	public function settings()
	{
		return view('dashboards.user.settings');
	}	
	
	public function saveSettings(Request $request)
	{
	    $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'nif' => 'required',
            'tax_address' => 'required',
        ]);
		
		$user = User::find($request->user_id);
		$user->name = $request->name;
		$user->phone = $request->phone;
		$user->nif = $request->nif;
		$user->tax_address = $request->tax_address;
		if(!empty($request->password)){
			$user->normal_password = $request->password;
			$user->password = Hash::make($request->password);
		}
		if($user->save()){
			return redirect()->back()->with('success', 'Settings updated successfully.');  
		}else{
			return redirect()->back()->with('error', 'Error while updating'); 
		}		
	}	
	
	
}