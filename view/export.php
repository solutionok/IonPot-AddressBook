<?php
if (! $result) {
    die('Couldn\'t fetch records');
}
if($result){
    $headers = [
        'No.S',
        'Name',
        'Mobile',
        'Landline',
        'Residential',
        'Office',
        'Email',
        'Department',
        'Employee type'
    ];
    
    $fp = fopen('php://output', 'w');
    if ($fp && $result) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        fputcsv($fp, $headers);
        foreach ($result as $i=>$k) {
            fputcsv($fp, [
                $i+1,
                $k['name'],
                $k['user_mobile_no'],
                $k['user_landline_no'],
                $k['user_residential_no'],
                $k['user_office_no'],
                $k['user_email'],
                $k['destination'],
                $k['relationship'],
            ]);
        }
    }
}
die();
