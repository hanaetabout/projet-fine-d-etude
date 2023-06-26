<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use App\Models\Transaction;
use App\Models\PropertyMeta;
use App\Models\Chat;
use App\Models\PropertyDocument;
use App\Models\PropertyGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use App\Mail\SendMail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    } 
	
	public function index()
	{
		$properties = Property::where('status',0)->with('owner','chat')->orderBy('id','Desc')->get();
		$users_exist =  User::where('role_id',2)->get();
		return view('dashboards.admin.index')->with(compact('properties','users_exist'));
	}
	
	public function clients()
	{
		$clients = User::where('role_id',2)->get();
		return view('dashboards.admin.clients')->with(compact('clients'));
	}
	
	public function clientsApprove(Request $request)
	{
		$user = User::find($request->user_id);
		$user->approve = $user->approve == 1 ? 0 : 1;
		if($user->update()){
			if($user->approve == 1){
				$testMailData = [
					'title' => 'Rambla Approval',
					'body' => 'Congrats! Admin can approve you to login on:',
				];

				Mail::to($user->email)->send(new SendMail($testMailData));
				
				return response()->json(['status'=>1, 'msg'=>'Updated successfully','approve'=>1]);
			}else{
				return response()->json(['status'=>1, 'msg'=>'Updated successfully','approve'=>0]);
			}
		}else{
			return response()->json(['status'=>0, 'msg'=>'Error','approve'=>'']);
		}
	}
	
	public function users()
	{
		$users = User::where('id','!=', Auth::user()->id)->get();
		return view('dashboards.admin.users')->with(compact('users'));
	}

	
	public function propertyDetail($id,$revenueY=null,$expenseY=null)
	{
		if(!empty($revenueY) && !empty($expenseY)){
			if($revenueY < 2022 || $expenseY < 2022){
				return redirect()->route('admin.propertyDetail',[$id]);
				exit();
			}
		}
		
		$properties = Property::where('id',$id)->with('owner','propertyDocuments','propertyGallery','propertyMeta')->first();	
		
		if($properties->status != 0){
			return redirect()->route('admin.dashboard');
		}
		
		$months = array("1"=>"January", "February", "March","April","May","June","July","August","September","October","November","Dec");
		$docs = array("1"=>"Property Documents", "Rental Agreement", "CPCV & Deeds","Tenant Documents");
		
		return view('dashboards.admin.propertyDetail')->with(compact('properties','months','docs','revenueY','expenseY'));
	}
	
	
	public function addProperty(Request $request)
	{
		//print_r($request->all());die();
		$users_exist =  User::where('role_id',2)->get();
		
		$property = new Property();
		$property->address = $request->address;
		$property->user_id = Auth::user()->id;
		if($property->save()){
			$PropertyMeta = new PropertyMeta();
			$PropertyMeta->user_id = Auth::user()->id;
			$PropertyMeta->property_id = $property->id;
			$PropertyMeta->save();
			return response()->json(['status'=>1, 'msg'=>'Saved successfully','id'=>$property->id,'users'=>$users_exist]);
		}else{
			return response()->json(['status'=>0, 'msg'=>'Error while saving','id'=>'','users'=>$users_exist]);
		}
	}
	
	
	
	public function updateProperty(Request $request) {	
		$checkdata = Property::where(['id'=>$request->pro_id])->first();
		$checkdata->address = $request->address;
		if($checkdata->update()){
			return response()->json(['status'=>1, 'msg'=>'Saved successfully']);
		}else{
			return response()->json(['status'=>0, 'msg'=>'Error while saving']);
		}	
		
	}
	
	public function propertyChat(Request $request)
	{
		$chat = new Chat();
		$chat->property_id = $request->property_id;
		$chat->text = $request->chat;
		$chat->user_id = Auth::user()->id;
		if($request->hasFile('media')) {
			$media = $request->file('media')->getClientOriginalName();
			$request->media->move(storage_path('app/public/chat/'.date('FY')), str_replace(" ","_",$media));
			$chat->media = 'chat/'.date('FY').'/'.str_replace(" ","_",$media);
		}
		if($chat->save()){
			$html = '<div class="chtng"><p>'.$chat->text.'</p>';
			if($request->hasFile('media')) {
				$html .= '<img src="'.asset('public/storage/'.$chat->media).'" alt="media" width="40px" height="40px"/>';
			}
			$html .= '</div><div class="users"><img src="'.asset("public/storage/".Auth::user()->avatar).'"/>
						<div class="date"><p>'.date('d M, Y / H:i A',strtotime($chat->created_at)).'</p><i class="fa-solid fa-ellipsis"></i></div></div>';
						
			$lateststatus = '<a class="btn btn-light" data-bs-toggle="offcanvas" href="#offcanvasExample'.$chat->property_id.'" role="button" aria-controls="offcanvasExample'.$chat->property_id.'">
									Last updated'.date('d.m.Y',strtotime($chat->created_at)).' 
								</a>';
			return response()->json(['status'=>1,'msg'=>$html,'lateststatus'=>$lateststatus]);
		}else{
			return response()->json(['status'=>0,'msg'=>'','lateststatus'=>'']);
		}
		//echo "<pre>";print_r($request->all());die('asd');
	}
	
	
	public function addTransaction(Request $request)
	{
		if(!empty($request->currentM)){	
			$data = explode('_', $request->currentM);
			if($data[0] == 'r'){
				$checkdata = Transaction::where(['property_id'=>$request->property_id,'year'=>$data[1],'month'=>$data[2],'type'=>1])->first();
			}else{
				$checkdata = Transaction::where(['property_id'=>$request->property_id,'year'=>$data[1],'month'=>$data[2],'type'=>2])->first();
			}
				
				
			if(!is_null($checkdata)){					
				$checkdata->price = $request->price;					
				if($checkdata->update()){
					return response()->json(['status'=>1]);
				}else{
					return response()->json(['status'=>0]);
				}
			}else{				
				$Transaction = new Transaction();
				$Transaction->property_id = $request->property_id;
				$Transaction->price = 	$request->price;
				$Transaction->month = 	$data[2];
				$Transaction->year = 	$data[1];
				if($data[0] == 'r'){
					$Transaction->type = 1;
				}else{
					$Transaction->type = 2;
				}
				$Transaction->user_id = Auth::user()->id;
				if($Transaction->save()){
					return response()->json(['status'=>1]);
				}else{
					return response()->json(['status'=>0]);
				}
			
			}			
		}
	}	
	
	
	public function addPropGallery(Request $request)
	{
		if($request->hasFile('media')) {
			foreach($request->file('media') as $file){
				$media = $file->getClientOriginalName();
				$file->move(storage_path('app/public/property_gallery/'.date('FY')), str_replace(" ","_",$media));
				$PropertyGallery = new PropertyGallery();
				$PropertyGallery->media = 'property_gallery/'.date('FY').'/'.str_replace(" ","_",$media);
				$PropertyGallery->property_id = $request->property_id;
				$PropertyGallery->user_id = Auth::user()->id;
				$filename = pathinfo($media, PATHINFO_FILENAME);
				$PropertyGallery->media_name = $filename;
				$PropertyGallery->save();
			}
			return redirect()->back()->with('success', 'Property gallery added.');
		}else{
			return redirect()->back()->with('error', 'No image uploaded.');
		}		
	}
	
	
	public function addPropDocument(Request $request)
	{
		if($request->type == 1){
			if($request->hasFile('prop_doc')) {
				foreach($request->file('prop_doc') as $file){
					$prop_doc = $file->getClientOriginalName();
					$prop_doc = str_replace(" ","",$prop_doc);
					//print_R($prop_doc ); 
					$file->move(storage_path('app/public/property_documents/'.date('FY')), $prop_doc);
					
					$PropertyDocument = new PropertyDocument();
					$PropertyDocument->document = 'property_documents/'.date('FY').'/'.$prop_doc;
					$PropertyDocument->property_id = $request->property_id;
					$PropertyDocument->category = $request->category;
					$PropertyDocument->user_id = Auth::user()->id;
					$filename = pathinfo($prop_doc, PATHINFO_FILENAME);
					$PropertyDocument->document_name = $filename;
					$PropertyDocument->save();
				}//die('sdf');
				return redirect()->back()->with('success', 'Documents added.');
			}else{
				return redirect()->back()->with('error', 'No document uploaded.');
			}		
		}else{
			if($request->hasFile('doc')) {
				$data = explode('_', $request->data);
				if($data[0] == 'r'){
					$checkdata = Transaction::where(['property_id'=>$request->property_id,'year'=>$data[1],'month'=>$data[2],'type'=>1])->first();
				}else{
					$checkdata = Transaction::where(['property_id'=>$request->property_id,'year'=>$data[1],'month'=>$data[2],'type'=>2])->first();
				}	

				if(!is_null($checkdata)){
					if($data[3] == 'condominium'){
						$old_docs = (!empty($checkdata->condominium) ? json_decode($checkdata->condominium) : []);
					}elseif($data[3] == 'other'){
						$old_docs = (!empty($checkdata->other) ? json_decode($checkdata->other) : []);
					}else{
						$old_docs = (!empty($checkdata->document) ? json_decode($checkdata->document) : []);
					}
					$doc = $request->file('doc')->getClientOriginalName();
					$request->doc->move(storage_path('app/public/property_documents/'.date('FY')), str_replace(" ","_",$doc));
				
					//$checkdata->document = 'property_documents/'.date('FY').'/'.str_replace(" ","_",$doc);		
					array_push($old_docs,'property_documents/'.date('FY').'/'.str_replace(" ","_",$doc));
					
					if($data[3] == 'condominium'){
						$checkdata->condominium = json_encode($old_docs);	
					}elseif($data[3] == 'other'){
						$checkdata->other = json_encode($old_docs);	
					}else{
						$checkdata->document = json_encode($old_docs);	
					}				
					if($checkdata->update()){
						return redirect()->back()->with('success', 'Document added.');
					}else{
						return redirect()->back()->with('error', 'Error.');
					}
				}else{	
					$doc = $request->file('doc')->getClientOriginalName();
					$request->doc->move(storage_path('app/public/property_documents/'.date('FY')), str_replace(" ","_",$doc));
					
					$Transaction = new Transaction();
					$Transaction->property_id = $request->property_id;
					$Transaction->month = 	$data[2];
					$Transaction->year = 	$data[1];
					if($data[3] == 'condominium'){
						$Transaction->condominium = json_encode(['property_documents/'.date('FY').'/'.str_replace(" ","_",$doc)]);
					}elseif($data[3] == 'other'){
						$Transaction->other = json_encode(['property_documents/'.date('FY').'/'.str_replace(" ","_",$doc)]);
					}else{
						$Transaction->document = json_encode(['property_documents/'.date('FY').'/'.str_replace(" ","_",$doc)]);
					}
					
					if($data[0] == 'r'){
						$Transaction->type = 1;
					}else{
						$Transaction->type = 2;
					}
					$Transaction->user_id = Auth::user()->id;
					if($Transaction->save()){
						return redirect()->back()->with('success', 'Document added.');
					}else{
						return redirect()->back()->with('error', 'Error.');
					}
				
				}	
			}else{
				return redirect()->back()->with('error', 'No document uploaded.');
			}				
		}
	}
	
	
	public function propBulkAction(Request $request)
	{
		if($request->type == 'delete'){	
			if(!empty($request->values)){
				foreach($request->values as $val){
					$Property = Property::where('id',$val)->update(['status'=>1]);						
				}
			}
		}	
		return response()->json(array('status' => 1));		
	}
	
	
	public function prop_update(Request $request)
    {
		$property =  Property::find($request->property_id);
		$type =   $request->type;
		$data =   $request->data;
	 
		if($type =='email'){
			 $property->email_address = $request->data;
		}else if ($type == 'start_date'){
			 $property->start_date = $request->data;
		}else if ($type =='nif') {
			 $property->nif = $request->data;
		}
		if($property->save()){
			return response()->json(['status'=>1, 'msg'=>'Saved successfully','data'=>array('id'=>$request->property_id,'data'=>$request->data,'type' =>$type) ]);
		}else{
			return response()->json(['status'=>0, 'msg'=>'Error while saving','data'=>array()]);
		}  
	
    } 
	
	
	public function updatePropMeta(Request $request)
	{
		//print_r($request->all());die('asd');
		$PropertyMeta = PropertyMeta::find($request->id);
		$PropertyMeta->floor = $request->floor;
		$PropertyMeta->apartment_number = $request->apartment_number;
		$PropertyMeta->email = $request->email;
		$PropertyMeta->phone = $request->phone;
		$PropertyMeta->fullname = $request->fullname;
		if($PropertyMeta->update()){
			return response()->json([
				'status'=>1,
				'msg'=>'Saved successfully',
				'data'=>array(
						'fullname'=>($PropertyMeta->fullname ? $PropertyMeta->fullname : ''),
						'email'=>($PropertyMeta->email ? $PropertyMeta->email : ''),
						'apartment_number'=>($PropertyMeta->apartment_number ? $PropertyMeta->apartment_number : ''),
						'phone'=>($PropertyMeta->phone ? $PropertyMeta->phone : ''),
						'floor'=>($PropertyMeta->floor ? $PropertyMeta->floor : ''),
						)
				]);
		}else{
			return response()->json(['status'=>0, 'msg'=>'Error while saving','data'=>array()]);
		} 
	}
	
	
	public function addPropOwner(Request $request)
	{
		if($request->type == 'new'){
			$request->validate([
				'email' => 'required|unique:users',
			]);
		
			$user = new User();
			$user->name = $request->name;
			$user->phone = $request->phone;
			$user->nif = $request->nif;
			$user->normal_password = $request->password;
			$user->password = Hash::make($request->password);
			$user->email = $request->email;
			$user->tax_address = $request->tax_address;
			$user->comment = $request->comment;
			$user->role_id = 2;
			if($user->save()){
				$property = Property::find($request->property_id);
				$property->owner_id = $user->id;
				$property->update();
				return redirect()->back()->with('success', 'Owner detail saved.');
			}else{
				return redirect()->back()->with('error', ' Error while saving !.');
			}
		}else{
			$property = Property::find($request->property_id);
			$property->owner_id = $request->exist_user;
			if($property->update()){
				$user = User::find($request->exist_user);
				$user->comment = $request->comment;
				$user->save();
				return redirect()->back()->with('success', 'Owner detail saved.');
			}else{
				return redirect()->back()->with('error', ' Error while saving !.');
			}			
		}
	}
	
	public function updatePropOwner(Request $request)
	{
		$user = User::find($request->user_id);
		$user->name = $request->name;
		$user->phone = $request->phone;
		$user->nif = $request->nif;
		$user->password = Hash::make($request->password);
		$user->tax_address = $request->tax_address;
		$user->comment = $request->comment;
		if($user->save()){
			return redirect()->back()->with('success', 'Owner detail saved.');
		}else{
			return redirect()->back()->with('error', ' Error while saving !.');
		}
	}
	
	 public function pdfview($id,$revenueY=null,$expenseY=null){
		 
		 
	  $properties = Property::where('id',$id)->with('owner','propertyDocuments','propertyMeta')->first();	
      $months = array("1"=>"January", "February", "March","April","May","June","July","August","September","October","November","Dec");
      $docs = array("1"=>"Property Documents", "Rental Agreement", "CPCV & Deeds","Tenant Documents");
		
	   return view('dashboards.admin.pdfview')->with(compact('properties','months','docs','revenueY','expenseY'));
	 }
	 
	 public function downloadpdfview($id,$revenueY=null,$expenseY=null){
		   $properties = Property::where('id',$id)->with('owner','propertyDocuments','propertyMeta')->first();	
      $months = array("1"=>"January", "February", "March","April","May","June","July","August","September","October","November","Dec");
      $docs = array("1"=>"Property Documents", "Rental Agreement", "CPCV & Deeds","Tenant Documents");
		
    $pdf = PDF::loadView('dashboards.admin.pdfview',compact('properties','months','docs','revenueY','expenseY'));
     return $pdf->download('rambla.pdf');

	 }
	 
	 
	 public function create_user(Request $request){
		 
	      $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'role_id' => 'required',
            'nif' => 'required',
            'tax_address' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users'
			
        ]); 
		
		    $user = new User();
			$user->name = $request->name;
			$user->phone = $request->phone;
			$user->nif = $request->nif;
			$user->role_id = $request->role_id;
			$user->normal_password = $request->password;
			$user->password = Hash::make($request->password);
			$user->email = $request->email;
			if($user->save()){
				return redirect()->back()->with('success', 'User added successfully.');  
					//return redirect()->route('admin.addUser');
			}else{
				return redirect()->back()->with('error', 'Error while adding'); 
			}
				
	 }
	 
	 
	public function addUser(){
		 return view('dashboards.admin.addUser');
	}
	
	public function addClient(){
		return view('dashboards.admin.addClient');
	}
	
	public function editUser($id)
	{
		$user = User::find($id);
		return view('dashboards.admin.editUser')->with(compact('user'));
	}
	
	public function deleteUser($id)
	{
		$user = User::find($id);
		$Transaction = Transaction::where('user_id',$id)->delete();
		$Property = Property::where('owner_id',$id)->update(['owner_id' => null]);
		if($user->delete()){
			return redirect()->back()->with('success', 'User deleted successfully.');  
		}else{
			return redirect()->back()->with('error', 'Error while deleting');
		}
	}
	
	public function updateUser(Request $request)
	{
	    $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'role_id' => 'required',
            'nif' => 'required',
            'tax_address' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->user_id.',id'
        ]); 
		
		$user = User::find($request->user_id);
		$user->name = $request->name;
		$user->phone = $request->phone;
		$user->nif = $request->nif;
		$user->tax_address = $request->tax_address;
		$user->role_id = $request->role_id;
		if(!empty($request->password)){
			$user->normal_password = $request->password;
			$user->password = Hash::make($request->password);
		}
		$user->email = $request->email;
		if($user->save()){
			return redirect()->back()->with('success', 'User updated successfully.');  
		}else{
			return redirect()->back()->with('error', 'Error while updating'); 
		}
	}
	
	
	public function deleteDocument(Request $request)
	{
		//print_r($request->all());die('asf');
		if($request->type == 1){
			$document = PropertyDocument::where('id',$request->data_id)->delete();
		}elseif($request->type == 2){
			$document = PropertyDocument::where('id',$request->data_id)->delete();			
		}else{
			$idss = explode('_',$request->data_id);
			$document = Transaction::where('id',$idss[0])->first();
			if($idss[2] == 'condominium'){
				if(!empty($document) && !empty($document->condominium)){
					//print_R($document->document);die('asd');
					$doc = json_decode($document->condominium);
					unset($doc[$idss[1]]);
					//print_R(json_encode(array_values($doc)));die('asd');
					$document->condominium = (count($doc) > 0) ? json_encode(array_values($doc)) : '';
					$document->save();
				}				

			}elseif($idss[2] == 'other'){
				if(!empty($document) && !empty($document->other)){
					//print_R($document->document);die('asd');
					$doc = json_decode($document->other);
					unset($doc[$idss[1]]);
					//print_R(json_encode(array_values($doc)));die('asd');
					$document->other = (count($doc) > 0) ? json_encode(array_values($doc)) : '';
					$document->save();
				}				
				
			}else{
				if(!empty($document) && !empty($document->document)){
					//print_R($document->document);die('asd');
					$doc = json_decode($document->document);
					unset($doc[$idss[1]]);
					//print_R(json_encode(array_values($doc)));die('asd');
					$document->document = (count($doc) > 0) ? json_encode(array_values($doc)) : '';
					$document->save();
				}				
			}
		}
		
		if($document){
			return response()->json(['status'=>1, 'msg'=>'Successfully deleted']);
		}else{
			return response()->json(['status'=>0, 'msg'=>'Error while deleting']);
		}
	}
	 
	 
	public function settings()
	{
		return view('dashboards.admin.settings');
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
	 
