<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\ParentUser;
use Hash;
use Illuminate\Support\Facades\Validator;

class ImportParentFile implements ToCollection
{
    public function collection(Collection $rows)
    {
        unset($rows[0]);
        $validator = Validator::make($rows->toArray(), [
                        '*.0' => 'required',
                        '*.1' => 'required',
                        '*.2' => 'required',
                        '*.3' => 'required',
                        '*.4' => 'required',
                        '*.5' => 'required|email|unique:parents,email',
                        '*.6' => 'required|min:6|max:16',
                        '*.7' => 'required|min:10|max:12',
                        '*.8' => 'required',
                        '*.9' => 'required',
                        '*.10' => 'required',
                        '*.11' => 'required',
                        '*.12' => 'required',
                        '*.13' => 'required',
                    ],[
                        '*.0.required'=>'The firstname field is required.',
                        '*.1.required'=>'The middlename field is required.',
                        '*.2.required'=>'The lastname field is required.',
                        '*.3.required'=>'The date of birth field is required.',
                        '*.4.required'=>'The gender field is required.',
                        '*.5.required'=>'The email field is required.',
                        '*.5.unique'=>'The email is already exist.',
                        '*.5.email'=>'The email id field is not valid.',
                        '*.6.required'=>'The password field is required.',
                        '*.6.min'=>'The password field required minimum 6 character.',
                        '*.6.max'=>'The password field required minimum 16 character.',
                        '*.7.required'=>'The phone field is required.',
                        '*.7.min'=>'The phone field required minimum 10 numbers.',
                        '*.7.max'=>'The phone field required maximum 12 numbers.',
                        '*.8.required'=>'The address field is required.',
                        '*.9.required'=>'The city field is required.',
                        '*.10.required'=>'The state field is required.',
                        '*.11.required'=>'The country field is required.',
                        '*.12.required'=>'The is tuition parent field is required.',
                        '*.13.required'=>'The zipcode field is required.',
                    ])->validate();

        $k = [];
        if(count($rows) == 0){
            return redirect()->route('parent_import')->withError(__('formname.not_found'));
        }
        foreach ($rows as $key => $row)
        {
            if ($key > 0 && count($row) > 0) {
                $data = [
                    'first_name' => $row[0],
                    'middle_name' => $row[1],
                    'last_name' => $row[2],
                    'dob' => date('Y-m-d',strtotime($row[3])),
                    'gender' => $row[4],
                    'email' => strtolower($row[5]),
                    'password' => Hash::make($row[6]),
                    'mobile' => $row[7],
                    'address' => $row[8],
                    'country' => $row[9],
                    'region' => $row[10],
                    'council' => $row[11],
                    'is_tuition_parent' => $row[12] == 'YES' ? 1 : 0,
                    'zip_code' => $row[13],
                    'full_name' => $row[0].' '.$row[1].' '.$row[2],
                ];
                ParentUser::create($data);
            }
        }
    }

}
