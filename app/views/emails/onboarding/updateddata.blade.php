<!DOCTYPE html>
<html lang="en">
<head></head>
<body style="padding:10px; margin:0; border:0;">
<table width="728" cellspacing="0" border="0" align="center" style="font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; color:#252525;">
  <tr><td colspan="5" style="padding:0 10px; border-top: 3px solid #C9252C; line-height:3px;">&nbsp;</td></tr>
  <tr>
    <td colspan="5" style="background-color:#ffffff; color:#C9252C; font-size:20px; line-height:40px;">
      <img width="128" src="{{ asset('public/dist/img/custom/logo.png') }}"/>
    </td>
  </tr>
  <tr><td colspan="5" style="padding:0 10px; border-top: 1px solid #eee;">&nbsp;</td></tr>

  <tr>
    <td width="30" style="padding:0 10px;">&nbsp;</td>
    <td width="250">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td style="padding:0 10px;">&nbsp;</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">Hello Admin,</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>

  <tr>
    <td colspan="5" style="padding:0 10px;text-indent:50px;">
      Account On-Boarding data of {{ $record->comp_name }} has been updated. Changed labels are marked with a star symbol. 
      Below are the details.
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:10px 10px; border-bottom:1px solid #C9252C; font-weight:bold; font-size: 16px;"> Account On-Boarding Data</td></tr>
  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>

  <!-- Customer Number -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Customer Number: {{ $record->cust_no }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>

  <!-- Billing -->
  <tr><td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">Billing</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1 {{ $record->bill_addr1 != array_get($old, 'bill_addr1') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2 {{ $record->bill_addr2 != array_get($old, 'bill_addr2') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px; ">{{ $record->bill_addr1 }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->bill_addr2 }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3 {{ $record->bill_addr3 != array_get($old, 'bill_addr3') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City {{ $record->bill_city != array_get($old, 'bill_city') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px; ">{{ $record->bill_addr3 }}</td>
    <td>&nbsp;</td>
    <td style=" ">{{ $record->bill_city }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State {{ $record->bill_state != array_get($old, 'bill_state') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip {{ $record->bill_zip != array_get($old, 'bill_zip') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px; ">{{ $record->bill_state }}</td>
    <td>&nbsp;</td>
    <td style=" ">{{ $record->bill_zip }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Billing -->

  <!-- Invoicing -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Invoicing
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr>
    <td colspan="5" style="padding:0 10px;"><b>Invoicing same as Billing? {{ $record->inv_eq_bill != array_get($old, 'inv_eq_bill') ? '<span style="color:#f00;">*</span>' : '' }}</b> {{ $record->inv_eq_bill == '1' ? 'Yes' : 'No' }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1 {{ $record->inv_addr1 != array_get($old, 'inv_addr1') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2 {{ $record->inv_addr2 != array_get($old, 'inv_addr2') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px; ">{{ $record->inv_addr1 }}</td>
    <td>&nbsp;</td>
    <td style=" ">{{ $record->inv_addr2 }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3 {{ $record->inv_addr3 != array_get($old, 'inv_addr3') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City {{ $record->inv_city != array_get($old, 'inv_city') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px; ">{{ $record->inv_addr3 }}</td>
    <td>&nbsp;</td>
    <td style=" ">{{ $record->inv_city }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State {{ $record->inv_state != array_get($old, 'inv_state') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip {{ $record->inv_zip != array_get($old, 'inv_zip') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->inv_state }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->inv_zip }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Invoicing -->

  <!-- Credit Card -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Credit Card
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr>
    <td colspan="5" style="padding:0 10px;"><b>Credit Card is Applicable? {{ $record->has_cc != array_get($old, 'has_cc') ? '<span style="color:#f00;">*</span>' : '' }}</b> {{ $record->has_cc == '1' ? 'Yes' : 'No' }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name on Card {{ $record->cc_name_on_cc != array_get($old, 'cc_name_on_cc') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">CC# {{ $record->cc_no != array_get($old, 'cc_no') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->cc_name_on_cc }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->cc_no }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">CC Billing Address {{ $record->cc_bill_addr != array_get($old, 'cc_bill_addr') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ $record->cc_bill_addr }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">City {{ $record->cc_city != array_get($old, 'cc_city') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">State {{ $record->cc_state != array_get($old, 'cc_state') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->cc_city }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->cc_state }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Zip {{ $record->cc_zip != array_get($old, 'cc_zip') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone# {{ $record->cc_phone != array_get($old, 'cc_phone') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->cc_zip }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->cc_phone }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">CVC Number {{ $record->cc_cvc_no != array_get($old, 'cc_cvc_no') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Receipt Email {{ $record->cc_email != array_get($old, 'cc_email') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->cc_cvc_no }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->cc_email }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Expiry {{ ( $record->cc_exp_mm != array_get($old, 'cc_exp_mm') || $record->cc_exp_yy != array_get($old, 'cc_exp_yy') ) ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">&nbsp;</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->cc_exp_mm != '' ? $record->cc_exp_mm . '/' .  $record->cc_exp_yy : '' }}</td>
    <td>&nbsp;</td>
    <td style="">&nbsp;</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Credit Card -->

  <!-- Purchasing Primary Contact -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Purchasing Primary Contact
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name {{ $record->pur_prim_name != array_get($old, 'pur_prim_name') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone {{ $record->pur_prim_phone != array_get($old, 'pur_prim_phone') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->pur_prim_name }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->pur_prim_phone }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email(s) {{ $record->pur_prim_emails != array_get($old, 'pur_prim_emails') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ $record->pur_prim_emails }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Purchasing Primary Contact -->

  <!-- Authorized Purchasers Contacts -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Authorized Purchasers Contacts
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">Contact One</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name {{ $record->auth_pur1_name != array_get($old, 'auth_pur1_name') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone {{ $record->auth_pur1_phone != array_get($old, 'auth_pur1_phone') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->auth_pur1_name }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->auth_pur1_phone }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email {{ $record->auth_pur1_email != array_get($old, 'auth_pur1_email') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ $record->auth_pur1_email }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">Contact Two</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name {{ $record->auth_pur2_name != array_get($old, 'auth_pur2_name') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone {{ $record->auth_pur2_phone != array_get($old, 'auth_pur2_phone') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->auth_pur2_name }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->auth_pur2_phone }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email {{ $record->auth_pur2_email != array_get($old, 'auth_pur2_email') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ $record->auth_pur2_email }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">Contact Three</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name {{ $record->auth_pur3_name != array_get($old, 'auth_pur3_name') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone {{ $record->auth_pur3_phone != array_get($old, 'auth_pur3_phone') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->auth_pur3_name }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->auth_pur3_phone }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email {{ $record->auth_pur3_email != array_get($old, 'auth_pur3_email') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ $record->auth_pur3_email }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Authorized Purchasers Contacts -->

  <!-- Primary Shipping Address -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Primary Shipping Address
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1 {{ $record->prim_ship_addr1 != array_get($old, 'prim_ship_addr1') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2 {{ $record->prim_ship_addr2 != array_get($old, 'prim_ship_addr2') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->prim_ship_addr1 }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->prim_ship_addr2 }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3 {{ $record->prim_ship_addr3 != array_get($old, 'prim_ship_addr3') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City {{ $record->prim_ship_city != array_get($old, 'prim_ship_city') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->prim_ship_addr3 }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->prim_ship_city }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State {{ $record->prim_ship_state != array_get($old, 'prim_ship_state') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip {{ $record->prim_ship_zip != array_get($old, 'prim_ship_zip') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->prim_ship_state }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->prim_ship_zip }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Primary Shipping Address -->

  <!-- Secondary Shipping Address -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Secondary Shipping Address
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1 {{ $record->sec_ship_addr1 != array_get($old, 'sec_ship_addr1') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2 {{ $record->sec_ship_addr2 != array_get($old, 'sec_ship_addr2') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->sec_ship_addr1 }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->sec_ship_addr2 }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3 {{ $record->sec_ship_addr3 != array_get($old, 'sec_ship_addr3') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City {{ $record->sec_ship_city != array_get($old, 'sec_ship_city') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->sec_ship_addr3 }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->sec_ship_city }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State {{ $record->sec_ship_state != array_get($old, 'sec_ship_state') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip {{ $record->sec_ship_zip != array_get($old, 'sec_ship_zip') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->sec_ship_state }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->sec_ship_zip }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Secondary Shipping Address -->

  <!-- Payments, Taxes, and Invoicing -->
  <tr>
    <td colspan="5" style="padding:10px 10px; background-color:#F8F8F8; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">
      Payments, Taxes, and Invoicing
    </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Tax ID # {{ $record->tax_id_no != array_get($old, 'tax_id_no') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">&nbsp;</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->tax_id_no }}</td>
    <td>&nbsp;</td>
    <td style="">&nbsp;</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr>
    <td colspan="5" style="padding:0 10px;">
      <b>Please indicate if you will accept EFT payments to E2E. If so, bank account information will be supplied upon confirmation. {{ $record->accept_eft != array_get($old, 'accept_eft') ? '<span style="color:#f00;">*</span>' : '' }}</b>
       {{ $record->accept_eft == '1' ? 'Yes' : 'No' }}
     </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">Bank Account Information</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank Name {{ $record->eft_bank_name != array_get($old, 'eft_bank_name') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">&nbsp;</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->eft_bank_name }}</td>
    <td>&nbsp;</td>
    <td style="">&nbsp;</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank Address 1 {{ $record->eft_bank_addr1 != array_get($old, 'eft_bank_addr1') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Bank Address 2 {{ $record->eft_bank_addr2 != array_get($old, 'eft_bank_addr2') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->eft_bank_addr1 }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->eft_bank_addr2 }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank City {{ $record->eft_bank_city != array_get($old, 'eft_bank_city') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Bank State {{ $record->eft_bank_state != array_get($old, 'eft_bank_state') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->eft_bank_city }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->eft_bank_state }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank Routing {{ $record->eft_bank_routing != array_get($old, 'eft_bank_routing') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">&nbsp;</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->eft_bank_routing }}</td>
    <td>&nbsp;</td>
    <td style="">&nbsp;</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Account Name {{ $record->eft_acc_name != array_get($old, 'eft_acc_name') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Account Number {{ $record->eft_acc_no != array_get($old, 'eft_acc_no') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->eft_acc_name }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->eft_acc_no }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Can invoices and credit card receipts be emailed? {{ $record->email_inv != array_get($old, 'email_inv') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Email {{ $record->email_inv_to != array_get($old, 'email_inv_to') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->email_inv == '1' ? 'Yes' : 'No' }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->email_inv_to }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Can multiple invoices be processed in single credit card transaction? {{ $record->proc_multi_inv != array_get($old, 'proc_multi_inv') ? '<span style="color:#f00;">*</span>' : '' }}</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Can E2E take orders via email? {{ $record->order_via_email != array_get($old, 'order_via_email') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="3" style="padding:0 10px;">{{ $record->proc_multi_inv == '1' ? 'Yes' : 'No' }}</td>
    <td>&nbsp;</td>
    <td style="">{{ $record->order_via_email == '1' ? 'Yes' : 'No' }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Other Notes {{ $record->other_notes != array_get($old, 'other_notes') ? '<span style="color:#f00;">*</span>' : '' }}</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ nl2br($record->other_notes) }}</td>
  </tr>


  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- / Payments, Taxes, and Invoicing -->

  <tr><td colspan="5" style="padding:0 10px; border-bottom:1px solid #C9252C; font-weight:bold; font-size: 16px;">&nbsp;</td></tr>


  <!-- WIP -->

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px;">Please contact us at: </td></tr>
  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>

  <tr><td colspan="5" style="padding:0 10px; font-weight: bold; font-size: 26px;">E2E Customer Service, Orders, and Account Receivables</td></tr>

  <tr>
    <td colspan="2" style="padding:0 10px;">End 2 End Technologies HQ</td>
    <td>&nbsp;</td>
    <td colspan="2" style="padding:0 10px;">End 2 End Technologies Warehouse</td>
  </tr>
  <tr>
    <td colspan="2" style="padding:0 10px;">60 Sycamore Street West</td>
    <td>&nbsp;</td>
    <td colspan="2" style="padding:0 10px;">1017 South Kansas Avenue</td>
  </tr>
  <tr>
    <td colspan="2" style="padding:0 10px;">St. Paul, MN  55117</td>
    <td>&nbsp;</td>
    <td colspan="2" style="padding:0 10px;">Liberal, Kansas 67901</td>
  </tr>
  <tr>
    <td colspan="2" style="padding:0 10px;"><a href="http://www.e2etechinc.com" target="_blank">http://www.e2etechinc.com</a></td>
    <td>&nbsp;</td>
    <td colspan="2" style="padding:0 10px;"><a href="mailto:orders@e2etechinc.com" target="_blank">orders@e2etechinc.com</a></td>
  </tr>
  <tr>
    <td colspan="2" style="padding:0 10px;">Phone: 651-560-0321</td>
    <td>&nbsp;</td>
    <td colspan="2" style="padding:0 10px;">&nbsp;</td>
  </tr>


  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">Regards,</td></tr>
  <tr><td colspan="5" style="padding:0 10px;">E2E TECHNOLOGIES</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>

  <tr><td colspan="5" style="padding:0 10px; border-top: 3px solid #C9252C; line-height:3px;">&nbsp;</td></tr>

</table>
</body>
</html>