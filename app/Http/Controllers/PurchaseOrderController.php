<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrderDetailss;
use App\Models\PurchaseOrderHeaders;
use App\Models\Items;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $pagecontent =  view('purchase-order.index');

        $pagemain = array(
            'title' => 'Purchase Order - Index ',
            'pagecontent' => $pagecontent,
        );
        return view('masterpage', $pagemain);
    }

    public function create_page()
    {
        $pagecontent =  view('purchase-order.create');

        $pagemain = array(
            'title' => 'Purchase Order - Create ',
            'pagecontent' => $pagecontent,
        );
        return view('masterpage', $pagemain);
    }

    public function create_save(Request $request)
    {
        $request->validate([
            'date' => 'required|date', 
            'cost_header' => 'required',
            'total_header' => 'required'
        ]);

        $save_poh = new PurchaseOrderHeaders;
        $save_poh->po_number = $this->get_code();
        $save_poh->po_date = $request->date;
        $save_poh->po_cost_total = $request->cost_header;
        $save_poh->po_price_total = $request->total_header;
        $save_poh->save();

        $data_detail = [];
        for ($i=0; $i < count($request->items) ; $i++) { 
            $save_pod = new PurchaseOrderDetailss;
            $save_pod->po_h_id = $save_poh->id;
            $save_pod->po_item_id =  $request->items[$i];
            $save_pod->po_item_qyt = $request->qty[$i];
            $save_pod->po_item_price = $request->price[$i];
            $save_pod->po_item_cost = $request->cost[$i];
            $save_pod->save();
            array_push($data_detail,$save_pod);
        }

        return response()->json([
            'data_heder' => $save_poh,
            'data_detail' => $data_detail
        ]); 
    }

    public function getPo()
    {
        $getpo = PurchaseOrderHeaders::all();
  
        return response()->json(array('data_header'=> $getpo), 200);

    } 

    public function update_page($id)
    {
        return $id;
    }

    protected function get_code()
    {
        $date_ym = date('Ym');
        $date_between = [date('Y-m-01 00:00:00'), date('Y-m-t 23:59:59')];

        $datapr = PurchaseOrderHeaders::select('po_number')
        ->whereBetween('created_at',$date_between)
        ->orderBy('created_at','desc')
        ->first();

        if(is_null($datapr)) {
            $nowcode = '0001';
        } else {
            $lastcode = $datapr->po_number;
            $lastcode1 = intval(substr($lastcode, -4))+1;
            $nowcode = str_pad($lastcode1, 4, '0', STR_PAD_LEFT);
        }

        return $date_ym.'-'.$nowcode;
    }
}
