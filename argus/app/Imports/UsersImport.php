<?php

namespace App\Imports;
use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UsersImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'fname'     => $row[0],
            'lname'     => $row[1],
            'email'     => $row[2],
            'customer_id'     => $row[3],
            'corporate_name'     => $row[4],
            'street'     => $row[5],
            'city'     => $row[6],
            'state'     => $row[7],
            'post_code'     => $row[8],
            'country'     => $row[9],
            'service_expiry'     => $row[10],
            'remark'     => $row[11],
            'password' => $row[12],
            'original' => $row[12],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }  
}
