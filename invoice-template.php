<?php
/** @var array $quotation */
/** @var array $company */
/** @var array $elevations */
/** @var bool $show_details */
/** @var mysqli $conn */
/** @var array $client */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proforma Invoice</title>
    <style>
      @page{size:A4;margin:8mm 8mm 8mm 8mm}body{font-size:11px;background:#fff;color:#000;font-family: Arial, sans-serif;}.page-header{position:fixed;top:-90px;left:0;right:0;height:70px}.sheet-wrapper{padding:10px;margin:0 auto}table.main{border-collapse:collapse;width:100%}table.main td,table.main th{border:1px solid #000;padding:3px 5px;vertical-align:middle;font-size:11px;line-height:1.3}.no-border td{border:none}col.col-a{width:5%}col.col-b{width:38%}col.col-c{width:10%}col.col-d{width:10%}col.col-e{width:8%}col.col-f{width:13%}col.col-g{width:16%}.row-copies td{font-weight:400;font-size:10px;background:#fff}.row-title td{text-align:center;font-weight:700;font-size:14px;letter-spacing:1px;background:#d9d9d9;border:1px solid #000}.company-name{color:#AF2025;font-weight:700;font-size:14px}.gstin-label{font-weight:700;font-size:10px;text-align:center}.gstin-value{font-weight:700;font-size:11px}.label{font-weight:700}.row-col-headers td{background:#d9d9d9;font-weight:700;text-align:center;border:1px solid #000;font-size:11px}.row-item td{background:#fff}.row-total td{background:#92CDDC;font-weight:700;text-align:center;border:1px solid #000}.row-grandtotal td{font-weight:700}.row-taxable td{font-weight:700}.right{text-align:right}.center{text-align:center}.bold{font-weight:700}.teal-bg{background-color:#92CDDC!important}.gray-bg{background-color:#d9d9d9!important}.no-bd{border:none!important}td.top-align{vertical-align:top}.small-text{font-size:9px}.declaration{font-size:9px;font-style:normal}td{overflow:hidden}.invoice-block{border:2px solid #888}table{border-collapse:collapse}tr{page-break-inside:auto}.unit-block{page-break-inside:auto}.page-footer{position:fixed;bottom:-10mm;left:0;right:0;height:10mm;font-size:12px;border-top:1px solid #000}.footer-left{float:left}.footer-center{text-align:center}.footer-right{text-align:right}#watermark{position:fixed;top:45%;left:50%;transform:translate(-50%,-50%) rotate(-45deg);width:1200px;text-align:center;opacity:.2;font-size:60px;font-weight:700;color:#666;white-space:nowrap}
    </style>
  </head>
  <body>
    <div id="watermark">
        F&R Kitchens And Wardrobe Pvt Ltd
    </div>
    <div class="page-header"></div>
    <main>
    <?php
      $grandTotal = (float)$quotation['grand_total'];
      $packingCharge = (float)$quotation['packing_charge'];
      $installationCharge = (float)$quotation['installation_charge'];
      $subTotal = $grandTotal - $packingCharge - $installationCharge;
      $taxableValue = $grandTotal;
      $specialDiscount = (float)$quotation['special_discount'];
      $discountAmount = ($taxableValue * $specialDiscount) / 100;
      $afterDiscountTotal = $taxableValue - $discountAmount;
      $shippingAddress = trim($quotation['shipping_address'] ?? '');
      $addressParts = array_values(array_filter(array_map('trim',explode(',', $shippingAddress))));
      $customerState = strtolower(end($addressParts));
      $cgstPercent = 0;
      $sgstPercent = 0;
      $igstPercent = 0;
      if($customerState == 'maharashtra'){
          $cgstPercent = 9;
          $sgstPercent = 9;
          $igstPercent = 0;
      }else{
          $cgstPercent = 0;
          $sgstPercent = 0;
          $igstPercent = 18;
      }
      $cgstAmount = ($afterDiscountTotal * $cgstPercent) / 100;
      $sgstAmount = ($afterDiscountTotal * $sgstPercent) / 100;
      $igstAmount = ($afterDiscountTotal * $igstPercent) / 100;
      $finalGrandTotal = $afterDiscountTotal + $cgstAmount + $sgstAmount + $igstAmount;
      $finalGrandTotal = round($finalGrandTotal);
    ?>
    <div class="page">
      <table class="main invoice-block">

        <colgroup>
          <col class="col-a">
          <col class="col-b">
          <col class="col-c">
          <col class="col-d">
          <col class="col-e">
          <col class="col-f">
          <col class="col-g">
        </colgroup>

        <tr style="height:22px;">
          <td colspan="7" class="row-title" style="font-size:14px; font-weight:bold; text-align:center;">PROFORMA INVOICE</td>
        </tr>
        
        <tr style="height:18px;  background:#d9d9d9;">
          <td colspan="4" style="border:1px solid #000;">
            <span class="company-name"><?= $company['company_name'] ?></span>
          </td>
          <td colspan="1" style="border:1px solid #000; font-size:12px;">GSTIN</td>
          <td colspan="2" style="border:1px solid #000; text-align: center ;font-weight:bold;"><?= $company['gst_number'] ?></td>
        </tr>
        
        <tr style="height:10px;">
          <td colspan="4" rowspan="2" style="border:1px solid #000; font-size:10px;">L-5/L-6,Shree Raj Laxmi Hi-Tech Textile Park, Village - Sonale, Taluka- Bhiwandi, Thane - 421302<br> Email: <?= $company['email'] ?>   TEL: <?= $company['landline_number'] ?></td>
          <td colspan="2" style="border:1px solid #000; text-align:center; font-weight:bold; font-size:10px;">PROFORMA NO :</td>
          <td colspan="1" style="border:1px solid #000; font-weight:bold; font-size:10px; text-align: center;">DATE :</td>
        </tr>
        
        <tr style="height:10px;">
          <td colspan="2" style="border:1px solid #000;text-align:center;"><?= $quotation['proforma_no'] ?></td>
          <td style="border:1px solid #000; font-size:10px; text-align: center;"><?= date('d/m/Y',strtotime(!empty($quotation['updated_at']) ? $quotation['updated_at'] : $quotation['created_at'])); ?></td>
        </tr>
        
        <tr style="height:10px;">
          <td colspan="4" rowspan="2" style="border:1px solid #000; font-size:10px;">CIN: <?= $company['cin_number'] ?></td>
          <td colspan="2" style="border:1px solid #000; text-align:center; font-weight:bold; font-size:10px;">E-Way Bill No</td>
          <td style="border:1px solid #000; font-weight:bold; font-size:10px; text-align: center;">Mode of Payment:</td>
        </tr>
        
        <tr style="height:20px;">
          <td colspan="2" style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; text-align: center;">100% Advance</td>
        </tr>
        
        <tr style="height:16px;">
          <td colspan="4" rowspan="2" style="border:1px solid #000; font-size:10px;">Quotation Created By: <?= $quotation['created_user_name'] ?></td>
          <td colspan="2" style="border:1px solid #000; text-align:center; font-weight:bold; font-size:10px;">Supplier's ref.:</td>
          <td style="border:1px solid #000; font-weight:bold; font-size:10px; text-align: center;">Other Ref.:</td>
        </tr>
        
        <tr style="height:20px;">
          <td colspan="2" style="border:1px solid #000;"></td>
          <td style="border:1px solid #000;"></td>
        </tr>
        
        <tr style="height:30px; background:#d9d9d9;">
          <td colspan="4" style="border:1px solid #000; font-size:12px;">Name &amp; Address of Consignee :</td>
          <td style="border:1px solid #000; font-size:10px;">GSTIN</td>
          <td colspan="2" style="border:1px solid #000; font-weight:bold; font-size:11px; text-align: center;"><?= $quotation['gst_number'] ?></td>
        </tr>
        
        <tr style="height:10px;">
          <td colspan="4" rowspan="3" style="border:1px solid #000; font-weight:bold; font-size:11px;"><?= $quotation['client_name'] ?></td>
          <td colspan="2" style="border:1px solid #000; text-align:center; font-weight:bold; font-size:10px;">Buyer's Order No :</td>
          <td style="border:1px solid #000; font-weight:bold; font-size:10px; text-align: center;">DATE :</td>
        </tr>
        
        <tr style="height:20px;">
          <td colspan="2" style="border:1px solid #000;"></td>
          <td style="border:1px solid #000;"></td>
        </tr>
        
        <tr style="height:14px;">
          <td colspan="3" style="border:1px solid #000; font-size:10px;">Ship To :</td>
        </tr>
        
        <tr style="height:38px;">
          <td colspan="4" style="border:1px solid #000; font-size:10px; vertical-align:top; padding-top:20px; padding-bottom:20px;"><?= nl2br($quotation['address']) ?></td>
          <td colspan="3" style="border:1px solid #000;"><?= nl2br($quotation['shipping_address']) ?></td>
        </tr>
        
        <tr style="height:16px;">
          <td colspan="4" rowspan="2" style="border:1px solid #000; font-size:10px;">Pan Card No : <strong><?= nl2br($quotation['pan_number']) ?></strong></td>
          <td colspan="2" style="border:1px solid #000; font-size:10px;text-align: center;font-weight:bold;">Dispatch through :</td>
          <td colspan="1" style="border:1px solid #000; font-weight:bold; font-size:10px; text-align: center;">Destination :</td>
        </tr>
        
        <tr style="height:20px;">
          <td colspan="2" style="border:1px solid #000;text-align: center;">Transport</td>
          <td colspan="1" style="border:1px solid #000;text-align: center;">As per address</td>
        </tr>
        
        <tr style="height:16px;">
          <td colspan="4" style="border:1px solid #000; font-weight:bold; font-size:10px;">Terms of Delivery :</td>
          <td colspan="2" style="border:1px solid #000; font-weight:bold; font-size:10px;">Total Pkts :</td>
          <td colspan="1" style="border:1px solid #000;"></td>
        </tr>

      </table>

      <table class="main invoice-block">

        <colgroup>
          <col class="col-a">
          <col class="col-b">
          <col class="col-c">
          <col class="col-d">
          <col class="col-e">
          <col class="col-f">
          <col class="col-g">
        </colgroup>
        
        <tr style="height:20px;" class="row-col-headers">
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000; padding-top: 10px; padding-bottom: 10px;">NO</td>
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000;">DESCRIPTION</td>
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000;">HSN</td>
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000;">Quantity</td>
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000;">Unit</td>
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000;">Rate</td>
          <td style="background:#d9d9d9; font-weight:bold; text-align:center; border:1px solid #000;">Total</td>
        </tr>
        <?php if($show_details == 'no'): ?>
          <tr>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; text-align:center; vertical-align:top; padding-top:10px;">1</td>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; padding:10px 10px 0 10px; vertical-align:top; font-size:11px; line-height:18px;">Modular <?= $quotation['project_type'] ?> with  Accessories<br><!-- <strong>Total Elevations :</strong> <?= count($elevations) ?> --></td>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; text-align:center; vertical-align:top; padding-top:10px;">940350</td>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; text-align:center; vertical-align:top; padding-top:10px;">1</td>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; text-align:center; vertical-align:top; padding-top:10px;">Nos.</td>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; text-align:right; vertical-align:top; padding-right:8px; padding-top:10px;">INR <?= number_format($subTotal, 2) ?></td>
            <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; border-bottom:none; text-align:right; vertical-align:top; padding-right:8px; padding-top:10px;">INR <?= number_format($subTotal, 2) ?></td>
          </tr>
        <?php endif; ?>
        <?php
        $sr = 1;
        $quotation_subtotal = 0;
        ?>
        <?php if($show_details == 'yes'): ?>
          <?php foreach($elevations as $index => $elevation): ?>
            <?php
              $elevationId = $elevation['id'];
              $elevationTotalQuery = mysqli_query(
                  $conn,
                  "SELECT SUM(unit_total) AS elevation_total
                  FROM units
                  WHERE elevation_id = '$elevationId'"
              );
              $elevationTotalData = mysqli_fetch_assoc($elevationTotalQuery);
              $elevationTotal = floatval($elevationTotalData['elevation_total']);
            ?>
            <tr>
              <td class="center"><?= $index + 1 ?></td>
              <td style="padding:8px;">
                <strong>Elevation <?= chr(65 + $index) ?>
                  <span style="font-size:10px;color:#555;margin-left:8px;">
                    <?= htmlspecialchars($elevation['elevation_note']) ?>
                  </span>
                </strong>
              </td>
              <td class="center">940350</td>
              <td class="center">1</td>
              <td class="center">Nos</td>
              <td class="right">INR <?= number_format($elevationTotal,2) ?></td>
              <td class="right">INR <?= number_format($elevationTotal,2) ?></td>
          </tr>
            <?php
              $elevationId = $elevation['id'];
              $unitQuery = mysqli_query($conn,"SELECT * FROM units WHERE elevation_id='$elevationId'");
            ?>
            <?php $unitCounter = 1; ?>
            <?php while($unit = mysqli_fetch_assoc($unitQuery)): ?>
              <tr >
                <td></td>
                <td colspan="6" style="border-left: none !important;">                
                  <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="border:none !important;">
                        <strong><?= ($index + 1) . '.' . $unitCounter++; ?>] <?= str_replace('_', ' Unit ', explode('_', $unit['unit_key'])[1] . '_' . explode('_', $unit['unit_key'])[2]); ?></strong> : 
                        Cabinet Size (MM): W <?= $unit['width_mm'] ?> x D <?= $unit['depth_mm'] ?> x H <?= $unit['height_mm'] ?> | 
                        Area (Sq.Ft.): <?= $unit['sqft'] ?><br>
                        <?php
                          $carcassCategoryId = $unit['carcass_categories_id'];
                          $carcassCategoryQuery = mysqli_query($conn,"SELECT * FROM carcass_categories WHERE id='$carcassCategoryId'");
                          $carcassCategory = mysqli_fetch_assoc($carcassCategoryQuery);
                          $carcassMaterialId = $unit['carcass_materials_id'];
                          $carcassMaterialQuery = mysqli_query($conn,"SELECT * FROM carcass_materials WHERE id='$carcassMaterialId'");
                          $carcassMaterial = mysqli_fetch_assoc($carcassMaterialQuery);
                        ?>
                        <!-- CARCASS -->
                        <strong>Carcass Details</strong>:
                        Finish : <?= $carcassMaterial['material_name'] ?><br>
                        
                        <?php
                          $shutterCategoryId = $unit['shutter_categories_id'];
                          $shutterCategoryQuery = mysqli_query($conn,"SELECT * FROM shutter_categories WHERE id='$shutterCategoryId'");
                          $shutterCategory = mysqli_fetch_assoc($shutterCategoryQuery);
                          $shutterMaterialId = $unit['shutter_materials_id'];
                          $shutterMaterialQuery = mysqli_query($conn,"SELECT * FROM shutter_materials WHERE id='$shutterMaterialId'");
                          $shutterMaterial = mysqli_fetch_assoc($shutterMaterialQuery);
                        ?>
                        <?php
                          if(
                              !empty($unit['shutter_categories_id'])
                          ){
                        ?>
                        <!-- SHUTTER -->
                        <strong>Shutter Details</strong>: 
                        Finish : <?= $shutterCategory['category_name'] ?> | 
                        Material : <?= $shutterMaterial['material_type'] ?> <br>
                        <?php } ?>
                        <?php
                          $drawerQuery = mysqli_query(
                              $conn,
                              "
                              SELECT
                                  dd.*,
                                  dc.category_name,
                                  dm.material_name
                              FROM drawers_data dd
                              LEFT JOIN drawer_categories dc
                              ON dd.drawer_categories_id = dc.id
                              LEFT JOIN drawer_materials dm
                              ON dd.drawer_materials_id = dm.id
                              WHERE dd.assigned_unit_id = '".$unit['unit_key']."'
                              AND dd.quotation_id = '".$quotation['id']."'
                              "
                          );
                          $drawerCount = 1;
                          if(mysqli_num_rows($drawerQuery) > 0){
                            echo '<strong>Drawer Details</strong><br>';
                            while($drawer = mysqli_fetch_assoc($drawerQuery)){
                                echo '
                                '.$drawerCount++.'] Qty : '.$drawer['quantity'].' | 
                                Size (MM) : W '.$drawer['width_mm'].' x H '.$drawer['height_mm'].' | 
                                Fascia Finish : '.$drawer['material_name'].'<br>
                                ';
                            }
                          }
                        ?>
                        <?php
                          $shelfQuery = mysqli_query(
                              $conn,
                              "
                              SELECT
                                  sd.*,
                                  sc.category_name,
                                  sm.material_name
                              FROM shelves_data sd
                              LEFT JOIN shelf_categories sc
                              ON sd.shelf_categories_id = sc.id
                              LEFT JOIN shelf_materials sm
                              ON sd.shelf_materials_id = sm.id
                              WHERE sd.assigned_unit_id = '".$unit['unit_key']."'
                              AND sd.quotation_id = '".$quotation['id']."'
                              "
                          );
                          $shelfCount = 1;
                          if(mysqli_num_rows($shelfQuery) > 0){
                            echo '<strong>Shelf Details</strong><br>';
                            while($shelf = mysqli_fetch_assoc($shelfQuery)){
                                echo '
                                '.$shelfCount++.'] Qty : '.$shelf['quantity'].' | Size (MM): W '.$shelf['width_mm'].' | 
                                Finish : '.$shelf['material_name'].'
                                <br>
                                ';
                            }
                          }
                        ?>                   
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endforeach; ?>
          <?php
            $panelQuery = mysqli_query(
              $conn,
              "
              SELECT
                  qp.*,
                  sm.material_type,
                  sc.category_name
              FROM quotation_panels qp
              LEFT JOIN shutter_materials sm
              ON qp.shutter_material_id = sm.id
              LEFT JOIN shutter_categories sc
              ON qp.shutter_category_id = sc.id
              WHERE qp.quotation_id = '".$quotation['id']."'
              "
            );
            if(mysqli_num_rows($panelQuery) > 0){
              $panelRowNo = count($elevations);
              $panelsTotal = 0;
              $panelTotalQuery = mysqli_query(
                $conn,
                "
                SELECT
                    SUM(panel_price) AS total
                FROM quotation_panels
                WHERE quotation_id = '".$quotation['id']."'
                "
              );
              if($panelTotalQuery){
                $panelTotalData = mysqli_fetch_assoc($panelTotalQuery);
                $panelsTotal = floatval($panelTotalData['total']);
              }
          ?>
            <tr>
              <td style="text-align:center;"><?= $panelRowNo + 1; ?></td>
              <td><strong>Visible Panels / Side Panels</strong></td>
              <td style="text-align:center;">940350</td>
              <td style="text-align:center;">1</td>
              <td style="text-align:center;">Nos.</td>
              <td style="text-align:right;">INR <?= number_format($panelsTotal,2); ?></td>
              <td style="text-align:right;">INR <?= number_format($panelsTotal,2); ?></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="6" style="border-left:none !important;">
                  <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                      <td style="border:none;">
                        <?php
                          $sr = 1;
                          mysqli_data_seek($panelQuery,0);
                          while(
                            $panel = mysqli_fetch_assoc($panelQuery)
                          ){
                        ?>
                          <strong><?= $sr++; ?>]</strong>
                          <?= number_format($panel['width_mm'],0); ?>MM ×
                          <?= number_format($panel['height_mm'],0); ?>MM
                          | Finish : <?= htmlspecialchars($panel['category_name']); ?>
                          | Material : <?= htmlspecialchars($panel['material_type']); ?>
                          <br>
                        <?php } ?>
                      </td>
                    </tr>
                  </table>
                </td>
            </tr>
          <?php } ?>
          <?php
            $accessoryQuery = mysqli_query(
                $conn,
                "
                SELECT
                    qa.*,
                    a.accessory_name
                FROM quotation_accessories qa
                LEFT JOIN accessories a
                ON qa.accessory_id = a.id
                WHERE qa.quotation_id = '".$quotation['id']."'
                "
            );
            $standardAccessoriesQuery = mysqli_query(
                $conn,
                "
                SELECT
                    qsa.*,
                    sam.material_name,
                    sam.unit,
                    sac.category_name
                FROM quotation_standard_accessories qsa
                LEFT JOIN standard_accessory_materials sam
                ON qsa.standard_accessory_id = sam.id
                LEFT JOIN standard_accessory_categories sac
                ON sam.category_id = sac.id
                WHERE qsa.quotation_id = '".$quotation['id']."'
                "
            );
            if(
                mysqli_num_rows($standardAccessoriesQuery) > 0
            ){
              $standardAccessoryRowNo = count($elevations);
              if(mysqli_num_rows($panelQuery) > 0){
                  $standardAccessoryRowNo++;
              }
              $standardAccessoryRowNo++;
              $standardAccessoriesTotal = 0;
              $standardTotalQuery = mysqli_query(
                  $conn,
                  "
                  SELECT
                      SUM(total_price) AS total
                  FROM quotation_standard_accessories
                  WHERE quotation_id = '".$quotation['id']."'
                  "
              );
              if($standardTotalQuery){
                  $standardTotalData = mysqli_fetch_assoc($standardTotalQuery);
                  $standardAccessoriesTotal = floatval($standardTotalData['total']);
              }
          ?>
          <tr>
            <td style="text-align:center;"><?= $standardAccessoryRowNo; ?></td>
            <td><strong>Standard Accessories</strong></td>
            <td style="text-align:center;">940350</td>
            <td style="text-align:center;">1</td>
            <td style="text-align:center;">Nos.</td>
            <td style="text-align:right;"> INR <?= number_format($standardAccessoriesTotal,2); ?></td>
            <td style="text-align:right;"> INR <?= number_format($standardAccessoriesTotal,2); ?></td>
          </tr>
          <tr>
            <td></td>
            <td colspan="6" style="border-left:none !important;">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                        <td style="border:none;">
                            <?php $sr = 1; while($standardAccessory = mysqli_fetch_assoc($standardAccessoriesQuery)){?>
                              <strong><?= $sr++; ?>] </strong>
                              <?= htmlspecialchars($standardAccessory['material_name']); ?> |
                              Qty [Nos. / Mtr] : <?= $standardAccessory['qty']; ?> <?= $standardAccessory['unit']; ?> <br>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
          <?php } ?>
          <?php
            if(mysqli_num_rows($accessoryQuery) > 0){
              $accessoryRowNo = count($elevations);
              if(mysqli_num_rows($panelQuery) > 0){
                  $accessoryRowNo++;
              }
              if(mysqli_num_rows($accessoryQuery) > 0){
                  $accessoryRowNo++;
              }
              $accessoryRowNo++;
              $accessoriesTotal = 0;
              $accessoryTotalQuery = mysqli_query(
                  $conn,
                  "
                  SELECT
                      SUM(total) AS total
                  FROM quotation_accessories
                  WHERE quotation_id = '".$quotation['id']."'
                  "
              );
              if($accessoryTotalQuery){
                $accessoryTotalData = mysqli_fetch_assoc($accessoryTotalQuery);
                $accessoriesTotal = floatval($accessoryTotalData['total']);
              }
          ?>
          <tr>
              <td style="text-align:center;"><?= $accessoryRowNo; ?></td>
              <td><strong>Additional Accessories</strong></td>
              <td style="text-align:center;">940350</td>
              <td style="text-align:center;">1</td>
              <td style="text-align:center;">Nos.</td>
              <td style="text-align:right;">INR <?= number_format($accessoriesTotal,2); ?></td>
              <td style="text-align:right;">INR <?= number_format($accessoriesTotal,2); ?></td>
          </tr>
          <tr>
              <td></td>
              <td colspan="6" style="border-left:none !important;">
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <tr>
                      <td style="border:none;">
                          <?php
                            mysqli_data_seek($accessoryQuery,0);
                            $sr = 1;
                            while($accessory = mysqli_fetch_assoc($accessoryQuery)){
                          ?>
                            <strong><?= $sr++; ?>]</strong>
                            <?php
                            if(!empty($accessory['other_material'])){
                              echo 'Other - '.htmlspecialchars($accessory['other_material']);
                            }else{
                              echo htmlspecialchars($accessory['accessory_name']);
                            }
                            ?>
                            | Qty : <?= $accessory['qty']; ?>
                            <br>
                          <?php } ?>
                      </td>
                    </tr>
                </table>
              </td>
          </tr>
          <?php } ?>
        <?php endif; ?>
        <tr>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none;">&nbsp;</td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none; padding:10px 10px 20px 10px; vertical-align:top;">
            <?php if($show_details == 'yes'): ?>    
              <div style="text-align:justify; line-height:18px; font-size:11px;">Cost of Hinges and Profile Handles are included.</div>
            <?php endif; ?>
          </td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none;">&nbsp;</td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none;">&nbsp;</td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none;">&nbsp;</td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none;">&nbsp;</td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:none;">&nbsp;</td>
        </tr>
        
        <tr style="height:2px;">
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
          <td style="border-left:1px solid #000; border-right:1px solid #000; border-top:none; border-bottom:1px solid #000; padding:0;"></td>
        </tr>

        <tr style="height:20px;">
          <td style="background:#92CDDC; border:1px solid #000;"></td>
          <td style="background:#92CDDC; border:1px solid #000; font-weight:bold; padding-top: 10px; padding-bottom: 10px;">TOTAL</td>
          <td style="background:#92CDDC; border:1px solid #000;"></td>
          <td style="background:#92CDDC; border:1px solid #000; font-weight:bold; text-align:center;">1</td>
          <td style="background:#92CDDC; border:1px solid #000;"></td>
          <td style="background:#92CDDC; border:1px solid #000; font-weight:bold; text-align:right;">INR <?= number_format($subTotal, 2) ?></td>
          <td style="background:#92CDDC; border:1px solid #000; font-weight:bold; text-align:right;">INR <?= number_format($subTotal, 2) ?></td>
        </tr>

        <tr style="height:16px;">
          <td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-size:10px;">Add : Pkg. &amp; Forwarding &amp; Transport</td>
          <td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; text-align:right;">INR <?= number_format($quotation['packing_charge'],2) ?></td>
        </tr>

        <tr style="height:16px;">
          <td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-size:10px;">Add : Installation</td>
          <td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; text-align:right;">INR <?= number_format($quotation['installation_charge'],2) ?></td>
        </tr>

        <tr style="height:18px; background:#d9d9d9;">
          <td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-weight:bold; font-size:11px;">TAXABLE VALUE</td>
          <td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000;"></td><td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-weight:bold; text-align:right;">INR <?= number_format($taxableValue,2) ?></td>
        </tr>

        <tr style="height:16px;">
            <td style="border:1px solid #000;"></td>
            <td style="border:1px solid #000;font-size:10px;">Special Discount</td>
            <td style="border:1px solid #000;"></td>
            <td style="border:1px solid #000;"></td>
            <td style="border:1px solid #000;"></td>
            <td style="border:1px solid #000;text-align:right;"><?= $quotation['special_discount'] ?>%</td>
            <td style="border:1px solid #000;text-align:right;color:red;">INR - <?= number_format($discountAmount,2) ?></td>
        </tr>
        
        <tr style="height:16px;">
          <td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-size:10px;">Add : CGST</td>
          <td style="border:1px solid #000;"></td>
          <td colspan="2" style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; text-align:right;"><?= number_format($cgstPercent,2) ?>%</td>
          <td style="border:1px solid #000; text-align:right;">INR <?= number_format($cgstAmount,2) ?></td>
        </tr>

        <tr style="height:16px;">
          <td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-size:10px;">Add : SGST</td>
          <td style="border:1px solid #000;"></td>
          <td colspan="2" style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; text-align:right;"><?= number_format($sgstPercent,2) ?>%</td>
          <td style="border:1px solid #000; text-align:right;">INR <?= number_format($sgstAmount,2) ?></td>
        </tr>

        <tr style="height:16px;">
          <td style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; font-size:10px;">Add : IGST</td>
          <td style="border:1px solid #000;"></td>
          <td colspan="2" style="border:1px solid #000;"></td>
          <td style="border:1px solid #000; text-align:right;"><?= number_format($igstPercent,2) ?>%</td>
          <td style="border:1px solid #000; text-align:right;">INR <?= number_format($igstAmount,2) ?></td>
        </tr>

        <tr style="height:20px; background:#92CDDC;">
          <td style="border:1px solid #000;"></td>
          <td colspan="5" style="border:1px solid #000; font-weight:bold; font-size:11px;">GRAND TOTAL</td>
          <td style="border:1px solid #000; font-weight:bold; text-align:right;">INR <?= number_format($finalGrandTotal,2) ?></td>
        </tr>

        <tr style="height:16px;">
          <td style="border:1px solid #000;"></td>
          <td colspan="1" style="border:1px solid #000; font-size:10px; font-weight:bold;">Amount in Words :-</td>
          <td colspan="5" style="border:1px solid #000;"></td>
        </tr>
      </table>

      <table class="main invoice-block" style="margin-top:-1px;">
        <colgroup>
          <col class="col-a">
          <col class="col-b">
          <col class="col-c">
          <col class="col-d">
          <col class="col-e">
          <col class="col-f">
          <col class="col-g">
        </colgroup>

        <tr style="height:16px;">
          <td colspan="5" rowspan="2" style="border:1px solid #000; font-size:9px;"><b>Declaration</b> :- We declare that invoice shows the actual price of the goods described and that all particulars are true and correct.</td>
          <td colspan="2" style="border:1px solid #000; text-align:center; font-size:10px; font-weight:bold;">VEHICLE NO</td>
        </tr>

        <tr style="height:30px;">
          <td colspan="2" style="border:1px solid #000;"></td>
        </tr>

        <tr style="height:18px;">
          <td colspan="5" style="border:1px solid #000; font-size:10px; font-weight:bold;">craftreD Designs Pvt. Ltd</td>
          <td colspan="2" style="border:1px solid #000; text-align:center; font-size:10px;">Receiver Of The Goods (Name/Date/Time/Signature)</td>
        </tr>

        <tr style="height:48px !important; ">
          <td colspan="5" style="border:1px solid #000;">&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;
          </td>
          <td colspan="2" style="border:1px solid #000;"></td>
        </tr>

        <tr style="height:18px;">
          <td colspan="5" style="border:1px solid #000; font-weight:bold; font-size:10px;">Authorised Signatory</td>
          <td colspan="2" style="border:1px solid #000;"></td>
        </tr>
      </table>
    </div>
    </main>
  </body>
</html>