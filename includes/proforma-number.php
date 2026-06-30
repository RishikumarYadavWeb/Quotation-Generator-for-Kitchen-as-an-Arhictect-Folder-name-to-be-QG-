<?php
/** @var mysqli $conn */
function generateProformaNumber(mysqli $conn): string{
    mysqli_begin_transaction($conn);
    try{
        $year = (int)date('Y');
        $month = (int)date('m');
        if($month < 4){
            $startYear = $year - 1;
            $endYear = substr((string) $year,-2);
        }else{
            $startYear = $year;
            $endYear = substr((string) ($year + 1),-2);
        }
        $financialYear = $startYear . '-' . $endYear;
        $lastQuotationNumber = 0;
        $quotationQuery = mysqli_query(
            $conn,
            "
            SELECT proforma_no
            FROM quotations
            WHERE proforma_no LIKE 'PI/$financialYear/%'
            ORDER BY id DESC
            LIMIT 1
            "
        );
        if(
            $quotationQuery && mysqli_num_rows($quotationQuery) > 0
        ){
            $quotationRow = mysqli_fetch_assoc($quotationQuery);
            preg_match('/(\d+)$/',$quotationRow['proforma_no'],$matches);
            $lastQuotationNumber = (int)($matches[1] ?? 0);
        }
        mysqli_query(
            $conn,
            "
            INSERT IGNORE INTO quotation_sequences(
                financial_year,
                last_number
            )
            VALUES(
                '$financialYear',
                '$lastQuotationNumber'
            )
            "
        );
        $lockQuery = mysqli_query(
            $conn,
            "
            SELECT last_number
            FROM quotation_sequences
            WHERE financial_year = '$financialYear'
            FOR UPDATE
            "
        );
        $lockData = mysqli_fetch_assoc($lockQuery );
        $sequenceNumber = $lastQuotationNumber;
        $newNumber = $sequenceNumber + 1;
        $formattedNumber = str_pad((string)$newNumber,4,'0',STR_PAD_LEFT);
        $proformaNo = 'PI/' . $financialYear . '/' . $formattedNumber;
        mysqli_query(
            $conn,
            "
            UPDATE quotation_sequences
            SET last_number = '$newNumber'
            WHERE financial_year = '$financialYear'
            "
        );
        mysqli_commit($conn);
        return $proformaNo;
    }catch(Exception $e){
        mysqli_rollback($conn);
        return '';
    }
}