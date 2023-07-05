<?php

namespace App\Imports;

use App\Models\Tree;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TreesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Tree(
            [
                "name" => $row['name'],
                "date" => $row['date'],
                "description" => $row['description'],
            ]
        );
    }
}
