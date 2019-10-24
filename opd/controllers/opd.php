<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> 
---------------------------------------------------------------------------------- 
Date : June 2016
Author: Mr. Jayanath Liyanage   jayanathl@icta.lk

Programme Manager: Shriyananda Rathnayake
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/
class Opd extends MX_Controller {
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
		$this->load->library('session');
		$this->load->helper('text');
		if(isset($_GET["mid"])){
			$this->session->set_userdata('mid', $_GET["mid"]);
		}		
	 }

	public function index()
	{
		return;
	}
	public function refers(){
       
          /*  $qry = "SELECT opd_visits.OPDID as OPDID, 
			CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  , 
			opd_visits.CreateDate , 
			opd_visits.Complaint , 
			visit_type.Name as VisitType 
			from opd_visits 
			LEFT JOIN `patient` ON patient.PID = opd_visits.PID 
			LEFT JOIN `visit_type` ON visit_type.VTYPID = opd_visits.VisitType 
			where opd_visits.is_refered =1
			";
        $this->load->model('mpager',"visit_page");
        $visit_page = $this->visit_page;
        $visit_page->setSql($qry);
        $visit_page->setDivId("patient_list"); //important
        $visit_page->setDivClass('');
        $visit_page->setRowid('OPDID');
        $visit_page->setCaption("Referred patient list");
        $visit_page->setShowHeaderRow(false);
        $visit_page->setShowFilterRow(false);
        $visit_page->setShowPager(false);
        $visit_page->setColNames(array("","Date", "Patient", "Complaint","OPD Type"));
        $visit_page->setRowNum(25);
        $visit_page->setColOption("OPDID", array("search" => false, "hidden" => true));
		$visit_page->setColOption("CreateDate", array("search" => true, "hidden" => false, "width" => 75));
        $visit_page->setColOption("patient_name", array("search" => true, "hidden" => false));
        $visit_page->setColOption("VisitType", array("search" => true, "hidden" => false, "width" => 75));
        $visit_page->setColOption("Complaint", array("search" => true, "hidden" => false, "width" => 75));
        $visit_page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/admission/proceed")."/'+rowId;
        });
        }";
        $visit_page->setOrientation_EL("L");
		$data['pager'] = $visit_page->render(false);
		$this->load->vars($data);
        $this->load->view('search/opd_refer_search');*/	
            
               		$prefix=$this->config->item('clinic_nuber_prefix');
      $qry = "SELECT opd_visits.OPDID as OPDID, 
			CONCAT(patient.Full_Name_Registered,' ', patient.Personal_Used_Name) , 
			opd_visits.CreateDate , 
			opd_visits.Complaint , 
			visit_type.Name as VisitType 
			from opd_visits 
			LEFT JOIN `patient` ON patient.PID = opd_visits.PID 
			LEFT JOIN `visit_type` ON visit_type.VTYPID = opd_visits.VisitType 
			where opd_visits.is_refered =1
			";
        $this->load->model('mpager',"visit_page");
        $visit_page = $this->visit_page;
        $visit_page->setSql($qry);
        $visit_page->setDivId("patient_list"); //important
        $visit_page->setDivClass('');
        $visit_page->setRowid('OPDID');
        $visit_page->setCaption("Admission Referred patient list");
        $visit_page->setShowPager(false);
        $visit_page->setColNames(array("","Patient", "Referred Date", "Complaint","OPD Type"));
        $visit_page->setRowNum(25);
        $visit_page->setColOption("OPDID", array("search" => false, "hidden" => true));
	$visit_page->setColOption("CreateDate", array("search" => true, "hidden" => false, "width" => 50));
       // $visit_page->setColOption("patient_name", array("search" => true, "hidden" => false, "width" => 70));
        $visit_page->setColOption("VisitType", array("search" => true, "hidden" => false, "width" => 50));
        $visit_page->setColOption("Complaint", array("search" => true, "hidden" => false, "width" => 50));
        //$visit_page->setColOption("Clinic", array("search" => true, "hidden" => false, "width" => 50));
        $visit_page->setColOption("CreateDate", $visit_page->getDateSelector());
        $visit_page->gridComplete_JS
            = "function() {
        $('#patient_list .jqgrow').mouseover(function(e) {
            var rowId = $(this).attr('id');
            $(this).css({'cursor':'pointer'});
        }).mouseout(function(e){
        }).click(function(e){
            var rowId = $(this).attr('id');
            window.location='".site_url("/admission/proceed")."/'+rowId;
        });
        }";
        $visit_page->setOrientation_EL("L");
		$data['pager'] = $visit_page->render(false);
		$this->load->vars($data);
        $this->load->view('search/opd_refer_search');
       
	}		
	
	public function create($pid){
		$data = array();
		$this->load->vars($data);
        $this->load->view('opd_new');	
	}
	
	public function get_previous_notes_list($pid){
		$this->load->model("mopd");
		$data["previous_notes_list"] = $this->mopd->get_previous_notes_list($pid);
		$this->load->vars($data);
                $this->load->view('patient_previous_notes_list');
	}
        
                	public function get_previous_prescription_for_patient($pid=null){
		if (!$pid){
			echo 0;
		}
		if (!$pid){
			echo 0;
		}
		$this->load->model('mopd');
		$data["last_prescription"] = $this->mopd->get_last_prescription_for_patient($pid);		//200439 //200439 ,
		//print_r($data["last_prescription"]);exit;
		if (isset($data["last_prescription"]["PRSID"])){
			$data["prescribe_items_list"] = $this->mopd->get_drug_item($data["last_prescription"]["PRSID"]);
			//print_r($data["prescribe_items_list"]);exit;
			$this->load->model('mpersistent');
			for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
				if ($data["prescribe_items_list"][$i]["drug_list"] == "who_drug"){
					$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["wd_id"], "who_drug", "wd_id");
					$data["prescribe_items_list"][$i]["name"] = isset($drug_info["name"])?$drug_info["name"]:'';
					$data["prescribe_items_list"][$i]["formulation"] = isset($drug_info["formulation"])?$drug_info["formulation"]:'';
					$data["prescribe_items_list"][$i]["default_num"] = isset($drug_info["default_num"])?$drug_info["default_num"]:'';
                                        $data["prescribe_items_list"][$i]["default_timing"] = isset($drug_info["default_timing"])?$drug_info["default_timing"]:'';
                                        $data["prescribe_items_list"][$i]["DPeriod"] = isset($drug_info["DPeriod"])?$drug_info["DPeriod"]:'';
				}	
				else{ //for old version drugs comes from table "drugs"
					$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["wd_id"], "drugs", "DRGID");
					$data["prescribe_items_list"][$i]["name"] = isset($drug_info["Name"])?$drug_info["Name"]:'';
					$data["prescribe_items_list"][$i]["formulation"] =  isset($drug_info["Type"])?$drug_info["Type"]:'';
					$data["prescribe_items_list"][$i]["dose"] = ' ';
				}
			}
			$json = json_encode($data["prescribe_items_list"]);
			echo $json ;
		}
		else{
			echo 0;
		}	
	}
	
	
	public function get_previous_prescription($opd_id=null,$stock_id=null){
		if (!$opd_id){
			echo 0;
		}
		if (!$stock_id){
			echo 0;
		}
		$this->load->model('mopd');
		$data["last_prescription"] = $this->mopd->get_last_prescription($opd_id);
		if (isset($data["last_prescription"]["PRSID"])){
			$data["list"] = $this->mopd->get_drug_list($data["last_prescription"]["PRSID"],$stock_id);
			$json = json_encode($data["list"]);
			echo $json ;
		}
		else{
			echo 0;
		}
		
	}
        
                	public function prescribe_all_favour($favid,$pid,$opdid,$prsid){
		if (!$favid){
			echo 0;
			return;
		}
		if (!$pid){
			echo 0;
			return;
		}
		if (!$opdid){
			echo 0;
			return;
		}
             //echo $prsid;
			//return;
		
		$this->load->model('mopd');
		$this->load->model('mpersistent');
                $this->load->model('muser');
		$data["list"] = $this->muser->get_favour_drug_list($favid);
		if (!empty($data["list"])){
		 $pres_data = array(
                'Dept'   => "OPD",
                'OPDID'  => $opdid,
                'PID'    => $pid,
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'PrescribeBy' => $this->session->userdata("FullName"),
                'Status'      => "Draft",
                'Active'      => 1,
                'GetFrom'     => "Stock"
            );
                 if($prsid>0){
				$this->add_prescribe_all_favor($favid,$prsid);
				return;
			}
                        else{
			$PRSID = $this->mpersistent->create("opd_presciption", $pres_data);
			if ( $PRSID >0){
				$pres_data = array();
				for ($i=0; $i < count($data["list"]); ++$i){
					$pres_item = array(
							'PRES_ID'        => $PRSID ,
							'DRGID'  => $data["list"][$i]["wd_id"],
							'HowLong'    => $data["list"][$i]["how_long"],
                                                        'DoseComment'    => $data["list"][$i]["dose_comment"],
							'Frequency'    => $data["list"][$i]["frequency"],
							'Dosage'    => $data["list"][$i]["dosage"],
							'Status'           => "Pending",
							'drug_list'           => "who_drug",
							'Active'          => 1,
                                                        'CreateDate'      =>  date("Y-m-d H:i:s"),
                                                        'CreateUser'  => $this->session->userdata("FullName"),
							'LastUpDate'      => date("Y-m-d H:i:s"),
							'LastUpDateUser'  => $this->session->userdata("FullName")
						);
					array_push($pres_data,$pres_item );
                                       // $alergy_data = $this->check_alergy_alert($data["list"][$i]["wd_id"],$pid);
		
				}
				$PRS_ITEM_ID = $this->mpersistent->insert_batch("prescribe_items", $pres_data);
				echo $PRSID;
				return;
			}
			echo 0;
			return;
		}
                }
		echo 0;
		return;
	}
	
	public function prescribe_all($prsid,$pid,$opdid){
		if (!$prsid){
			echo 0;
			return;
		}
		if (!$pid){
			echo 0;
			return;
		}
		if (!$opdid){
			echo 0;
			return;
		}
		
		$this->load->model('mopd');
		$this->load->model('mpersistent');
		$data["list"] = $this->mopd->get_prescribe_items($prsid);
		if (!empty($data["list"])){
		 $pres_data = array(
                'Dept'   => "OPD",
                'OPDID'  => $opdid,
                'PID'    => $pid,
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'PrescribeBy' => $this->session->userdata("FullName"),
                'Status'      => "Draft",
                'Active'      => 1,
                'GetFrom'     => "Stock"
            );
			$PRSID = $this->mpersistent->create("opd_presciption", $pres_data);
			if ( $PRSID >0){
				$pres_data = array();
				for ($i=0; $i < count($data["list"]); ++$i){
					$pres_item = array(
							'PRES_ID'        => $PRSID ,
							'DRGID'  => $data["list"][$i]["DRGID"],
							'HowLong'    => $data["list"][$i]["HowLong"],
                            'DoseComment'    => $data["list"][$i]["DoseComment"],
							'Frequency'    => $data["list"][$i]["Frequency"],
							'Dosage'    => $data["list"][$i]["Dosage"],
							'Status'           => "Pending",
							'drug_list'           => "who_drug",
							'Active'          => 1,
							'LastUpDate'      => date("Y-m-d H:i:s"),
							'LastUpDateUser'  => $this->session->userdata("FullName")
						);
					array_push($pres_data,$pres_item );
				}
				$PRS_ITEM_ID = $this->mpersistent->insert_batch("prescribe_items", $pres_data);
				echo $PRSID;
				return;
			}
			echo 0;
			return;
		}
		echo 0;
		return;
	}
	
	public function prescription_add_favour(){
		if ($_POST["PRSID"]>0){
			$prisid = $_POST["PRSID"];
			$favour_data = array(
						'name'  => $this->input->post("name"),
						'uid'  => $this->session->userdata("UID"),
						'Active' => 1
					);
			$this->load->model('mpersistent');
			$this->load->model('mopd');		
			$res = $this->mpersistent->create("user_favour_drug", $favour_data);
			if ($res>0){
				$data["prescribe_items_list"] =$this->mopd->get_prescribe_items($prisid);
				$d_items = array();
				for ($i=0; $i < count($data["prescribe_items_list"]); ++$i){
					if ($data["prescribe_items_list"][$i]["drug_list"] == "who_drug"){
						$item = array( 
							"user_favour_drug_id" => $res,
							"who_drug_id"=> $data["prescribe_items_list"][$i]["DRGID"],
                                                        "dosage"=> $data["prescribe_items_list"][$i]["Dosage"],
                                                        "dose_comment"=> $data["prescribe_items_list"][$i]["DoseComment"],
							"frequency"=> $data["prescribe_items_list"][$i]["Frequency"],
							"how_long"=> $data["prescribe_items_list"][$i]["HowLong"],
							"Active"=> 1,
						) ;
						$this->mpersistent->create("user_favour_drug_items", $item);	
					}
				}
				echo 1;
				return;
			}
		}
		echo -1;
	}
	
	public function check_notify($opd){
		$this->load->model("mnotification");
		$data = array();
		if ($opd["Complaint"]){
			$data["complaint_data"]= $this->mnotification->is_complaint_notify($opd["Complaint"]);
			$data["notification_data"]= $this->mnotification->is_opd_notifed($opd["OPDID"]);
			return $data;
		}
		return null;
	}
	public function save_refer(){
		$data = array();
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("Doctor", "Doctor", "numeric|required");
        $this->form_validation->set_rules("PID", "PID", "numeric|required");
        $this->form_validation->set_rules("referred_id", "referred_id", "numeric|required");

        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('opd/reffer_to_admission',$this->input->post("referred_id") );
        } 
		else {	
			$status2 = $this->mpersistent->update('opd_visits','OPDID' , $this->input->post("referred_id"), array("is_refered"=>1,"Remarks"=>'[Referred to admission] '.$this->input->post("Remarks")));
			$this->session->set_flashdata(
				'msg', 'REC: ' . 'OPD Refered'
			);
				header("Status: 200");
				header("Location: ".site_url('opd/view/'.$this->input->post("referred_id")));
				return;
			}
	}
        
        	public function save_refer_clinic(){
		$data = array();
		$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("Doctor", "Doctor", "numeric|required");
        $this->form_validation->set_rules("PID", "PID", "numeric|required");
        $this->form_validation->set_rules("Clinic", "Clinic", "numeric|required");
        $this->form_validation->set_rules("referred_id", "referred_id", "numeric|required");

        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('opd/reffer_to_clinic',$this->input->post("referred_id") );
        } 
		else {	
			$status2 = $this->mpersistent->update('opd_visits','OPDID' , $this->input->post("referred_id"), array("is_refered_clinic"=>1,"referred_clinic_id"=>$this->input->post("Clinic"),"Remarks"=>'[Referred to clinic] '.$this->input->post("Remarks")));
			$this->session->set_flashdata(
				'msg', 'REC: ' . 'OPD Refered'
			);
				header("Status: 200");
				header("Location: ".site_url('opd/view/'.$this->input->post("referred_id")));
				return;
			}
	}
        
	public function reffer_to_admission($opdid){
		$data = array();
		if(!isset($opdid) ||(!is_numeric($opdid) )){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mpatient');
		$this->load->helper('form');
        $this->load->library('form_validation');
        $data["opd_visits_info"] = $this->mopd->get_info($opdid);

		if ($data["opd_visits_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
        $uid=$this->session->userdata("UID");
		$data["patient_info"]["HIN"] = Modules::run('patient/print_hin',$data["patient_info"]["HIN"]);
		$data["doctor_list"] = $this->mpersistent->table_select("
		SELECT UID,CONCAT(Title,FirstName,' ',OtherName ) as Doctor 
		FROM user WHERE (Active = TRUE) AND ((Usergroup = 'Doctor') OR (Usergroup = 'Programmer')) AND (UID='$uid')
		");		
		
		$data["ward_list"] = $this->mpersistent->table_select("
		SELECT WID,Name  as Ward 
		FROM ward WHERE (Active = TRUE)
		 ORDER BY Name 
		");

		$data["PID"] = $data["opd_visits_info"]["PID"];
		$data["OPDID"] = $opdid;
                $this->checkNotification($data["opd_visits_info"]["Complaint"],$opdid);
		
		$this->load->vars($data);
                $this->load->view('opd_reffer_admission');		
	}
        
        	public function reffer_to_clinic($opdid){
		$data = array();
		if(!isset($opdid) ||(!is_numeric($opdid) )){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mpatient');
		$this->load->helper('form');
        $this->load->library('form_validation');
        $data["opd_visits_info"] = $this->mopd->get_info($opdid);

		if ($data["opd_visits_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
        $uid=$this->session->userdata("UID");
		$data["patient_info"]["HIN"] = Modules::run('patient/print_hin',$data["patient_info"]["HIN"]);
		$data["doctor_list"] = $this->mpersistent->table_select("
		SELECT UID,CONCAT(Title,FirstName,' ',OtherName ) as Doctor 
		FROM user WHERE (Active = TRUE) AND ((Usergroup = 'Doctor') OR (Usergroup = 'Programmer')) AND (UID='$uid')
		");	
		
		$data["clinic_list"] = $this->mpersistent->table_select("
		SELECT clinic_id,name  as name 
		FROM clinic WHERE (Active = TRUE)
		 ORDER BY name 
		");

		$data["PID"] = $data["opd_visits_info"]["PID"];
		$data["OPDID"] = $opdid;
		$this->checkNotification($data["opd_visits_info"]["Complaint"],$opdid);
                
		$this->load->vars($data);
                $this->load->view('opd_refer_clinic');		
	}
	
	public function prescription_item_delete($pres_item_id){
		if ($pres_item_id>0){
			$this->load->model("mpersistent");
			$data["pres"] = $this->mpersistent->open_id($pres_item_id, "prescribe_items", "PRS_ITEM_ID");
			if ($data["pres"]["PRES_ID"]>0){
				if ($this->mpersistent->delete($pres_item_id, "prescribe_items", "PRS_ITEM_ID")){
					$this->session->set_flashdata('msg', 'Drug deleted!' );
					echo 1;
				}
			}
			echo 0;
			
		}
		echo 0;
	}
	public function prescription_send($prsid){
			$this->load->model("mpersistent");
			 $pres_data = array(
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'Status'      => "Pending",
                'Active'      => 1
            );
			//update($table=null,$key_field=null,$id=null,$data)
			if( $this->mpersistent->update("opd_presciption","PRSID",$prsid, $pres_data) > 0 ){
				$this->session->set_flashdata('msg', 'Prescription sent!' );
				echo 1;
			}
			else{
				echo 0;
			}
	}
	
	public function add_durg_item(){
		
		if ($_POST["PRSID"]>0){
                    
                    $pres_data = array(
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'PrescribeBy' => $this->session->userdata("FullName"),
                'Status'      => "Draft",
                'Active'      => 1,
                'GetFrom'     => "Stock"
            );
			//$PRSID = $this->mpersistent->create("opd_presciption", $pres_data);
                        $res = $this->mpersistent->update("opd_presciption","PRSID",$_POST["PRSID"],$pres_data);
			$pres_item_data = array(
						'PRES_ID'        => $_POST["PRSID"] ,
						'DRGID'  => $this->input->post("wd_id"),
						'HowLong'    => $this->input->post("HowLong"),
                                                'DoseComment'    => $this->input->post("DoseComment"),
						'Frequency'    => $this->input->post("Frequency"),
						'Dosage'    => $this->input->post("Dose"),
						'Status'           => "Pending",
						'drug_list'           => "who_drug",
						'Active'                   => 1
					);
			$PRS_ITEM_ID = $this->mpersistent->create("prescribe_items", $pres_item_data);
			if ( $PRS_ITEM_ID >0){
				//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
				$this->session->set_flashdata('msg', 'Drug added!' );
				//($table=null,$key_field=null,$id=null,$data)
				
				if ($this->input->post("choose_method")){
					$this->mpersistent->update("user", "UID",$this->session->userdata("UID"),array("last_prescription_cmd"=>$this->input->post("choose_method")));
				}
				$this->session->set_userdata("choose_method",$this->input->post("choose_method"));
				$new_page   =   base_url()."index.php/opd/prescription/".$_POST["PRSID"]."?CONTINUE=".$this->input->post("CONTINUE")."";
				header("Status: 200");
				header("Location: ".$new_page);
			}
		}
	}
        
        	public function add_prescribe_all_favor($favid,$prsid){
		
		if ($prsid>0){
                    
                    $pres_data = array(
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'PrescribeBy' => $this->session->userdata("FullName"),
                'Status'      => "Draft",
                'Active'      => 1,
                'GetFrom'     => "Stock"
            );
			//$PRSID = $this->mpersistent->create("opd_presciption", $pres_data);
                        $res = $this->mpersistent->update("opd_presciption","PRSID",$prsid,$pres_data);
                        $this->load->model('mopd');
                        $this->load->model('mpersistent');
                        $this->load->model('muser');
                        $data["list"] = $this->muser->get_favour_drug_list($favid);
                        
                        			if ( $prsid >0){
				$pres_data = array();
				for ($i=0; $i < count($data["list"]); ++$i){
					$pres_item = array(
							'PRES_ID'        => $prsid ,
							'DRGID'  => $data["list"][$i]["wd_id"],
							'HowLong'    => $data["list"][$i]["how_long"],
                                                        'DoseComment'    => $data["list"][$i]["dose_comment"],
							'Frequency'    => $data["list"][$i]["frequency"],
							'Dosage'    => $data["list"][$i]["dosage"],
							'Status'           => "Pending",
							'drug_list'           => "who_drug",
							'Active'          => 1,
                                                        'CreateDate'      =>  date("Y-m-d H:i:s"),
                                                        'CreateUser'  => $this->session->userdata("FullName"),
							'LastUpDate'      => date("Y-m-d H:i:s"),
							'LastUpDateUser'  => $this->session->userdata("FullName")
						);
					array_push($pres_data,$pres_item );
                                       // $alergy_data = $this->check_alergy_alert($data["list"][$i]["wd_id"],$pid);
		
				}
				$PRS_ITEM_ID = $this->mpersistent->insert_batch("prescribe_items", $pres_data);
				echo $prsid;
				return;
			}
                        
		}
	}
        
	public function save_prescription(){
       // $alergy_data = $this->check_alergy_alert($this->input->post("wd_id"),$this->input->post("PID"));
		
               /* if (!empty($alergy_data)){
			$data["error"] = "Patient has '" .$alergy_data[0]["Name"]. "' in the list of allergies.";
			$this->load->vars($data);
			if ($this->input->post("PRSID")>0){
				$this->prescription($this->input->post("PRSID"));	
			}
			else{
				$this->new_prescribe($this->input->post("OPDID"));	
			}
			return;
		}*/
                
	$this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');

        $this->form_validation->set_rules("OPDID", "OPDID", "numeric|xss_clean");
        $this->form_validation->set_rules("PID", "PID", "numeric|xss_clean");
        $this->form_validation->set_rules("wd_id", "Age", "numeric|xss_clean");
		$data = array();
		//Array ( [PRSID] => [CONTINUE] => opd/view/620 [OPDID] => 620 [PID] => 184 [wd_id] => undefined [Frequency] => qds [HowLong] => For 3 days [drug_stock_id] => 2 [choose_method] => by_favour )
		//print_r($_POST);
		//exit;
        if ($this->form_validation->run() == FALSE) {
            $data["error"] = "Save not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
        } else {	
			if($this->input->post("PRSID")>0){
				$this->add_durg_item();
				return;
			}
			 $pres_data = array(
                'Dept'   => "OPD",
                'OPDID'  => $this->input->post("OPDID"),
                'PID'    => $this->input->post("PID"),
                'PrescribeDate'   => date("Y-m-d H:i:s"),
                'PrescribeBy' => $this->session->userdata("FullName"),
                'Status'      => "Draft",
                'Active'      => 1,
                'GetFrom'     => "Stock"
            );
			$PRSID = $this->mpersistent->create("opd_presciption", $pres_data);
                        // $res = $this->mpersistent->update("appointment","APPID",$appid,$sve_data );
			if ( $PRSID >0){
				$pres_item_data = array(
					'PRES_ID'        => $PRSID ,
					'DRGID'  => $this->input->post("wd_id"),
					'HowLong'    => $this->input->post("HowLong"),
                                        'DoseComment'    => $this->input->post("DoseComment"),
					'Frequency'    => $this->input->post("Frequency"),
					'Dosage'    => $this->input->post("Dose"),
					'Status'           => "Pending",
					'drug_list'           => "who_drug",
					'Active'                   => 1
				);
				$PRS_ITEM_ID = $this->mpersistent->create("prescribe_items", $pres_item_data);
				if ( $PRS_ITEM_ID >0){
					//echo Modules::run('opd/new_prescribe',$this->input->post("OPDID"));
					$this->session->set_flashdata('msg', 'Prescription created!' );
					$new_page   =   base_url()."index.php/opd/prescription/".$PRSID."?CONTINUE=".$this->input->post("CONTINUE")."";
					header("Status: 200");
					header("Location: ".$new_page);
				}
			}
			else{
				$data["error"] = "Save not found";
				$this->load->vars($data);
				$this->load->view('opd_error');	
				return;
			}
		}		
	}
        
     public function check_alergy_alert(){
     $wd_id = $_POST["drgid"];
	 $pid = $_POST["pid"];
	 if ($wd_id=="")$wd_id=null;
	 if ($pid=="")$pid=null;
	 $this->load->model("mpersistent");
	 $this->load->model("mpatient");
	 $drug_info = $this->mpersistent->open_id($wd_id,"who_drug","wd_id");
	 $alert_info = $this->mpatient->check_alergy_alert($drug_info["name"],$pid);
	 $json = json_encode($alert_info);
	 echo $json ;
}

public function check_alergy_blk($prsid){
	if ($prsid=="")$prsid=null;
	$this->load->model('mopd');
	$prescribe_items_list =$this->mopd->get_prescribe_items($prsid);
	$json = json_encode($prescribe_items_list);
	echo $json ;
}

public function check_alergy_favlist($favid){
	if ($favid=="")$favid=null;
	$this->load->model('muser');
	$list = $this->muser->get_favour_drug_list($favid);
	$json = json_encode($list);
	echo $json ;
}
	
	public function prescription($prisid){
		if(!isset($prisid) ||(!is_numeric($prisid) )){
			$data["error"] = "Prescription  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mpatient');
		$this->load->helper('string');
                $data['prisid']=$prisid;
		$data["opd_presciption_info"] = $this->mpersistent->open_id($prisid, "opd_presciption", "PRSID");
		$data["prescribe_items_list"] =$this->mopd->get_prescribe_items($prisid);
		if(isset($data["prescribe_items_list"])){
			for ($i=0;$i<count($data["prescribe_items_list"]); ++$i){
				if ($data["prescribe_items_list"][$i]["drug_list"] == "who_drug"){
					$drug_info = $this->mpersistent->open_id($data["prescribe_items_list"][$i]["DRGID"], "who_drug", "wd_id");
					
				}	
				$data["prescribe_items_list"][$i]["drug_name"] = isset($drug_info["name"])?$drug_info["name"]:'';
				$data["prescribe_items_list"][$i]["formulation"] = isset($drug_info["formulation"])?$drug_info["formulation"]:'';
				$data["prescribe_items_list"][$i]["dose"] = isset($drug_info["DStrength"])?$drug_info["DStrength"]:'';
			}
		}
		$data["my_favour"] = $this->mopd->get_favour_drug_count($this->session->userdata("UID"));
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		if ($data["opd_presciption_info"]["OPDID"]>0){
			$data["opd_visits_info"] = $this->mopd->get_info($data["opd_presciption_info"]["OPDID"]);
		}
		if ($data["opd_visits_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["opd_visits_info"]["PID"]);
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		if(isset($data["opd_visits_info"]["visit_type_id"])){
			$data["stock_info"] = $this->mopd->get_stock_info($data["opd_visits_info"]["visit_type_id"]);
		}
		$data["PID"] = $data["opd_visits_info"]["PID"];
		$data["OPDID"] = $data["opd_presciption_info"]["OPDID"];
                $data["drug_dosage"] = $this->mopd->get_drug_dosage();
                $data["drug_frequency"] = $this->mopd->get_drug_frequency();
                $data["drug_period"] = $this->mopd->get_drug_period();
		$this->load->vars($data);
                $this->load->view('opd_new_prescribe');			
	}
        
                public function update_dosage(){

                 $prs_item_id = $_POST["prs_item_id"];
                 $nd=$_POST["new_dosage"];
              	 $this->load->model('mpersistent');
		 $st=$this->mpersistent->update("prescribe_items", "PRS_ITEM_ID",$prs_item_id,array("Dosage"=>$nd));
                 echo $nd;
        }
        
                public function update_frequency($prs_item_id=null,$new_frequency=null){

                $nf=urldecode($new_frequency);
            	$this->load->model('mpersistent');
		$st=$this->mpersistent->update("prescribe_items", "PRS_ITEM_ID",$prs_item_id,array("Frequency"=>$nf));
                echo $nf ;
        }
        
                public function update_period($prs_item_id=null,$new_period=null){

                $np=urldecode($new_period);
            	$this->load->model('mpersistent');
		$st=$this->mpersistent->update("prescribe_items", "PRS_ITEM_ID",$prs_item_id,array("HowLong"=>$np));
                echo $np ;
        }
	
	
	public function new_prescribe($opdid){          
		
		if(!isset($opdid) ||(!is_numeric($opdid) )){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mpatient');
        $data["opd_visits_info"] = $this->mopd->get_info($opdid);
		if(isset($data["opd_visits_info"]["visit_type_id"])){
			$data["stock_info"] = $this->mopd->get_stock_info($data["opd_visits_info"]["visit_type_id"]);
		}
		if ($data["opd_visits_info"]["PID"] >0){
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
			$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["opd_visits_info"]["PID"]);
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["user_info"] = $this->mpersistent->open_id($this->session->userdata("UID"), "user", "UID");
		$data["my_favour"] = $this->mopd->get_favour_drug_count($this->session->userdata("UID"));
                $data["drug_dosage"] = $this->mopd->get_drug_dosage();
		$data["PID"] = $data["opd_visits_info"]["PID"];
		$data["OPDID"] = $opdid;
		$this->load->vars($data);
	$this->checkNotification($data["opd_visits_info"]["Complaint"],$opdid);	
        $this->load->view('opd_new_prescribe');	  
        
	}
	
	public function get_nursing_notes($opdid,$continue,$mode='HTML'){
		$this->load->model("mopd");
		$data = array();
		$data["nursing_notes_list"] = $this->mopd->get_previous_notes_list($opdid);
		$data["continue"] = $continue;
		if ($mode == "HTML"){
			$this->load->vars($data);
			$this->load->view('opd_nursing_notes');
		}
		else{
			return $data["nursing_notes_list"];
		}
	}		
	
	public function view($opdid){
		
		$data = array();
		if(!isset($opdid) ||(!is_numeric($opdid) )){
			$data["error"] = "OPD visit not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		$this->load->model('mpersistent');
		$this->load->model('mopd');
		$this->load->model('mpatient');
        $data["opd_visits_info"] = $this->mopd->get_info($opdid);
		$data["notification"]=$this->check_notify($data["opd_visits_info"]);
		$visit_date=$data["opd_visits_info"]["DateTimeOfVisit"];
		$today=date("Y-m-d H:i:s");
		$diff = abs(strtotime($today) - strtotime($visit_date));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));;
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$data["opd_visits_info"]["days"]=$days +$months*30+$years*365;
		if (isset($data["opd_visits_info"]["PID"])){
			$data["patient_info"] = $this->mpersistent->open_id($data["opd_visits_info"]["PID"], "patient", "PID");
			//$data["patient_allergy_list"] = $this->mpatient->get_allergy_list($data["opd_visits_info"]["PID"]);
			//$data["patient_exams_list"] = $this->mpatient->get_exams_list($data["opd_visits_info"]["PID"]);
			//$data["patient_history_list"] = $this->mpatient->get_history_list($data["opd_visits_info"]["PID"]);
			//$data["patient_lab_order_list"] = $this->mpatient->get_lab_order_list($data["opd_visits_info"]["PID"]);
			$data["patient_prescription_list"] = $this->mpatient->get_prescription_list($opdid);
			$data["patient_treatment_list"] = $this->mpatient->get_treatment_list($opdid);
                        $data["patient_ecg_list"] = $this->mpatient->get_ecg_list($opdid);
                        $data["last_dispensed_prescription"] = $this->mpatient->last_dispensed_prescription($opdid);
                        //$data["patient_prescription_list"] = $this->mpatient->get_prescription_list($opdid);
			//$data["previous_injection_list"] = $this->mpatient->get_previous_injection_list($data["opd_visits_info"]["PID"]);
		}
		else{
			$data["error"] = "OPD Patient  not found";
			$this->load->vars($data);
			$this->load->view('opd_error');	
			return;
		}
		if (empty($data["patient_info"])){
			$data["error"] ="OPD Patient not found";
			$this->load->vars($data);
			$this->load->view('opd_error');
			return;
		}
		if (isset($data["patient_info"]["DateOfBirth"])) {
            $data["patient_info"]["Age"] = Modules::run('patient/get_age',$data["patient_info"]["DateOfBirth"]);
        }
		$data["patient_info"]["HIN"] = Modules::run('patient/print_hin',$data["patient_info"]["HIN"]);

		$data["PID"] = $data["opd_visits_info"]["PID"];
		$data["OPDID"] = $opdid;
		
		$this->load->vars($data);
        $this->load->view('opd_view');	
	}
        
                public function checkNotification($complaint,$opdid){
                $this->load->model("mnotification");
		$complaint_data= $this->mnotification->is_complaint_notify($complaint);
                $notification_data= $this->mnotification->is_opd_notifed($opdid);
               // die(print_r($nid));
             if (!empty($complaint_data)){
                 //die(print_r($notification_data));
                   if (empty($notification_data)) {
 
                    $msg = "";
                    $msg .= "<table width=100% style='font-size:10px;'><tr><td colspan=2 align=center style='color:#FF0000;'>Alert!<hr></td></tr>";
                    $msg .= "<tr>";
                    $msg .= "<td  width=5%>Complaint:</td>";
                    $msg .= "<td  ><textarea disabled rows=4>".$complaint."</textarea></td>";
                    $msg .= "</tr>";
                    $msg .= "<tr><td colspan=2 >Do you want to notify this?</td></tr>";
                    $msg .= "<tr><td colspan=2 align=center><a class='btn btn-sm btn-default' href='".site_url('notification/create/opd/'.$opdid.'?CONTINUE=opd/view/'.$opdid)."'>Yes</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='notification_close();'>Cancel</a></td></tr>";
                    $msg .= "</table>";
                    echo "<div id='n_pop' class='nPop' style='padding:10px;border:1px solid #ff0000;background-color:#fff4f4;z-index:9999999;position:absolute;top:0px;left:50%;width:300px;margin-left:-100px;height:200px;max-height:300px;' >$msg</div>";
                    

                   }
                 
             
  
        }
	
                }	
	
	
} 


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */