<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SIRecord;


class SmileKYCRecordsController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        $records = SIRecord::query();
        $records->select(['id', 'si_id', 'user_id', 'flags', 'address_document', 'bank_account_document', 'created_at']);
        $records->orderBy('id', 'desc');
        $data['records'] = $records->paginate(30);
        return view('admin.reports.smilekyc_records', $data);
    }
}
