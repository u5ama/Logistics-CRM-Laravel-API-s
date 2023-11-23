<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NewUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if (isset($this->opoperatorRecords) && count($this->operatorRecords) > 0){
            foreach ($this->operatorRecords as $opt){
                $opt['opt_given_name'] = $opt['given_name'];
                $opt['opt_surname'] = $opt['surname'];
                $opt['opt_mobile'] = $opt['mobile'];
                $opt['opt_hs_card_number'] = $opt['ohs_induction_card'];
                $opt['opt_hs_issuer'] = $opt['ohs_induction_issuer'];
                $opt['opt_driver_license'] = $opt['driver_license_number'];
                $opt['opt_driver_license_expiry'] = $opt['driver_license_expiry'];
                $opt['opt_ticket_license'] = $opt['operator_license_type'];
                $opt['opt_ticket_license_expiry'] = $opt['operator_license_expiry'];
            }
        }

        if (isset($this->truckDetails) && count($this->truckDetails) > 0){
            foreach ($this->truckDetails as $detail){
                $detail['truck_type'] = $detail['type'];
                $detail['truck_make'] = $detail['make'];
                $detail['truck_model'] = $detail['model'];
                $detail['truck_year'] = $detail['year'];
                $detail['truck_body_type'] = $detail['body_type'];
                $detail['truck_truck_reg'] = $detail['truck_reg'];
                $detail['truck_trailer_reg'] = $detail['trailer_reg'];
                $detail['truck_capacity'] = $detail['capacity'];
                $detail['truck_tare_gross'] = $detail['tare_gross'];
                $detail['truck_suspension'] = $detail['suspension'];
                $detail['truck_style'] = $detail['style'];
                $detail['truck_selectedChecklist'] = json_decode($detail['truck_checks']);
            }
        }

        if (isset($this->trailerDetails) && count($this->trailerDetails) > 0){
            foreach ($this->trailerDetails as $t){
                $t['trailer_manufacturer'] = $t['manufacturer'];
                $t['trailer_year'] = $t['year'];
                $t['trailer_body_type'] = $t['body_type'];
                $t['trailer_capacity'] = $t['capacity'];
                $t['trailer_tare_gross'] = $t['tare_gross'];
                $t['trailer_suspension'] = $t['suspension'];
                $t['trailer_selectedChecklist'] = json_decode($t['trailer_checks']);
            }
        }

        if (isset($this->plantDetails) && count($this->plantDetails) > 0){
            foreach ($this->plantDetails as $p){
                $p['plant_type'] = $p['type'];
                $p['plant_machine_size'] = $p['machine_size'];
                $p['plant_make'] = $p['make'];
                $p['plant_model'] = $p['model'];
                $p['plant_year'] = $p['year'];
                $p['plant_bucket_types'] = $p['bucket_types'];
                $p['plant_selectedChecklist'] = json_decode($p['plant_checks']);
            }
        }

        if (isset($this->checklistFiles) && count($this->checklistFiles) > 0){
            foreach ($this->checklistFiles as $f){
                $file_path = 'app/' . $f['file_path'];
                $f['file_path'] = Storage::url($file_path);
            }
        }


        return
          [
              'id'=>$this->id,
              'user_id'=>$this->id,
              //Company
              'company_name' => $this->companyInformation->company_name,
              'trading_name' => $this->companyInformation->trading_name,
              'corporate_trustee' => $this->companyInformation->corporate_trustee,
              'abn' => $this->companyInformation->abn,
              'acn' => $this->companyInformation->acn,
              'company_director' => $this->companyInformation->company_director,
              'email' => $this->email,
              'contact_person' => $this->companyInformation->main_contact_person,
              'mobile' => $this->companyInformation->mobile,
              'phone' => $this->companyInformation->phone,
              'about_us' => $this->companyInformation->about_us_description,
              'TaxCheck' => json_decode($this->companyInformation->TaxCheck),
              'infoCheck' => json_decode($this->companyInformation->infoCheck),

              'business_number_street' => $this->companyAddress->business_number_street,
              'business_suburb' => $this->companyAddress->business_suburb,
              'business_state' => $this->companyAddress->business_state,
              'business_post_code' => $this->companyAddress->business_post_code,
              'postal_number_street' => $this->companyAddress->postal_number_street,
              'postal_suburb' => $this->companyAddress->postal_suburb,
              'postal_state' => $this->companyAddress->postal_state,
              'postal_post_code' => $this->companyAddress->postal_post_code,

              'bsb' => $this->bankDetails->bsb,
              'account_number' => $this->bankDetails->account_number,
              'account_name' => $this->bankDetails->account_name,
              'banking_corporation' => $this->bankDetails->banking_corporation,

              //insurance
              'work_policy_number' => $this->insurances->work_policy_number,
              'work_policy_expiry_date' => $this->insurances->work_policy_expiry_date,
              'work_cover_file' => isset($this->insurances->work_cover_file) ? Storage::url('app/'.$this->insurances->work_cover_file) : null,

              'public_policy_number' => $this->insurances->public_policy_number,
              'public_policy_expiry_date' => $this->insurances->public_policy_expiry_date,
              'public_policy_file' => isset($this->insurances->public_policy_file) ? Storage::url('app/'.$this->insurances->public_policy_file) : null,

              'equipment_policy_number' => $this->insurances->equipment_policy_number,
              'equipment_policy_expiry_date' => $this->insurances->equipment_policy_expiry_date,
              'equipment_policy_file' => isset($this->insurances->equipment_policy_file) ? Storage::url('app/'.$this->insurances->equipment_policy_file): null,

              'operatorDetails'=> $this->operatorRecords,

              'complianceChecklist'=> isset($this->complainceChecklist) ? json_decode($this->complainceChecklist->compliance_checklist) : null,
              'equipmentChecklist'=> isset($this->equipmentChecklist) ? json_decode($this->equipmentChecklist->equipment_checklist) : null,
              'requirementChecklist'=> isset($this->requirementChecklist) ? json_decode($this->requirementChecklist->requirement_checklist) : null,
              'hireChecklist'=> isset($this->hireChecklist) ? json_decode($this->hireChecklist->hire_checklist) : null,

              'truckDetails'=> $this->truckDetails,
              'trailerDetails'=> $this->trailerDetails,
              'plantDetails'=> $this->plantDetails,

              'checklistFiles'=> $this->checklistFiles,

              'created_at'=>$this->created_at,
              'updated_at'=>$this->updated_at,
          ];
    }
}
