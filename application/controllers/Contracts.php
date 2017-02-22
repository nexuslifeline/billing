<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contracts extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
            'Contract_model',
            'Customers_model',
            'Customer_file_model',
            'Customers_services_model',
            'Customer_document_type_model',
            'Charges_model',
            'Contract_fee_template_model'
        ));

    }

    public function index() {

        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Contract Management';
        $data['customers']=$this->Customers_model->get_list('is_deleted=0');

        $this->load->view('contracts_view', $data);
    }

    function transaction($txn = null,$filter_value=null) {

        switch($txn){
            case 'list':
                $m_contracts=$this->Contract_model;
                $response['data']=$this->get_response('contracts.is_deleted=0');
                echo json_encode($response);

                break;
            case 'create':
                $m_contracts=$this->Contract_model;

                if($this->contract_exist($this->input->post('contract_no',TRUE))){
                    $response['title']="Exist!";
                    $response['stat']="error";
                    $response['msg']="Contract number already exist!";
                    die(json_encode($response));
                }

                $m_contracts->begin();

                $m_contracts->contract_no=$this->input->post('contract_no',TRUE);
                $m_contracts->customer_id=$this->input->post('customer_id',TRUE);
                $m_contracts->date_started=date('Y-m-d',strtotime($this->input->post('date_started',TRUE)));
                $m_contracts->tin_no=$this->input->post('tin_no',TRUE);
                $m_contracts->billing_address=$this->input->post('billing_address',TRUE);
                $m_contracts->contact_person=$this->input->post('contact_person',TRUE);
                $m_contracts->posted_by=$this->session->user_id;
                $m_contracts->set('date_posted','NOW()');



                if($m_contracts->save()){
                    $contract_id=$m_contracts->last_insert_id();

                    $response['title']="Success!";
                    $response['stat']="success";
                    $response['msg']="Contract successfully created!";
                    $response['row_added']=$this->get_response($contract_id);
                    echo json_encode($response);
                }

                $m_contracts->commit();

                break;
            case 'update':
                $m_contracts=$this->Contract_model;
                $contract_id=$this->input->post('contract_id');




                $m_contracts->begin();

                $m_contracts->contract_no=$this->input->post('contract_no',TRUE);
                $m_contracts->customer_id=$this->input->post('customer_id',TRUE);
                $m_contracts->date_started=date('Y-m-d',strtotime($this->input->post('date_started',TRUE)));
                $m_contracts->tin_no=$this->input->post('tin_no',TRUE);
                $m_contracts->billing_address=$this->input->post('billing_address',TRUE);
                $m_contracts->contact_person=$this->input->post('contact_person',TRUE);
                $m_contracts->modified_by=$this->session->user_id;
                $m_contracts->set('date_modified','NOW()');

                if($m_contracts->modify($contract_id)){
                    $response['title']="Success!";
                    $response['stat']="success";
                    $response['msg']="Contract successfully updated!";
                    $response['row_updated']=$this->get_response($contract_id);
                    echo json_encode($response);
                }

                $m_contracts->commit();

                break;
            case 'expand-view':
                $contract_id=$filter_value;


                $m_customers=$this->Customers_model;
                $m_fees=$this->Charges_model;
                //$m_documents=$this->Documents_model;
                $m_contracts=$this->Contract_model;
                $m_customer_files=$this->Customer_file_model;
                $m_customer_services=$this->Customers_services_model;

                $data['contract_id']=$contract_id;
                $data['services']=$m_customer_services->get_customer_service_status($contract_id);
                $data['customer_info']=$m_contracts->get_list(
                    array(
                        'contracts.contract_id'=>$contract_id
                    ),
                    array(
                        'contracts.contract_no',
                        'c.*',
                        'tt.tax_type'
                    ),
                    array(
                        array('customers_info as c','c.customer_id=contracts.customer_id','left'),
                        array('tax_types as tt','tt.tax_type_id=c.tax_type_id','left')
                    )

                );



                $data['fees']=$m_contracts->get_contract_fee_template($contract_id);
                $data['documents']=$m_customer_files->get_customer_doc_count($contract_id);
                $data['customer_files']=$m_customer_files->get_list(

                    array(
                        'customers_files.contract_id'=>$contract_id,
                        'customers_files.is_deleted'=>0
                    ),

                    array(
                        'customers_files.*',
                        'dt.document_type',
                        'dt.document_type_description',
                        'CONCAT_WS(" ",ua.user_fname,ua.user_lname) as user_name',
                        'DATE_FORMAT(customers_files.date_posted,"%m/%d/%Y")as date_posted'
                    ),

                    array(
                        array('document_types as dt','dt.document_type_id=customers_files.document_type_id','left'),
                        array('user_accounts as ua','ua.user_id=customers_files.posted_by_user','left')
                    )

                );

                $this->load->view('Template/customer_expand_view',$data);
                break;



            case 'upload-attachments': //upload attachment
                $data=array();
                $files=array();

                $contract_id=$this->input->get('cid',TRUE);
                $doc_type_id=$this->input->get('did',TRUE);

                $directory='assets/files/docs/';
                $m_files=$this->Customer_file_model;
                $m_customer_doc_types=$this->Customer_document_type_model;


                foreach($_FILES as $file){
                    $server_file_name=uniqid('');
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $file_path=$directory.$server_file_name.'.'.$extension;
                    $orig_file_name=$file['name'];

                    if(move_uploaded_file($file['tmp_name'],$file_path)){
                        //$m_files->begin();
                        $exist=$m_customer_doc_types->get_list(
                            array(
                                'contract_id'=>$contract_id,
                                'document_type_id'=>$doc_type_id
                            )
                        );

                        if(count($exist)>0){

                        }else{
                            $m_customer_doc_types->contract_id=$contract_id;
                            $m_customer_doc_types->document_type_id=$doc_type_id;
                            $m_customer_doc_types->save();
                        }

                        $m_files->set('date_posted','NOW()');
                        $m_files->contract_id=$contract_id;
                        $m_files->document_type_id=$doc_type_id;
                        $m_files->document_path=$file_path;
                        $m_files->document_filename=$orig_file_name;
                        $m_files->posted_by_user=$this->session->user_id;

                        if($m_files->save()){
                            $new_file_id=$m_files->last_insert_id();

                            $response['title']="Uploaded!";
                            $response['stat']="success";
                            $response['msg']="File successfully uploaded.";
                            $response['doc_details']=$m_files->get_customer_doc_count($contract_id,$doc_type_id);
                            $response['new_file']=$m_files->get_list(

                                $new_file_id,

                                array(
                                    'customers_files.*',
                                    'CONCAT_WS(" ",ua.user_fname,ua.user_lname)as user_name',
                                    'dt.document_type',
                                    'dt.document_type_description',
                                    'DATE_FORMAT(customers_files.date_posted,"%m/%d/%Y") as date_posted'
                                ),


                                array(
                                    array('user_accounts as ua','ua.user_id=customers_files.posted_by_user','left'),
                                    array('document_types as dt','dt.document_type_id=customers_files.document_type_id','left')
                                )


                            );
                            echo json_encode($response);

                        }

                    }

                }



                break;
            case 'doc-type-status':
                $m_customer_doc_types=$this->Customer_document_type_model;
                $m_customer_files=$this->Customer_file_model;

                $contract_id=$this->input->post('contract_id',TRUE);
                $doc_type_id=$this->input->post('doc_type_id',TRUE);

                //$m_files->begin();
                $exist=$m_customer_doc_types->get_list(
                    array(
                        'contract_id'=>$contract_id,
                        'document_type_id'=>$doc_type_id
                    )
                );

                if(count($exist)>0){
                    $m_customer_doc_types->delete(array(
                        'contract_id'=>$contract_id,
                        'document_type_id'=>$doc_type_id
                    ));
                }else{
                    $m_customer_doc_types->contract_id=$contract_id;
                    $m_customer_doc_types->document_type_id=$doc_type_id;
                    $m_customer_doc_types->save();
                }

                $response['title']='Status Updated!';
                $response['stat']='success';
                $response['msg']='Document type status successfully updated.';
                $response['doc_details']=$m_customer_files->get_customer_doc_count($contract_id,$doc_type_id);
                echo json_encode($response);


                break;
            case 'service-status':
                $m_services=$this->Customers_services_model;


                $service_id=$this->input->post('service_id',TRUE);
                $contract_id=$this->input->post('contract_id',TRUE);

                $exist=$m_services->get_list(array(
                    'service_id'=>$service_id,
                    'contract_id'=>$contract_id
                ));

                if(count($exist)>0){ //if service already exist
                    $m_services->delete(array(
                        'service_id'=>$service_id,
                        'contract_id'=>$contract_id
                    ));

                }else{
                    $m_services->contract_id=$contract_id;
                    $m_services->service_id=$service_id;
                    $m_services->save();
                }

                $response['title']='Status Updated!';
                $response['stat']='success';
                $response['msg']='Service status successfully updated.';
                $response['row_updated']=$m_services->get_customer_service_status($contract_id,$service_id);
                echo json_encode($response);

                break;
            case 'file-delete':
                $m_files=$this->Customer_file_model;
                $file_id=$this->input->post('file_id',TRUE);

                $m_files->is_deleted=1;
                if($m_files->modify($file_id)){
                    $response['title']='Deleted!';
                    $response['stat']='success';
                    $response['msg']='File successfully deleted.';
                    echo json_encode($response);
                }

                break;
            case 'delete':
                $m_contracts=$this->Contract_model;
                $contract_id=$this->input->post('contract_id',TRUE);

                $m_contracts->is_deleted=1;
                if($m_contracts->modify($contract_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Contract successfully deleted.';
                    $response['row_updated']=$this->get_response($contract_id);
                    echo json_encode($response);
                }

                break;

            case 'update-contract-status':
                $m_contracts=$this->Contract_model;
                $contract_id=$this->input->post('contract_id',TRUE);

                $m_contracts->set('is_active','NOT is_active');
                if($m_contracts->modify($contract_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Contract successfully updated.';
                    $response['row_updated']=$this->get_response($contract_id);
                    echo json_encode($response);
                }

                break;

            case 'contract-fee-template':
                $template=$this->Contract_fee_template_model;
                $contract_id=$this->input->post('contract_id',TRUE);

                $fee_items=$this->input->post('charge_id');
                $fee_amount=$this->input->post('charge_amount');

                $template->delete(array('contract_id'=>$contract_id));

                for($i=0;$i<=count($fee_items)-1;$i++){
                    $template->contract_id=$contract_id;
                    $template->charge_id=$fee_items[$i];
                    $template->amount=$this->get_numeric_value($fee_amount[$i]);
                    $template->save();
                }

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Contract fees successfully saved.';
                echo json_encode($response);


                break;
        }


    }


    function contract_exist($contract_no){
        $m_contracts=$this->Contract_model;

        $exist=$m_contracts->get_list(
            array(
                'contract_no'=>$contract_no,
                'is_deleted'=>FALSE
            )
        );

        return (count($exist)>0);
    }


    function get_response($params){
        $m_contracts=$this->Contract_model;

        return $m_contracts->get_list(
            $params,

            array(
                'contracts.*',
                'ci.company_name',
                'ci.trade_name',
                'ci.contact_no'
            ),

            array(
                array('customers_info as ci','ci.customer_id=contracts.customer_id','left')
            )

        );
    }



}