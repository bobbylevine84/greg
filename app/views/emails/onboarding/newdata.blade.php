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
      Account On-Boarding data of {{ $record->comp_name }} has been created. Below are the details.
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip</td>
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
    <td colspan="5" style="padding:0 10px;"><b>Invoicing same as Billing?</b> {{ $record->inv_eq_bill == '1' ? 'Yes' : 'No' }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip</td>
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
    <td colspan="5" style="padding:0 10px;"><b>Credit Card is Applicable?</b> {{ $record->has_cc == '1' ? 'Yes' : 'No' }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name on Card</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">CC#</td>
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
    <td colspan="5" style="padding:0 10px; font-weight:bold;">CC Billing Address</td>
  </tr>
  <!-- data -->
  <tr>
    <td colspan="5" style="padding:0 10px;">{{ $record->cc_bill_addr }}</td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">City</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">State</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Zip</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone#</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">CVC Number</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Receipt Email</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Expiry</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone</td>
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
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email(s)</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone</td>
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
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone</td>
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
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Name</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Phone</td>
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
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Email</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 1</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Address 2</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Address 3</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">City</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">State</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Zip</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Tax ID #</td>
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
      <b>Please indicate if you will accept EFT payments to E2E. If so, bank account information will be supplied upon confirmation.</b>
       {{ $record->accept_eft == '1' ? 'Yes' : 'No' }}
     </td>
  </tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <tr><td colspan="5" style="padding:0 10px; color:#C9252C; font-weight:bold; font-size: 14px; line-height:20px;">Bank Account Information</td></tr>

  <tr><td colspan="5" style="padding:0 10px;">&nbsp;</td></tr>
  <!-- label -->
  <tr>
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank Name</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank Address 1</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Bank Address 2</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank City</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Bank State</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Bank Routing</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Account Name</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Account Number</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Can invoices and credit card receipts be emailed?</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Email</td>
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
    <td colspan="3" style="padding:0 10px; font-weight:bold;">Can multiple invoices be processed in single credit card transaction?</td>
    <td>&nbsp;</td>
    <td style="font-weight:bold;">Can E2E take orders via email?</td>
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
    <td colspan="5" style="padding:0 10px; font-weight:bold;">Other Notes</td>
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