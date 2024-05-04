<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Quotation;
use App\Product;

DB::beginTransaction();

class QuotationController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'quotation';
        $data['page'] = 'Quotation';
        $data['page_url'] = 'quotation';

        $results = Quotation::selectRaw('quotations.*,members.member_firstname,members.member_lastname');
        $results = $results->leftJoin('members','members.id','=','quotations.ref_member_id');
        if(@$request->quotation_number){
            $results = $results->Where('quotations.number','LIKE','%'.$request->quotation_number.'%');
        }
        if(@$request->customer_name){
            $results = $results->Where(DB::raw("CONCAT(members.member_firstname, ' ', members.member_lastname)"),'LIKE','%'.$request->customer_name.'%');
        }
        $results = $results->with('quotation_details.product','quotation_details.color','quotation_details.size')
                ->orderBy('id','DESC')
                ->paginate(10);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/quotations/index', $data);

    }

    public function get_modal($quotation_id){
        
        
        
        // tr += '<tr>'
        //         +'<td colspan="2">'
        //             +'<h6 class="m-0 text-right">Sub Total:</h6>'
        //         +'</td>'
        //         +'<td>฿' +quotation_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        //         +'</td>'
        //     +'</tr>'
        //     +'<tr>'
        //         +'<td colspan="2">'
        //             +'<h6 class="m-0 text-right">Shipping:</h6>'
        //         +'</td>'
        //         +'<td>'
                    
        //         +'</td>'
        //     +'</tr>'
        //     +'<tr>'
        //         +'<td colspan="2">'
        //             +'<h6 class="m-0 text-right">Total:</h6>'
        //         +'</td>'
        //         +'<td>฿' +quotation_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        //         +'</td>'
        //     +'</tr>'
    }

    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Product::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function pdf($id)
    {
        $data['order'] = Quotation::select('quotations.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
        'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
        'members.member_firstname','members.member_lastname','members.company_name')
        ->leftJoin('provinces as ship_pro','ship_pro.id','=','quotations.ship_ref_province_id')
        ->leftJoin('amphures as ship_amph','ship_amph.id','=','quotations.ship_ref_amphure_id')
        ->leftJoin('districts as ship_dist','ship_dist.id','=','quotations.ship_ref_district_id')
        ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','quotations.ship_ref_province_id')
        ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','quotations.ship_ref_amphure_id')
        ->leftJoin('districts as receipt_dist','receipt_dist.id','=','quotations.ship_ref_district_id')
        ->leftJoin('members','members.id','=','quotations.ref_member_id')
        ->where('quotations.id',$id)->with('quotation_details.product','quotation_details.color','quotation_details.size')->first();
        $order_date = strtotime($data['order']['created_at']);
        $d = date('d',$order_date);
        $m = date('m',$order_date);
        $Y = date('Y',$order_date);
        $month = [
        '01'=>'ม.ค.',
        '02'=>'ก.พ.',
        '03'=>'มี.ค.',
        '04'=>'ม.ย.',
        '05'=>'พ.ค.',
        '06'=>'มิ.ย.',
        '07'=>'ก.ค.',
        '08'=>'ส.ค.',
        '09'=>'ก.ย.',
        '10'=>'ต.ค.',
        '11'=>'พ.ย.',
        '12'=>'ธ.ค.'
        ];
        $data['order']->date = $d.' '.$month[$m].' '.$Y;
        return view('admin/quotations/pdf', $data);
    }
}
